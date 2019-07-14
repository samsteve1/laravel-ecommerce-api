<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'userId'    => (int)$buyer->id,
            'name'      =>  (string)$buyer->name,
            'email'     =>  (string)$buyer->email,
            'isVerified'=>  (bool)$buyer->verified,
            'creationDate' =>   (string)$buyer->created_at,
            'lastModified' => (string)$buyer->updated_at,
            'deletedDate' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,

            'links' => [
                [
                    'rel'   => 'self',
                    'href'  =>  route('buyers.show', $buyer->id),
                ],
                [
                    'rel'   => 'buyers.categories',
                    'href'  => route('buyers.categories.index', $buyer->id),
                ],
                [
                    'rel'   => 'buyers.products',
                    'href'  => route('buyers.products.index', $buyer->id),
                ],
                [
                    'rel'   =>  'buyers.sellers',
                    'href'  =>  route('buyers.sellers.index', $buyer->id),
                ],

                [
                    'rel '  =>  'buyers.transactions',
                    'href'  =>  route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel'   =>  'buyer.profile',
                    'href'  =>  route('users.show', $buyer->id)
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
            'id'            => 'userId',
            'name'          =>  'name',
            'email'         =>  'email',
            'verified'      =>  'isVerified',
            'created_at'    =>  'creationDate',
            'updated_at'    =>  'lastModified',
            'deleted_at'    =>  'deletedDate'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
