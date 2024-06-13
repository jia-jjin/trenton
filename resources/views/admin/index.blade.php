<x-app-layout>
    <style>
        th,
        td {
            border: 1px black solid;
            padding: 1rem;
            text-align: center;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="border border-black p-4 sm:p-8 bg-white shadow sm:rounded-lg duration-200 transition-all">
                <div class="max-w-xl">
                    <h1 class="text-3xl font-bold">All Destinations</h1>
                    <p class="mt-1 text-lg text-gray-600 ">
                        Create, update or delete destinations.
                    </p>
                    <div class="flex gap-2 mt-4">
                        <x-secondary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'view-destinations')">
                            View all</x-secondary-button>
                        @include('admin.partials.destinations')
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('destination_name')" />
                    @if (session('status') === 'destination-created')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-500 mt-2">{{ __('Destination created.') }}</p>
                    @endif
                    @if (session('status') === 'destination-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-500 mt-2">{{ __('Destination updated.') }}</p>
                    @endif
                    @if (session('status') === 'destination-deleted')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-red-500 mt-2">{{ __('Destination deleted.') }}</p>
                    @endif
                </div>
            </div>

            <div class="border border-black p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h1 class="text-3xl font-bold">All Trains</h1>
                    <p class="mt-1 text-lg text-gray-600 ">
                        Create, update or delete trains and the destinations they will stop at during their journey.
                    </p>
                    <div class="flex gap-2 mt-4">
                        <x-secondary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'view-trains')">View all</x-secondary-button>
                        @include('admin.partials.trains')
                    </div>
                    @if (session('status') === 'train-created')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-500 mt-2">{{ __('Train created.') }}</p>
                    @endif
                    @if (session('status') === 'train-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-500 mt-2">{{ __('Train updated.') }}</p>
                    @endif
                    @if (session('status') === 'train-deleted')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-red-500 mt-2">{{ __('Train deleted.') }}</p>
                    @endif
                    @if (session('status') === 'train-destinations-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-500 mt-2">{{ __('Train destinations edited.') }}</p>
                    @endif
                    @if (session('status') === 'train-destinations-update-failed')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-red-500 mt-2">{{ __('Train destinations update failed.') }}</p>
                    @endif
                </div>
            </div>

            <div class="border border-black p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h1 class="text-3xl font-bold">All Users</h1>
                    <p class="mt-1 text-lg text-gray-600 ">
                        Manage all users (excluding admins).
                    </p>
                    <div class="flex gap-2 mt-4">
                        <x-secondary-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'view-users')">View users</x-secondary-button>
                        @include('admin.partials.users')
                    </div>
                    @if (session('status') === 'user-deleted')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-red-500 mt-2">{{ __('User deleted.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
