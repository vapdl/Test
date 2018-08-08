<?php
/**
 *
 * Conexion con la API de loterias Magayo.
 *
 */
namespace src\services;

define("APIKEY", "QS538DW5AKABASBMLD");
define("BASEURL", "https://www.magayo.com/api/results.php");

use src\interfaces\IResultApi;
use src\providers\ApiLotoConnector;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class ApiMagayoService extends ApiLotoConnector implements IResultApi
{
    private $game;
    /**
     *
     * Constructor que depende si es entorno de prod o pruebas mockea una respuesta o va y llama a la API.
     *
     */
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
    /**
     *
     * Metodo que trae el ultimo sorteo de la API Magayo.
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
    /**
     *
     * Metodo que genera request para traer el ultimo sorteo de la API Magayo.
     *
     */
    public function getRequest()
    {
        return $this->client->request('GET', BASEURL, ['query' => ['api_key' => APIKEY, 'game' => $this->game]]);
    }

    /**
     *
     * Metodo que setea el juego a traer informacion de la API Magayo.
     *
     */
    public function setGame($game)
    {
        $this->game = $game;
    }
    /**
     *
     * Metodo que retorna el juego a traer informacion de la API Magayo.
     *
     */
    public function getGame()
    {
        return $this->game;
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
            if($data->error == 0)
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