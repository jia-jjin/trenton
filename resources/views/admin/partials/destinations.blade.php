<x-modal name="view-destinations">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">
                Edit Destinations
            </h2>
            <x-secondary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'create-destination')">
                Create new destination
            </x-secondary-button>

        </div>

        <p class="mt-2 text-sm text-gray-600">
            You can also press enter upon changing to a new destination name to update.
        </p>

        <div class="mt-6 flex">
            <table class="table-auto border-collapse overflow-x-scroll">
                <tr>
                    <th class="">ID</th>
                    <th class="">Destination</th>
                    <th class="" colspan="2">Actions</th>
                </tr>
                @foreach ($destinations as $destination)
                    <tr>
                        <td class="">{{ $destination['id'] }}</td>
                        <form method="post" action="{{ route('admin.edit_destination') }}">
                            @csrf
                            @method('put')
                            <td class="">
                                <input type="submit" value="">
                                <input type="hidden" name="id" value="{{ $destination['id'] }}">
                                <input type="text" placeholder="name" name="destination_name"
                                    value="{{ $destination['destination'] }}">
                            </td>
                            <td class="">
                                <x-primary-button>Save</x-primary-button>
                            </td>
                        </form>
                        <td class="">
                            <form method="post" action="{{ route('admin.delete_destination') }}">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $destination['id'] }}">
                                <x-danger-button>Delete</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button x-on:click="$dispatch('close')" class="">
                {{ __('Close') }}
            </x-primary-button>
        </div>
    </div>
</x-modal>
@include('admin.partials.create_destination')
