<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    //
    public function createGroup(Request $request){
        return view('groups.create');
    }

    public function saveGroup(Request $request){
        // dd($request->all());
        $request->validate([
            'group_name' => ['required'],
        ]);

        \DB::transaction(function () use($request) {

            $group =  Group::create([
                'group_name' => $request->group_name,
                'user_id' => \Auth::id(),
            ]);
           
        });

        return to_route('group.list.expense');
    }
}
