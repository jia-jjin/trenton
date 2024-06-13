<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\DB;
use App\Models\Tickets;
use App\Models\Seats;
use App\Models\TrainDestinations;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tickets>
 */
class TicketsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seat_id = fake()->unique()->numberBetween(1,count(Seats::all()));
        $train_id = Seats::where("id", $seat_id)->first()->train_id;
        $destinations_list = TrainDestinations::where("train_id", $train_id)->get("id");
        $departing_destination = fake()->randomElement($destinations_list)->id;
        $arriving_destination = fake()->randomElement($destinations_list)->id;
        $ticket_id = (string)(count(Tickets::all())+1);
        for ($i = strlen($ticket_id); $i < 8; $i++){
            $ticket_id = "0".$ticket_id;
        }
        while ($arriving_destination == $departing_destination) {
            $arriving_destination = fake()->randomElement($destinations_list)->id;
        }
        QrCode::size(500)->generate($ticket_id, public_path('ticket_qrcodes/'.$ticket_id.'.svg'));
        return [
            'seat_id' => $seat_id,
            'user_id' => 1,
            'date' => fake()->date(),
            'departing_destination' => $departing_destination,
            'arriving_destination' => $arriving_destination,
            'price' => fake()->numberBetween(50,300),
            'qrCode' => $ticket_id,
            'isActive' => rand(0,1) == 1,
            'hasInsurance' => rand(0,1) == 1,
        ];
    }
}
