<?php
namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/**
 * Class ApiTest
 *
 * With Mockery we are simulating dark sky api requests.
 *
 * @package Tests\Feature
 */
class ApiTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        /**
         * A fake api service to avoid doing request to the real API.
         * We are going to test our own functionality.
         */
        $this->app->singleton('DarkSkyConc', function($app)
        {
            // Create a mock and queue two responses.
            $mock = new MockHandler([
                new Response(200, ['Content-Type' => 'application/json'], json_encode([
                    'daily' => [
                        'data' => [
                            [
                                'time' => 1528772400,
                                'temperatureMin' => 10,
                                'temperatureHigh' => 24,
                                'summary' => 'Light rain until afternoon.',
                                'icon' => 'rain'
                            ],
                        ]
                    ]
                ])),
                new Response(200, ['Content-Type' => 'application/json'], json_encode([
                    'daily' => [
                        'data' => [
                            [
                                'time' => 1528772400,
                                'temperatureMin' => 10,
                                'temperatureHigh' => 24,
                                'summary' => 'Light rain until afternoon.',
                                'icon' => 'rain'
                            ],
                        ]
                    ]
                ])),
                new Response(200, ['Content-Type' => 'application/json'], json_encode([
                    'daily' => [
                        'data' => [
                            [
                                'time' => 1528772400,
                                'temperatureMin' => 10,
                                'temperatureHigh' => 24,
                                'summary' => 'Light rain until afternoon.',
                                'icon' => 'rain'
                            ],
                        ]
                    ]
                ])),
                new Response(200, ['Content-Type' => 'application/json'], json_encode([
                    'daily' => [
                        'data' => [
                            [
                                'time' => 1528772400,
                                'temperatureMin' => 10,
                                'temperatureHigh' => 24,
                                'summary' => 'Light rain until afternoon.',
                                'icon' => 'rain'
                            ],
                        ]
                    ]
                ])),
                new Response(200, ['Content-Type' => 'application/json'], json_encode([
                    'daily' => [
                        'data' => [
                            [
                                'time' => 1528772400,
                                'temperatureMin' => 10,
                                'temperatureHigh' => 24,
                                'summary' => 'Light rain until afternoon.',
                                'icon' => 'rain'
                            ],
                        ]
                    ]
                ])),
                new Response(200, ['Content-Type' => 'application/json'], json_encode([
                    'daily' => [
                        'data' => [
                            [
                                'time' => 1528772400,
                                'temperatureMin' => 10,
                                'temperatureHigh' => 24,
                                'summary' => 'Light rain until afternoon.',
                                'icon' => 'rain'
                            ],
                        ]
                    ]
                ])),
                new Response(200, ['Content-Type' => 'application/json'], json_encode([
                    'daily' => [
                        'data' => [
                            [
                                'time' => 1528772400,
                                'temperatureMin' => 11,
                                'temperatureHigh' => 24,
                                'summary' => 'Light rain until afternoon.',
                                'icon' => 'rain'
                            ],
                        ]
                    ]
                ]))
            ]);

            $handler = HandlerStack::create($mock);
            $client = new Client(['handler' => $handler]);

            return new \App\Http\Helpers\DarkSkyConcurrent($client);
        });

    }

    /**
     * Test API get one date forecast
     *
     * @return void
     */
    public function testOneDateForecast()
    {
        $response = $this->get('/api/today?lat=-34.60368440000001&lon=-58.381559100000004');

        $this->assertEquals(json_decode($response->getContent())->time, 1528772400);
        $this->assertEquals(json_decode($response->getContent())->temperatureMin, 10);
    }


    /**
     * Test API get one date forecast
     *
     * @return void
     */
    public function testFutureForecast()
    {
        $response = $this->get('/api/future?lat=-34.60368440000001&lon=-58.381559100000004');

        $responseData = json_decode($response->getContent());
        $this->assertNotEmpty($responseData);
        $this->assertEquals($responseData[0]->temperatureMin, 10);
        $this->assertEquals($responseData[6]->temperatureMin, 11);
    }



    /**
     * Check middleware responses. Validate lat and lon param
     *
     * @return void
     */
    public function testMiddleware()
    {

        $response1 = $this->get('/api/today');
        $response1->assertStatus(400);

        $response2 = $this->get('/api/history');
        $response2->assertStatus(400);

        $response3 = $this->get('/api/future');
        $response3->assertStatus(400);

        $response4 = $this->get('/api/today?lat=-34.60368440000001&lon=-58.381559100000004');
        $response4->assertStatus(200);

    }

}
