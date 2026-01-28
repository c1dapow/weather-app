<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{

    protected $table = 'weather';
    protected $fillable = ['date', 'temperature_night', 'temperature_day', 'humidity', 'pressure', 'speed', 'choice_direction', 'choice_weather'];

}
