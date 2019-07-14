<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'userId'    => (int)$seller->id,
            'name'      =>  (string)$seller->name,
            'email'     =>  (string)$seller->email,
            'isVerified'=>  (bool)$seller->verified,
            'creationDate' =>   (string)$seller->created_at,
            'lastModified' => (string)$seller->updated_at,
            'deletedDate' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null,

            'links' => [
                [
                    'rel'   => 'self',
                    'href'  =>  route('sellers.show', $seller->id),
                ],
                [
                    'rel'   => 'sellers.categories',
                    'href'  => route('sellers.categories.index', $seller->id),
                ],
                [
                    'rel'   => 'sellers.products',
                    'href'  => route('sellers.products.index', $seller->id),
                ],
                [
                    'rel'   =>  'sellers.buyers',
                    'href'  =>  route('sellers.buyers.index', $seller->id),
                ],

                [
                    'rel '  =>  'sellers.transactions',
                    'href'  =>  route('sellers.transactions.index', $seller->id),
                ],
                [
                    'rel'   =>  'seller.profile',
                    'href'  =>  route('users.show', $seller->id)
                ]
            ]
        ];
    }
    public static function originalAttributes($index)
    {
           $attributes = [
            'userId'    =>  'id',
            'name'      =>  'name',
            'email'     =>  'email',
            'isVerified'=>  'verified',
            'creationDate' =>   'created_at',
            'lastModified' => 'updated_at',
            'deletedDate' =>    'deleted_at'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    public static function transformedAttributes($index)
    {
           $attributes = [
            'id'            =>  'userId',
            'name'          =>  'name',
            'email'         =>  'name',
            'verified'      =>  'isVerified',
            'created_at'    =>  'creationDate',
            'updated_at'    =>  'lastModified',
            'deleted_at'    =>  'deletedDate'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
