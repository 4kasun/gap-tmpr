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

    /**
     * This method use for get weekly data from csv file
     *
     *
     * @return json
     */
    public function getWeekChartData()
    {
        // read csv file direcly
        // If we can use database we can upload those data and retrive data via any service layer ( just like design pattern)
        $file = fopen(storage_path() . '/export.csv', "r");
        $data = array();

        // push csv data to array
        while (!feof($file)) {
            $data[] = fgetcsv($file, null, ';');
        }

        fclose($file);
        // remove 1st element from arraya. because of csv titles

        array_shift($data);
        // added data set to collection for manipulations
        $collection = collect($data);

        /**
         * collection column map
         * [
         *     0 => user_id,
         *     1 => created_at,
         *     2 =>	onboarding_perentage,
         *     3 =>	count_applications,	count_accepted_applications
         * ]
         *  */

         // group by created date
        // $grouped = $collection->groupBy('1');

        // grpup by week
        $grouped = $collection->groupBy(function ($date) {
            return Carbon::parse($date[1])->format('W');
        });

        $i = 0;
        // preparing chart data object by filterd collection
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
