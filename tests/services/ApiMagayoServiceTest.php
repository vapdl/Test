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

     public function testConnectionToApi()
     {
         $response= $this->apiObject->getRequest();
         $this->assertEquals(200, $response->getStatusCode());
     }

     public function testGetRequest()
     {
         $response= $this->apiObject->getRequest();
         $this->assertMatchesJsonSnapshot($response->getBody()->getContents());
     }

     public function testSetDrawResponse()
     {
         $apiObject=new ApiMagayoService('euromillions', true);
         $expected=['status' => 200, 'drawDate' => '2018-08-05', 'results' => [1,2,3,4,5,6,7]];
         $result=$apiObject->fetch();
         $this->assertEquals($expected, $result);
     }
}