<?php
/**
 * This helper extends the DarkSky lib to include concurrent requests
 * and use 1 connection to do multiple request for history or future.
 *
 * User: Matias Gonzalez
 * Date: 7/11/18
 * Time: 6:58 p.m.
 */

namespace App\Http\Helpers;

use GuzzleHttp\Promise\EachPromise;
use Naughtonium\LaravelDarkSky\DarkSky;
use Response;

class DarkSkyConcurrent extends DarkSky
{
    // GuzzleHttp Client
    protected $client;

    public function __construct($client)
    {
        parent::__construct();

        $this->client = $client;
    }

    /**
     * We overwrite this method to use dependency injection
     * of the client. For testing we can use a mock HTTP client.
     *
     * @return mixed
     */
    public function get()
    {
        $url = $this->endpoint  . '/' . $this->lat . ',' . $this->lon;

        if ($this->timestamp) {
            $url .= ',' . $this->timestamp;
        }

        return json_decode($this->client->get($url, [
            'query' => $this->params,
        ])->getBody());
    }

    /**
     * Will fetch history forecast from current date to $days back in the past.
     *
     * @param array $dates
     *
     * @return mixed
     */
    public function days(Array $dates) {
        $url = $this->endpoint  . '/' . $this->lat . ',' . $this->lon;

        $forecastDates = [];
        $client = $this->client;

        $promises = (function () use ($client, $dates, $url) {
            foreach ($dates as $date) {
                $uri = $url.','.$date . '?exclude=currently,hourly,flags,offset';

                yield $client->requestAsync('GET', $uri);
            }
        })();

        $each = new EachPromise($promises, [
            'concurrency' => 4,
            'fulfilled' => function ($forecast) use (&$forecastDates) {
                $forecastDates[] = json_decode($forecast->getBody())->daily->data[0];
            }
        ]);

        $each->promise()->wait();

        return $forecastDates;
    }
}