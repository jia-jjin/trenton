@foreach ($users as $user)
    <x-modal name="view-users-tickets{{ $user['id'] }}" maxWidth="3xl" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                View tickets for {{$user['name']}} ({{$user['email']}})
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                View only. No editing.
            </p>

            <div class="mt-6">
                <table class="table-auto border-collapse">
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Train</th>
                        <th>Seat</th>
                        <th>Departing Destination</th>
                        <th>Arriving Destination</th>
                        <th>Price</th>
                        <th>Active</th>
                        <th>Insurance</th>
                    </tr>
                    @foreach ($user->tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->date }}</td>
                            <td>{{ $ticket->model }}</td>
                            <td>{{ $ticket->coach }}-{{ $ticket->seat }}</td>
                            <td>{{ $ticket->departing_destination }}</td>
                            <td>{{ $ticket->arriving_destination }}</td>
                            <td>RM{{ $ticket->price }}</td>
                            <td>{{ $ticket->isActive }}</td>
                            <td>{{ $ticket->hasInsurance }}</td>
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
@endforeach
