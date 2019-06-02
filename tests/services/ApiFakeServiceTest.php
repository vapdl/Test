<?php

namespace tests\services;

use Spatie\Snapshots\MatchesSnapshots;
use src\services\ApiFakeService;
use PHPUnit\Framework\TestCase;

class ApiFakeServiceTest extends TestCase
{
    use MatchesSnapshots;

    private $apiObject;

    protected function setUp()
    {

        $this->apiObject = new ApiFakeService();
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
        $expected=['status' => 200, 'drawDate' => '2018-08-07', 'results' => [16,28,29,30,36,8,10]];
        $result=$this->apiObject->fetch();
        $this->assertEquals($expected, $result);
    }
}