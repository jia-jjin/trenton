<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class DashboardController extends Controller
{
    public function defaultQuery()
    {
        $id = Auth::id();

        return "SELECT tickets.id, seats.id as seat_id, seats.coach, seats.seat, trains.model, trains.type, tickets.user_id, tickets.date, 
        departing.arrival_time as departing_time, 
        arriving.arrival_time as arriving_time, 
        departing_destination.destination as departing_destination, 
        arriving_destination.destination as arriving_destination, tickets.price, 
        tickets.qrCode, tickets.isActive, tickets.hasInsurance 
        FROM tickets 
        JOIN train_destinations as departing ON tickets.departing_destination = departing.id
        JOIN train_destinations as arriving ON tickets.arriving_destination = arriving.id
        JOIN destinations as departing_destination ON departing.destination_id = departing_destination.id
        JOIN destinations as arriving_destination ON arriving.destination_id = arriving_destination.id 
        JOIN seats ON tickets.seat_id = seats.id
        JOIN trains ON seats.train_id = trains.id 
        WHERE tickets.user_id = $id";
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = ["show" => "upcoming", "sort" => "latest"];
        $today = Date::today()->format("Y-m-d");
        $outdated_tickets = Tickets::where("date","<", $today)->pluck('id');
        if(!empty($outdated_tickets)){
            for ($i = 0; $i < count($outdated_tickets); $i++) {
                $ticket = Tickets::find($outdated_tickets[$i]);
                $ticket->isActive = false;
                $ticket->save();
            }
        }

        // $dead = Tickets::with('seat.train')->get();
        // dd($dead[0]['seat']);
        // for ($i = 0; $i < count($tickets); $i++) {
        //     $tickets[$i] = (array)$tickets[$i];
        // }
        // dd($tickets);
        return $this->runQuery($filter);
    }

    public function sort(Request $request)
    {

        $show = $request['show'];
        $sort = $request['sort'];
        $filter = ["show" => $show, "sort" => $sort];

        return $this->runQuery($filter);
    }

    public function runQuery($filter)
    {
        $query = $this->defaultQuery();
        $show = $filter['show'];
        $sort = $filter['sort'];
        if ($show == "upcoming") {
            $query .= " AND isActive = true";
        } else if ($show == "past") {
            $query .= " AND isActive = false";
        }
        if ($sort == "highest_price") {
            $query .= " ORDER BY price DESC";
        } else if ($sort == "lowest_price") {
            $query .= " ORDER BY price ASC";
        } else if ($sort == "latest") {
            $query .= " ORDER BY CONCAT(date, ' ', departing_time) DESC";
        } else if ($sort == "earliest") {
            $query .= " ORDER BY CONCAT(date, ' ', departing_time) ASC";
        }
        $querySelect = DB::select($query);

        for ($i = 0; $i < count($querySelect); $i++) {
            $querySelect[$i] = (array)$querySelect[$i];
        }
        // dd($tickets);
        return view('dashboard', ['tickets' => $querySelect, 'filter' => $filter]);
    }
}
