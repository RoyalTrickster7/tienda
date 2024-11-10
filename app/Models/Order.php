<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'order_number', 
        'total_price', 
        'payment_status', 
        'order_status', 
        'shipping_address'
    ];

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
}
