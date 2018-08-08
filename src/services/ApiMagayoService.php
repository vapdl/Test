<?php

namespace src\services;

define("APIKEY", "mASBxwC2sUzjyTNRpS");
define("BASEURL", "https://www.magayo.com/api/results.php");

use src\interfaces\IResultApi;
use src\services\providers\ApiLotoConnector;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class ApiMagayoService extends ApiLotoConnector implements IResultApi
{
    private $game;

    public function __construct($game, $dev= false)
    {
        if($dev)
        {
            $mock = new MockHandler([new Response(200, [],file_get_contents(__DIR__.'/../../tests/mock/ApiMagayoResponseMock.txt'))]);
            $handler = HandlerStack::create($mock);
            $this->client = new Client(['handler' => $handler]);
        }
        else
        {
            parent::__construct();
        }
        $this->game = $game;
    }

    public function fetch()
    {
        try {
            $response = $this->getRequest();
            return $this->setDraw( $response);
        } catch (ClientException $e) {
            $this->throwException(sprintf('Failed to get data'));
        }
    }

    public function getRequest()
    {
        return $this->client->request('GET', BASEURL, ['query' => ['api_key' => APIKEY, 'game' => $this->game]]);
    }

    public function setGame($game)
    {
        $this->game = $game;
    }

    public function getGame()
    {
        return $this->game;
    }

    protected function setDraw($response)
    {
        $arr['status'] = $response->getStatusCode();

        if($arr['status'] == 200)
        {
            $data= json_decode($response->getBody());
            if($data->error == 200)
            {
                foreach(explode(',',$data->results) as $item => $value)
                {
                    $arr['results'][]=$value;
                }
                $arr['drawDate']=$data->draw;
            }
            else{
                $this->throwException(sprintf($response->getBody()));
            }
        }
        else{
            $this->throwException(sprintf($response->getBody()));
        }

        return $arr;
    }
}