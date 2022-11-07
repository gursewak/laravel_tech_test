<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'ordered_on' => 'date'
    ];

    public const PENDING = 'pending';


    public function details()
    {

        return $this->hasMany(OrderDetails::class, 'order_id');
    }
}
