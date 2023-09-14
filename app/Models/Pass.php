<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Pass extends Model
{
  use HasFactory;
  use HasTranslations;

  protected $table = 'passes';

  protected $fillable = ['name', 'date', 'number'];

  public $translatable = [
      'name'
  ];

  public function car_passes(){
    return $this->hasMany(CarPass::class);
  }
}
