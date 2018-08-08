<?php

namespace tests\models;

use src\models\Euromillions;
use PHPUnit\Framework\TestCase;
use Predis\Client;

class EuromillionsModelTest extends TestCase
{
    protected function setUp()
    {
        $this->mysqli = new \mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
        $this->mysqli->query('truncate euromillions_draws');

        $this->redis = new Client();
    }

    protected function tearDown()
    {
        $this->mysqli->query('truncate euromillions_draws');
        $this->mysqli->close();
    }

    public function testSaveDraw()
    {
        $model = new Euromillions();
        $model->draw_date= date("Y-m-d", mt_rand(1, time()));
        $model->result_regular_number_one=rand(0,9);
        $model->result_regular_number_two=rand(0,9);
        $model->result_regular_number_three=rand(0,9);
        $model->result_regular_number_four=rand(0,9);
        $model->result_regular_number_five=rand(0,9);
        $model->result_lucky_number_one=rand(0,9);
        $model->result_lucky_number_two=rand(0,9);
        $model->save();
        $this->assertEquals($this->getLastId(), $model->id);

        return $model->id;
    }

    /**
     * @depends testSaveDraw
     */
    public function testGetLastDraw($id)
    {
        $model = new Euromillions();
        $model->getLastDraw();
        $this->assertEquals($id, $model->id);
        $this->assertEquals($this->getLastIdCache(), $model->id);
    }

    private function getLastId()
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