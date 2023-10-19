<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
     
            <form action="{{route('send.request')}}" method="post">
                @csrf   
                <div>
                    <x-input-label for="email" :value="'Send Request'" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                </div>

                <x-primary-button class="mt-4">
                    Send Request
                </x-primary-button>

            </form>


            
            <div class="relative overflow-x-auto mt-4">
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
                                {{$friendRequest?->receiver?->name ?? 'Pending'}}
                            </td>

                            @elseif ($receiver)
                            <td class="px-6 py-4">
                                {{$friendRequest?->sender?->name ?? 'Pending'}}
                            </td>
                            @endif

                            @if ($sender)
                            <td class="px-6 py-4">
                                {{$friendRequest?->receiver?->email ?? 'Pending'}}
                            </td>
                            @elseif ($receiver)
                            <td class="px-6 py-4">
                            {{$friendRequest?->receiver?->email ?? 'Pending'}}
                             </td>
                            @endif

                            <td class="px-6 py-4">
                                
                                {{$friendRequest->requestStatus()}}   @if ($sender) ( <i> {{$friendRequest->email }}</i> ) @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>



    </div>
</x-app-layout>
