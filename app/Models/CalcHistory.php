<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalcHistory extends Model
{
    use HasFactory;

    protected $table = 'calc_histories';

    protected $fillable = [
      'user_id',
      'container_id',
      'from_address_id',
      'delivery_address_id',
      'return_address_id',
      'delivery2_address_id',
      'return2_address_id',
      'tax_id',
      'price',
      'weight',
      'imo',
      'temp_reg',
      'is_international'
    ];

    public function user(){
      return $this->belongsTo(User::class);
    }
    public function container(){
      return $this->belongsTo(Container::class);
    }
    public function from_address(){
      return $this->belongsTo(Address::class, 'from_address_id');
    }
    public function delivery_address(){
      return $this->belongsTo(Address::class, 'delivery_address_id');
    }
    public function return_address(){
      return $this->belongsTo(Address::class, 'return_address_id');
    }
    public function delivery2_address(){
      return $this->belongsTo(Address::class, 'delivery2_address_id');
    }
    public function return2_address(){
      return $this->belongsTo(Address::class, 'return2_address_id');
    }
    public function tax(){
      return $this->belongsTo(Tax::class, 'tax_id');
    }
}
