<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
     

            
            <div class="relative overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                                
                            <th scope="col" class="px-6 py-3">
                                Group
                            </th>
                            
                            <th scope="col" class="px-6 py-3">
                                View
                            </th>
                            

                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        
                          
                            <td class="px-6 py-4">
                                {{$group->group_name}}
                            </td>

                            <td>
                                <a href="{{route('groups.view',$group)}}">View</a>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>



    </div>
</x-app-layout>
