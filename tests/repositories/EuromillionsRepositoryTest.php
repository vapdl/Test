<?php

namespace tests\repositories;

use src\repositories\EuromillionsRepository;
use PHPUnit\Framework\TestCase;

class EuromillionsRepositoryTest extends TestCase
{
    private $euromillionsObject;

    protected function setUp()
    {
        $this->mysqli = new \mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
        $this->mysqli->query('truncate euromillions_draws');
        $this->euromillionsObject = new EuromillionsRepository(true);
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
        $this->assertEquals($this->getLastId(), $actual->id);
        return $actual->id;
    }

    /**
     * @depends testSaveDraw
     */
    public function testGetLastDraw($id)
    {
        $actual=$this->euromillionsObject->getLastDraw();
        $this->assertEquals($id, $actual->id);
    }


    private function getLastId()
    {
        $result=$this->mysqli->query('select id from euromillions_draws order by id Desc LIMIT 1');
        $aux= $result->fetch_assoc();
        return $aux['id'];
    }
}