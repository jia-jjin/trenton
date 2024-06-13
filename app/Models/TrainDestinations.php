<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainDestinations extends Model
{
    use HasFactory;

    protected $fillable = ['train_id', 'destination_id', 'arrival_time'];

    public $timestamps = false;
}
