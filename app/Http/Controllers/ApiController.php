<?php
/**
 * API Controller for Single Page Application (Forecast)
 *
 * User: Matias Gonzalez
 * Date: 7/10/18
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class ApiController extends Controller
{

    /**
     * @var string Latitude
     */
    protected $lat;

    /**
     * @var string Longitude
     */
    protected $lon;


    /**
     * This generates the cache key for a latitude+longitude+date
     *
     * @param Request $request Will take lat and lon from request
     * @param $key  The date of the data we want to save/get
     *
     * @return string
     */
    protected function _getKey( Request $request, $key) {
        $this->lat = $request->get('lat');
        $this->lon = $request->get('lon');

        // set up cache key
        $cKey = "{$this->lat}_{$this->lon}_{$key}";

        return $cKey;
    }

    /**
     * Get today's forecast. Needs the latitude and longitude.
     * It will try to fetch from cache the last value saved of the current day.
     * If the value expired (or does not exists), it will request the forecast data
     * to the API and store it locally. It will use the date as a key and not the
     * time because the cache has a short time expiration.
     *
     * @param Request $request
     *
     * @return string Json with 1 forecast
     */
    public function forecastToday(Request $request) {
        $cKey = $this->_getKey($request, date('Y-m-d'));

        $value = Cache::remember($cKey, env("DARKSKY_CACHE_MINUTES"), function () use ($cKey) {
            $dsc = App::make('DarkSkyConc'); //service

            return $dsc->location($this->lat, $this->lon)->atTime(time())->daily()[0];
        });

        return Response::json($value, 200);
    }


    /**
     * Get history forecast. Needs the latitude and longitude.
     * It will try to fetch from cache the last 30 days.
     * If empty, it will request the forecast data to the API
     * and store it locally.
     * For history cache, we will keep it more time because past forecast
     * does not change.
     *
     * @param Request $request
     *
     * @return string Json with an array forecast (history of 30 days)
     */
    public function forecastHistory(Request $request) {

        $dates = [];
        $values = [];
        for ($i=30;$i>0;$i--) { // 30 days
            $day = strtotime("-{$i} day", time());
            $cKey = $this->_getKey($request, date('Y-m-d', $day));

            if (Cache::has($cKey)) {
                $values[] = Cache::get($cKey);
            } else {
                $dates[] = $day;
            }
        }

        if (count($dates) > 0) {
            $dsc = App::make('DarkSkyConc'); //service

            $missingValues = $dsc->location($this->lat, $this->lon)->days($dates);
            foreach ($missingValues as $missingVal) {
                $cKey = $this->_getKey($request, date('Y-m-d', $missingVal->time));
                Cache::put($cKey, $missingVal, env("DARKSKY_CACHE_HISTORY_MINUTES"));
            }
            $values = array_merge($missingValues, $values);
        }

        return Response::json($values, 200);
    }


    /**
     * Get future forecast. Needs the latitude and longitude.
     * It will try to fetch from cache the next week.
     * If empty, it will request the forecast data to the API
     * and store it locally. It will use the date as a key and not the
     * time because the cache has a short time expiration.
     *
     * @param Request $request
     *
     * @return string Json with an array forecast (history of 30 days)
     */
    public function forecastFuture(Request $request) {

        $dates = [];
        $values = [];
        for ($i=1;$i<8;$i++) { //1 week
            $day = strtotime("+{$i} day", time());
            $cKey = $this->_getKey($request, date('Y-m-d', $day));

            if (Cache::has($cKey)) {
                $values[] = Cache::get($cKey);
            } else {
                $dates[] = $day;
            }
        }

        // we fetch missing dates from cache
        if (count($dates) > 0) {
            $dsc = App::make('DarkSkyConc'); //service

            $missingValues = $dsc->location($this->lat, $this->lon)->days($dates);
            foreach ($missingValues as $missingVal) {
                $cKey = $this->_getKey($request, date('Y-m-d', $missingVal->time));
                Cache::put($cKey, $missingVal, env("DARKSKY_CACHE_MINUTES"));
            }
            $values = array_merge($missingValues, $values);
        }

        return Response::json($values, 200);
    }

}