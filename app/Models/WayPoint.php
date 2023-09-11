<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;

class WayPoint extends Model
{
    use HasFactory;

    protected $table = 'way_points';

    protected $types = [1 => 'terminal',2 => 'stop',3 => 'on_way'];

    protected $casts = [
      'location' => Point::class,
    ];

    protected $fillable = [
      'order_id',
      'user_id',
      'address_id',
      'type_id',
      'location'
    ];

    public function user(){
      return $this->belongsTo(User::class);
    }
    public function address(){
      return $this->belongsTo(Address::class);
    }
    public function order(){
      return $this->belongsTo(Order::class);
    }

    public function getType(){
      return $this->types[$this->type_id];
    }
}
