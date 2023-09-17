<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSetting extends Model
{
    use HasFactory;

    protected $table = 'order_settings';

    protected $fillable = ['default_over_weight_price','default_car_price','default_distance'];
}
