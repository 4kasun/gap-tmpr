<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getWeekChartData()
    {
        $file = fopen(storage_path() . '/export.csv', "r");
        $data = array();

        while (!feof($file)) {
            $data[] = fgetcsv($file, null, ';');
        }

        fclose($file);
        array_shift($data);
        $collection = collect($data);

        $grouped = $collection->groupBy('1');

        $grouped = $collection->groupBy(function ($date) {
            return Carbon::parse($date[1])->format('W'); // grouping by months
        });

        // $grouped = $collection->groupBy('1');

        // print_r($grouped->toArray());die;

        $i = 0;

        foreach ($grouped->toArray() as $date => $values) {
            $categories[] = (string) $date;
            $series[$i]['name'] = (string) $date;
            $value = array_map(
                function ($values) {
                    return (int) $values[2];
                }, $values);
            rsort($value);
            $series[$i]['data'] = array_values(array_unique($value));

            $i++;
        }

        return response()->json([
            'data' => [$series, $categories],
            'status' => 'success',
            'message' => 'Payment method not updated',
        ], 200);
    }
}
