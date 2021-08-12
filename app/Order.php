<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        "customer_name", "customer_phone_number", "delivery_address", "customer_mail"
    ];

    public function dishes() {
        return $this->belongsToMany("App\Dish")->withPivot('quantity');
    }
}
