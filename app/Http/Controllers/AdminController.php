<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Models\Destination;
use App\Models\Train;
use App\Models\TrainDestinations;
use App\Models\User;
use App\Models\Tickets;
use App\Models\Seats;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\Attributes\Ticket;

class AdminController extends Controller
{

    public function adminOnly()
    {
        if (request()->user()->role_id !== 3) {
            abort(403);
        }
    }
    public function index()
    {
        $this->adminOnly();
        $destinations = Destination::all();
        $trains = Train::all();
        $users = User::where('role_id', '=', 1)->get();
        $train_destinations = [];
        foreach ($trains as $key => $train) {
            $current_train_destinations = DB::table('train_destinations')->where('train_id', '=', $train->id)->get();
            foreach ($current_train_destinations as $i => $current_train_destination) {
                $current_train_destinations[$i]->id = $i + 1;
            }
            $train_destinations[$train->id - 1] = $current_train_destinations;
            // if ($key ==  $train->id-1) {
            // } else {
            //     array_push($train_destinations, ["s"]);
            // }
        }
        if (!empty($users)) {
            foreach ($users as $key => $user) {
                $query = "SELECT tickets.id, seats.id as seat_id, seats.coach, seats.seat, trains.model, trains.type, tickets.user_id, tickets.date, 
                        departing.arrival_time as departing_time, 
                        arriving.arrival_time as arriving_time, 
                        departing_destination.destination as departing_destination, 
                        arriving_destination.destination as arriving_destination, tickets.price, 
                        tickets.isActive, tickets.hasInsurance 
                        FROM tickets 
                        JOIN train_destinations as departing ON tickets.departing_destination = departing.id
                        JOIN train_destinations as arriving ON tickets.arriving_destination = arriving.id
                        JOIN destinations as departing_destination ON departing.destination_id = departing_destination.id
                        JOIN destinations as arriving_destination ON arriving.destination_id = arriving_destination.id 
                        JOIN seats ON tickets.seat_id = seats.id
                        JOIN trains ON seats.train_id = trains.id 
                        WHERE tickets.user_id = $user->id";
                $user_tickets = DB::select($query);
                $users[$key]->tickets = $user_tickets;
            }
        }

        return view("admin.index", [
            'destinations' => $destinations,
            'trains' => $trains, 'train_destinations' => $train_destinations,
            'users' => $users
        ]);
    }

    public function create_destination(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            "destination_name" => ['required', Rule::unique('destinations', 'destination')],
        ]);

        Destination::create(['destination' => $request->destination_name]);
        return redirect()->route('admin')->with('status', 'destination-created');
    }

    public function edit_destination(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            "destination_name" => ['required', Rule::unique('destinations', 'destination')],
        ]);

        $destination = Destination::find($request->id);
        $destination->destination = $request->destination_name;
        $destination->save();
        return redirect()->route('admin')->with('status', 'destination-updated');
    }

    public function edit_train_destinations(Request $request)
    {
        $this->adminOnly();

        DB::table('train_destinations')->where('train_id', '=', $request->train_id)->delete();
        if (!empty($request->result)) {
            for ($i = 0; $i < count($request->result); $i++) {
                $destination_id = Destination::where('destination', '=', $request->result[$i])->first()->id;
                TrainDestinations::create([
                    'train_id' => $request->train_id,
                    'destination_id' => $destination_id,
                    'arrival_time' => $request->result2[$i],
                ]);
            }
        } else {
            TrainDestinations::where('train_id', $request->train_id)->delete();
        }

        return redirect()->route('admin')->with('status', 'train-destinations-updated');
    }

    public function delete_destination(Request $request)
    {
        $this->adminOnly();
        Destination::destroy($request->id);
        return redirect()->route('admin')->with('status', 'destination-deleted');
    }

    public function create_train(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            "train_name" => ['required', Rule::unique('trains', 'model')],
        ]);

        Train::create([
            'model' => $request->train_name,
            'type' => 'Platinum'
        ]);

        $currentTrainId = Train::where('model', $request->train_name)->pluck('id')->first();
        $coaches = ["A",];
        $seat_rows = ["1", "2", "3", "4", "5", "6", '7', '8', '9', '10', '11', '12'];
        $seat_columns = ['A', 'B', 'C', 'D'];

        foreach ($coaches as $coach) {
            foreach ($seat_rows as $seat_row) {
                foreach ($seat_columns as $seat_column) {
                    Seats::create([
                        'isTaken' => false,
                        'train_id' => $currentTrainId, 'coach' => $coach,
                        'seat' => $seat_row . $seat_column,
                    ]);
                }
            }
        }
        return redirect()->route('admin')->with('status', 'train-created');
    }

    public function edit_train(Request $request)
    {
        $this->adminOnly();
        $request->validate([
            "train_name" => ['required', Rule::unique('trains', 'model')],
        ]);

        $train = Train::find($request->id);
        $train->model = $request->train_name;
        $train->save();
        return redirect()->route('admin')->with('status', 'train-updated');
    }

    public function delete_train(Request $request)
    {
        $this->adminOnly();
        Train::destroy($request->id);
        return redirect()->route('admin')->with('status', 'train-deleted');
    }

    public function delete_user(Request $request)
    {
        $this->adminOnly();
        Tickets::where('user_id', $request->id)->delete();
        User::destroy($request->id);
        return redirect()->route('admin')->with('status', 'user-deleted');
    }
}
