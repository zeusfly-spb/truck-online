<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class RightUse extends Model
{
  use HasFactory;
  use HasTranslations;

  protected $table = 'right_uses';

  protected $fillable = ['name'];

  public $translatable = [
      'name'
  ];
}
