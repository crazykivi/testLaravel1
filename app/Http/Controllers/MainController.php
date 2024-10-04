<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MainController extends Controller
{
    protected $cities = [];

    public function __construct()
    {
        $this->cities = $this->fetchCities();
    }

    public function index(Request $request)
    {
        $selectedCity = $request->session()->get('city');
        return view('index', ['cities' => $this->cities, 'selectedCity' => $selectedCity]);
    }

    public function city($city, Request $request)
    {
        // Проверка, есть ли выбаранный город в списке городов
        if (in_array($city, $this->cities)) {
            // сохранение города в сессию
            $request->session()->put('city', $city);

            // Редирект на главную страницу с выбранным городом
            return redirect()->route('index');
        }

        // Если город не найден, то ошибка 404
        return abort(404);
    }


    public function about(Request $request)
    {
        $selectedCity = $request->session()->get('city');
        // передача $cities для использования на странийц
        return view('about', ['cities' => $this->cities, 'selectedCity' => $selectedCity]);
    }

    public function news(Request $request)
    {
        $selectedCity = $request->session()->get('city');
        // передача $cities для использования на странице
        return view('news', ['cities' => $this->cities, 'selectedCity' => $selectedCity]);
    }

    private function fetchCities()
    {
        $client = new Client();
        $response = $client->get('https://api.hh.ru/areas');
        $data = json_decode($response->getBody(), true);

        $cities = [];

        foreach ($data as $country) {
            if ($country['name'] === 'Россия') {
                $this->extractCities($country['areas'], $cities);
                break;
            }
        }

        return $cities;
    }

    private function extractCities($areas, &$cities)
    {
        foreach ($areas as $area) {
            if (empty($area['areas'])) {
                $cities[] = strtolower($area['name']);
            } else {
                $this->extractCities($area['areas'], $cities);
            }
        }
    }

    public function selectCity($city)
    {
        // сохранение выбранного города в сессию
        session(['selected_city' => $city]);

        return redirect("/$city");
    }

    public function handle($request, \Closure $next)
    {
        if (!$request->is('*/') && session()->has('selected_city')) {
            $city = session('selected_city');
            return redirect("/$city");
        }

        return $next($request);
    }
}
