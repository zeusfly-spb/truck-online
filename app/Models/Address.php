<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;
  use HasTranslations;

  protected $table = 'addresses';

  protected $fillable = ['name', 'address_type_id', 'location', 'return', 'from','to', 'accept_status'];

  public $translatable = [
      'name'
  ];

  protected $casts = [
      'location' => Point::class,
  ];

  public function address_type(){
      return $this->belongsTo(AddressType::class);
  }
}
