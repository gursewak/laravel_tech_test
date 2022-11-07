<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends BaseController
{


    public $schemas = [
        \App\Models\Order::class => \App\Http\Schemas\OrderSchema::class,
        \App\Models\User::class => \App\Http\Schemas\UserSchema::class
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
    public function store(PlaceOrderRequest $request)
    {
        try {
            $request->validated();
            $products = Product::whereIn('id', $request['productIds'])->get();
            if ($products->isEmpty()) {
                return response()->json([
                    'message' => 'Product Not Exists!'
                ]);
            }
            $totalAmount = $products->sum('price');
            $user = User::find(Auth::user()->id);

            if ($user->hasAmount($totalAmount)) {
                $user->placeOrder($products);
            } else {
                return response()->json([
                    'message' => 'Wallet has not sufficient Balance'
                ]);
            }

            return $this->generateData($user, $this->schemas);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
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
        $order = Order::find($id);
        return $this->generateData($order, $this->schemas);
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
}
