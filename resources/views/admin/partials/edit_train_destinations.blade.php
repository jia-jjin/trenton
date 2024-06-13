@foreach ($trains as $train)
    <script>
        function moveTrainDestinationUp{{ $train['id'] }}(row) {
            let table = document.getElementById('train_destinations_table' + {{ $train['id'] }})
            let refRowIndex = row.parentElement.parentElement.rowIndex
            let tempRow = table.rows[refRowIndex]
            let tempTime = row.parentElement.parentElement.children[2].firstChild.value
            if (refRowIndex > 1) {
                table.deleteRow(refRowIndex)
                let insertingRow = table.insertRow(refRowIndex - 1)
                insertingRow.innerHTML = tempRow.innerHTML
                insertingRow.children[2].firstChild.value = tempTime
                updateDestinations{{ $train['id'] }}()
            }
        }

        function moveTrainDestinationDown{{ $train['id'] }}(row) {
            let table = document.getElementById('train_destinations_table' + {{ $train['id'] }})
            let refRowIndex = row.parentElement.parentElement.rowIndex
            let tempRow = table.rows[refRowIndex]
            let tempTime = row.parentElement.parentElement.children[2].firstChild.value
            if (refRowIndex < table.rows.length - 1) {
                table.deleteRow(refRowIndex)
                let insertingRow = table.insertRow(refRowIndex + 1)
                insertingRow.innerHTML = tempRow.innerHTML
                insertingRow.children[2].firstChild.value = tempTime
                updateDestinations{{ $train['id'] }}()
            }
        }

        function addTrainDestinationFilter{{ $train['id'] }}() {
            let table_rows = document.getElementById('train_destinations_table' + {{ $train['id'] }}).rows
            let create_train_destination_selector = document.getElementById('select-new-train-destination' +
                {{ $train['id'] }})
            for (let i = 0; i < create_train_destination_selector.children.length; i++) {
                create_train_destination_selector.children[i].classList.remove("hidden")
            }
            let chosenDestinations = []
            for (let i = 1; i < table_rows.length; i++) {
                chosenDestinations.push(table_rows[i].children[1].innerText.split(" ").join("-"))
            }
            for (let i = 0; i < chosenDestinations.length; i++) {
                let temp_select_option = document.getElementById("select-new-train-destination" + {{ $train['id'] }} +
                    "-" + chosenDestinations[i])
                temp_select_option.classList.add("hidden")
            }
            console.log(chosenDestinations)
        }

        function addTrainDestination{{ $train['id'] }}() {
            let table = document.getElementById('train_destinations_table' + {{ $train['id'] }})
            let create_train_destination_selector = document.getElementById('select-new-train-destination' +
                {{ $train['id'] }})
            let insertingRow = table.insertRow()
            insertingRow.innerHTML = `<tr>
                        <td>${table.rows.length-1}</td>
                        <td>${create_train_destination_selector.value}</td>
                        <td><input type="time" value="00:00"
                                onblur="updateDestinations{{ $train['id'] }}(this)" required></td>
                        <td><x-secondary-button
                                onclick="moveTrainDestinationUp{{ $train['id'] }}(this)">Up</x-secondary-button>
                        </td>
                        <td><x-secondary-button
                                onclick="moveTrainDestinationDown{{ $train['id'] }}(this)">Down</x-secondary-button>
                        </td>
                        <td><x-danger-button
                                onclick="deleteDestination{{ $train['id'] }}(this)">Delete</x-danger-button></td>
                    </tr>`
            create_train_destination_selector.value = create_train_destination_selector.children[0].value
        }

        function deleteDestination{{ $train['id'] }}(row) {
            let table = document.getElementById('train_destinations_table' + {{ $train['id'] }})
            let refRowIndex = row.parentElement.parentElement.rowIndex
            table.deleteRow(refRowIndex)
            updateDestinations{{ $train['id'] }}()
        }

        function updateDestinations{{ $train['id'] }}() {
            let table_rows = document.getElementById('train_destinations_table' + {{ $train['id'] }}).rows
            let destinations_list = []
            let destinations_arrival_time_list = []
            for (let index = 1; index < table_rows.length; index++) {
                destinations_list[index - 1] = table_rows[index].children[1].innerText
                destinations_arrival_time_list[index - 1] = table_rows[index].children[2].firstChild.value
            }
            let input_div = document.getElementById('array-input' + {{ $train['id'] }})
            input_div.innerHTML = ""

            function onlySemicolons(element) {
                return element == ":"
            }
            for (let index = 0; index < destinations_list.length; index++) {
                input_div.innerHTML += `<input type='hidden' name='result[]' value='${destinations_list[index]}'>`
            }
            for (let index = 0; index < destinations_arrival_time_list.length; index++) {
                let valueToBeInserted = destinations_arrival_time_list[index];
                if (valueToBeInserted.split("").filter(onlySemicolons).join("").length < 2) {
                    valueToBeInserted += ":00"
                }
                input_div.innerHTML += `<input type='hidden' name='result2[]' value='${valueToBeInserted}'>`
            }
            console.log()
        }
    </script>
    <x-modal name="view-train{{ $train['id'] }}" maxWidth="3xl" focusable>
        <div class="p-6">
            <div class="flex justify-between">
                <h2 class="text-lg font-medium text-gray-900">
                    Edit destinations of {{ $train['model'] }}
                </h2>
                <x-secondary-button x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'view-train-add-destination{{ $train['id'] }}')"
                    onclick="addTrainDestinationFilter{{ $train['id'] }}()">
                    Add destination
                </x-secondary-button>
            </div>

            {{-- <div class="mt-2">
                <x-input-label for="train_name" :value="__('Train Name')" />
                <x-text-input id="train_name" name="train_name" type="text" class="mt-1 block w-full" required autofocus />
            </div> --}}

            <table class="mt-6 flex" id="train_destinations_table{{ $train['id'] }}">
                <tr>
                    <th>ID</th>
                    <th>Destination</th>
                    <th>Arrival Time</th>
                    <th colspan="3">Actions</th>
                </tr>
                @foreach ($train_destinations[$train['id'] - 1] as $train_destination)
                    <tr>
                        <td>{{ $train_destination->id }}</td>
                        <td>{{ $destinations[$train_destination->destination_id - 1]['destination'] }}</td>
                        <td><input type="time" value="{{ $train_destination->arrival_time }}"
                                onblur="updateDestinations{{ $train['id'] }}(this)" required></td>
                        <td><x-secondary-button
                                onclick="moveTrainDestinationUp{{ $train['id'] }}(this)">Up</x-secondary-button>
                        </td>
                        <td><x-secondary-button
                                onclick="moveTrainDestinationDown{{ $train['id'] }}(this)">Down</x-secondary-button>
                        </td>
                        <td><x-danger-button
                                onclick="deleteDestination{{ $train['id'] }}(this)">Delete</x-danger-button></td>
                    </tr>
                @endforeach
            </table>


            <div class="flex items-center gap-4 mt-6 w-full justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-400">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <form method="post" action="{{ route('admin.edit_train_destinations') }}">
                    @csrf
                    @method('put')
                    <input type="hidden" name="train_id" value="{{ $train['id'] }}">
                    <div id="array-input{{ $train['id'] }}">
                        {{-- list of updated destinations --}}
                    </div>
                    <x-primary-button
                        onclick="updateDestinations{{ $train['id'] }}()">{{ __('Save') }}</x-primary-button>
                </form>
            </div>
        </div>
    </x-modal>
    @include('admin.partials.add_train_destinations')
@endforeach
