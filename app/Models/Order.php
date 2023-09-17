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
      'order_status',
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

    //relations
    public function order_status(){
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
    public function actions(){
      return $this->hasMany(OrderAction::class);
    }

    //scopes

    public function scopeFilterByOrderStatuses($query, array $ids)
    {
        return $query->whereHas('order_status', function ($query) use ($ids) {
            $query->whereIn('id', $ids);
        });
    }
    public function scopeFilterByOrderContainers($query, array $ids)
    {
        return $query->whereHas('container', function ($query) use ($ids) {
            $query->whereIn('id', $ids);
        });
    }
    public function scopeFilterByOrderFromAddresses($query, array $ids)
    {
        return $query->whereHas('from_address', function ($query) use ($ids) {
            $query->whereIn('id', $ids);
        });
    }
    public function scopeFilterByOrderDeliveryAddresses($query, array $ids)
    {
        return $query->whereHas('delivery_address', function ($query) use ($ids) {
            $query->whereIn('id', $ids);
        });
    }
    public function scopeFilterByWeight($query, $weight)
    {
        return $query->where('weight', 'like', '%' . $weight . '%');
    }
    public function scopeFilterByPrice($query, $price)
    {
        return $query->where('price', 'like', '%' . $price . '%');
    }
    public function scopeFilterByLengthAlgo($query, $length)
    {
        return $query->where('length_algo', 'like', '%' . $length . '%');
    }
    public function scopeFilterByLengthReal($query, $length)
    {
        return $query->where('length_real', 'like', '%' . $length . '%');
    }
    public function scopeFilterByImo($query, $status)
    {
        return $query->where('imo', $status);
    }
    public function scopeFilterByTemp($query, $status)
    {
        return $query->where('temp_reg', $status);
    }
    public function scopeFilterByInternational($query, $status)
    {
        return $query->where('is_international', $status);
    }
    public function scopeFromDate($query, $fromDate)
    {
        return $query->whereDate('from_date', '>=', $fromDate);
    }
    public function scopeDeliveryDate($query, $deliveryDate)
    {
        return $query->whereDate('delivery_date', '<=', $deliveryDate);
    }

    //mutators
    public function legalForUpdate(){
      if ($this->order_status_id == 1 || $this->order_status_id == 2)
        return true;
      return false;
    }

    public function selectedByExecuter(){
      if($this->order_status_id==3){
        return true;
      }
    }

    // public function finish(){
    //   if($this->order_status_id==4 || $this->order_status_id){
    //     return true;
    //   }
    // }
}
