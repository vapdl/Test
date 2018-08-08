<?php

namespace tests\repositories;

use src\repositories\EuromillionsRepository;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class EuromillionsRepositoryTest extends TestCase
{
    private $euromillionsObject;

    protected function setUp()
    {
        $this->mysqli = new \mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
        $this->mysqli->query('truncate euromillions_draws');
        $this->euromillionsObject = new EuromillionsRepository(true);

        $this->redis = new Client();
    }

    protected function tearDown()
    {
        $this->euromillionsObject = null;
        $this->mysqli->query('truncate euromillions_draws');
        $this->mysqli->close();
    }

    public function testGetLastDrawResultFromAPI()
    {
        $expected=['status' => 200, 'drawDate' => '2018-08-05', 'results' => [1,2,3,4,5,6,7]];
        $draw=$this->euromillionsObject->getLastDrawResultFromAPI();
        $this->assertEquals($expected, $draw);
        return $draw;
    }

    /**
     * @depends testGetLastDrawResultFromAPI
     */
    public function testSaveDraw($draw)
    {
        $actual=$this->euromillionsObject->saveDraw($draw);
        $this->assertEquals($this->getLastIdDataBase(), $actual->id);
        return $actual->id;
    }

    /**
     * @depends testSaveDraw
     */
    public function testGetLastDraw($id)
    {
        $actual=$this->euromillionsObject->getLastDraw();
        $this->assertEquals($id, $actual->id);
        $this->assertEquals($this->getLastIdCache(), $actual->id);
    }


    private function getLastIdDataBase()
    {
        $result=$this->mysqli->query('select id from euromillions_draws order by id Desc LIMIT 1');
        $aux= $result->fetch_assoc();
        return $aux['id'];
    }

    private function getLastIdCache()
    {
        $aux=$this->redis->get('lastDraw');
        $aux=(array)json_decode($aux);
        return $aux['id'];
    }
}