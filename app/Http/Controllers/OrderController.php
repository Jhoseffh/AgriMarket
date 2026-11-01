<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Product;

class OrderController extends Controller
{
    // Store a customer's order request.
    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'    => 'required|integer|exists:products,product_id',
            'quantity'      => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:30',
            'address'       => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $product = DB::table('products')
            ->where('product_id', $request->product_id)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        if ($product->seller_id == auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot order your own product.',
            ], 403);
        }

        if ($request->quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Requested quantity exceeds available stock.',
            ], 422);
        }

        $shippingFee = session(
            'order_shipping_fee_' . $product->product_id,
            10
        );

        $totalAmount = ($product->price * $request->quantity) + $shippingFee;

        DB::table('order_requests')->insert([
            'order_id'      => null,
            'buyer_id'      => auth()->id(),
            'seller_id'     => $product->seller_id,
            'product_id'    => $product->product_id,
            'product_name'  => $product->product_name,
            'quantity'      => $request->quantity,
            'oum'           => $product->oum,
            'customer_name' => $request->customer_name,
            'mobile_number' => $request->mobile_number,
            'address'       => $request->address,
            'total_amount'  => $totalAmount,
            'status'        => 'pending',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your order request has been submitted.',
        ]);
    }


    // Display the order summary page.
    public function orderSummary(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,product_id',
        ]);

        $product = Product::where('product_id', $request->product_id)->first();

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        if ($product->seller_id == auth()->id()) {
            return back()->with('error', 'You cannot order your own product.');
        }

        if ($product->quantity <= 0) {
            return back()->with('error', 'This product is currently out of stock.');
        }

        $shippingFee = session(
            'order_shipping_fee_' . $product->product_id,
            rand(10, 30)
        );

        session([
            'order_shipping_fee_' . $product->product_id => $shippingFee
        ]);

        return view('order.ordersummary', compact('product', 'shippingFee'));
    }


    // Get the product availability status.
    private function getProductStatus($quantity)
    {
        if ($quantity <= 0) {
            return 'Unavailable';
        }

        if ($quantity <= 10) {
            return 'Low Stock';
        }

        return 'Available';
    }


    // Automatically mark expired shipping orders as Completed.
    private function updateCompletedOrders()
    {
        DB::table('transactions')
            ->where('status', 'Shipping')
            ->whereNotNull('completion_time')
            ->where('completion_time', '<=', now('Asia/Manila'))
            ->update([
                'status' => 'Completed',
                'updated_at' => now('Asia/Manila'),
            ]);
    }


    // Display the seller's orders page, pending order requests,
    // and transactions.
    public function orders()
    {
        // Automatically complete orders whose completion time has passed.
        $this->updateCompletedOrders();

        $totalProducts = Product::where('seller_id', auth()->id())->count();

        $products = DB::table('products')
            ->where('seller_id', auth()->id())
            ->orderByDesc('product_id')
            ->get();

        $orderRequests = DB::table('order_requests')
            ->leftJoin(
                'products',
                'order_requests.product_id',
                '=',
                'products.product_id'
            )
            ->where('order_requests.seller_id', auth()->id())
            ->where('order_requests.status', 'pending')
            ->select(
                'order_requests.*',
                'products.price as product_price'
            )
            ->orderByDesc('order_requests.created_at')
            ->get();

        $transactions = DB::table('transactions')
            ->leftJoin(
                'products',
                'transactions.product_id',
                '=',
                'products.product_id'
            )
            ->where('transactions.seller_id', auth()->id())
            ->select(
                'transactions.*',
                'products.price as product_price'
            )
            ->orderByDesc('transactions.created_at')
            ->get();

        return view('order.orders', compact(
            'totalProducts',
            'products',
            'orderRequests',
            'transactions'
        ));
    }


    // ACCEPT: Deduct stock, create a Shipping transaction,
    // and automatically schedule its completion through completion_time.
    public function acceptOrderRequest($requestId)
    {
        try {
            $result = DB::transaction(function () use ($requestId) {

                // Lock the pending request.
                $orderRequest = DB::table('order_requests')
                    ->where('request_id', $requestId)
                    ->where('seller_id', auth()->id())
                    ->where('status', 'pending')
                    ->lockForUpdate()
                    ->first();

                if (!$orderRequest) {
                    throw new \Exception(
                        'Order request not found or is no longer pending.'
                    );
                }

                // Lock the product before checking its stock.
                $product = Product::where('product_id', $orderRequest->product_id)
                    ->where('seller_id', auth()->id())
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new \Exception(
                        'The product associated with this request was not found.'
                    );
                }

                // Prevent accepting orders when stock is zero.
                if ($product->quantity <= 0) {
                    throw new \Exception(
                        'This product is currently unavailable. Please add more stock before accepting another order.'
                    );
                }

                // Check whether sufficient stock is available.
                if ($orderRequest->quantity > $product->quantity) {
                    throw new \Exception(
                        'Insufficient stock. Available stock: ' .
                        $product->quantity .
                        ', requested quantity: ' .
                        $orderRequest->quantity . '.'
                    );
                }

                // Deduct the requested quantity.
                $product->quantity -= $orderRequest->quantity;

                // Update product availability.
                $product->status = $this->getProductStatus(
                    $product->quantity
                );

                $product->save();

                // Generate a random delivery duration between 1.00 and 3.00 days.
                $deliveryDays = random_int(100, 300) / 100;

                // Calculate completion time using Philippine Time (UTC+8).
                $completionTime = now('Asia/Manila')->addSeconds(
                    (int) round($deliveryDays * 86400)
                );

                // Insert the accepted order as Shipping.
                DB::table('transactions')->insert([
                    'order_id'        => $orderRequest->order_id,
                    'buyer_id'        => $orderRequest->buyer_id,
                    'seller_id'       => $orderRequest->seller_id,
                    'product_id'      => $orderRequest->product_id,
                    'product_name'    => $orderRequest->product_name,
                    'quantity'        => $orderRequest->quantity,
                    'oum'             => $orderRequest->oum,
                    'customer_name'   => $orderRequest->customer_name,
                    'mobile_number'   => $orderRequest->mobile_number,
                    'address'         => $orderRequest->address,
                    'total_amount'    => $orderRequest->total_amount,
                    'status'          => 'Shipping',
                    'completion_time' => $completionTime->format('Y-m-d H:i:s.v'),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                // Delete the request after successful acceptance.
                DB::table('order_requests')
                    ->where('request_id', $requestId)
                    ->where('seller_id', auth()->id())
                    ->delete();

                return [
                    'quantity'        => $product->quantity,
                    'status'          => $product->status,
                    'delivery_days'   => $deliveryDays,
                    'completion_time' => $completionTime,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Order accepted successfully. The order is now shipping.',
                'quantity' => $result['quantity'],
                'status' => $result['status'],
                'delivery_time_days' => $result['delivery_days'],
                'completion_time' => $result['completion_time'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    // DECLINE: Delete the request without adding it to transactions.
    public function declineOrderRequest($requestId)
    {
        $deleted = DB::table('order_requests')
            ->where('request_id', $requestId)
            ->where('seller_id', auth()->id())
            ->where('status', 'pending')
            ->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Order request not found or is no longer pending.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order request declined and removed.'
        ]);
    }


    // Update the quantity of a seller's product.
    public function updateQuantity(Request $request, $productId)
    {
        $request->validate([
            'action' => 'required|in:add,less',
        ]);

        $product = Product::where('product_id', $productId)
            ->where('seller_id', auth()->id())
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        if ($request->action === 'add') {
            $product->quantity++;
        } elseif ($request->action === 'less') {
            if ($product->quantity <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product quantity cannot go below zero.'
                ], 422);
            }

            $product->quantity--;
        }

        $product->status = $this->getProductStatus($product->quantity);
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product quantity updated successfully.',
            'quantity' => $product->quantity,
            'status' => $product->status
        ]);
    }


    // Remove a product belonging to the logged-in seller.
    public function removeProduct($productId)
    {
        $product = Product::where('product_id', $productId)
            ->where('seller_id', auth()->id())
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        $imagePath = public_path('image/product/' . $product->image);

        if ($product->image && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed successfully.'
        ]);
    }


    // Add a new product.
    public function addProduct(Request $request)
    {
        $categories = [
            'Fruits',
            'Vegetables',
            'Grains & Rice',
            'Seeds',
            'Organic Products',
            'Herbs & Spices',
            'Meat & Poultry',
            'Fish & Seafood',
            'Dairy & Eggs',
            'Processed Foods',
        ];

        $validator = Validator::make($request->all(), [
            'product_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z ]+$/',
            ],
            'category' => 'required|in:' . implode(',', $categories),
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
            'oum' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z]+$/',
            ],
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please check the product information.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $productName = Str::title(trim($request->product_name));

        // Prevent duplicate product names for the same seller.
        $existingProduct = Product::where('seller_id', auth()->id())
            ->whereRaw('LOWER(product_name) = ?', [strtolower($productName)])
            ->exists();

        if ($existingProduct) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have a product with this name.',
                ], 409);
            }

            return back()
                ->with('error', 'You already have a product with this name.')
                ->withInput();
        }

        // Store the uploaded image.
        $imageName = time() . '_' . uniqid() . '.' .
            $request->file('image')->getClientOriginalExtension();

        $request->file('image')->move(
            public_path('image/product'),
            $imageName
        );

        // Insert the product.
        $productId = DB::table('products')->insertGetId([
            'seller_id'    => auth()->id(),
            'product_name' => $productName,
            'category'     => $request->category,
            'price'        => $request->price,
            'quantity'     => $request->quantity,
            'oum'          => $request->oum,
            'image'        => $imageName,
            'status'       => 'Available',
            'created_at'   => now(),
            'updated_at'   => now(),
        ], 'product_id');

        $product = DB::table('products')
            ->where('product_id', $productId)
            ->first();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully.',
                'product' => $product,
            ], 201);
        }

        return redirect()
            ->route('orders')
            ->with('success', 'Product added successfully.');
    }
}
