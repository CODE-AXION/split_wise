<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class,'user_group');
    }

    public function ownerGroups()
    {
        return $this->hasMany(Group::class, 'user_id');
    }
    // public function group()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function ownerExpenseAmount($id,$user_id)
    {
        // $members = $this->groups->where('id',$id)->where('user_id',$user_id)->first()->members->count(); 
        
        // var_dump($id);
        
        // var_dump($user_id);
        $amount = $this->groups->where('id',$id)->where('user_id',$user_id)->first()->expenses()->sum('amount');
        
        return $amount;
    }

 
}
