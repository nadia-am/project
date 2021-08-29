<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_auth',
        'phone_number',
        'is_superuser',
        'is_staff'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //region Methods
    public function hasTwoFactor($key)
    {
        return $this->two_factor_auth == $key;
    }

    public function activeCodes()
    {
        return $this->hasMany(ActiveCode::class);
    }

    public function has2factorAuth()
    {
        return $this->two_factor_auth == 'sms';
    }
    //endregion

    public function hasSmsEnabled()
    {
        return $this->two_factor_auth == 'sms';
    }

    public function isSuperUser()
    {
        return $this->is_superuser;
    }

    public function isStaff()
    {
        return $this->is_staff;
    }

    public function setPasswordAtrribute($value)
    {
        $this->attributes['password'] = bcrypt($value);

    }

}
