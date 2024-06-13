<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="icon" href="/images/logo.png">

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/7629b30e08.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        {{-- @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        AOS.init()

        function dropdownVisible1() {
            document.getElementById('myDropdown1').classList.toggle("hidden");
        }

        function dropdownVisible2() {
            document.getElementById('myDropdown2').classList.toggle("hidden");
        }

        function filterFunction1() {
            const input = document.getElementById("myInput1");
            const filter = input.value.toUpperCase();
            const div = document.getElementById("myDropdown1");
            const a = div.getElementsByTagName("a");
            for (let i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }

        function filterFunction2() {
            const input = document.getElementById("myInput2");
            const filter = input.value.toUpperCase();
            const div = document.getElementById("myDropdown2");
            const a = div.getElementsByTagName("a");
            for (let i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }

        function typeToResult1(place) {
            const input = document.getElementById("myInput1")
            input.value = place;
            filterFunction1()
        }

        function typeToResult2(place) {
            const input = document.getElementById("myInput2")
            input.value = place;
            filterFunction2()
        }

        function swapPlaces(e) {
            const input1 = document.getElementById("myInput1")
            const input2 = document.getElementById("myInput2")
            const tempValue = input1.value
            input1.value = input2.value
            input2.value = tempValue
            e.classList.toggle("rotate-180");
            filterFunction1()
            filterFunction2()
        }

        // function parallax(){
        //     var yPos = window.scrollY / 10;
        // }

        // window.addEventListener("scroll", function() {
        //     parallax();
        // });

        var returningDate = "";

        window.onload = function onloadOneway(e) {
            const checkbox = document.getElementById("oneway")
            const date2 = document.getElementById("datepicker2")
            if (checkbox.checked) {
                date2.disabled = true;
                returningDate = date2.value
                date2.value = ""
                date2.placeholder = "Travelling one way"
            } else {
                date2.disabled = false;
                date2.placeholder = "Choose a date"
            }
        }

        function oneWay(e) {
            const checkbox = document.getElementById("oneway")
            const date2 = document.getElementById("datepicker2")
            if (checkbox.checked) {
                date2.disabled = true;
                returningDate = date2.value
                date2.value = ""
                date2.placeholder = "Travelling one way"
            } else {
                date2.disabled = false;
                date2.value = returningDate
                date2.placeholder = "Choose a date"
            }
        }

        let seats = document.getElementsByClassName("seat")
        let seats2 = document.getElementsByClassName("seat2")
        let passengers = document.getElementById("passengers")
        let selected_seats1 = [];
        let selected_seats2 = [];
        let alphabets = ["A", "B", "C", "D"].reverse();
        let departing_table = document.getElementById("departing_table-")
        let returning_table = document.getElementById("returning_table")
        let departing_table_placeholder = document.getElementById("departing_table_placeholder-")
        let returning_table_placeholder = document.getElementById("returning_table_placeholder")
        let departing_proceed = document.getElementById("departing_proceed-")
        let returning_proceed = document.getElementById("returning_proceed")
        function selectDepartingTrain(train_id){
            departing_table = document.getElementById("departing_table-"+train_id)
            departing_table_placeholder = document.getElementById("departing_table_placeholder-"+train_id)
            departing_proceed = document.getElementById("departing_proceed-"+train_id)
        }
        function selectReturningTrain(train_id){
            returning_table = document.getElementById("returning_table-"+train_id)
            returning_table_placeholder = document.getElementById("returning_table_placeholder-"+train_id)
            returning_proceed = document.getElementById("returning_proceed-"+train_id)
        }
        let departing_train = document.getElementById("departing_train")
        let returning_train = document.getElementById("returning_train")
        let departing_train_id = 0;
        let returning_train_id = 0;
        let payment = document.getElementById("payment");
        let departing_depart_time = "";
        let departing_arrive_time = "";
        let returning_depart_time = "";
        let returning_arrive_time = "";
        for (var i = 0; i < seats.length; i++) {
            let tempInt = i
            seats[tempInt].addEventListener('click', (e) => {
                if (!seats[tempInt].classList.contains('seat-booked')) {
                    let seat_name = (Math.floor(tempInt %48 / 4) + 1) + (alphabets[tempInt%48 % 4]);
                    // seats[tempInt].classList.toggle("seat")
                    if (seats[tempInt].classList.contains("seat-selected1")) {
                        selected_seats1.splice(selected_seats1.indexOf(seat_name), 1)
                        seats[tempInt].classList.toggle("seat-selected1")
                    } else {
                        if (selected_seats1.length < passengers.value) {
                            selected_seats1.push(seat_name)
                            seats[tempInt].classList.toggle("seat-selected1")
                        }
                    }
                    if (selected_seats1.length) {
                        if (!departing_table_placeholder.classList.contains("hidden"))
                            departing_table_placeholder.classList.add("hidden")
                        if (departing_table.classList.contains("hidden"))
                            departing_table.classList.remove("hidden")
                        if (departing_table.parentElement.classList.contains("items-center"))
                            departing_table.parentElement.classList.remove("items-center")
                        departing_table.parentElement.classList.add("items-start")
                    } else {
                        departing_table_placeholder.classList.remove("hidden")
                        departing_table.classList.add("hidden")
                        departing_table.parentElement.classList.add("items-center")
                        departing_table.parentElement.classList.remove("items-start")
                    }
                    departing_table.innerHTML = "<tr><th>ID</th><th>Coach</th><th>Seat</th><th>Fare</th></tr>"
                    for (let i = 0; i < selected_seats1.length; i++) {
                        var row = departing_table.insertRow();
                        var row_id = row.insertCell(0);
                        var row_coach = row.insertCell(1);
                        var row_seat = row.insertCell(2);
                        var row_fare = row.insertCell(3);
                        row_id.innerHTML = i + 1
                        row_coach.innerHTML = "A"
                        row_seat.innerHTML = selected_seats1[i]
                        row_fare.innerHTML = "RM XXX"
                    }
                    if (passengers.value == selected_seats1.length) {
                        departing_proceed.disabled = false
                    } else {
                        departing_proceed.disabled = true
                    }
                }
            });
        }
        for (var i = 0; i < seats2.length; i++) {
            let tempInt = i
            seats2[tempInt].addEventListener('click', (e) => {
                if (!seats2[tempInt].classList.contains('seat-booked')) {
                    let seat_name = (Math.floor(tempInt % 48 / 4) + 1) + (alphabets[tempInt % 48 % 4]);
                    // seats[tempInt].classList.toggle("seat")
                    if (seats2[tempInt].classList.contains("seat-selected2")) {
                        selected_seats2.splice(selected_seats2.indexOf(seat_name), 1)
                        seats2[tempInt].classList.toggle("seat-selected2")
                    } else {
                        if (selected_seats2.length < passengers.value) {
                            selected_seats2.push(seat_name)
                            seats2[tempInt].classList.toggle("seat-selected2")
                        }
                    }
                    if (selected_seats2.length) {
                        if (!returning_table_placeholder.classList.contains("hidden"))
                            returning_table_placeholder.classList.add("hidden")
                        if (returning_table.classList.contains("hidden"))
                            returning_table.classList.remove("hidden")
                        if (returning_table.parentElement.classList.contains("items-center"))
                            returning_table.parentElement.classList.remove("items-center")
                        returning_table.parentElement.classList.add("items-start")
                    } else {
                        returning_table_placeholder.classList.remove("hidden")
                        returning_table.classList.add("hidden")
                        returning_table.parentElement.classList.add("items-center")
                        returning_table.parentElement.classList.remove("items-start")
                    }
                    returning_table.innerHTML = "<tr><th>ID</th><th>Coach</th><th>Seat</th><th>Fare</th></tr>"
                    for (let i = 0; i < selected_seats2.length; i++) {
                        var row = returning_table.insertRow();
                        var row_id = row.insertCell(0);
                        var row_coach = row.insertCell(1);
                        var row_seat = row.insertCell(2);
                        var row_fare = row.insertCell(3);
                        row_id.innerHTML = i + 1
                        row_coach.innerHTML = "A"
                        row_seat.innerHTML = selected_seats2[i]
                        row_fare.innerHTML = "RM XXX"
                    }
                    if (passengers.value == selected_seats2.length) {
                        returning_proceed.disabled = false
                    } else {
                        returning_proceed.disabled = true
                    }
                }
            });
        }

        function updateBookedSeats(train_id, departingOrReturning, position) {
            let booked_seats = document.getElementsByClassName(train_id + "-seat[]")
            let booked_coach = document.getElementsByClassName(train_id + "-coach[]")
            let booked_seats_name = []
            let booked_coach_name = []
            let booked_seats_id = []
            let alphabets = ['A', 'B', 'C', 'D'].reverse()
            for (let i = 0; i < booked_seats.length; i++) {
                booked_seats_name[i] = booked_seats[i].value
                booked_coach_name[i] = booked_coach[i].value
            }
            for (let i = 0; i < booked_seats_name.length; i++) {
                let possible_seat_ids = []
                let the_seat_id = 0;
                let booked_seat_number = booked_seats_name[i].slice(0, booked_seats_name[i].length - 1)
                let booked_seat_alphabet = alphabets.indexOf(booked_seats_name[i].split('').pop())
                booked_seat_number -= 1
                for (let j = 0; j < 4; j++) {
                    possible_seat_ids.push(booked_seat_number * 4 + j)
                }
                for (let j = 0; j <= 100; j++) {
                    if (possible_seat_ids.includes(booked_seat_alphabet + j * 4)) {
                        the_seat_id = booked_seat_alphabet + j * 4
                        break
                    }
                }
                booked_seats_id.push(the_seat_id)
            }
            for (let i = 0; i < booked_seats_id.length; i++) {
                if (departingOrReturning == "departing") {
                    seats[booked_seats_id[i]+position*48].classList.add("seat-booked")
                } else {
                    seats2[booked_seats_id[i]+position*48].classList.add("seat-booked")
                }
            }
        }

        function abortDeparting() {
            let temp_selected_seats = document.getElementsByClassName("seat-selected1")
            selected_seats1 = []
            departing_table_placeholder.classList.remove("hidden")
            departing_table.classList.add("hidden")
            departing_table.parentElement.classList.add("items-center")
            departing_table.parentElement.classList.remove("items-start")
            departing_proceed.disabled = true
            departing_train.innerHTML = "not selected"
            departing_depart_time = ""
            departing_arrive_time = ""
            for (let i = temp_selected_seats.length - 1; i >= 0; i--) {
                temp_selected_seats[i].classList.remove("seat-selected1")
            }
            checkIfBothTrainsAreSelected();
        }

        function abortReturning() {
            let temp_selected_seats = document.getElementsByClassName("seat-selected2")
            selected_seats2 = []
            returning_table_placeholder.classList.remove("hidden")
            returning_table.classList.add("hidden")
            returning_table.parentElement.classList.add("items-center")
            returning_table.parentElement.classList.remove("items-start")
            returning_proceed.disabled = true
            returning_train.innerHTML = "not selected"
            returning_depart_time = ""
            returning_arrive_time = ""
            for (let i = temp_selected_seats.length - 1; i >= 0; i--) {
                temp_selected_seats[i].classList.remove("seat-selected2")
            }
            checkIfBothTrainsAreSelected();
        }

        function confirmDeparting(element) {
            departing_train_name = element.parentElement.getAttribute("data-train")
            departing_train.innerHTML = departing_train_name
            departing_depart_time = element.parentElement.getAttribute("data-depart-time")
            departing_arrive_time = element.parentElement.getAttribute("data-arrive-time")
            checkIfBothTrainsAreSelected();
        }

        function confirmReturning(element) {
            returning_train_name = element.parentElement.getAttribute("data-train")
            returning_train.innerHTML = returning_train_name
            returning_depart_time = element.parentElement.getAttribute("data-depart-time")
            returning_arrive_time = element.parentElement.getAttribute("data-arrive-time")
            checkIfBothTrainsAreSelected();
        }

        let oneway = document.getElementById("oneway").checked

        function checkIfBothTrainsAreSelected() {
            if (oneway) {
                if (departing_train.innerHTML != "not selected") {
                    payment.disabled = false
                } else {
                    payment.disabled = true
                }
            } else {
                if (departing_train.innerHTML != "not selected" && returning_train.innerHTML != "not selected") {
                    payment.disabled = false
                } else {
                    payment.disabled = true
                }
            }
        }

        let show = document.getElementById('show')
        let sort = document.getElementById('sort')
        if (show != null && sort != null) {
            show.addEventListener('change', (e) => {
                e.target.parentElement.parentElement.parentElement.submit()
            });
            sort.addEventListener('change', (e) => {
                e.target.parentElement.parentElement.parentElement.submit()
            });
        }

        function changeTrainType() {
            let departing = document.getElementById("departing_trains_list")
            let returning = document.getElementById("returning_trains_list")
            let departing_dropdown = trains_type;
            let returning_dropdown = trains_type2;
            departing.classList.toggle("hidden")
            returning.classList.toggle("hidden")
            departing_dropdown.value = "departing"
            returning_dropdown.value = "returning"
        }

        let initialData = "";

        function proceedPaymentDetails() {
            let paymentDetails = document.getElementById("payment_details")
            initialData = paymentDetails.innerHTML
            let paymentTable = document.getElementById("payment_table")
            paymentTable.innerHTML = "<tr><th>ID</th><th>Train</th><th>Coach</th><th>Seat</th><th>Fare</th></tr>"
            let total_selected_seats = selected_seats1.concat(selected_seats2)
            document.getElementById('payment_departing_train').firstElementChild.innerHTML = departing_train.innerHTML
            document.getElementById('payment_returning_train').firstElementChild.innerHTML = returning_train.innerHTML
            document.getElementById('payment_departing_depart_time').innerHTML = departing_depart_time
            document.getElementById('payment_departing_arrive_time').innerHTML = departing_arrive_time
            document.getElementById('payment_returning_depart_time').innerHTML = returning_depart_time
            document.getElementById('payment_returning_arrive_time').innerHTML = returning_arrive_time
            for (let i = 0; i < total_selected_seats.length; i++) {
                var row = paymentTable.insertRow();
                var row_id = row.insertCell();
                var row_train = row.insertCell();
                var row_coach = row.insertCell();
                var row_seat = row.insertCell();
                var row_fare = row.insertCell();
                row_id.innerHTML = i + 1
                row_train.innerHTML = departing_train.innerHTML
                if (i >= selected_seats1.length) {
                    row_train.innerHTML = returning_train.innerHTML
                }
                row_coach.innerHTML = "A"
                row_seat.innerHTML = total_selected_seats[i]
                row_fare.innerHTML = "RM XXX"
            }
            let paymentDetailsFields = ["departing_train_name", "returning_train_name", ]
            let paymentDetailsValues = [departing_train.innerHTML, returning_train.innerHTML, ]
            for (let i = 0; i < paymentDetailsFields.length; i++) {
                let inputElement = document.createElement("input")
                inputElement.type = "hidden"
                inputElement.name = paymentDetailsFields[i]
                inputElement.value = paymentDetailsValues[i]
                paymentDetails.appendChild(inputElement)
            }
            for (let i = 0; i < selected_seats1.length; i++) {
                let inputElement = document.createElement("input")
                inputElement.type = "hidden"
                inputElement.name = "departing_ticket" + (i + 1)
                inputElement.value = selected_seats1[i]
                paymentDetails.appendChild(inputElement)
            }
            for (let i = 0; i < selected_seats2.length; i++) {
                let inputElement = document.createElement("input")
                inputElement.type = "hidden"
                inputElement.name = "returning_ticket" + (i + 1)
                inputElement.value = selected_seats2[i]
                paymentDetails.appendChild(inputElement)
            }

        }

        function cancelPaymentDetails() {
            let paymentDetails = document.getElementById("payment_details")
            paymentDetails.innerHTML = initialData
        }
    </script>
</body>
<footer class="py-6 text-center text-sm text-black border border-black w-full border-x-0 border-b-0">
    TRENTON &copy; 2024
</footer>

</html>
