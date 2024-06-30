<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinations;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Train;
use App\Models\Seats;
use App\Models\Tickets;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SearchController extends Controller
{

    public function defaultQuery()
    {
        return DB::select("SELECT * from trains");
    }

    public function show_results($search)
    {
        $result = $this->defaultQuery();
        $result2 = $this->defaultQuery();
        $destinations = Destinations::all();

        $from_destination = $search->from_destination;
        $to_destination = $search->to_destination;
        $departing_date = $search->date;
        $arriving_date = "";
        $oneway = $search->oneway == "oneway";
        $oneway_value = $search->oneway;
        if (!$oneway) {
            $arriving_date = $search->date2;
        }
        $passengers = $search->passengers;

        $search = array("from_destination" => $from_destination, "to_destination" => $to_destination, "oneway" => $oneway_value,  "date" => $departing_date, "date2" => $arriving_date, "passengers" => $passengers);

        foreach ($result as $index => $i) {
            $result[$index] = (array) $i;
            $result[$index]['destinations'] = DB::table('train_destinations')
                ->join('destinations', 'destinations.id', '=', 'train_destinations.destination_id')
                ->where('train_id', $result[$index]['id'])->orderBy('train_destinations.id')->pluck('destinations.destination')
                ->toArray();
        }

        $result2 = [];

        // if ($from_destination != "" && $to_destination != "") {
        foreach ($result as $key => $value) {
            $remaining_destinations = array_slice($value['destinations'], array_search($from_destination, $value['destinations']) + 1);
            $result[$key]['from_destination'] = $from_destination;
            $result[$key]['to_destination'] = $to_destination;
            if ((in_array($from_destination, $value['destinations']) && in_array($to_destination, $value['destinations'])) && $from_destination != $to_destination) {
                if (!in_array($to_destination, $remaining_destinations)) {
                    $result[$key]['from_destination'] = $to_destination;
                    $result[$key]['to_destination'] = $from_destination;
                    array_push($result2, $result[$key]);
                    $result[$key] = null;
                }
            } else {
                $result[$key] = null;
            }
        }

        $result = array_filter($result, function ($element) {
            return $element != null;
        });

        $result_index = 0;
        foreach ($result as $key => $value) {
            $result[$key]['departing_time'] = DB::table('train_destinations')
                ->join('destinations', 'destinations.id', '=', 'train_destinations.destination_id')
                ->where('destinations.destination', $value['from_destination'])
                ->where('train_destinations.train_id', $result[$key]['id'])->pluck('arrival_time')->first();

            $result[$key]['arriving_time'] = DB::table('train_destinations')
                ->join('destinations', 'destinations.id', '=', 'train_destinations.destination_id')
                ->where('destinations.destination', $value['to_destination'])
                ->where('train_destinations.train_id', $result[$key]['id'])->pluck('arrival_time')->first();

            // $destinations_list = DB::table('destinations')->where('destination', $from_destination)->pluck('id')->first();
            $train_id = $result[$key]['id'];
            $from_destination_id = DB::table('train_destinations')
                ->where('train_id', $train_id)
                ->where('destination_id', DB::table('destinations')->where('destination', $from_destination)->pluck('id')->first())
                ->pluck('id')->first();
            $to_destination_id = DB::table('train_destinations')
                ->where('train_id', $train_id)
                ->where('destination_id', DB::table('destinations')->where('destination', $to_destination)->pluck('id')->first())
                ->pluck('id')->first();

            $result[$key]['booked_seats'] = DB::table('tickets')
                ->where('date', implode('-', array_reverse(explode('/', $departing_date))))
                // ->where('departing_destination', $from_destination_id)
                // ->where('arriving_destination', $to_destination_id)
                ->where('seats.train_id', $train_id)
                ->join('seats', 'seats.id', '=', 'seat_id')
                ->get();

            $result[$key]['seats'] = count(DB::table('seats')
                ->where('train_id', $result[$key]['id'])
                ->get()) - count($result[$key]['booked_seats']);

            $result[$key]['position'] = $result_index;
            $result_index += 1;

            // dd($result[$key]['booked_seats']);
        }

        $result2_index = 0;
        foreach ($result2 as $key => $value) {
            $result2[$key]['departing_time'] = DB::table('train_destinations')
                ->join('destinations', 'destinations.id', '=', 'train_destinations.destination_id')
                ->where('destinations.destination', $value['from_destination'])
                ->where('train_destinations.train_id', $result2[$key]['id'])->pluck('arrival_time')->first();

            $result2[$key]['arriving_time'] = DB::table('train_destinations')
                ->join('destinations', 'destinations.id', '=', 'train_destinations.destination_id')
                ->where('destinations.destination', $value['to_destination'])
                ->where('train_destinations.train_id', $result2[$key]['id'])->pluck('arrival_time')->first();

            $train_id = $result2[$key]['id'];
            $to_destination_id = DB::table('train_destinations')
                ->where('train_id', $train_id)
                ->where('destination_id', DB::table('destinations')->where('destination', $from_destination)->pluck('id')->first())
                ->pluck('id')->first();
            $from_destination_id = DB::table('train_destinations')
                ->where('train_id', $train_id)
                ->where('destination_id', DB::table('destinations')->where('destination', $to_destination)->pluck('id')->first())
                ->pluck('id')->first();

            $result2[$key]['booked_seats'] = DB::table('tickets')
                ->where('date', implode('-', array_reverse(explode('/', $arriving_date))))
                // ->where('departing_destination', $from_destination_id)
                // ->where('arriving_destination', $to_destination_id)
                ->where('seats.train_id', $train_id)
                ->join('seats', 'seats.id', '=', 'seat_id')
                ->get();

            $result2[$key]['seats'] = count(DB::table('seats')
                ->where('train_id', $result2[$key]['id'])
                ->get()) - count($result2[$key]['booked_seats']);

            $result2[$key]['position'] = $result2_index;
            $result2_index += 1;
        }

        return view("booking", [
            'destinations' => $destinations, 'departing_trains' => $result, 'returning_trains' => $result2, 'data' => $search
        ]);
    }

    public function initial_state()
    {
        $destinations = Destinations::all();
        $search = array("from_destination" => "", "to_destination" => "", "oneway" => "",  "date" => "", "date2" => "", "passengers" => "");
        return view("booking", [
            'destinations' => $destinations, 'departing_trains' => [], 'returning_trains' => [], 'data' => $search
        ]);
    }

    public function search(Request $request)
    {
        return $this->show_results($request);
    }

    public function payment(Request $request)
    {
        $departing_price = fake()->numberBetween(50, 300);
        $returning_price = fake()->numberBetween(50, 300);
        for ($i = 0; $i < $request->passengers; $i++) {
            $train_id = DB::table('trains')->where('model', '=', $request->departing_train_name)->first()->id;
            $seat_id = DB::table('seats')->where('train_id', '=', $train_id)->where('seat', '=', $request['departing_ticket' . $i + 1])->first()->id;
            $departing_destination = DB::table('destinations')->where('destination', '=', $request->departing_destination)->first()->id;
            $departing_destination_id = DB::table('train_destinations')->where('train_id', '=', $train_id)->where('destination_id', '=', $departing_destination)->first()->id;
            $arriving_destination = DB::table('destinations')->where('destination', '=', $request->arriving_destination)->first()->id;
            $arriving_destination_id = DB::table('train_destinations')->where('train_id', '=', $train_id)->where('destination_id', '=', $arriving_destination)->first()->id;
            $ticket_id = (string)((int)count(Tickets::all()) + 1);
            $ticket_id2 = (string)((int)count(Tickets::all()) + 2);
            // dd($ticket_id, $ticket_id2);
            for ($j = strlen($ticket_id); $j < 8; $j++) {
                $ticket_id = "0" . $ticket_id;
            }
            for ($j = strlen($ticket_id2); $j < 8; $j++) {
                $ticket_id2 = "0" . $ticket_id2;
            }
            Tickets::create([
                'seat_id' => $seat_id,
                'user_id' => Auth::user()->id,
                'date' => implode('-', array_reverse(explode('/', $request->date))),
                'departing_destination' => $departing_destination_id,
                'arriving_destination' => $arriving_destination_id,
                'price' => $departing_price,
                'qrCode' => $ticket_id,
                'isActive' => true,
                'hasInsurance' => false,
            ]);
            QrCode::size(500)->generate($ticket_id, public_path('ticket_qrcodes/'.$ticket_id.'.svg'));

            if ($request->oneway == null) {
                $train_id2 = DB::table('trains')->where('model', '=', $request->returning_train_name)->first()->id;
                $seat_id2 = DB::table('seats')->where('train_id', '=', $train_id2)->where('seat', '=', $request['returning_ticket' . $i + 1])->first()->id;
                Tickets::create([
                    'seat_id' => $seat_id2,
                    'user_id' => Auth::user()->id,
                    'date' => implode('-', array_reverse(explode('/', $request->date2))),
                    'departing_destination' => $arriving_destination_id,
                    'arriving_destination' => $departing_destination_id,
                    'price' => $returning_price,
                    'qrCode' => $ticket_id2,
                    'isActive' => true,
                    'hasInsurance' => false,
                ]);
                QrCode::size(500)->generate($ticket_id2, public_path('ticket_qrcodes/'.$ticket_id2.'.svg'));
            }
        }
        return redirect()->route("dashboard")->with('status', 'ticket-created');
    }
}
