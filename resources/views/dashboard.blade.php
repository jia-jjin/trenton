<x-app-layout>
    @if (session('status') === 'ticket-created')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="fixed top-10 left-0 z-[100] w-[95%] m-[2.5%] p-6 shadow-md h-16 flex justify-start items-center border border-black rounded-lg bg-[#E9C46A]">
            <h1>Ticket(s) booked successfully!</h1>
        </div>
    @endif
    <div class="py-12 lg:px-24 sm:px-12 px-4">
        <div class="flex justify-between sm:items-center sm:flex-row flex-col sm:gap-0 gap-4">
            <h1 class="text-4xl font-bold">Dashboard</h1>
            <!-- to prevent errors when finding for oneway checkbox -->
            <div class="hidden">
                <input type="checkbox" id="oneway" disabled>
                <input type="text" name="" id="datepicker2">
            </div>
            <form action="" method="POST">
                @csrf
                <div class="flex sm:items-center md:flex-row flex-col md:gap-0 gap-2">
                    <div>
                        <label for="show" class="me-2">Show:</label>
                        <select name="show" id="show" class="rounded-md bg-[#E9C46A] border-black text-black">
                            <option value="upcoming" @if ($filter['show'] == 'upcoming') {{ 'selected' }} @endif>
                                Upcoming Tickets</option>
                            <option value="past" @if ($filter['show'] == 'past') {{ 'selected' }} @endif>Past
                                Tickets</option>
                            <option value="all" @if ($filter['show'] == 'all') {{ 'selected' }} @endif>All
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="me-2 sm:ms-6">Sort by:</label>
                        <select name="sort" id="sort" class="rounded-md bg-[#E9C46A] border-black text-black">
                            <option value="latest" @if ($filter['sort'] == 'latest') {{ 'selected' }} @endif>Latest
                            </option>
                            <option value="earliest" @if ($filter['sort'] == 'earliest') {{ 'selected' }} @endif>
                                Earliest</option>
                            <option value="highest_price" @if ($filter['sort'] == 'highest_price') {{ 'selected' }} @endif>
                                Highest Price</option>
                            <option value="lowest_price" @if ($filter['sort'] == 'lowest_price') {{ 'selected' }} @endif>
                                Lowest Price</option>
                            {{-- <option value="longest">Longest Time</option>
                            <option value="shortest">Shortest Time</option> --}}
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div class="border border-black min-h-[200px] sm:p-8 p-3 gap-4 flex flex-col bg-white relative">
            @if (!count($tickets))
                <div class="flex size-full items-center justify-center">
                    <h1 class="text-xl text-center"><br><br><span class="font-semibold text-2xl">No tickets
                            found.</span><br><br>Stop using your 🚗 and start saving money by <a
                            href="{{ route('booking') }}" class="decoration-2 underline text-blue-600">buying 🚄
                            tickets</a> today!<br><br><br></h1>
                </div>
            @else
                @foreach ($tickets as $ticket)
                    <div
                        class="relative
                {{-- min-h-[200px]  --}}
                border border-black rounded-xl 
                            @if ($ticket['isActive']) {{ 'bg-[#ffecc5]' }}
                            @else
                                {{ 'bg-[#c2c2c2]' }} @endif ">
                        <div
                            class="min-h-[50px] 
                            @if ($ticket['isActive']) {{ 'bg-[#af945c]' }}
                            @else
                                {{ 'bg-[#898989]' }} @endif 
                             rounded-t-xl border-b border-black flex items-center p-4 justify-between gap-4">
                            <div class="flex items-center"><i class="fa-solid fa-calendar"></i>
                                <h1 class=" ms-2 me-4">{{ $ticket['date'] }}</h1><i
                                    class="fa-solid fa-clock sm:inline hidden"></i>
                                <h1 class="ms-2 sm:inline hidden">{{ $ticket['departing_time'] }}</h1>
                            </div>
                            <div class="flex sm:items-center sm:flex-row flex-col">
                                @if ($ticket['hasInsurance'])
                                    <div class="flex items-center"><i
                                            class="fa-solid fa-shield-halved text-blue-800"></i>
                                        <h1 class="ms-2 sm:me-4 text-blue-800"><span class="md:inline hidden">Protected
                                                with i</span><span class="md:hidden sm:inline">I</span><span
                                                class="">nsurance</span></h1>
                                    </div>
                                @endif
                                <div class="flex items-center"><i class="fa-solid fa-dollar-sign"></i>
                                    <h1 class="ms-2">RM{{ $ticket['price'] }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="flex md:flex-row flex-col">
                            <div class="flex w-full">
                                <div class="p-4 gap-4 flex flex-col w-1/2 border-e border-black justify-center">
                                    <div class="flex md:gap-6 gap-3 sm:items-center sm:flex-row flex-col">
                                        <div>
                                            <p class="text-[#987f46] font-bold tracking-widest">DEPART</p>
                                            <h1 class="md:text-2xl text-xl font-medium">
                                                {{ $ticket['departing_destination'] }}</h1>
                                            <div class="flex items-center font-medium"><i class="fa-solid fa-clock"></i>
                                                <h1 class="ms-2">{{ $ticket['departing_time'] }}</h1>
                                            </div>
                                        </div>
                                        <i class="fa-solid fa-chevron-right text-2xl sm:inline-block hidden"></i>
                                        <div>
                                            <p class="text-[#987f46] font-bold tracking-widest">ARRIVE</p>
                                            <h1 class="md:text-2xl text-xl font-medium">
                                                {{ $ticket['arriving_destination'] }}</h1>
                                            <div class="flex items-center font-medium"><i class="fa-solid fa-clock"></i>
                                                <h1 class="ms-2">{{ $ticket['arriving_time'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="flex gap-6 items-center">
                                    <div
                                        class="border border-black p-4 bg-[#fff2cd] flex flex-col justify-center rounded-md">
                                        <p class="text-[#987f46] font-bold tracking-widest">COACH</p>
                                        <h1 class="text-xl font-medium text-center">{{ $ticket['coach'] }}</h1>
                                    </div>
                                    <div
                                        class="border border-black p-4 bg-[#fff2cd] flex flex-col justify-center rounded-md">
                                        <p class="text-[#987f46] font-bold tracking-widest">SEAT</p>
                                        <h1 class="text-xl font-medium text-center">{{ $ticket['seat'] }}</h1>
                                    </div>
                                </div> --}}
                                    {{-- <div>
                                    <p class="text-[#987f46] font-bold tracking-widest">DURATION</p>
                                    <h1 class="text-xl font-medium">
                                        {{ strtotime($ticket['arriving_time']) - strtotime($ticket['departing_time']) }}</h1>
                                </div> --}}
                                </div>
                                <div class="p-4 gap-8 flex w-1/2 items-center justify-between">
                                    <div class="flex gap-4 flex-col">
                                        <div>
                                            <p class="text-[#987f46] font-bold tracking-widest">YOUR SEAT</p>
                                            <h1 class="text-xl font-medium">{{ $ticket['seat'] }}, Coach
                                                {{ $ticket['coach'] }}
                                            </h1>
                                        </div>
                                        <div>
                                            <p class="text-[#987f46] font-bold tracking-widest">TRAIN MODEL</p>
                                            <h1 class="text-xl font-medium">{{ $ticket['type'] }} -
                                                {{ $ticket['model'] }}
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="md:flex items-center justify-center size-[150px] hidden cursor-pointer" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'expandQrCode{{$ticket['qrCode']}}')">
                                        {!! file_get_contents('ticket_qrcodes/' . $ticket['qrCode'] . '.svg') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-full md:hidden p-4 border-t border-black">
                                <div class="size-[150px] flex items-center justify-center" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'expandQrCode{{$ticket['qrCode']}}')">
                                    {!! file_get_contents('ticket_qrcodes/' . $ticket['qrCode'] . '.svg') !!}
                                </div>
                            </div>
                        </div>
                        <img src="/images/past_stamp.png" alt=""
                            class="@if ($ticket['isActive']) {{ 'hidden' }} @endif z-10 h-20 absolute bottom-5 right-0">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @foreach ($tickets as $ticket)
        <x-modal name="expandQrCode{{$ticket['qrCode']}}" maxWidth="xl" class="overflow-auto">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Ticket-{{$ticket['qrCode']}}
                </h2>
    
                <p class="mt-1 text-sm text-gray-600">
                    Please screenshot this and save it on your phone to use it at the counter on the day of departing.
                </p>

                <div class="mt-4 size-full flex justify-center items-center">
                    <div class="lg:size-[500px] md:size-[450px] sm:size-[400px] min-[400px]:size-[300px] size-[200px] flex items-center justify-center">
                        {!! file_get_contents('ticket_qrcodes/' . $ticket['qrCode'] . '.svg') !!}
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-400">
                        {{ __('Close') }}
                    </x-secondary-button>
                </div>
            </div>
        </x-modal>
    @endforeach
</x-app-layout>
