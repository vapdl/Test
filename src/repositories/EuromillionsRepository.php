<?php
/**
 *
 * Repositorio que brinda funcionalidad a la aplicacion sobre sorteo Euromillion.
 *
 */
namespace src\repositories;

use src\models\Euromillions;
use src\services\ApiMagayoService;

class EuromillionsRepository
{
    /**
     *
     * Constructor donde se puede seleccionar a que Api de loterias nos vamos a conectar para bajar los sorteos.
     *
     */
    public function __construct($dev=false)
    {
            $this->service = new ApiMagayoService('euromillions', $dev);
            $this->model= new Euromillions();
    }
    /**
     *
     * Metodo que obtiene el ultimo sorteo de la Api.
     *
     */
    public function getLastDrawResultFromAPI()
    {
        return $this->service->fetch();
    }

    /**
     *
     * Metodo que guarda el ultimo sorteo Euromillion.
     *
     */
    public function saveDraw($draw)
    {
        $this->model->draw_date= $draw['drawDate'];
        $this->model->result_regular_number_one=$draw['results'][0];
        $this->model->result_regular_number_two=$draw['results'][1];
        $this->model->result_regular_number_three=$draw['results'][2];
        $this->model->result_regular_number_four=$draw['results'][3];
        $this->model->result_regular_number_five=$draw['results'][4];
        $this->model->result_lucky_number_one=$draw['results'][5];
        $this->model->result_lucky_number_two=$draw['results'][6];
        $this->model->save();

        return $this->model;
    }

    /**
     *
     * Metodo que obtiene el ultimo sorteo Euromillion.
     *
     */
    public function getLastDraw()
    {
        $result=$this->model->getLastDraw();

        if($result==false)
        {
            $draw= $this->getLastDrawResultFromAPI();
            $this->saveDraw($draw);
        }
        return $this->model;
    }
}