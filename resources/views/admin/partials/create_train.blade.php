<x-modal name="create-train" focusable>
    <form method="post" action="{{ route('admin.create_train') }}">
        @csrf

        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create a new train
            </h2>

            <div class="mt-2">
                <x-input-label for="train_name" :value="__('Train Model')" />
                <x-text-input id="train_name" name="train_name" type="text" class="mt-1 block w-full" required autofocus />
            </div>

            <div class="mt-2">
                <x-input-label for="train_type" :value="__('Train Type')" />
                <x-text-input id="train_type" name="train_type" readonly value="Platinum" type="text" class="mt-1 block w-full" required autofocus />
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
