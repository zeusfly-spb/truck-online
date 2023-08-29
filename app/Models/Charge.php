<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $table = 'charges';

    protected $fillable = ['company_from_id','company_to_id', 'order_id','amount','notified','payed','fine'];

    public function company_from(){
      return $this->belongsTo(Company::class,'company_from_id');
    }
    public function company_to(){
      return $this->belongsTo(Company::class,'company_to_id');
    }
    public function order(){
      return $this->belongsTo(Order::class);
    }
}
