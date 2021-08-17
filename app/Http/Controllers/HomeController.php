<?php

namespace App\Http\Controllers;

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

    public function getWeekChartData() {
        $file = fopen(storage_path() . '/export.csv', "r");
        $data = array();

        while (!feof($file)) {
            $data[] = fgetcsv($file, null, ';');
        }

        fclose($file);
        array_shift($data);
        $collection = collect($data);

        $grouped = $collection->groupBy('1');

        $i=0;
        foreach ($grouped->toArray() as $date => $values) {
            $categories[] = $date;
            $series[$i]['name'] = $date;
            $series[$i]['data'] = array_column($values, '2');
            if($i>2) continue;
            $i++;
        }

        return response()->json([
            'data' => [$series, $categories],
            'status'  => 'success',
            'message' => 'Payment method not updated',
        ], 200);

        // dd($series);

        // dd($data);
    }
}
