<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendFriendRequest;

class FriendRequestController extends Controller
{
    public function sendRequest(Request $request)
    {
        \DB::transaction(function () use($request) {
            
            $friendRequest = FriendRequest::create([
                'sender_id' => \Auth::id(),
                'receiver_id' => null,
                'email' => $request->email,
                'token' => rand(000000,999999) . '-' . now(),
                'is_friend' => 1
            ]);
    
            $friendRequestUrl = $friendRequest->generateFriendRequestUrl(\Auth::id(),$friendRequest->email,$friendRequest->token);
            
            // Notification::send($users, new InvoicePaid($invoice));
    
            Notification::route('mail', $friendRequest->email)
            ->notify(new SendFriendRequest($friendRequestUrl,\Auth::user()));
        });

        return redirect()->back();
    }

    public function createRequest()
    {
        $query = FriendRequest::query();
        
        $sender = false;
        $receiver = false;
        $friendRequests = [];
        
        if(FriendRequest::where('sender_id',\Auth::id())->first()?->exists()){
            
            $sender = true;
            $friendRequests = $query->where('sender_id',\Auth::id())->get();
        }

        if(FriendRequest::where('receiver_id',\Auth::id())->first()?->exists()){
            
            $receiver = true;
            $friendRequests = $query->where('receiver_id',\Auth::id())->get();
        }
   
        return view('requests.create')->with('friendRequests',$friendRequests)->with('sender',$sender)->with('receiver',$receiver);
    }

    public function acceptRequest(Request $request)
    {
        dd($request->all());
    }
}
