<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses_detail';

    protected $fillable = ['expense_title','group_id','date','user_id','individual_amount','split_method','amount','description'];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->hasMany(ExpenseParticipants::class,'expense_id');
    }

    public function split_method()
    {
        if($this->split_method == 1)
        {
            return 'Equal';
        } 

        if($this->split_method == 2)
        {
            return 'Percentage';
        }

        if($this->split_method == 3)
        {
            return 'Amount';
        }
    }
}
