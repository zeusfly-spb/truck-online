<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\MangoInteractionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'first_name',
    'middle_name',
    'last_name',
    'company_id',
    'extension'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'password' => 'hashed',
  ];

  public function company()
  {
    return $this->belongsTo(Company::class);
  }

  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  public function calcHistory()
  {
    return $this->hasMany(CalcHistory::class);
  }

  /**
   * @return void
   */
  public function addMangoAccount()
  {
    $extension = str_pad(env('EXTENSION_START_NUMBER') + $this->id, env('EXTENSION_LENGTH'),
      '0', STR_PAD_LEFT);
    $this->update(['extension' => $extension]);
    $name = "Пользователь " . $this->id;
    $params = [
      'email' => $this->email,
      'name' => $name,
      'extension' => $extension,
      'access_role_id' => 0,
      'mobile' => '7' . $this->phone
    ];
    return MangoInteractionController::addUser($params);
  }
}
