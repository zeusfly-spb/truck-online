<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'addresses';

    protected $fillable = ['name', 'address_type_id', 'location'];

    public $translatable = [
        'name'
    ];

    public function address_type(): BelongsTo{
        return $this->belongsTo(AddressType::class);
    }
}
