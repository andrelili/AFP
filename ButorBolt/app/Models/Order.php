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

    public function setCartItemsAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $value = $decoded;
            }
        }

        if (is_array($value)) {
            $this->attributes['cart_items'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        } else {
            $this->attributes['cart_items'] = json_encode([], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getCartItemsAttribute($value)
    {
        $decoded = json_decode($value, true);
        return $decoded === null ? [] : $decoded;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
