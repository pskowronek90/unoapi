<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class SortController extends BaseController
{
    public function sortClicks(Request $request)
    {
        $allSortedData = [];
        $data = $request->all();

        foreach ($data as $array) {
            $clicks = array_filter($array, function($value) {
                return(strpos($value, 'Clicks_') !== false);
            }, ARRAY_FILTER_USE_KEY);
            
            arsort($clicks);

            $index = 1;
            foreach ($clicks as $key => $value) {
                $country = str_replace('Clicks_', '', $key);
                $clicks["Segment_Nr_{$index}"] = $value == 0 ? 'None' : "{$value} ({$country})";

                $index++;
            }

            $clicks = array_filter($clicks, function($value) {
                return(strpos($value, 'Segment_Nr_') !== false);
            }, ARRAY_FILTER_USE_KEY);

            ksort($clicks);

            $clicks["SubscriberKey"] = $array["SubscriberKey"];
            $allSortedData[] = $clicks;
        }

        return response()->json($allSortedData, 200);
    }
}