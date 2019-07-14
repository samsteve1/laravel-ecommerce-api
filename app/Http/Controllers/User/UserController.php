<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\{UserUpdateRequest, UserStoreRequest};
use App\Http\Controllers\ApiController;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store']);
        $this->middleware('auth:api')->except(['store']);
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-account')->only(['show', 'update']);

        $this->middleware('can:view,user')->only(['show', 'update']);
        $this->middleware('can:update,user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->allowedAdminAction();

        $users = User::all();

       return $this->showAll($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        $data['verified'] = false;
        $data['verification_token'] = User::generateVerificationCode();
        $data['role_id'] = 2;
        $user = User::create($data);

        
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return $this->showOne($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {

        if($request->has('name')) {
            $user->name = $request->name;
        }
        if($request->has('email') && ($user->email != $request->email)) {
            $user->verified = false;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }
        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if($request->has('role_id')) {
            
            $this->allowedAdminAction();

            if(!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify user roles', 422);
            }
            $user->role_id = $request->role_id;
        }

        if(!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }
        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return $this->showOne($user);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return $this->showOne($user);
    }
}
