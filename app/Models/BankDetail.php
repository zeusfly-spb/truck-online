<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $table = 'bank_details';
    protected $fillable = ['company_id', 'bik', 'bank_name', 'account', 'k_account'];
}
