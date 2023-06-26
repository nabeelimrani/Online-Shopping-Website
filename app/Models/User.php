<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    public function GetUsernameAttribute()
    {
        return $this->fname." ".$this->lname;
    }
    public function GetRolenameAttribute()
    {
        if($this->role==1)$name="Admin";
        else
        $name="Operator";
        return $name;
    }
    use HasApiTokens, HasFactory, Notifiable;
    public function sales()
    {
        return $this->hasMany("App\Models\Sale");
    }
     public function payments()
    {
        return $this->hasMany("App\Models\Payment","clientid");
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=[];

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
        'email_verified_at' => 'datetime',
    ];
}
