<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Tickets;
use App\Models\Destination;
use App\Models\Train;
use App\Models\Seats;
use App\Models\TrainDestinations;
use App\Models\Destinations;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create(['role' => 'user']);
        Role::create(['role' => 'staff']);
        Role::create(['role' => 'admin']);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('12345678'),
            'phone_no' => '0123456789',
            'role_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'blabla',
            'email' => 'bbbbb@gmail.com',
            'password' => bcrypt('12345678'),
            'phone_no' => '23123131231',
            'role_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'shesh',
            'email' => 'sheshgamer123@gmail.com',
            'password' => bcrypt('12345678'),
            'phone_no' => '01244',
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Jia Jin',
            'email' => 'lewjjn@gmail.com',
            'password' => bcrypt('12345678'),
            'phone_no' => '0176717767',
            'role_id' => 3,
        ]);

        $butterworth_KLSentral_destinations = [
            "Butterworth",
            "Bukit Mertajam",
            "Parit Buntar",
            "Taiping",
            "Kuala Kangsar",
            "Ipoh",
            "Batu Gajah",
            "Kampar",
            "Tanjung Malim",
            "Sungai Buloh",
            "Kuala Lumpur",
            "KL Sentral",
        ];

        $KLSentral_butterworth_destinations = array_reverse($butterworth_KLSentral_destinations);

        $butterworth_KLSentral_arrival_time = [
            "16:05",
            "16:15",
            '16:32',
            '17:01',
            '17:17',
            '17:45',
            '18:00',
            '18:13',
            '18:57',
            '19:49',
            '20:14',
            '20:20',
        ];

        $KLSentral_butterworth_arrival_time = [
            '15:55',
            '15:59',
            '16:23',
            '17:13',
            '17:57',
            '18:10',
            '18:24',
            '18:53',
            '19:09',
            '19:38',
            '19:55',
            '20:07',
        ];



        foreach ($butterworth_KLSentral_destinations as $destination) {
            Destination::create(['destination' => $destination]);
        }

        Destination::factory(100)->create();

        Train::create([
            'model' => "EP9177",
            'type' => "Platinum"
        ]);

        Train::create([
            'model' => "EP9178",
            'type' => "Platinum"
        ]);

        Train::create([
            'model' => "PT888",
            'type' => "Platinum"
        ]);

        Train::create([
            'model' => "PT694",
            'type' => "Platinum"
        ]);

        foreach ($butterworth_KLSentral_destinations as $key => $destination) {
            TrainDestinations::create([
                'train_id' => 1,
                "destination_id" => Destination::where("destination", "=", $destination)->pluck("id")->first(),
                "arrival_time" => $butterworth_KLSentral_arrival_time[$key],
            ]);
        }

        foreach ($KLSentral_butterworth_destinations as $key => $destination) {
            TrainDestinations::create([
                'train_id' => 2,
                "destination_id" => Destination::where("destination", "=", $destination)->pluck("id")->first(),
                "arrival_time" => $KLSentral_butterworth_arrival_time[$key],
            ]);
        }

        TrainDestinations::factory(20)->create();

        $trains = [1, 2];
        $coaches = ["A",];
        $seat_rows = ["1", "2", "3", "4", "5", "6", '7', '8', '9', '10', '11', '12'];
        $seat_columns = ['A', 'B', 'C', 'D'];

        foreach ($trains as $train) {
            foreach ($coaches as $coach) {
                foreach ($seat_rows as $seat_row) {
                    foreach ($seat_columns as $seat_column) {
                        Seats::create([
                            'isTaken' => false,
                            'train_id' => $train, 'coach' => $coach,
                            'seat' => $seat_row . $seat_column,
                        ]);
                    }
                }
            }
        }

        for ($i = 0; $i < 20; $i++){
            Tickets::factory(1)->create();
        }
        // Tickets::factory(10)->create([
        //     'date' => '2024-06-20',
        //     'isActive' => true
        // ]);
        // Tickets::factory(20)->create();
    }
}
