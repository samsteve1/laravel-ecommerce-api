<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
           'transactionId' => (int)$transaction->id,
           'quantity'       => (int)$transaction->quantity,
           'buyer'          => (int)$transaction->user_id,
           'product'        => (int)$transaction->product_id,
            'creationDate' =>   (string)$transaction->created_at,
            'lastModified' => (string)$transaction->updated_at,
            'deletedDate' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null,

            'links' => [
                [
                    'rel'   => 'self',
                    'href'  =>  route('transactions.show', $transaction->id)
                ],
                
                [
                    'rel'   =>  'transaction.categories',
                    'href'  =>  route('transactions.categories.index', $transaction->id),
                ],               
                [
                    'rel'   =>  'transaction.seller',
                    'href'  =>  route('transactions.sellers.index', $transaction->id),
                ],
                [
                    'rel'   =>  'buyer',
                    'href'  =>  route('buyers.show', $transaction->id),
                ],
                [
                    'rel'   =>  'product',
                    'href'  =>  route('products.show', $transaction->product_id),
                ]
            ]
        ];
    }

    public static function originalAttributes($index)
    {
           $attributes = [
            'transactionId'    =>  'id',
            'quantity'         => 'quantity',
            'buyer'             => 'user_id',
            'product'       =>  'product_id',
            'creationDate' =>   'created_at',
            'lastModified' => 'updated_at',
            'deletedDate' =>    'deleted_at'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    public static function transformedAttributes($index)
    {
           $attributes = [
            'id'            =>  'transactionId',
            'quantity'      =>  'quantity',
            'user_id'       =>   'buyer',
            'product_id'    =>   'product',
            'created_at'    =>  'creationDate',
            'updated_at'    =>  'lastModified',
            'deleted_at'    =>  'deletedDate'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
