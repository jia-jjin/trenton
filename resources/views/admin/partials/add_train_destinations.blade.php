<x-modal name="view-train-add-destination{{ $train['id'] }}" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Add a new destination to {{ $train['model'] }}
        </h2>

        <x-input-label class="mt-2" for="select-new-train-destination{{ $train['id'] }}">Destination</x-input-label>
        <select class="mt-1" name="select-new-train-destination{{ $train['id'] }}" id="select-new-train-destination{{ $train['id'] }}">
            <option value="not-selected" selected disabled hidden>Not selected</option>
            @foreach ($destinations as $destination)
                <option id="select-new-train-destination{{ $train['id'] }}-{{implode('-',explode(' ', $destination->destination))}}">{{$destination->destination}}</option>
            @endforeach
        </select>

        <div class="flex justify-end mt-6">
            <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-400">
                {{ __('Close') }}
            </x-secondary-button>
            <x-primary-button x-on:click="$dispatch('close')" class="ms-3" onclick="addTrainDestination{{ $train['id'] }}()">
                {{ __('Add') }}
            </x-primary-button>
        </div>
    </div>
</x-modal>
