@foreach ($users as $user)
    <x-modal name="delete-user{{$user['id']}}" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Delete {{$user['name']}} ({{$user['email']}})?
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                This will delete all tickets related to this user too.
            </p>


            <div class="flex justify-end mt-6">
                <x-primary-button x-on:click="$dispatch('close')" class="bg-gray-400">
                    {{ __('Cancel') }}
                </x-primary-button>
                <form method="post" action="{{ route('admin.delete_user') }}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="id" value="{{ $user['id'] }}">
                    <x-danger-button class="ms-3">Delete</x-danger-button>
                </form>
            </div>
        </div>
    </x-modal>
@endforeach