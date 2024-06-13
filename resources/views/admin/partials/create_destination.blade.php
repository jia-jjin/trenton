<x-modal name="create-destination" focusable>
    <form method="post" action="{{ route('admin.create_destination') }}">
        @csrf

        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create a new destination
            </h2>

            <div class="mt-2">
                <x-input-label for="destination_name" :value="__('Destination Name')" />
                <x-text-input id="destination_name" name="destination_name" type="text" class="mt-1 block w-full" required autofocus />
            </div>


            <div class="flex items-center gap-4 mt-6 w-full justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-400">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
        </div>
    </form>
</x-modal>
