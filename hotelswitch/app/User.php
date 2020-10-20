<?php

namespace App;

use App\Models\Reservation;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserWelcomeMail;

class User extends Eloquent implements AuthenticatableContract, MustVerifyEmailContract, CanResetPasswordContract
{
    use Notifiable;
    use AuthenticableTrait;
    use MustVerifyEmailTrait;
    use CanResetPasswordTrait;

    protected $connection = 'mongodb';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'email', 'password','country', 'b_day', 'b_month', 'b_year'
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [
        'password', 'remember_token',
    ];

    //The attributes that should be cast to native types.
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function reservation(){
        return $this->hasMany(Reservation::class,'email','email')->orderBy('created_at', 'DESC');
    } 

    protected static function boot()
    {
        parent::boot();    

        static::created(function($user){
            Mail::to($user->email)->send(new NewUserWelcomeMail());
        });
    }
}
