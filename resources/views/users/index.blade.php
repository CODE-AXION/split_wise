<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
     
        <div class="relative overflow-x-auto mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                                Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th>
                            Send Invite
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$user->name}}
                        </th>
                        <td class="px-6 py-4">
                            {{$user?->email}}
                        </td>

                        <th>
                            <div>
                                <form action="{{route('send.request',['user' => Auth::id() ,'email'=>$user->email])}}">

                                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Send Invite
                                    </button>

                                </form>
                            </div>
                        </th>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>


    </div>
</x-app-layout>
