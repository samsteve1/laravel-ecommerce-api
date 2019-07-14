<?php

namespace App\Http\Controllers\Product;

use App\{Buyer, Product, Transaction};
use Illuminate\Http\Request;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use App\Transformers\TransactionTransformer;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-products')->only(['store']);
        $this->middleware('can:purchase,buyer')->only('store');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionStoreRequest $request, Product $product, User $buyer)
    {
        // $rules = [
        //     'quantity' => 'required|integer|min:1'
        // ];

        // $this->validate($request, $rules);

        if($buyer->id == $product->user_id) {
            return $this->errorResponse('Product seller cannot be the buyer', 409);
        }

        if(!$buyer->isVerified()) {
            return $this->errorResponse('The buyer must be a verified user', 409);
        }

        if(!$product->user->isVerified()) {
            return $this->errorResponse('The product seller must be a verified user.', 409);
        }

        if(!$product->isAvailable()) {
            return $this->errorResponse('The selected product is unavailable.', 409);
        }

        if($product->quantity < $request->quantity) {
            return $this->errorResponse('The requested quantity is not avalaible.', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) { 
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'user_id'  => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);
        });

        
    }

   
}
