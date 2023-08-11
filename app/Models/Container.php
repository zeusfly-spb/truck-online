<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Container extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'containers';

    protected $fillable = ['name', 'weight', 'kit'];

    public $translatable = [
        'name',
    ];
}
