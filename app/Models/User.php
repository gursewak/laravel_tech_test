<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'wallet',
    ];


    public const ADMIN_ROLE = 'admin';
    public const CUSTOMER_ROLE = 'customer';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addMoney($amount)
    {
        $this->wallet += $amount;
        return $this->save();
    }

    public function hasAmount($amount)
    {
        return $this->wallet >= $amount;
    }

    public function deductAmount($amount)
    {
        $this->wallet -= $amount;
        $this->save();
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'ordered_by');
    }

    public function placeOrder($products)
    {
        $order = $this->orders()->create([
            'ordered_on' => Carbon::now(),
            'status' => Order::PENDING
        ]);

        $products->each(function ($product) use ($order) {
            $order->details()->create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price
            ]);
        });

        $this->deductAmount($products->sum('price'));
    }
}
