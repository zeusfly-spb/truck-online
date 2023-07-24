<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'car_types';

    protected $fillable = ['name'];

    public $translatable = [
        'name',
    ];
}
