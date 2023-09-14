<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
      'icon',
      'number',
      'company_id',
      'mark_model',
      'car_type_id',
      'country_id',
      'sts',
      'sts_file_1',
      'sts_file_2',
      'right_use_id',
      'max_weigth'
    ];

    public function car_type(){
      return $this->belongsTo(CarType::class);
    }
    public function company(){
      return $this->belongsTo(Company::class);
    }
    public function country(){
      return $this->belongsTo(Country::class);
    }
    public function passes(){
      return $this->hasMany(CarPass::class);
    }
}
