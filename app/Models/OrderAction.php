<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAction extends Model
{
    use HasFactory;

    protected $table = 'order_actions';

    public $status_names = [0 => 'waiting', 1 => 'accept', 2 => 'decline'];

    protected $fillable = ['order_id','column_name','old_value', 'update_value', 'status', 'user_id', 'order_action_id'];

    public function status_name(){

      return $this->status_names([$this->status]);
    }

  }
