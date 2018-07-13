<?php
namespace Tests\Feature;

use App\Http\Controllers\ApiController;
use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use http\Env\Request;
use Illuminate\Support\Facades\Cache;
use Tests\CreatesApplication;
use Tests\TestCase;

/**
 * Class ApiTest
 *
 * @package Tests\Feature
 */
class ApiTest extends TestCase
{
    use CreatesApplication;

    /**
     * @var string Latitude
     */
    protected $lat;

    /**
     * @var string Longitude
     */
    protected $lon;

    /**
     * Init latitude and longitude values
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $faker = Factory::create();
        $this->lat = $faker->latitude();
        $this->lon = $faker->longitude();
    }

    /**
     * Test API get one date forecast
     *
     * @return void
     */
    public function testOneDateForecast()
    {

        $response = $this->get('/api/today?lat='.$this->lat.'&lon='.$this->lon);

        $this->assertNotEmpty($response);
        $responseData = json_decode($response->getContent());

        $this->assertObjectHasAttribute('temperatureMin', $responseData);
        $this->assertObjectHasAttribute('temperatureMin', $responseData);
    }


    /**
     * Test API get one date forecast
     *
     * @return void
     */
    public function testFutureForecast()
    {
        $response = $this->get('/api/future?lat='.$this->lat.'&lon='.$this->lon);

        $responseData = json_decode($response->getContent());
        $this->assertNotEmpty($responseData);
        $this->assertObjectHasAttribute('temperatureMin', $responseData[0]);
        $this->assertObjectHasAttribute('temperatureMin', $responseData[6]);
        $this->assertNotEmpty($responseData[0]->temperatureMin);
        $this->assertNotEmpty($responseData[6]->temperatureMin);
        $this->assertArrayHasKey(4,$responseData);
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

        $response1 = $this->get('/api/today?lat='.$this->lat.'&lon='.$this->lon);
        $response1->assertStatus(200);

    }

}
