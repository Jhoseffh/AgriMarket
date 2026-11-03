<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Convert the user's profile picture BLOB into a Base64 data URI.
     */
    private function prepareProfilePicture($user)
    {
        if (!$user || empty($user->profile_picture)) {
            return $user;
        }

        $imageData = $user->profile_picture;

        // Already converted into a data URI.
        if (is_string($imageData) && str_starts_with($imageData, 'data:image/')) {
            return $user;
        }

        $imageInfo = @getimagesizefromstring($imageData);

        if ($imageInfo === false) {
            $user->profile_picture = null;
            return $user;
        }

        $mimeType = strtolower($imageInfo['mime']);

        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/avif',
        ];

        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            $user->profile_picture = null;
            return $user;
        }

        $user->profile_picture = 'data:' . $mimeType . ';base64,' .
            base64_encode($imageData);

        return $user;
    }

    /**
     * Display the authenticated user's Report page.
     * Retrieves sales and inventory reports from the database.
     */
    public function report()
    {
        $userId = auth()->id();

        $user = DB::table('users')
            ->where('id', $userId)
            ->first();

        abort_unless($user, 404);

        $user = $this->prepareProfilePicture($user);

        /*
        |--------------------------------------------------------------------------
        | SALES REPORT
        |--------------------------------------------------------------------------
        */

        $sales = DB::table('transactions')
            ->select(
                'transaction_id',
                'order_id',
                'created_at',
                'product_name',
                'customer_name',
                'quantity',
                'total_amount',
                'status'
            )
            ->where('seller_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | UNITS SOLD PER PRODUCT
        |--------------------------------------------------------------------------
        */

        $unitsSold = DB::table('transactions')
            ->select('product_id')
            ->selectRaw('SUM(quantity) as total_sold')
            ->where('seller_id', $userId)
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        /*
        |--------------------------------------------------------------------------
        | INVENTORY REPORT
        |--------------------------------------------------------------------------
        */

        $inventory = DB::table('products')
            ->where('seller_id', $userId)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($product) use ($unitsSold) {
                $currentStock = (int) $product->quantity;
                $sellingPrice = (float) $product->price;

                $productUnitsSold = $unitsSold->get($product->product_id);

                $status = strtolower(trim((string) $product->status));

                if (
                    $status === 'unavailable' ||
                    $status === 'out of stock' ||
                    $status === 'out_of_stock' ||
                    $currentStock <= 0
                ) {
                    $displayStatus = 'Out of Stock';
                } elseif (
                    $status === 'low stock' ||
                    $status === 'low_stock'
                ) {
                    $displayStatus = 'Low Stock';
                } else {
                    $displayStatus = 'In Stock';
                }

                return [
                    'product' => $product->product_name,
                    'category' => $product->category,
                    'currentStock' => $currentStock,

                    'unitsSold' => $productUnitsSold
                        ? (int) $productUnitsSold->total_sold
                        : 0,

                    'recentlyAdded' => $product->created_at
                        ? Carbon::parse($product->created_at)->format('Y-m-d')
                        : 'N/A',

                    'unitCost' => $sellingPrice,

                    'inventoryValue' => $sellingPrice * $currentStock,

                    'status' => $displayStatus,

                    'lastUpdated' => $product->updated_at
                        ? Carbon::parse($product->updated_at)->format('Y-m-d')
                        : 'N/A',
                ];
            })
            ->values();

        return view('user.reports', compact(
            'user',
            'sales',
            'inventory'
        ));
    }

    /**
     * Display the authenticated user's Profile page.
     * Retrieves profile information and seller analytics from the database.
     */
    public function profile()
    {
        $userId = auth()->id();

        $user = DB::table('users')
            ->where('id', $userId)
            ->first();

        abort_unless($user, 404);

        $user = $this->prepareProfilePicture($user);

        /*
        |--------------------------------------------------------------------------
        | QUANTITY SALES AND SALES REVENUE
        |--------------------------------------------------------------------------
        */

        $quantitySalesData = [];
        $salesRevenueData = [];

        $periods = [7, 30, 60, 90];

        foreach ($periods as $period) {
            $startDate = Carbon::today()->subDays($period - 1);
            $endDate = Carbon::today();

            $dailySales = DB::table('transactions')
                ->selectRaw('DATE(created_at) as sale_date')
                ->selectRaw('SUM(quantity) as total_quantity')
                ->selectRaw("
                    SUM(
                        CASE
                            WHEN status = 'Completed' THEN total_amount
                            ELSE 0
                        END
                    ) as total_revenue
                ")
                ->where('seller_id', $userId)
                ->whereBetween('created_at', [
                    $startDate->copy()->startOfDay(),
                    $endDate->copy()->endOfDay()
                ])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('sale_date')
                ->get()
                ->keyBy('sale_date');

            $labels = [];
            $quantityValues = [];
            $revenueValues = [];

            for ($i = 0; $i < $period; $i++) {
                $date = $startDate->copy()->addDays($i);
                $dateKey = $date->format('Y-m-d');

                $labels[] = $date->format('M d');

                $sales = $dailySales->get($dateKey);

                $quantityValues[] = $sales
                    ? (int) $sales->total_quantity
                    : 0;

                $revenueValues[] = $sales
                    ? (float) $sales->total_revenue
                    : 0;
            }

            $quantitySalesData[$period] = [
                'labels' => $labels,
                'values' => $quantityValues,
            ];

            $salesRevenueData[$period] = [
                'labels' => $labels,
                'values' => $revenueValues,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | BEST-SELLING PRODUCTS
        |--------------------------------------------------------------------------
        */

        $bestSellingProducts = DB::table('transactions')
            ->select('product_id', 'product_name')
            ->selectRaw('SUM(quantity) as sold')
            ->where('seller_id', $userId)
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('sold')
            ->limit(20)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->product_name,
                    'sold' => (int) $product->sold,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | INVENTORY STATUS
        |--------------------------------------------------------------------------
        */

        $sellerProducts = DB::table('products')
            ->select('quantity', 'status')
            ->where('seller_id', $userId)
            ->get();

        $inventoryData = [
            'inStock' => 0,
            'lowStock' => 0,
            'outOfStock' => 0,
        ];

        foreach ($sellerProducts as $product) {
            $status = strtolower(trim((string) $product->status));

            if (
                $status === 'unavailable' ||
                $status === 'out of stock' ||
                (float) $product->quantity <= 0
            ) {
                $inventoryData['outOfStock']++;
            } elseif (
                $status === 'low stock' ||
                $status === 'low_stock'
            ) {
                $inventoryData['lowStock']++;
            } else {
                $inventoryData['inStock']++;
            }
        }

        return view('user.profile', compact(
            'user',
            'quantitySalesData',
            'salesRevenueData',
            'bestSellingProducts',
            'inventoryData'
        ));
    }

    /**
     * Upload and save the authenticated user's profile picture as a database BLOB.
     */
    public function updateProfilePicture(Request $request)
    {
        $validated = $request->validate([
            'profile_picture' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $userId = auth()->id();

        $file = $validated['profile_picture'];

        $imageData = file_get_contents($file->getRealPath());

        if ($imageData === false) {
            return back()->withErrors([
                'profile_picture' => 'Unable to read the uploaded image.',
            ]);
        }

        DB::table('users')
            ->where('id', $userId)
            ->update([
                'profile_picture' => $imageData,
            ]);

        return redirect('/profile')
            ->with('status', 'Your profile picture was updated successfully.');
    }

    /**
     * Display the authenticated user's Settings page.
     */
    public function settings()
    {
        $user = DB::table('users')
            ->where('id', auth()->id())
            ->first();

        abort_unless($user, 404);

        $user = $this->prepareProfilePicture($user);

        $savedAddresses = [];
        $activeAddress = $user->active_address;

        $addressColumns = ['address_1', 'address_2', 'address_3'];
        $hasActiveAddress = false;

        foreach ($addressColumns as $slot) {
            if (!empty($user->{$slot}) && $activeAddress === $user->{$slot}) {
                $hasActiveAddress = true;
                break;
            }
        }

        if (!$hasActiveAddress) {
            foreach ($addressColumns as $slot) {
                if (!empty($user->{$slot})) {
                    $activeAddress = $user->{$slot};

                    DB::table('users')
                        ->where('id', auth()->id())
                        ->update(['active_address' => $activeAddress]);

                    break;
                }
            }
        }

        foreach ($addressColumns as $slot) {
            if (!empty($user->{$slot})) {
                $savedAddresses[] = [
                    'slot' => $slot,
                    'address' => $user->{$slot},
                    'active' => $activeAddress === $user->{$slot},
                ];
            }
        }

        return view('user.settings', compact('user', 'savedAddresses'));
    }

    /**
     * Update marketplace name and synchronize buyer records.
     */
    public function updateName(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:20', 'min:5'],
        ]);

        DB::transaction(function () use ($userId, $validated) {
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'name' => $validated['name'],
                ]);

            DB::table('transactions')
                ->where('buyer_id', $userId)
                ->update([
                    'customer_name' => $validated['name'],
                ]);

            DB::table('order_requests')
                ->where('buyer_id', $userId)
                ->update([
                    'customer_name' => $validated['name'],
                ]);
        });

        return redirect()
            ->route('settings')
            ->with('status', 'Your name and related buyer records were updated successfully.');
    }

    /**
     * Update password after verifying the current password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::table('users')
            ->where('id', auth()->id())
            ->update([
                'password' => Hash::make($validated['password']),
            ]);

        return redirect()
            ->route('settings')
            ->with('status', 'Your password was updated successfully.');
    }

    /**
     * Update real name and synchronize buyer records.
     */
    public function updateRealName(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'real_name' => [
                'required',
                'string',
                'regex:/^[\pL\s\-\'\.]+$/u',
                'max:100',
            ],
        ]);

        $realName = $validated['real_name'] ?? null;

        DB::transaction(function () use ($userId, $realName) {
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'real_name' => $realName,
                ]);

            DB::table('order_requests')
                ->where('buyer_id', $userId)
                ->update([
                    'customer_name' => $realName,
                ]);

            DB::table('transactions')
                ->where('buyer_id', $userId)
                ->update([
                    'customer_name' => $realName,
                ]);
        });

        return redirect()
            ->route('settings')
            ->with('status', 'Your real name and related buyer records were updated successfully.');
    }

    /**
     * Update phone number.
     */
    public function updatePhone(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'regex:/^09[0-9]{9}$/'],
        ]);

        DB::table('users')
            ->where('id', auth()->id())
            ->update([
                'phone' => $validated['phone'] ?? null,
            ]);

        return redirect()
            ->route('settings')
            ->with('status', 'Your contact number was updated successfully.');
    }

    /**
     * Update email address.
     */
    public function updateEmail(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId, 'id'),
            ],
            'email_current_password' => ['required', 'current_password'],
        ]);

        DB::table('users')
            ->where('id', $userId)
            ->update([
                'email' => $validated['email'],
            ]);

        return redirect()
            ->route('settings')
            ->with('status', 'Your email address was updated successfully.');
    }

    /**
     * Update biography.
     */
    public function updateBio(Request $request)
    {
        $validated = $request->validate([
            'bio' => ['nullable', 'string', 'max:300'],
        ]);

        DB::table('users')
            ->where('id', auth()->id())
            ->update([
                'bio' => $validated['bio'] ?? null,
            ]);

        return redirect()
            ->route('settings')
            ->with('status', 'Your bio was updated successfully.');
    }

    /**
     * Save a new address in the first available address column.
     */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'region' => ['required', 'string', 'max:150'],
            'province' => ['required', 'string', 'max:150'],
            'city' => ['required', 'string', 'max:150'],
            'barangay' => ['required', 'string', 'max:150'],
            'additional' => ['nullable', 'string', 'max:100'],
        ]);

        $parts = [
            trim($validated['barangay']),
            trim($validated['city']),
            trim($validated['province']),
            trim($validated['region']),
        ];

        $address = implode(', ', array_filter($parts));

        if (!empty($validated['additional'])) {
            $address .= ' — ' . trim($validated['additional']);
        }

        $result = DB::transaction(function () use ($address) {
            $user = DB::table('users')
                ->where('id', auth()->id())
                ->lockForUpdate()
                ->first();

            abort_unless($user, 404);

            foreach (['address_1', 'address_2', 'address_3'] as $slot) {
                if (!empty($user->{$slot}) && $user->{$slot} === $address) {
                    return [
                        'error' => 'This address is already saved.',
                        'status' => 422,
                    ];
                }
            }

            $availableSlot = null;

            foreach (['address_1', 'address_2', 'address_3'] as $slot) {
                if (empty($user->{$slot})) {
                    $availableSlot = $slot;
                    break;
                }
            }

            if (!$availableSlot) {
                return [
                    'error' => 'You can save a maximum of 3 addresses.',
                    'status' => 422,
                ];
            }

            DB::table('users')
                ->where('id', auth()->id())
                ->update([
                    $availableSlot => $address,
                    'active_address' => $address,
                ]);

            return [
                'slot' => $availableSlot,
                'address' => $address,
            ];
        });

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['error'],
            ], $result['status']);
        }

        return response()->json([
            'message' => 'New address saved and selected.',
            'address' => $result,
            'active_address' => $address,
        ]);
    }

    /**
     * Set one saved address as active.
     */
    public function selectAddress(Request $request, string $slot)
    {
        if (!in_array($slot, ['address_1', 'address_2', 'address_3'], true)) {
            return response()->json([
                'message' => 'Invalid address selection.',
            ], 422);
        }

        $result = DB::transaction(function () use ($slot) {
            $user = DB::table('users')
                ->where('id', auth()->id())
                ->lockForUpdate()
                ->first();

            abort_unless($user, 404);

            $address = $user->{$slot};

            if (empty($address)) {
                return null;
            }

            DB::table('users')
                ->where('id', auth()->id())
                ->update([
                    'active_address' => $address,
                ]);

            return $address;
        });

        if ($result === null) {
            return response()->json([
                'message' => 'That saved address could not be found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Active address changed.',
            'active_address' => $result,
        ]);
    }

    /**
     * Delete a saved address only when it is not active
     * and another saved address remains.
     */
    public function deleteAddress(Request $request, string $slot)
    {
        if (!in_array($slot, ['address_1', 'address_2', 'address_3'], true)) {
            return response()->json([
                'message' => 'Invalid address selection.',
            ], 422);
        }

        $result = DB::transaction(function () use ($slot) {
            $user = DB::table('users')
                ->where('id', auth()->id())
                ->lockForUpdate()
                ->first();

            abort_unless($user, 404);

            $address = $user->{$slot};

            if (empty($address)) {
                return [
                    'error' => 'That saved address could not be found.',
                    'status' => 404,
                ];
            }

            if ($user->active_address === $address) {
                return [
                    'error' => 'You cannot delete your active address. Switch to another address first.',
                    'status' => 422,
                ];
            }

            $remainingCount = 0;

            foreach (['address_1', 'address_2', 'address_3'] as $column) {
                if ($column !== $slot && !empty($user->{$column})) {
                    $remainingCount++;
                }
            }

            if ($remainingCount < 1) {
                return [
                    'error' => 'At least one saved address must remain.',
                    'status' => 422,
                ];
            }

            DB::table('users')
                ->where('id', auth()->id())
                ->update([
                    $slot => null,
                ]);

            return ['deleted' => true];
        });

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['error'],
            ], $result['status']);
        }

        return response()->json([
            'message' => 'Address deleted successfully.',
        ]);
    }
}
