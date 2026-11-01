<?php
namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function shop()
    {
        $products = Product::orderBy('product_id', 'desc')->get();

        return view('shop.shop', compact('products'));
    }

    public function search($product_name)
    {
        $products = Product::where(
            'product_name',
            'LIKE',
            '%' . $product_name . '%'
        )
        ->orderBy('product_id', 'desc')
        ->get();

        $allProducts = Product::orderBy('product_id', 'desc')->get();

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

        // Match category without considering uppercase or lowercase
        $matchedCategory = collect($categories)->first(function ($item) use ($category) {
            return strtolower($item) === strtolower($category);
        });

        if (!$matchedCategory) {
            abort(404);
        }

        // Use the original category capitalization
        $category = $matchedCategory;

        if ($category === 'All Products') {
            $products = Product::orderBy('product_id', 'desc')->get();

        } elseif ($category === 'Below 100') {
            $products = Product::where('price', '<', 100)
                ->orderBy('product_id', 'desc')
                ->get();

        } elseif ($category === 'New Arrivals') {

            $products = Product::where('created_at', '>=', now()->subHours(24))
                ->orderBy('product_id', 'desc')
                ->get();

            if ($products->isEmpty()) {
                $products = Product::where('created_at', '>=', now()->subDays(2))
                    ->orderBy('product_id', 'desc')
                    ->get();
            }

            if ($products->isEmpty()) {
                $products = Product::where('created_at', '>=', now()->subDays(3))
                    ->orderBy('product_id', 'desc')
                    ->get();
            }

        } else {
            $products = Product::where('category', $category)
                ->orderBy('product_id', 'desc')
                ->get();
        }

        $allProducts = Product::orderBy('product_id', 'desc')->get();

        return view('shop.category', compact('products', 'category', 'allProducts'));
    }
}
