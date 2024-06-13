<x-modal name="view-users" maxWidth="3xl" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Edit Users
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            Be careful when deleting users.
        </p>

        <div class="mt-6">
            <table class="table-auto border-collapse">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone No.</th>
                    <th>Tickets Bought</th>
                    <th>Actions</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['phone_no'] }}</td>
                        <td><x-secondary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'view-users-tickets{{$user['id']}}')">View</x-secondary-button></td>
                        <td>
                            <x-danger-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'delete-user{{$user['id']}}')">Delete</x-danger-button>
                            
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
@include('admin.partials.users_tickets')
@include('admin.partials.confirm_delete_user')
