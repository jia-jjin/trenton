<x-app-layout>
    <div class="w-full relative">
        <div class="absolute bg-black/30 size-full"></div>
        <div
            class="absolute size-full px-20 lg:py-0 py-10 flex items-center lg:justify-between justify-center lg:flex-row flex-col gap-4">
            <h1 class="col-md-4 font-black sm:text-6xl text-5xl text-white drop-shadow-2xl lg:text-start text-center">
                Train
                Service<br>Across MALAYSIA</h1>
            <div
                class="md:block hidden col-md-4 border border-black w-full min-h-80 sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form method="POST" action="{{ route('booking.search') }}">
                    @csrf
                    <h1>Destinations</h1>
                    <div class="flex items-center w-full gap-2 mt-2 justify-center">
                        <div class="relative inline-block">
                            <input type="text" id="myInput1" placeholder="Depart from" onfocusin="dropdownVisible1()"
                                name="from_destination" onfocusout="setTimeout(dropdownVisible1,120)"
                                onkeyup="filterFunction1()" class="border border-black rounded-md p-2" required>
                            <div id="myDropdown1"
                                class="shadow-2xl duration-150 transition-all py-2 max-h-48 min-h-14 w-full hidden absolute overflow-y-scroll z-[1] border border-black rounded-md bg-white">
                                <h1 class="text-black no-underline px-4 py-2 block absolute -z-[1]">No results found.
                                </h1>
                                @foreach ($destinations as $destination)
                                    <a class="text-black no-underline px-4 py-2 block cursor-pointer bg-white hover:bg-gray-200 duration-100"
                                        onclick="typeToResult1('{{ $destination['destination'] }}')">{{ $destination['destination'] }}</a>
                                @endforeach

                            </div>
                        </div>
                        <i class="fa-solid fa-right-left cursor-pointer duration-300 rotate-180"
                            onclick="swapPlaces(this)"></i>
                        <div class="relative inline-block">
                            <input type="text" id="myInput2" placeholder="Destination" onclick=""
                                name="to_destination" onfocusin="dropdownVisible2()"
                                onfocusout="setTimeout(dropdownVisible2,120)" onkeyup="filterFunction2()"
                                class="border border-black rounded-md p-2" required>
                            <div id="myDropdown2"
                                class="shadow-2xl duration-150 py-2 max-h-48 min-h-14 w-full hidden absolute overflow-y-scroll z-[1] border border-black rounded-md bg-white">
                                <h1 class="text-black no-underline px-4 py-2 block absolute -z-[1]">No results found.
                                </h1>
                                @foreach ($destinations as $destination)
                                    <a class="text-black no-underline px-4 py-2 block cursor-pointer bg-white hover:bg-gray-200 duration-100"
                                        onclick="typeToResult2('{{ $destination['destination'] }}')">{{ $destination['destination'] }}</a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <h1 class="mt-4">Out & Return Dates</h1>
                    <div class="flex items-center w-full gap-2 mt-2 justify-center">
                        <input type="text" placeholder="Choose a date" data-language='en' name="date" required
                            id="datepicker1" class="readonly border border-black rounded-md p-2">
                        <i class="fa-solid fa-arrow-right "></i>
                        <input type="text" placeholder="Choose a date" data-language='en' name="date2" required
                            id="datepicker2" class="readonly border border-black rounded-md p-2">
                    </div>

                    <div class="mt-2">
                        <input type="checkbox" id="oneway" name="oneway" value="oneway" onclick="oneWay(this)">
                        <label for="oneway" class="p-0 m-0">I am travelling one way</label>
                    </div>

                    <div class="flex flex-col w-full justify-center mt-4">
                        <label for="passengers">Passengers (maximum 12)</label>
                        <input type="number" placeholder="Choose amount of passengers..." data-language='en'
                            name="passengers" min=1 max=12 oninput="validity.valid||(value='');"
                            class="border border-black rounded-md p-2 mt-2" required>
                    </div>
                    <x-primary-button class="w-full justify-center mt-6 mb-2">
                        Search
                    </x-primary-button>
                </form>
            </div>
        </div>
        <img src="/images/hero-bg.jpg" alt="" class="w-full img-fluid lg:h-[500px] h-[600px] object-cover">
    </div>
    <div class="relative flex flex-col items-center justify-center py-10">
        <div class="relative px-6 lg:max-w-7xl max-w-2xl">
            <h1 class="text-3xl font-bold text-center">Why drive a 🚗 when a 🚄 <span class="text-nowrap">is <span
                        class="before:block before:absolute before:-inset-1 before:-skew-y-2 before:bg-green-500 relative inline-block whitespace-nowrap">
                        <span class="relative text-white">way faster</span></span>
                    ?</span></h1>
        </div>
    </div>

    <h1 class="text-2xl w-full justify-center flex font-semibold">A train has...</h1>
    <div class="flex flex-wrap mt-6 h-100 [&>*]:w-80 [&>*]:min-h-28 gap-4 w-full justify-center px-8" id="features"
        data-aos="fade-up">
        <div
            class="border border-black px-6 py-4 bg-white hover:drop-shadow-md hover:scale-105 overflow-hidden rounded-lg duration-150">
            <div class="space-y-2">
                <h1 class="text-3xl font-bold">🎫 CHEAP PRICES</h1>
                <h1>Buy your tickets at the lowest price guaranteed!</h1>
            </div>
        </div>
        <div
            class="border border-black px-6 py-4 bg-white hover:drop-shadow-md hover:scale-105 overflow-hidden rounded-lg duration-150">
            <div class="space-y-2">
                <h1 class="text-3xl font-bold">💨 HIGHER SPEED</h1>
                <h1>Definitely faster than a Ferarri!</h1>
            </div>
        </div>
        <div
            class="border border-black px-6 py-4 bg-white hover:drop-shadow-md hover:scale-105 overflow-hidden rounded-lg duration-150">
            <div class="space-y-2">
                <h1 class="text-3xl font-bold">😴 MORE REST</h1>
                <h1>Worry not about falling asleep while driving!</h1>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <div data-aos="fade-in" class="m-12 md:bg-white md:space-y-0 space-y-8">
        <div class="flex items-center justify-center border border-black divide-x divide-black">
            <div class="flex flex-col justify-center items-center md:w-1/2 size-full gap-4 relative h-full md:min-h-0 min-h-[400px] ">
                <h1 class="font-bold text-center text-3xl px-4">Anywhere, Anytime</h1>
                <p class="text-center px-4">Enjoy a peaceful & relaxing ride along with seamless transfers between stations.
                </p>
                <img src="/images/train-hero.jpg" alt=""
                    class="md:hidden flex opacity-25 absolute size-full object-cover -z-[1]">
            </div>
            <img src="/images/train-hero.jpg" alt="" class="w-1/2 md:block hidden">
        </div>
        <div class="flex items-center justify-center border border-black md:border-t-0">
            <img src="/images/train-hero2.jpg" alt="" class="w-1/2 md:block hidden md:border-e border-black">
            <div class="flex flex-col justify-center items-center md:w-1/2 size-full gap-4 relative md:min-h-0 min-h-[400px]">
                <h1 class="font-bold text-center text-3xl px-4">Trusted by Millions of Users and Officials</h1>
                <p class="text-center px-4">Always 5 stars reviews on our page.</p>
                <img src="/images/train-hero2.jpg" alt=""
                    class="md:hidden flex opacity-25 absolute size-full object-cover -z-[1]">
            </div>
        </div>
    </div>
    <br><br><br><br>
    <h1 class="text-5xl font-bold text-center">Popular Tourist Attractions</h1>
    <br><br>
    <div class="flex flex-wrap justify-center items-center gap-8 [&>*]:h-[200px] [&>*]:w-[350px]">
        <div class="relative overflow-clip [&>*]:duration-300 group border border-black rounded-xl">
            <img src="/images/langkawi.jpeg" alt=""
                class="md:group-hover:scale-110 md:scale-100 scale-110 img-fluid object-cover size-full">
            <div class="top-0 absolute size-full bg-black/20 md:group-hover:opacity-100 md:opacity-0 opacity-100"></div>
            <div
                class="h-16 bg-gradient-to-b from-[#e9c56a]/20 to-[#e9c56a] absolute w-full md:-bottom-20 md:group-hover:bottom-0 bottom-0 flex justify-center items-center">
                <h1 class="font-bold text-white text-3xl">Langkawi</h1>
            </div>
        </div>
        <div class="relative overflow-clip [&>*]:duration-300 group border border-black rounded-xl">
            <img src="/images/kl.jpg" alt="" class="md:group-hover:scale-110 md:scale-100 scale-110 img-fluid object-cover size-full">
            <div class="top-0 absolute size-full bg-black/20 group-hover:opacity-100 opacity-0"></div>
            <div
                class="h-16 bg-gradient-to-b from-[#e9c56a]/20 to-[#e9c56a] absolute w-full md:-bottom-20 md:group-hover:bottom-0 bottom-0 flex justify-center items-center">
                <h1 class="font-bold text-white text-3xl">KL</h1>
            </div>
        </div>
        <div class="relative overflow-clip [&>*]:duration-300 group border border-black rounded-xl">
            <img src="/images/leaning_tower.jpg" alt=""
            class="md:group-hover:scale-110 md:scale-100 scale-110 img-fluid object-cover size-full">
            <div class="top-0 absolute size-full bg-black/20 group-hover:opacity-100 opacity-0"></div>
            <div
                class="h-16 bg-gradient-to-b from-[#e9c56a]/20 to-[#e9c56a] absolute w-full md:-bottom-20 md:group-hover:bottom-0 bottom-0 flex justify-center items-center">
                <h1 class="font-bold text-white text-3xl">Perak</h1>
            </div>
        </div>
        <div class="relative overflow-clip [&>*]:duration-300 group border border-black rounded-xl">
            <img src="/images/malacca.jpg" alt=""
            class="md:group-hover:scale-110 md:scale-100 scale-110 img-fluid object-cover size-full">
            <div class="top-0 absolute size-full bg-black/20 group-hover:opacity-100 opacity-0"></div>
            <div
                class="h-16 bg-gradient-to-b from-[#e9c56a]/20 to-[#e9c56a] absolute w-full md:-bottom-20 md:group-hover:bottom-0 bottom-0 flex justify-center items-center">
                <h1 class="font-bold text-white text-3xl">Malacca</h1>
            </div>
        </div>
        <div class="relative overflow-clip [&>*]:duration-300 group border border-black rounded-xl">
            <img src="/images/komtar.jpg" alt=""
            class="md:group-hover:scale-110 md:scale-100 scale-110 img-fluid object-cover size-full">
            <div class="top-0 absolute size-full bg-black/20 group-hover:opacity-100 opacity-0"></div>
            <div
                class="h-16 bg-gradient-to-b from-[#e9c56a]/20 to-[#e9c56a] absolute w-full md:-bottom-20 md:group-hover:bottom-0 bottom-0 flex justify-center items-center">
                <h1 class="font-bold text-white text-3xl">Penang</h1>
            </div>
        </div>
        <div class="relative overflow-clip [&>*]:duration-300 group border border-black rounded-xl">
            <img src="/images/genting_highlands.jpg" alt=""
            class="md:group-hover:scale-110 md:scale-100 scale-110 img-fluid object-cover size-full">
            <div class="top-0 absolute size-full bg-black/20 group-hover:opacity-100 opacity-0"></div>
            <div
                class="h-16 bg-gradient-to-b from-[#e9c56a]/20 to-[#e9c56a] absolute w-full md:-bottom-20 md:group-hover:bottom-0 bottom-0 flex justify-center items-center">
                <h1 class="font-bold text-white text-3xl">Genting Highlands</h1>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <h1 class="text-5xl font-bold text-center">What our customers say</h1>
    <br><br>
    <div class="flex gap-8 px-12 [&>*]:w-[350px] flex-wrap justify-center" data-aos="flip-left">
        <div class="flex flex-col items-center border border-black rounded-md p-4 gap-2 relative bg-white">
            <img src="/images/guy.jpeg" alt=""
                class="w-16 h-16 rounded-full border-black border-2 absolute -top-6">
            <br>
            <h1 class="font-semibold">Charath Velan</h1>
            <h1>⭐⭐⭐⭐⭐</h1>
            <h1 class="text-center">"This is probably one of the best train ticket systems I've ever used."</h1>
        </div>
        <div class="flex flex-col items-center border border-black rounded-md p-4 gap-2 relative bg-white">
            <img src="/images/guy.jpeg" alt=""
                class="w-16 h-16 rounded-full border-black border-2 absolute -top-6">
            <br>
            <h1 class="font-semibold">Stanley Cheah</h1>
            <h1>⭐⭐⭐⭐⭐</h1>
            <h1 class="text-center">"10 out of 10 bro."</h1>
        </div>
        <div class="flex flex-col items-center border border-black rounded-md p-4 gap-2 relative bg-white">
            <img src="/images/guy.jpeg" alt=""
                class="w-16 h-16 rounded-full border-black border-2 absolute -top-6">
            <br>
            <h1 class="font-semibold">Logan Kannan</h1>
            <h1>⭐⭐⭐⭐⭐</h1>
            <h1 class="text-center">"Absolutely amazing."</h1>
        </div>
    </div>
    <br><br><br><br>
</x-app-layout>
