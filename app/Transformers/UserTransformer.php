<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'userId'    => (int)$user->id,
            'name'      =>  (string)$user->name,
            'email'     =>  (string)$user->email,
            'isVerified'=>  (bool)$user->verified,
            'isAdmin'  =>   (bool)($user->role_id === 1),
            'creationDate' =>   (string)$user->created_at,
            'lastModified' => (string)$user->updated_at,
            'deletedDate' => isset($user->deleted_at) ? (string)$user->deleted_at : null,

            'links'     => [
                [
                    'rel'   =>  'self',
                    'href'  =>  route('users.show', $user->id),
                ]
            ]
        ];
    }

    public static function  originalAttributes($index)
    {
           $attributes = [
            'userId'    =>  'id',
            'name'      =>  'name',
            'email'     =>  'email',
            'isVerified'=>  'verified',
            'isAdmin'  =>   'role_id',
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
            'role_id'       =>  'isAdmin',
            'created_at'    =>  'creationDate',
            'updated_at'    =>  'lastModified',
            'deleted_at'    =>  'deletedDate',
            'password'      =>  'password'
           ];

           return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
