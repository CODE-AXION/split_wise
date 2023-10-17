<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;
    protected $table = "user_friends";
    protected $fillable = ['sender_id','token','email','receiver_id','is_friend'];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

    public function hasAccount()
    {
        return is_null($this->receiver_id) ? 'Account Not Created' : $this->receiver?->name;
    }

    public function generateFriendRequestUrl($id,$email,$token)
    {
        return \URL::temporarySignedRoute(
            'register', now()->addMinutes(30), ['sender_id' => $id,'email' => $email,'token' => $token]
        );
    }

    public function requestStatus()
    {
        if($this->is_friend == 1)
        {
            return 'Not Yet Accepted';
        }

        if($this->is_friend == 2)
        {
            return 'Accepted';
        }
    }

}
