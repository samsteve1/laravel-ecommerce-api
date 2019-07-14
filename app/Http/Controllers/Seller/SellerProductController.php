<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\{UpdateProductRequest, StoreProductRequest};
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Transformers\ProductTransformer;
use Illuminate\Auth\Access\AuthorizationException;

class SellerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . ProductTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-products')->except('index');
        $this->middleware('can:view,seller')->only(['index', 'store', 'update', 'destroy']);

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        if(request()->user()->tokenCan('read-general') || request()->user()->tokenCan('manage-products')) {
            $products = $seller->products;

            return $this->showAll($products);
        }
        throw new AuthorizationException('Invalid scope');
    }
    public function store(StoreProductRequest $request, Seller $seller)
    {
        $product = Product::create([

            'name' => $request->name,
            'description'  => $request->description,
            'quantity' => $request->quantity,
            'user_id' => $seller->id,
            'image' => $request->image->store(''),
            'available' => false,
        ]);


        return $this->showOne($product);
    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->fill([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity
        ]);

        if($request->has('status')) {
            $product->available = $request->status = 'true' ? true : false;

            if($product->isAvailable() && !$product->categories()->count()) {
                return $this->errroResponse('This product has no category yet!', 409);
            }
        }

        if($request->hasFile('image')) {
            Storage::delete($product->image);

            $product->image = $request->image->store('');
        }

        if($product->isClean()) {
            return $this->errorResponse('Nothing to update!', 422);
        }

        $product->save();

        return $this->showOne($product);
    }

    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->delete();
        Storage::delete($product->image);

        return $this->showOne($product);
    }

    protected function checkSeller(Seller $seller, Product $product)
    {
        if($seller->id != $product->user_id) {
            $this->errorResponse( "This product doesnt seem to belong to this user.", 422);
            
        }
        return true;
    }
}
