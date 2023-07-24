<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OrderStatus extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'order_statuses';

    protected $fillable = ['name'];

    public $translatable = [
        'name'
    ];
}
