<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  use HasFactory;

  protected $table = 'companies';

  protected $fillable = ['iin', 'user_id', 'phone', 'email', 'first_name', 'last_name', 'company_reg_date'];

  public function user(){
    return $this->belongsTo(User::class);
  }
}
