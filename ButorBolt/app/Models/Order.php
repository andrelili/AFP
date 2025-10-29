<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'billing_address',
        'payment_method',
        'cart_items',
        'total',
    ];

    protected $casts = [
        'cart_items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
