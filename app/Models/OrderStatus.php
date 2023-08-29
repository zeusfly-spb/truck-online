<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    const DRAFT = 'Черновик';
    const CREATED = 'Создан';
    const SELECTED = 'Выбран';
    const EXECUTED = 'Исполнен';
    const CLOSED = 'Закрыт';
    const APPROVAL_PENDING = 'На согласовании';
    const CANCELED = 'Отмена';

    // protected $table = 'order_statuses';

    // protected $fillable = ['name'];

}
