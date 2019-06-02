<?php
/**
 *
 * Clase que implementa un modelo de Euromillions
 *
 */
namespace src\models;

use src\interfaces\ICache;
use src\providers\RedisConnector;
use src\providers\MySQLConnector;

class Euromillions implements ICache
{
    use RedisConnector;
    use MySQLConnector;

    public $id;
    public $draw_date;
    public $result_regular_number_one;
    public $result_regular_number_two;
    public $result_regular_number_three;
    public $result_regular_number_four;
    public $result_regular_number_five;
    public $result_lucky_number_one;
    public $result_lucky_number_two;

    /**
     *
     * Metodo que graba un nuevo sorteo en la base de datos y en el cache.
     *
     */
    public function save()
    {
        $this->openConnection();
        $sql='insert into euromillions_draws (draw_date, result_regular_number_one, result_regular_number_two, result_regular_number_three, result_regular_number_four, result_regular_number_five, result_lucky_number_one, result_lucky_number_two) values("'.$this->draw_date.'", '.$this->result_regular_number_one.', '.$this->result_regular_number_two.', '.$this->result_regular_number_three.', '.$this->result_regular_number_four.', '.$this->result_regular_number_five.', '.$this->result_lucky_number_one.', '.$this->result_lucky_number_two.')';
        try
        {
            $this->mysqli->query($sql);
            $this->id=$this->mysqli->insert_id;
        }
        catch(\Exception $e)
        {
            $this->throwException($e->getMessage());
        }

        $this->closeConnection();

        $this->put('lastDraw', json_encode(['id' => $this->id, 'draw_date' => $this->draw_date, 'result_regular_number_one' => $this->result_regular_number_one, 'result_regular_number_two' => $this->result_regular_number_two, 'result_regular_number_three' => $this->result_regular_number_three, 'result_regular_number_four' => $this->result_regular_number_four, 'result_regular_number_five' => $this->result_regular_number_five, 'result_lucky_number_one' => $this->result_lucky_number_one, 'result_lucky_number_two' => $this->result_lucky_number_two]));
    }

    /**
     *
     * Metodo que obtiene el ultimo sorteo guardado en el cache o la base de datos.
     *
     */
    public function getLastDraw()
    {
        $band=true;

        $aux = $this->get('lastDraw');

        if(is_null($aux))
        {
            $this->openConnection();
            try
            {
                $result=$this->mysqli->query('select * from euromillions_draws order by id Desc LIMIT 1');
                $aux= $result->fetch_assoc();
            }
            catch(\Exception $e)
            {
                $this->throwException($e->getMessage());
            }
            $this->closeConnection();
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

        return $band;
    }
}