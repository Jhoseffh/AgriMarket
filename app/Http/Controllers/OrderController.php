<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Product;

class OrderController extends Controller
{
    
    // Store multiple customer order requests.
    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|distinct',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cart_id' => 'nullable|integer|distinct',
            'cart_ids' => 'nullable|array',
            'cart_ids.*' => 'integer|distinct',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $buyerId = auth()->id();

        $buyer = DB::table('users')
            ->where('id', $buyerId)
            ->first();

        if (!$buyer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer account not found.',
            ], 404);
        }

        $customerName = trim($buyer->real_name ?? '');
        $mobileNumber = trim($buyer->phone ?? '');
        $customerAddress = trim($buyer->active_address ?? '');

        if (
            empty($customerName) ||
            empty($mobileNumber) ||
            empty($customerAddress)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete your name, phone number, and delivery address in your account settings before ordering.',
            ], 422);
        }

        $items = $request->input('items', []);
        $cartIds = $request->input('cart_ids', []);

        try {
            $result = DB::transaction(function () use (
                $items,
                $cartIds,
                $buyerId,
                $customerName,
                $mobileNumber,
                $customerAddress
            ) {
                $createdOrders = [];

                foreach ($items as $item) {
                    $product = Product::where(
                        'product_id',
                        $item['product_id']
                    )->lockForUpdate()->first();

                    if (!$product) {
                        throw new \Exception('One of the selected products no longer exists.');
                    }

                    if ((int) $product->seller_id === (int) $buyerId) {
                        throw new \Exception(
                            'You cannot order your own product: ' .
                            $product->product_name
                        );
                    }

                    $quantity = (int) $item['quantity'];

                    if ($product->quantity <= 0) {
                        throw new \Exception(
                            $product->product_name . ' is out of stock.'
                        );
                    }

                    if ($quantity > $product->quantity) {
                        throw new \Exception(
                            'Requested quantity exceeds available stock for ' .
                            $product->product_name .
                            '. Available stock: ' . $product->quantity
                        );
                    }

                    // Verify that a supplied cart item belongs to this buyer.
                    if (!empty($item['cart_id'])) {
                        $cartItem = DB::table('carts')
                            ->where('cart_id', $item['cart_id'])
                            ->where('buyer_id', $buyerId)
                            ->where('product_id', $product->product_id)
                            ->first();

                        if (!$cartItem) {
                            throw new \Exception(
                                'One of your selected cart items is no longer available.'
                            );
                        }
                    }

                    $shippingFee = (float) session(
                        'order_shipping_fee_' . $product->product_id,
                        10
                    );

                    $totalAmount =
                        ((float) $product->price * $quantity) + $shippingFee;

                    $requestId = DB::table('order_requests')->insertGetId([
                        'order_id' => null,
                        'buyer_id' => $buyerId,
                        'seller_id' => $product->seller_id,
                        'product_id' => $product->product_id,
                        'product_name' => $product->product_name,
                        'quantity' => $quantity,
                        'oum' => $product->oum,
                        'customer_name' => $customerName,
                        'mobile_number' => $mobileNumber,
                        'address' => $customerAddress,
                        'total_amount' => $totalAmount,
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ], 'request_id');

                    DB::table('order_requests')
                        ->where('request_id', $requestId)
                        ->update([
                            'order_id' => $requestId,
                        ]);

                    $createdOrders[] = $requestId;
                }

                // Remove only the cart items included in this checkout.
                if (!empty($cartIds)) {
                    $validCartIds = DB::table('carts')
                        ->where('buyer_id', $buyerId)
                        ->whereIn('cart_id', $cartIds)
                        ->pluck('cart_id')
                        ->toArray();

                    if (count($validCartIds) !== count(array_unique($cartIds))) {
                        throw new \Exception(
                            'One or more selected cart items could not be verified.'
                        );
                    }

                    DB::table('carts')
                        ->where('buyer_id', $buyerId)
                        ->whereIn('cart_id', $cartIds)
                        ->delete();
                }

                return $createdOrders;
            });

            return response()->json([
                'success' => true,
                'message' => count($result) . ' order(s) successfully submitted.',
                'orders' => $result,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    // Display the order summary page for multiple products.
    public function orderSummary(Request $request)
    {
        $buyerId = auth()->id();

        $buyer = DB::table('users')
            ->where('id', $buyerId)
            ->first();

        if (!$buyer) {
            return back()->with('error', 'Customer account not found.');
        }

        $customerName = $buyer->real_name ?? '';
        $mobileNumber = $buyer->phone ?? '';
        $deliveryAddress = $buyer->active_address ?? '';

        $items = collect();

        // Cart checkout.
        if ($request->filled('cart_ids')) {
            $validated = $request->validate([
                'cart_ids' => 'required|array|min:1',
                'cart_ids.*' => 'required|integer|distinct',
            ]);

            $cartItems = DB::table('carts')
                ->join(
                    'products',
                    'carts.product_id',
                    '=',
                    'products.product_id'
                )
                ->where('carts.buyer_id', $buyerId)
                ->whereIn('carts.cart_id', $validated['cart_ids'])
                ->select(
                    'carts.cart_id',
                    'carts.seller_id',
                    'carts.product_id',
                    'carts.product_name',
                    'carts.oum',
                    'carts.seller_name',
                    'products.price',
                    'products.quantity',
                    'products.image',
                    'products.status'
                )
                ->get();

            if ($cartItems->count() !== count($validated['cart_ids'])) {
                return back()->with(
                    'error',
                    'One or more selected cart products are no longer available.'
                );
            }

            foreach ($cartItems as $item) {
                if ((int) $item->seller_id === (int) $buyerId) {
                    return back()->with(
                        'error',
                        'You cannot order your own product.'
                    );
                }

                if ($item->quantity <= 0) {
                    return back()->with(
                        'error',
                        $item->product_name . ' is out of stock.'
                    );
                }

                $shippingFee = session(
                    'order_shipping_fee_' . $item->product_id
                );

                if ($shippingFee === null) {
                    $shippingFee = random_int(10, 30);

                    session([
                        'order_shipping_fee_' . $item->product_id => $shippingFee
                    ]);
                }

                $item->shipping_fee = (float) $shippingFee;
                $item->order_quantity = 1;

                $items->push($item);
            }
        }

        // Direct Buy Now checkout remains supported.
        elseif ($request->filled('product_id')) {
            $validated = $request->validate([
                'product_id' => 'required|integer|exists:products,product_id',
            ]);

            $product = Product::where(
                'product_id',
                $validated['product_id']
            )->first();

            if (!$product) {
                return back()->with('error', 'Product not found.');
            }

            if ((int) $product->seller_id === (int) $buyerId) {
                return back()->with(
                    'error',
                    'You cannot order your own product.'
                );
            }

            if ($product->quantity <= 0) {
                return back()->with(
                    'error',
                    'This product is currently out of stock.'
                );
            }

            $shippingFee = session(
                'order_shipping_fee_' . $product->product_id
            );

            if ($shippingFee === null) {
                $shippingFee = random_int(10, 30);

                session([
                    'order_shipping_fee_' . $product->product_id => $shippingFee
                ]);
            }

            $product->cart_id = null;
            $product->seller_name = DB::table('users')
                ->where('id', $product->seller_id)
                ->value('real_name');

            $product->shipping_fee = (float) $shippingFee;
            $product->order_quantity = 1;

            $items->push($product);
        }

        else {
            return back()->with(
                'error',
                'Please select at least one product.'
            );
        }

        return view('order.ordersummary', compact(
            'items',
            'customerName',
            'mobileNumber',
            'deliveryAddress'
        ));
    }


    // DISPLAY MY PURCHASES AND SHOPPING CART PAGE.
    public function cart()
    {
        $buyerId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | PENDING ORDER REQUESTS
        |--------------------------------------------------------------------------
        | These are orders submitted by the buyer but not yet accepted
        | by the seller.
        */

        $pendingPurchases = DB::table('order_requests')
            ->leftJoin(
                'users as sellers',
                'order_requests.seller_id',
                '=',
                'sellers.id'
            )
            ->where('order_requests.buyer_id', $buyerId)
            ->where('order_requests.status', 'pending')
            ->select(
                'order_requests.request_id',
                'order_requests.order_id',
                'order_requests.seller_id',
                'order_requests.product_name',
                'order_requests.quantity',
                'order_requests.oum',
                'order_requests.total_amount',
                'order_requests.status',
                'order_requests.created_at',
                'sellers.real_name as seller_name'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ACCEPTED ORDERS / TRANSACTIONS
        |--------------------------------------------------------------------------
        | These include Shipping and Completed transactions.
        */

        $completedPurchases = DB::table('transactions')
            ->leftJoin(
                'users as sellers',
                'transactions.seller_id',
                '=',
                'sellers.id'
            )
            ->where('transactions.buyer_id', $buyerId)
            ->select(
                'transactions.order_id',
                'transactions.seller_id',
                'transactions.product_name',
                'transactions.quantity',
                'transactions.oum',
                'transactions.total_amount',
                'transactions.status',
                'transactions.created_at',
                'sellers.real_name as seller_name'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | COMBINE BOTH PURCHASE SOURCES
        |--------------------------------------------------------------------------
        */

        $purchases = $pendingPurchases
            ->concat($completedPurchases)
            ->sortByDesc(function ($purchase) {
                return strtotime($purchase->created_at);
            })
            ->values()
            ->map(function ($purchase) {

                return [
                    'id' => (string) $purchase->order_id,

                    // Used only for cancelling pending purchases.
                    'request_id' => $purchase->request_id ?? null,

                    'seller' => $purchase->seller_name
                        ?: 'Unknown Seller',

                    'seller_id' => $purchase->seller_id,

                    'amount' => (float) $purchase->total_amount,

                    'status' => $purchase->status,

                    'date' => $purchase->created_at
                        ? \Carbon\Carbon::parse($purchase->created_at)
                            ->timezone('Asia/Manila')
                            ->format('F d, Y')
                        : '—',

                    'products' => [
                        [
                            'name' => $purchase->product_name,
                            'quantity' => (int) $purchase->quantity,
                            'unit' => $purchase->oum,
                        ]
                    ],
                ];
            })
            ->all();


        return view('order.cart', compact('purchases'));
    }


    // CANCEL: Delete a buyer's own pending purchase request.
    public function cancelPurchase($requestId)
    {
        try {
            $deleted = DB::transaction(function () use ($requestId) {

                $orderRequest = DB::table('order_requests')
                    ->where('request_id', $requestId)
                    ->where('buyer_id', auth()->id())
                    ->where('status', 'pending')
                    ->lockForUpdate()
                    ->first();

                if (!$orderRequest) {
                    throw new \Exception(
                        'This order cannot be cancelled. It may already have been processed or is no longer available.'
                    );
                }

                return DB::table('order_requests')
                    ->where('request_id', $requestId)
                    ->where('buyer_id', auth()->id())
                    ->where('status', 'pending')
                    ->delete();
            });

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to cancel this order.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Your order has been cancelled successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
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
    // transactions, and authenticated user's information.
    public function orders()
    {
        $this->updateCompletedOrders();

        $buyer = DB::table('users')
            ->where('id', auth()->id())
            ->first();

        $customerName = trim($buyer->real_name ?? '');
        $mobileNumber = trim($buyer->phone ?? '');
        $deliveryAddress = trim($buyer->active_address ?? '');

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
            'transactions',
            'customerName',
            'mobileNumber',
            'deliveryAddress'
        ));
    }


    // ACCEPT: Deduct stock, create a Shipping transaction,
    // and automatically schedule its completion through completion_time.
    public function acceptOrderRequest($requestId)
    {
        try {
            $result = DB::transaction(function () use ($requestId) {

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

                $product = Product::where('product_id', $orderRequest->product_id)
                    ->where('seller_id', auth()->id())
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new \Exception(
                        'The product associated with this request was not found.'
                    );
                }

                if ($product->quantity <= 0) {
                    throw new \Exception(
                        'This product is currently unavailable. Please add more stock before accepting another order.'
                    );
                }

                if ($orderRequest->quantity > $product->quantity) {
                    throw new \Exception(
                        'Insufficient stock. Available stock: ' .
                        $product->quantity .
                        ', requested quantity: ' .
                        $orderRequest->quantity . '.'
                    );
                }

                $product->quantity -= $orderRequest->quantity;

                $product->status = $this->getProductStatus(
                    $product->quantity
                );

                $product->save();

                $deliveryDays = random_int(100, 300) / 100;

                $completionTime = now('Asia/Manila')->addSeconds(
                    (int) round($deliveryDays * 86400)
                );

                $orderId = $orderRequest->order_id;

                DB::table('transactions')->insert([
                    'order_id'        => $orderId,
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

        // Product images are stored directly in the products.image BLOB column.
        // No filesystem image needs to be deleted.
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

        // Read the uploaded image as binary data and store it in the
        // products.image LONG BLOB column instead of saving a file path.
        $imageFile = $request->file('image');
        $imageBinary = file_get_contents($imageFile->getRealPath());

        if ($imageBinary === false || $imageBinary === '') {
            return response()->json([
                'success' => false,
                'message' => 'The uploaded product image could not be read.',
            ], 422);
        }

        $productId = DB::table('products')->insertGetId([
            'seller_id'    => auth()->id(),
            'product_name' => $productName,
            'category'     => $request->category,
            'price'        => $request->price,
            'quantity'     => $request->quantity,
            'oum'          => $request->oum,
            'image'        => $imageBinary,
            'status'       => 'Available',
            'created_at'   => now(),
            'updated_at'   => now(),
        ], 'product_id');

        $product = DB::table('products')
            ->where('product_id', $productId)
            ->first();

        if ($request->expectsJson()) {
            // Never return the raw binary BLOB in JSON. It may contain
            // invalid UTF-8 bytes and cause the AJAX response to fail.
            $productResponse = (array) $product;
            unset($productResponse['image']);

            $mimeType = $imageFile->getMimeType() ?: 'image/jpeg';

            $productResponse['image_data_url'] =
                'data:' . $mimeType . ';base64,' .
                base64_encode($imageBinary);

            return response()->json([
                'success' => true,
                'message' => 'Product added successfully.',
                'product' => $productResponse,
            ], 201);
        }

        return redirect()
            ->route('orders')
            ->with('success', 'Product added successfully.');
    }
}
