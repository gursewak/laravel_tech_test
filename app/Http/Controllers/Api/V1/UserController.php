<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UserPriceRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{

    public $schemas = [
        \App\Models\User::class => \App\Http\Schemas\UserSchema::class,
        \App\Models\Order::class => \App\Http\Schemas\OrderSchema::class,
    ];

    public $includedPaths = [
        'orders'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(UserRequest $request)
    {
        try {
            $request->validated();

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password'])
            ]);

            $user->assignRole($request['role']);
            return $this->generateData($user, $this->schemas, $this->includedPaths);
        } catch (Exception $ex) {
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function me(Request $request)
    {
        try {
            $user = User::find(Auth::user()->id);
            return $this->generateData($user, $this->schemas, $this->includedPaths);
        } catch (Exception $ex) {
        }
    }

    public function addMoney(UserPriceRequest $request)
    {
        try {
            $request->validated();
            $userId = Auth::user()->id;
            $user = User::find($userId);
            $user->addMoney($request['wallet']);
            return $this->generateData($user, $this->schemas);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }
}
