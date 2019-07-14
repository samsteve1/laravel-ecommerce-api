<?php

namespace App\Http\Controllers\Product;

use App\{Category, Product};
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('scope:manage-products')->except('index');

        $this->middleware('can:add-category,product')->only('update');
        $this->middleware('can:delete-category,product')->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;

        return $this->showAll($categories);
    }
    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching($category);

        return $this->showAll($product->categories);
    }

    public function destroy(Request $request, Product $product, Category $category)
    {
        $product->categories()->detach($category);

        return $this->showAll($product->categories);
    }


}
