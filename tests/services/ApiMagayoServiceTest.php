<?php

namespace tests\services;

use Spatie\Snapshots\MatchesSnapshots;
use src\services\ApiMagayoService;
use PHPUnit\Framework\TestCase;

class ApiMagayoServiceTest extends TestCase
{
    use MatchesSnapshots;

    private $apiObject;

    protected function setUp()
    {

        $this->apiObject = new ApiMagayoService('euromillions');
    }

    protected function tearDown()
    {
        $this->apiObject = null;
    }

    public function testSetDrawResponse()
    {
        $apiObject=new ApiMagayoService('euromillions', true);
        $expected=['status' => 200, 'drawDate' => '2018-08-05', 'results' => [1,2,3,4,5,6,7]];
        $result=$apiObject->fetch();
        $this->assertEquals($expected, $result);
    }

    public function testConnectionToApi()
    {
        $response= $this->apiObject->getRequest();
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Este metodo obtiene el request de la API y lo compara con una copia presente en __snapshots__ si se desea cambiar la copia de snapshots
     * solamente hay que cargar una nueva prueba asi -> ./vendor/bin/phpunit -d --update-snapshots  y automaticamente se genera una copia de snapshot
     * del request recibido.
     */
    public function testGetRequest()
    {
        $response= $this->apiObject->getRequest();
        $request=$response->getBody()->getContents();
        $this->assertMatchesJsonSnapshot($request);
        echo('
        El request recibido:
        '.$request);
    }
}