<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;

class WeatherController extends Controller
{

    public function mainPage()
    {

        $this->generateWeatherData();
        $coldestDay = session('coldestDay');
        $weatherLastYear = session('weatherLastYear');
        $selected = session('selected');
        $success = session('success');


        return view('welcome',['coldestDay' => $coldestDay, 'lastYear' => $weatherLastYear, 'selectedWeather' => $selected,  'success' => $success ?? null]);
    }


    // Записать погоду в бд
    public function loadWeatherData(Request $request)
    {
        $validatedData = $request->validate([

            'date' => 'required|max:10',
            'temperature_night' => 'required|max:4',
            'temperature_day' => 'required|max:4',
            'humidity' => 'required|max:4',
            'pressure' => 'required|max:4',
            'speed' => 'required|max:4',
            'choice_direction' => 'required',
            'choice_weather' => 'required',
        ],
        [
            'date.required' => 'Поле :attribute обязательно.',
            'temperature_night.required' => 'Поле :attribute обязательно.',
            'temperature_day.required' => 'Поле :attribute обязательно.',
            'humidity.required' => 'Поле :attribute обязательно.',
            'pressure.required' => 'Поле :attribute обязательно.',
            'speed.required' => 'Поле :attribute обязательно.',
            'choice_direction.required' => 'Выбор :attribute обязательно.',
            'choice_weather.required' => 'Выбор :attribute обязательно.'
        ],
        [
            'date' => 'Дата',
            'temperature_night' => 'Температура ночью',
            'temperature_day' => 'Температура днем',
            'humidity' => 'Влажность',
            'pressure' => 'Атмосферное давление',
            'speed' => 'Скорость ветра',
            'choice_direction' => 'Направления ветра',
            'choice_weather' => 'Погоды',
        ]
        );

        $weather = new Weather;

        $weather->date = date('Y-m-d', strtotime($request->date));
        $weather->temperature_night = $request->temperature_night;
        $weather->temperature_day = $request->temperature_day;
        $weather->humidity = $request->humidity;
        $weather->pressure = $request->pressure;
        $weather->speed = $request->speed;
        $weather->choice_direction = $request->choice_direction;
        $weather->choice_weather = $request->choice_weather;
        $weather->ip = $request->getClientIp();

        $weather->save();
        session(['success' => true]);

        return redirect('/');

    }

    // Получить погоду из бд для виджета
    private function generateWeatherData()
    {
        $coldestDay = Weather::whereMonth('date', date('m'))
            ->whereDay('date', date('d'))
            ->orderBy('temperature_day', 'asc')
            ->first();

        $weatherLastYear = Weather::whereDay('date', date('d'))
                           ->whereMonth('date', date('m'))
                           ->whereYear('date', date('Y', strtotime('-1 year')))
                           ->first();

        session(['coldestDay' => $coldestDay]);
        session(['weatherLastYear' => $weatherLastYear]);

    }

    // Выгрузить погоду из бд
    function getWeatherData()
    {

    }

    function getSelectedWeather(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $selected = Weather::whereBetween('date', [$from, $to])
                    ->orderBy('date', 'asc')
                    ->get();
        session(['success' => false]);
        $coldestDay = $request->session()->get('coldestDay');
        $weatherLastYear = $request->session()->get('weatherLastYear');
        session(["selected" => $selected]);

        return redirect('/');
    }

}
