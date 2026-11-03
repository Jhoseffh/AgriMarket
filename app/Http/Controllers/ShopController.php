<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    // Settings page
    public function settings()
    {
        return view('user.settings');
    }

    /**
     * Get all available products except products owned by the logged-in user.
     */
    private function visibleProducts(): Builder
    {
        return Product::query()
            ->where('status', '!=', 'unavailable')
            ->when(auth()->check(), function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('seller_id')
                      ->orWhere('seller_id', '!=', auth()->id());
                });
            });
    }

    /**
     * Get best-selling products with a specified limit.
     */
    private function getBestSellingProducts(int $limit)
    {
        $bestSellerSales = DB::table('transactions')
            ->select('product_id')
            ->selectRaw('SUM(quantity) as total_sold')
            ->whereIn('status', ['Completed', 'Shipping'])
            ->groupBy('product_id');

        return $this->visibleProducts()
            ->joinSub($bestSellerSales, 'sales', function ($join) {
                $join->on(
                    'products.product_id',
                    '=',
                    'sales.product_id'
                );
            })
            ->orderByDesc('sales.total_sold')
            ->limit($limit)
            ->select('products.*')
            ->get();
    }

    /**
     * Get the top 6 best-selling products for the Shop page.
     */
    private function bestSellingProducts()
    {
        return $this->getBestSellingProducts(6);
    }

    /**
     * Get the top 20 best-selling products for the Category page.
     */
    private function top20BestSellingProducts()
    {
        return $this->getBestSellingProducts(20);
    }

    public function shop()
    {
        $products = $this->visibleProducts()
            ->orderBy('product_id', 'desc')
            ->get();

        // Only 6 best-selling products in shop.blade.php
        $bestSellerProducts = $this->bestSellingProducts();

        return view('shop.shop', compact(
            'products',
            'bestSellerProducts'
        ));
    }

    public function search($product_name)
    {
        $products = $this->visibleProducts()
            ->where('product_name', 'LIKE', '%' . $product_name . '%')
            ->orderBy('product_id', 'desc')
            ->get();

        $allProducts = $this->visibleProducts()
            ->orderBy('product_id', 'desc')
            ->get();

        return view('shop.search', compact(
            'products',
            'product_name',
            'allProducts'
        ));
    }

    public function category($category)
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
            'New Arrivals',
            'Best Sellers',
            'Below 100',
            'All Products'
        ];

        // Match category without considering uppercase or lowercase.
        $matchedCategory = collect($categories)->first(function ($item) use ($category) {
            return strtolower($item) === strtolower($category);
        });

        if (!$matchedCategory) {
            abort(404);
        }

        // Use the original category capitalization.
        $category = $matchedCategory;

        if ($category === 'All Products') {

            $products = $this->visibleProducts()
                ->orderBy('product_id', 'desc')
                ->get();

        } elseif ($category === 'Below 100') {

            $products = $this->visibleProducts()
                ->where('price', '<', 100)
                ->orderBy('product_id', 'desc')
                ->get();

        } elseif ($category === 'New Arrivals') {

            $products = $this->visibleProducts()
                ->where('created_at', '>=', now()->subHours(24))
                ->orderBy('product_id', 'desc')
                ->get();

            if ($products->isEmpty()) {
                $products = $this->visibleProducts()
                    ->where('created_at', '>=', now()->subDays(2))
                    ->orderBy('product_id', 'desc')
                    ->get();
            }

            if ($products->isEmpty()) {
                $products = $this->visibleProducts()
                    ->where('created_at', '>=', now()->subDays(3))
                    ->orderBy('product_id', 'desc')
                    ->get();
            }

        } elseif ($category === 'Best Sellers') {

            // Top 20 best-selling products in category.blade.php
            $products = $this->top20BestSellingProducts();

        } else {

            $products = $this->visibleProducts()
                ->where('category', $category)
                ->orderBy('product_id', 'desc')
                ->get();
        }

        $allProducts = $this->visibleProducts()
            ->orderBy('product_id', 'desc')
            ->get();

        return view('shop.category', compact(
            'products',
            'category',
            'allProducts'
        ));
    }
}
