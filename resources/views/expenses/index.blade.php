<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
     

            
            <div class="relative overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                                
                            <th scope="col" class="px-6 py-3">
                                Expense Title
                            </th>
                            
                            {{-- @if ($receiver)
                                
                                <th>
                                    Group Owner
                                </th>
                            @endif --}}

                            <th scope="col" class="px-6 py-3">
                                Amount
                            </th>

                            <th scope="col" class="px-6 py-3">
                                Individual Amount Per Member
                            </th>

                            <th scope="col" class="px-6 py-3">
                                Split Method
                            </th>

                            
                            {{-- <th scope="col" class="px-6 py-3">
                                Group
                            </th>
                                  
                            <th scope="col" class="px-6 py-3">
                                Group Members
                            </th> --}}


                            <th scope="col" class="px-6 py-3">
                                Selected Members
                            </th>

                       

                            <th scope="col" class="px-6 py-3">
                                Created At
                            </th>

                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        
                          
                            <td class="px-6 py-4">
                                {{$expense?->expense_title}}
                            </td>
                            
                            {{-- @if ($receiver)
                            <td class="px-6 py-4">
                                {{$expense?->group?->owner->name ?? 'No Group Owner'}}
                            </td>
                            @endif --}}
                            
                            <td class="px-6 py-4">
                                {{$expense?->amount}}
                            </td>

                            <td class="px-6 py-4">
                                {{$expense?->individual_amount}}
                            </td>



                            <td class="px-6 py-4">
                                {{$expense?->split_method()}}
                            </td>

                            {{-- <td class="px-6 py-4">
                                {{$expense?->group->group_name ?? 'No Group'}}
                            </td> --}}

                            {{-- <td class="px-6 py-4">
                                @if ($expense->group?->members->count() > 0)
                                    @foreach ($expense->group->members as $member)
                                        
                                    {{$member->name ?? 'No Group Members'}} ,
                                    @endforeach
                                @endif
                            </td> --}}

                            <td class="px-6 py-4">
                                @foreach ($expense->participants as $participant)
                                    
                                @if (($participant->amount) > $expense->individual_amount)
                                <div class="border border-emerald-400  my-1 px-0.5">
                                    {{$participant->user->name}}
                                     Paid: {{$participant->amount}}, Need To Receive From Other Members: (  {{($participant->amount) - $expense->individual_amount}}   )
                                </div>
                                @elseif (($participant->amount) < $expense->individual_amount)

                                <div class="border border-red-400">
                                    {{$participant->user->name}}, 
                                    Paid: {{$participant->amount}}, Remaing To Pay {{$expense->individual_amount - ($participant->amount)}} 
                                </div>
                                @elseif (($participant->amount) == $expense->individual_amount)
                        
                                    <div class="border border-blue-400">
                                        {{$participant->user->name}} Balanced
                                    </div>
                                @endif

                                @endforeach
                            </td>

                        

                            <td class="px-6 py-4">
                                {{$expense?->created_at}}
                            </td>
                       
                            <td class="px-6 py-4">
                                <div>
                                  
                                    @if ($expense->group_id == null)
                                        
                                    @foreach ($expense->participants->where('user_id',\Auth::id()) as $participant)
                                        {{-- {{ dump($participant->amount) }} --}}
                                        @if (($participant->amount) > $expense->individual_amount)
                                            Remaining To Settle

                                        @elseif (($participant->amount) < $expense->individual_amount)
       
                                        <a href="{{ route('create.settle.up.expense', $expense->id) }}">
                                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover-bg-blue-700 dark:focus:ring-blue-800">
                                                Settle Up
                                            </button>
                                        </a>

                                        @elseif (($participant->amount) == $expense->individual_amount)

                                        
                                            Settled Up
                                            
                                        @endif

                                       
                                    @endforeach
{{-- 
                                        @if ($expense->participants->where('user_id',\Auth::id())->where('amount', 0)->first())
                                        
                                        <a href="{{ route('create.settle.up.expense', $expense->id) }}">
                                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover-bg-blue-700 dark:focus:ring-blue-800">
                                                Settle Up
                                            </button>
                                        </a>

                                        @elseif (($participant->amount) < $expense->individual_amount)

                                        @else
                                            @if ($expense->participants->where('user_id',\Auth::id())->first()->amount == $expense->individual_amount)
                                                Settled Up
                                            @else
                                                Remaing To Settle
                                            @endif
                                        @endif --}}

                                        
                                    @endif

                                </div>    
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>



    </div>
</x-app-layout>
