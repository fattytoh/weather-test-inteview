<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiServiceController extends Controller
{
    private $api_key = 'ea13844b0161088e0514674ad643357c';
    //
    public function getWeather(Request $request){
        $rules = [
            'city'    => 'required',
        ];
        $this->validate($request, $rules);
        try {
            $response = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q='.$request['city']."&appid=".$this->api_key);
            $res = json_decode($response, true);
            if(isset($res['weather'][0]['main']) && $res['weather'][0]['main']){
                $image = '';
                switch($res['weather'][0]['main']){
                    case 'Clouds':
                        $image = 'clouds.jpg';
                        break;
                    case 'Drizzle':
                        $image = 'drizzle.jpg';
                        break;
                    case 'Thunderstorm':
                        $image = 'thunderstorm.jpg';
                        break;
                    case 'Rain':
                        $image = 'rain.jpg';
                        break;
                    case 'Snow':
                        $image = 'snow.jpg';
                        break;
                    default:
                        $image = 'sunny.jpg';
                        break;  
                }
                $data = [
                    'status' => 'success',
                    'weather' => $res['weather'][0]['main'],
                    'city' => $res['name'],
                    'temp' => round(($res['main']['temp'] -273.15), 2),
                    'img' => $image,
                ];
                return $data;
            }
            else{
                return ['error' => 'Api Wrong'];
            }
        }
        catch (\Exception $e) {
            return ['error' => 'City not found'];
        }
    }
}
