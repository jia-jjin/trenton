<x-modal name="view-trains" maxWidth="3xl">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">
                Edit Trains
            </h2>
            <x-secondary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'create-train')">
                Create a new train
            </x-secondary-button>
        </div>

        <p class="mt-2 text-sm text-gray-600">
            You can also press enter upon changing to a new train name to update.
        </p>

        <div class="mt-6 flex">
            <table class="table-auto border-collapse">
                <tr>
                    <th class="">ID</th>
                    <th class="">Model</th>
                    <th class="">Type</th>
                    <th class="">Destinations</th>
                    <th class="" colspan="2">Actions</th>
                </tr>
                @foreach ($trains as $train)
                    <tr>
                        <td class="">{{ $train['id'] }}</td>
                        <form method="post" action="{{ route('admin.edit_train') }}">
                            @csrf
                            @method('put')
                            <td class="">
                                <input type="submit" value="">
                                <input type="hidden" name="id" value="{{ $train['id'] }}">
                                <input type="text" placeholder="Train name" name="train_name"
                                    value="{{ $train['model'] }}">
                            </td>
                            <td class="">
                                {{ $train['type'] }}
                            </td>
                            <td>
                                <x-secondary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'view-train{{$train['id']}}')">View</x-secondary-button>
                            </td>
                            <td class="">
                                <x-primary-button>Save</x-primary-button>
                            </td>
                        </form>
                        <td class="">
                            <form method="post" action="{{ route('admin.delete_train') }}">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $train['id'] }}">
                                <x-danger-button>Delete</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button x-on:click="$dispatch('close')" class="bg-gray-400">
                {{ __('Close') }}
            </x-primary-button>
        </div>
    </div>
</x-modal>
@include('admin.partials.create_train')
@include('admin.partials.edit_train_destinations')
