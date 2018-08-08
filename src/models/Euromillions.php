<?php

namespace src\models;

use src\exceptions\DataBaseException;
use Predis\Client;
use src\interfaces\ICache;

define('DBADDRESS', '127.0.0.1');
define('DBUSER', 'root');
define('DBPASSWORD', 'mypassword');
define('DBSCHEMA', 'euromillions');
class Euromillions implements ICache
{
    public $id;
    public $draw_date;
    public $result_regular_number_one;
    public $result_regular_number_two;
    public $result_regular_number_three;
    public $result_regular_number_four;
    public $result_regular_number_five;
    public $result_lucky_number_one;
    public $result_lucky_number_two;

    private function openConnection()
    {
        $this->mysqli = new \mysqli(DBADDRESS, DBUSER, DBPASSWORD, DBSCHEMA);
        if (mysqli_connect_errno()) {
            $this->throwException(mysqli_connect_error());
        }
        $this->redis = new Client();
    }

    private function closeConnection()
    {
        $this->mysqli->close();
    }

    public function save()
    {
        $this->openConnection();
        $sql='insert into euromillions_draws (draw_date, result_regular_number_one, result_regular_number_two, result_regular_number_three, result_regular_number_four, result_regular_number_five, result_lucky_number_one, result_lucky_number_two) values("'.$this->draw_date.'", '.$this->result_regular_number_one.', '.$this->result_regular_number_two.', '.$this->result_regular_number_three.', '.$this->result_regular_number_four.', '.$this->result_regular_number_five.', '.$this->result_lucky_number_one.', '.$this->result_lucky_number_two.')';
        $this->mysqli->query($sql);
        $this->id=$this->mysqli->insert_id;
        $this->closeConnection();

        $this->put(json_encode(['id' => $this->id, 'draw_date' => $this->draw_date, 'result_regular_number_one' => $this->result_regular_number_one, 'result_regular_number_two' => $this->result_regular_number_two, 'result_regular_number_three' => $this->result_regular_number_three, 'result_regular_number_four' => $this->result_regular_number_four, 'result_regular_number_five' => $this->result_regular_number_five, 'result_lucky_number_one' => $this->result_lucky_number_one, 'result_lucky_number_two' => $this->result_lucky_number_two]));
    }

    public function getLastDraw()
    {
        $band=true;

        $this->openConnection();

        $aux = $this->get('lastDraw');

        if(is_null($aux))
        {
            $result=$this->mysqli->query('select * from euromillions_draws order by id Desc LIMIT 1');
            $aux= $result->fetch_assoc();
            if(is_null($aux))
            {
                $band=false;
            }
        }
        if($band)
        {
            $this->id=$aux['id'];
            $this->draw_date=$aux['draw_date'];
            $this->result_regular_number_one=$aux['result_regular_number_one'];
            $this->result_regular_number_two=$aux['result_regular_number_two'];
            $this->result_regular_number_three=$aux['result_regular_number_three'];
            $this->result_regular_number_four=$aux['result_regular_number_four'];
            $this->result_regular_number_five=$aux['result_regular_number_five'];
            $this->result_lucky_number_one=$aux['result_lucky_number_one'];
            $this->result_lucky_number_two=$aux['result_lucky_number_two'];
        }

        $this->closeConnection();
    }

    protected function throwException($message)
    {
        throw new DataBaseException($message);
    }

    public function put($json)
    {
        $this->redis->set('lastDraw', $json);
    }

    public function get($key)
    {
        $aux=$this->redis->get($key);
        return (array)json_decode($aux);
    }
}