<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  use HasFactory;

  protected $table = 'companies';

  protected $fillable = [
    'iin',
    'kpp',
    'ogrn',
    'phone',
    'email',
    'short_name',
    'full_name',
    'link',
    'company_reg_date',
    'edo_provider',
    'edo_id',
    'user_id',
    'tax_id',
    'country_id',
    'address_id',
    'post_address_id',
    'contact',
    'data_contract',
    'ceo_name',
    'cceo_name',
    'cceo_contract_name',
    'cceo_contract_date'
  ];

  public function user(){
    return $this->belongsTo(User::class);
  }
  public function tax(){
    return $this->belongsTo(Tax::class);
  }
  public function country(){
    return $this->belongsTo(Country::class);
  }
  public function address(){
    return $this->belongsTo(Address::class);
  }
  public function post_address(){
    return $this->belongsTo(Address::class,'post_address_id');
  }
  public function cars(){
    return $this->hasMany(Car::class);
  }
}
