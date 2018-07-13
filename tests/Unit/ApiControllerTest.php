<?php
/**
 * Test the controller class
 *
 * User: matias
 * Date: 7/13/18
 * Time: 12:17 p.m.
 */

namespace Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Faker\Factory;
use App\Http\Controllers\ApiController;
use App\Http\Helpers\DarkSkyConcurrent;

class ApiControllerTest extends TestCase
{
    /**
     * @var Controller to test
     */
    protected $apiController;

    /**
     * @var string Latitude
     */
    protected $lat;

    /**
     * @var string Longitude
     */
    protected $lon;

    public function setUp()
    {
        parent::setUp();

        $faker = Factory::create();
        $this->lat = $faker->latitude();
        $this->lon = $faker->longitude();

        $responses = [];
        for($i=0;$i<30;$i++) {

            $responses[] = new Response(200, ['Content-Type' => 'application/json'], json_encode([
                'daily' => [
                    'data' => [
                        [
                            'time' => $faker->unixTime(),
                            'temperatureMin' => $faker->numberBetween(1,15),
                            'temperatureHigh' => $faker->numberBetween(15,24),
                            'summary' => $faker->sentence(),
                            'icon' => 'rain'
                        ]
                    ]
                ]
            ]));
        }

        // Create a mock and queue two responses.
        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->apiController = new ApiController(new DarkSkyConcurrent($client));


    }

    /**
     * Test today forecast cache usage
     */
    public function testCacheToday()
    {
        $request = new Request();
        $request->replace(['lat' => $this->lat, 'lon' => $this->lon]);

        Cache::shouldReceive('remember')->once();

        $this->apiController->forecastToday($request);
    }

    /**
     * Test future cache forecast
     */
    public function testCacheFuture()
    {
        $request = new Request();
        $request->replace(['lat' => $this->lat, 'lon' => $this->lon]);

        Cache::shouldReceive('has')->times(7);
        Cache::shouldReceive('put')->times(7);

        $this->apiController->forecastFuture($request);
    }

    /**
     * Test history cache forecast
     */
    public function _testCacheHistory()
    {
        $request = new Request();
        $request->replace(['lat' => $this->lat, 'lon' => $this->lon]);

        Cache::shouldReceive('has')->times(30);
        Cache::shouldReceive('put')->times(30);

        $this->apiController->forecastFuture($request);
    }
}
