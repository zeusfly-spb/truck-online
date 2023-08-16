<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;

  protected $table = 'addresses';

  protected $fillable = ['name', 'address', 'location', 'return', 'from','to', 'accept_status'];

  protected $casts = [
      'location' => Point::class,
  ];

  public function address_type(){
      return $this->belongsTo(AddressType::class);
  }

  public function scopeFilterByName($query, $name)
  {
      return $query->where('name', 'like', '%' . $name . '%');
  }
  public function scopeFilterByAddress($query, $address)
  {
      return $query->where('address', 'like', '%' . $address . '%');
  }
}
