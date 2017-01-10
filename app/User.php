<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Jenssegers\Mongodb\Model as Eloquent;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract
{
  use Authenticatable, CanResetPassword;

  protected $guarded = ['_id'];
  protected $collection = 'users';
  protected $hidden = ['password'];
  protected $fillable = ['email'];
  protected $rules = [
    'email'    => 'required|email|unique:users',
    'name'     => 'required',
    'password' => 'required|confirmed'
  ];

  public function validate( $data ) {
    return Validator::make($data, $this->rules);
  }

  public function getAuthIdentifier() { return $this->getKey(); }
  public function getAuthPassword() { return $this->password; }
  public function getReminderEmail() { return $this->email; }
  public function getRememberToken() { return $this->remember_token; }
  public function setRememberToken($value) { $this->remember_token = $value; }
  public function getRememberTokenName() { return 'remember_token'; }
}