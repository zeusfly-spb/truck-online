<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  use HasFactory;
  use HasTranslations;

  protected $table = 'countries';

  protected $fillable = ['name'];

  public $translatable = [
      'name'
  ];
}
