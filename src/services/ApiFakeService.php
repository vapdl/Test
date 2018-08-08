<?php
/**
 *
 * Conexion con una API de loterias fake.
 *
 */
namespace src\services;

define("BASEURL", "https://www.fake.api");

use src\interfaces\IResultApi;
use src\providers\ApiLotoConnector;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class ApiFakeService extends ApiLotoConnector implements IResultApi
{

    public function __construct()
    {

        $mock = new MockHandler([new Response(200, [],file_get_contents(__DIR__.'/../../tests/mock/ApiFakeResponseMock.txt'))]);
        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);

    }
    /**
     *
     * Metodo que trae el ultimo sorteo de la API Fake.
     *
     */
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
        return $this->client->request('GET', BASEURL);
    }

    /**
     *
     * Metodo obligatorio que deben tener todas las API de loterias que normaliza la respuesta de la API.
     *
     */
    protected function setDraw($response)
    {
        $arr['status'] = $response->getStatusCode();

        if($arr['status'] == 200)
        {
            $data= json_decode($response->getBody());
            foreach(explode(',',$data->results) as $item => $value)
            {
                $arr['results'][]=$value;
            }
            $arr['drawDate']=$data->draw;
        }
        else{
            $this->throwException(sprintf($response->getBody()));
        }

        return $arr;
    }
}