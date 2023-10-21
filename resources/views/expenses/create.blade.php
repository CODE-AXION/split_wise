<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
     
            <form action="{{route('record.expense')}}" method="post">
                @csrf   

                <input type="hidden" name="groupId" value="{{ request('groupId') }}">

                <div>
                    <x-input-label for="title" :value="'Title'" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"  autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="amount" :value="'Amount'" />
                    <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')"  autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="date" :value="'Date'" />
                    <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')"  autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                </div>

                <div class="mb-4 ">
                    <select name="split_method" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="">
                        <option value="1">Equal</option>
                        
                        {{-- <option value="2">Percentage</option>
                        
                        <option value="3">Amount</option> --}}
                    </select>
                    <x-input-error :messages="$errors->get('split_method')" class="mt-2" />
                </div>

                <div x-data="{ expenses: 'expense2' }">

                    <div class="flex items-center gap-4 my-4 py-4 w-fit">
                        {{-- <div @click.prevent="expenses = 'expense1'" class="border-b p-2 border-white w-fit mx-1">Pay By Group</div> --}}
                        <div @click.prevent="expenses = 'expense2'" class="border-b p-2 border-white w-fit mx-1">Pay By Friends</div>
                    </div>
                    {{-- <div x-show="expenses == 'expense1'">
                   
                        <div class="mb-4">
                            <select name="group" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  id="">
                                <option value="">Select Group</option>
                                @foreach ($groups as $group)
                                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('group')" class="mt-2" />
                        </div>
                     
                      
                    </div> --}}

                    <div x-show="expenses == 'expense2'">
                        <div class="mb-4">
                            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" multiple name="friends[]" id="">
                               @foreach ($friends as $friend)
                                    @if ($sender)
                                        <option value="{{$friend->receiver->id}}"> {{$friend?->receiver?->name}}</option>
                                
                                    @elseif ($receiver)
                                   
                                        <option value="{{$friend->sender->id}}"> {{$friend?->sender?->name}}</option>
                               
                                    @endif
                               @endforeach
                            </select>
                        </div>
                    </div>
                </div>
              
                {{-- <x-input-error :messages="$errors->get('split_method')" class="mt-2" /> --}}
                
             
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Additional Message</label>
                <textarea name="additional_message" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>

                <x-primary-button class="mt-4">
                    Create Expense
                </x-primary-button>

            </form>


            
            {{-- <div class="relative overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                                
                            <th scope="col" class="px-6 py-3">
                                Following
                            </th>
                            

                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Request Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($friendRequests as $friendRequest)
                            
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        
                            @if ($sender)
                                
                            <td class="px-6 py-4">
                                {{$friendRequest?->receiver?->name}}
                            </td>

                            @elseif ($receiver)
                            <td class="px-6 py-4">
                                {{$friendRequest?->sender?->name}}
                            </td>
                            @endif

                            @if ($sender)
                            <td class="px-6 py-4">
                                {{$friendRequest?->receiver?->email}}
                            </td>
                            @elseif ($receiver)
                            <td class="px-6 py-4">
                            {{$friendRequest?->receiver?->email}}
                             </td>
                            @endif

                            <td class="px-6 py-4">
                                
                                {{$friendRequest->requestStatus()}}
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div> --}}



    </div>
</x-app-layout>
