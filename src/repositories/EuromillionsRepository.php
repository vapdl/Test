<?php

namespace src\repositories;

use src\models\Euromillions;
use src\services\ApiMagayoService;

class EuromillionsRepository
{
    public function __construct($dev=false)
    {
            $this->service = new ApiMagayoService('euromillions', $dev);
            $this->model= new Euromillions();
    }

    public function getLastDrawResultFromAPI()
    {
        return $this->service->fetch();
    }

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

    public function getLastDraw()
    {
        $this->model->getLastDraw();
        return $this->model;
    }
}