<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
     

            <h1>Group: {{$group->group_name}}</h1>
            
            <div class="flex items-start gap-4">
                <div class="w-9/12 mx-auto text-gray-700  bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    
                    <div class="space-y-4 py-4">
                        @foreach ($group->expenses as $expense)
                            
                        <div class="w-11/12  mx-auto p-4 rounded border bg-slate-800">
                            <div class="flex gap-8 items-center justify-between">
                                <div>
                                    <div class="text-sm">Title</div>
                                    {{$expense->expense_title}}
                                </div>
    
                                <div>
                                    <div class="text-sm">Amount</div>
                                    {{$expense->amount}}
                                </div>
        
                            </div>
    
                            <div class="w-11/12 border-t rounded p-4 border-slate-700 bg-slate-800">
                               <div class="text-sm"> Added By {{$group->owner->name}} </div>
    
                               <div class="my-2 border-l rounded-bl-md p-1">
                                    <h2>Participants</h2>
    
                                    @foreach ($expense->participants as $participant)
                                        <div class="mx-1 border-b w-fit py-2 text-sm">  {{$participant->user->name}} owes {{$participant->amount}}  </div>
                                    @endforeach
    
                               </div>
    
                            </div>
                        </div>
                        @endforeach
                    </div>
    
                </div>
                <div>

                    <div class="w-full p-2 rounded-md border bg-slate-800">
                        @php
                            $totalDebt = [];
                        @endphp
                    
                        @foreach ($group->expenses as $expense)
                            @foreach ($expense->participants as $participant)
                                @php
                                    $debt = $participant->amount + $expense->amount / $expense->participants->count();
                                    $totalDebt[$participant->user->name] = $debt;
                                @endphp
                            @endforeach
                        @endforeach
                    
                        @foreach ($group->settlements as $settlement)
                            @php
                                $payerName = $settlement->payer->name;
                                $receiverName = $settlement->receiver->name;
                                $settlementAmount = $settlement->amount;
                            @endphp
                    
                            {{-- Update the debt after settlement --}}
                            @if (array_key_exists($payerName, $totalDebt) && array_key_exists($receiverName, $totalDebt))
                                @php
                                    $totalDebt[$payerName] -= $settlementAmount;
                                    $totalDebt[$receiverName] -= $settlementAmount;
                                @endphp
                            @endif
                    
                            <div>{{ $settlement->payer->name }} owes {{ $settlement->receiver->name }}: {{ $settlement->amount }}</div>
                        @endforeach
                    
                        {{-- Display the updated debts --}}
                        @foreach ($totalDebt as $name => $debt)
                            <div>{{ $name }} owes {{ $debt }}</div>
                        @endforeach
                    </div>
                    

                    {{-- <form action="{{route('group.settle.up')}}" method="POST">
                        @csrf
                        <div class="w-full p-2 rounded-md border bg-slate-800">
                            <div class="flex items-center gap-4">
                                
                                @if ($group->owner->id != \Auth::id())
                                    <div>{{\Auth::user()->name}}</div>
                                    <div>Owes</div>
                                    <div>
                                        <select name="payer_id" id="">
                                         <option value="">Select Group</option>
                 
                                         @foreach ($group->members as $member)
                                            @if ($member->id != \Auth::id())
                                                
                                            <option value="{{$member->id}}">{{$member->name}} </option>
                                            @endif
                                         @endforeach
                 
                                        </select>
                                    </div>
        
                                @else
    
                                @endif
                            </div>
                            <div class="mt-4">
                                <div class="text-sm">Amount</div>
                                <div>{{$paidAmount}}</div>
                            </div>
                            <input type="hidden" name="group_id" value="{{$group->id}}">
                            <input type="number" step="any" name="amount">
                            <x-primary-button class="mt-4">
                                Pay Money
                            </x-primary-button>
    
    
                        </div>
                    </form> --}}
                </div>
            </div>
          


    </div>
</x-app-layout>
