<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AddressType extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'address_types';

    protected $fillable = ['name'];

    public $translatable = [
        'name'
    ];

    public function addresses(){
        return $this->hasMany(Address::class);
    }
}
