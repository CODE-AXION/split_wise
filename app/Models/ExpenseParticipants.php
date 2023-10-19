<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseParticipants extends Model
{
    use HasFactory;
    
    protected $table = "expense_participants";
    protected $fillable = ['expense_id','user_id','split_method','amount'];

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
