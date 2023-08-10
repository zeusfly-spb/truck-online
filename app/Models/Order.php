<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
      'order_code',
      'order_status_id',
      'user_id',
      'container_id',
      'company_id',
      'from_address_id',
      'from_date',
      'from_slot',
      'from_contact_name',
      'from_contact_phone',
      'from_contact_email',
      'delivery_adress_id',
      'delivery_date',
      'delivery_slot',
      'delivery_contact_name',
      'delivery_contact_phone',
      'delivery_contact_email',
      'return_address_id',
      'return_date',
      'return_slot',
      'return_contact_name',
      'return_contact_phone',
      'return_contact_email',
      'car_id',
      'delivery2_adress_id',
      'delivery2_date',
      'delivery2_slot',
      'delivery2_contact_name',
      'delivery2_contact_phone',
      'delivery2_contact_email',
      'return2_adress_id',
      'return2_date',
      'return2_slot',
      'return2_contact_name',
      'return2_contact_phone',
      'return2_contact_email',
      'car2_id',
      'price',
      'weight',
      'length_algo',
      'length_real',
      'imo',
      'is_international',
      'temp_reg',
      'tax_id',
      'description'
    ];

    public function status(){
      return $this->belongsTo(OrderStatus::class);
    }
    public function user(){
      return $this->belongsTo(User::class);
    }
    public function car(){
      return $this->belongsTo(Car::class);
    }
    public function car2(){
      return $this->belongsTo(Car::class, 'car2_id');
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
}
