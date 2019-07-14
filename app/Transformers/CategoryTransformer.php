<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'catId' => (int)$category->id,
            'title' => (string)$category->name,
            'details' => (string)$category->description,
            'creationDate' =>   (string)$category->created_at,
            'lastModified' => (string)$category->updated_at,
            'deletedDate' => isset($category->deleted_at) ? (string)$category->deleted_at : null,

            'links' => [
                [
                    'rel'   => 'self',
                    'href'  =>  route('categories.show', $category->id)
                ],
                [
                    'rel'   =>  'category.buyers',
                    'href'  =>  route('categories.buyers.index', $category->id),
                ],
                [
                    'rel'   =>  'category.products',
                    'href'  =>  route('categories.products.index', $category->id),
                ],
                [
                    'rel'   =>  'category.sellers',
                    'href'  =>  route('categories.sellers.index', $category->id),
                ],
                [
                    'rel'   =>  'category.transactions',
                    'href'  =>  route('categories.transactions.index', $category->id),
                ]
            ],
        ];
    }
    public static function originalAttributes($index)
    {
           $attributes = [
            'catId'    =>  'id',
            'title'      =>  'name',
            'details'     =>  'description',
            'creationDate' =>   'created_at',
            'lastModified' => 'updated_at',
            'deletedDate' =>    'deleted_at'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttributes($index)
    {
           $attributes = [
            'id'            =>  'catId',
            'name'          =>  'title',
            'description'   =>  'details',
            'created_at'    =>  'creationDate',
            'updated_at'    =>  'lastModified',
            'deleted_at'    =>  'deletedDate'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
