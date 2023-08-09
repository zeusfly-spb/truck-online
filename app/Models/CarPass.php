<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPass extends Model
{
    use HasFactory;

    protected $table = 'car_passes';

    protected $fillable = ['car_id', 'pass_id'];

    public function car(){
      return $this->belongsTo(Car::class);
    }
    public function pass(){
      return $this->belongsTo(Pass::class);
    }
}
