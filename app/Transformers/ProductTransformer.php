<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'productId'    => (int)$product->id,
            'title'        => (string)$product->name,
            'details'      => (string)$product->description,
            'stock'        => (int)$product->quantity,
            'status'       => (bool)$product->available,
            'seller'       => (int)$product->user_id,
            'picture'      => url("img/{$product->image}"),
            'creationDate' =>   (string)$product->created_at,
            'lastModified' => (string)$product->updated_at,
            'deletedDate' => isset($product->deleted_at) ? (string)$product->deleted_at : null,

            'links' => [
                [
                    'rel'   => 'self',
                    'href'  =>  route('products.show', $product->id)
                ],
                [
                    'rel'   =>  'product.buyers',
                    'href'  =>  route('products.buyers.index', $product->id),
                ],
                [
                    'rel'   =>  'product.categories',
                    'href'  =>  route('products.categories.index', $product->id),
                ],               
                [
                    'rel'   =>  'product.transactions',
                    'href'  =>  route('products.transactions.index', $product->id),
                ],
                [
                    'rel'   =>  'seller',
                    'href'  =>  route('sellers.show', $product->user_id),
                ]
            ]
        ];
    }
    public static function originalAttributes($index)
    {
           $attributes = [
            'productId'    =>  'id',
            'title'      =>  'name',
            'details'     =>  'description',
            'stock'=>  'quantity',
            'status'  =>   'available',
            'seller' =>   'user_id',
            'picture' => 'image',
            'creationDate'  =>  'created_at',
            'lastModified'  =>  'updated_at',
            'deletedDate' =>    'deleted_at'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    public static function transformedAttributes($index)
    {
           $attributes = [
           'id'             =>  'productId',
           'name'           =>  'title',
           'description'    =>  'details',
           'quantity'       =>  'stock',
           'available'      =>  'status',
           'user_id'        =>  'seller',
           'image'          =>  'picture',
            'created_at'    =>  'creationDate',
            'updated_at'    =>  'lastModified',
            'deleted_at'    =>  'deletedDate'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
