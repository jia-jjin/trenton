<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    use HasFactory;

    protected $fillable = ['train_id', 'coach', 'seat'];

    public $timestamps = false;

    public function train()
    {
        return $this->belongsTo(Train::class,'train_id');
    }
}
