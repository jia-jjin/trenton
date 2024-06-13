<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinations;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function destinations_list(){
        $destinations = Destinations::all();
        return view("welcome", ['destinations' => $destinations]);
    }
}
