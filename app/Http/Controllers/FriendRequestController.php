<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FriendRequest;

class FriendRequestController extends Controller
{
    public function sendRequest(Request $request)
    {
        $friendRequest = FriendRequest::create([
            'sender_id' => \Auth::id(),
            'receiver_id' => null,
            'email' => $request->email,
            'token' => rand(000000,999999) . '-' . now(),
            'is_friend' => 1
        ]);

        $friendRequestUrl = $friendRequest->generateFriendRequestUrl(\Auth::id(),$friendRequest->email,$friendRequest->token);

        return $friendRequestUrl;

        connectify('success', 'Friend Request Send', 'Success Message Here');

        // dd($request->all());    
        return redirect()->back();
    }

    public function createRequest()
    {
        return view('requests.create')->with('friendRequests',FriendRequest::where('sender_id',\Auth::id())->orWhere('receiver_id',\Auth::id())->get());
    }

    public function acceptRequest(Request $request)
    {
        dd($request->all());
    }
}
