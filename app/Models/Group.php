<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['group_name','user_id'];

    public function members()
    {
        return $this->belongsToMany(User::class,'user_group','group_id','user_id');
    }
 
    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
 
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'group_id');
    }



    public function settlements()
    {
        return $this->hasMany(ExpenseSettlement::class, 'group_id');
    }
}
