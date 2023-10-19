<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSettlement extends Model
{
    use HasFactory;

    protected $fillable = ['expense_id','payer_id','receiver_id','amount','group_id'];

    protected $table = 'expense_settlements';



    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    

    
    public function expenseParticipant()
    {
        return $this->belongsTo(ExpenseParticipants::class, 'expense_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    
}
