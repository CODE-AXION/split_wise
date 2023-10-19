<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\User;
use App\Models\Expense;

use App\Models\ExpenseSettlement;
use App\Models\FriendRequest;

class ExpenseController extends Controller
{
    
    
    public function createExpense()
    {
        $groups = Group::where('user_id',\Auth::id())->get();

        $query = FriendRequest::query();
        
        $sender = false;
        $receiver = false;

        if(FriendRequest::where('sender_id',\Auth::id())->first()?->exists()){
            
            $sender = true;
            $friends = $query->where('sender_id',\Auth::id())->get();
        }

        if(FriendRequest::where('receiver_id',\Auth::id())->first()?->exists()){
            
            $receiver = true;
            $friends = $query->where('receiver_id',\Auth::id())->get();
        }
   
        return view('expenses.create')->with('sender',$sender)->with('receiver',$receiver)->with('friends',$friends)->with('groups',$groups);
    }

    public function getExpenses()
    {
    
        $sender = false;
        $receiver = false;

        if(FriendRequest::where('sender_id',\Auth::id())->first()?->exists()){
            
            $sender = true;
            $expenses = Expense::where('user_id',\Auth::id())->get();
        }

        if(FriendRequest::where('receiver_id',\Auth::id())->first()?->exists()){
            
            $receiver = true;
            $expenses = Expense::whereHas('participants',function ($query)
            {
                return $query->where('user_id',\Auth::id());

            })->get();
        }

   

        return view('expenses.index')->with('expenses',$expenses)->with('sender',$sender)->with('receiver',$receiver);
    }


    public function createSettleUp(Expense $expense)
    {
        return view('expenses.settleup')->with('expense',$expense);
    }

    public function groupView(Group $group)
    {
        return view('groups.group-view')->with('group',$group);
    } 

    public function settleUp(Request $request)
    {
        ExpenseSettlement::create([
            'group_id' => $request->group_id,
            'payer_id' => \Auth::id(),
            'receiver_id' => $request->payer_id,
            'amount' => $request->amount
        ]);
        dd($request->all());
    }

    public function groupList()
    {

        // dd();

        return view('groups.index')->with('groups',\Auth::user()->ownerGroups);
    }

    public function paySettleUp(Request $request,Expense $expense)
    {
        $request->validate([
            'amount' => ['required'],
        ]);
        
        $currentParticipantPaidAmount = $expense->participants()->where('user_id',\Auth::id())->first()->amount;

        if ($currentParticipantPaidAmount != 0 &&  $request->amount > ($expense->individual_amount - ($currentParticipantPaidAmount))) {
            
            return redirect()->back()->withErrors(['amount' => 'Cannot Pay More Than '. ($expense->individual_amount - ($currentParticipantPaidAmount)) ]);
        }
        
        // dd($currentParticipantPaidAmount == 0 && !is_null($request->participant_id));

        // if($currentParticipantPaidAmount == 0){
        //     dd(!is_null($request->participant_id));
            
        // }
        $participantPaidAmount = $expense->participants()->where('user_id',$request->participant_id)->first()?->amount ?? 0;
    
        if($currentParticipantPaidAmount == 0 && !is_null($request->participant_id)){
            
            $expense->participants()->where('user_id',$request->participant_id)->update([
                'amount' => $participantPaidAmount - $request->amount
            ]);
            $expense->participants()->where('user_id',\Auth::id())->update([
                'amount' => $currentParticipantPaidAmount + $request->amount
            ]);

            return to_route('get.expense');
        }elseif($currentParticipantPaidAmount == 0){
            
            $expense->participants()->where('user_id',\Auth::id())->update([
                'amount' => $request->amount
            ]);

            return to_route('get.expense');
        }

        
   
        $expense->participants()->where('user_id',$request->participant_id)->update([
            'amount' => $participantPaidAmount - $request->amount
        ]);
        $expense->participants()->where('user_id',\Auth::id())->update([
            'amount' => $currentParticipantPaidAmount + $request->amount
        ]);
        
        return  to_route('get.expense');
    }

    public function recordExpense(Request $request)
    {
      
        $request->validate([
            'title' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
            'split_method' => ['required'],
        ]);


        if($request->friends != [])
        {
            $amountPerMember = $request->amount / (count($request->friends) + 1);

            $friendsIds = [];

            $friends = array_merge($request->friends,[\Auth::id()]);
            foreach ($friends as $friend ) {
                
                $friendsIds[]['user_id'] = $friend;
            }

            \DB::transaction(function () use($request,$amountPerMember,$friendsIds,$friends) {

                $expense =  Expense::create([

                    'expense_title' => $request->title,
                    'amount' => $request->amount,
                    'date' => $request->date,
                    'split_method' => $request->split_method,
                    'individual_amount' => $amountPerMember,
                    'group_id' => null,
                    'user_id' => \Auth::id(),
                    'description' => $request->additional_message,

                ]);
                foreach($friends as $friend)
                {
                    $expense->participants()->create(['user_id' => $friend]);
                }
               
            });
        }

    
        return to_route('get.expense');

    }
}
