<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
            <form action="{{route('save.group')}}" method="post">
                @csrf   
                <div>
                    <x-input-label for="group_name" :value="'Group Name'" />
                    <x-text-input id="group_name" class="block mt-1 w-full" type="text" name="group_name" :value="old('group_name')"  autofocus autocomplete="group_name" />
                    <x-input-error :messages="$errors->get('group_name')" class="mt-2" />
                </div>

                <x-primary-button class="mt-4">
                    Create Group
                </x-primary-button>

            </form>

    </div>
</x-app-layout>
