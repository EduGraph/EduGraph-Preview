<?php


require_once '../vendor/autoload.php';

use GuzzleHttp;

class sparql
{
    var $service;

    /**
     * sparql constructor.
     * @param $service
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    public function httptransfer($data, $graph='default', $method='POST'){
        $client = new GuzzleHttp\Client(['base_uri' => $this->service]);
        $response = $client->request($method, 'data?graph='.$graph, [
            'headers' => [
                'Content-Type' => 'text/turtle'
            ],
            'body' => $data
        ]);
        return $response;
    }

    public function query($query){
        $client = new GuzzleHttp\Client(['base_uri' => $this->service.'/query']);
        $response = $client->request('POST', '', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/sparql-results+json; charset=utf-8application/sparql-results+json; charset=utf-8'
            ],
            'body' => 'query='.$query
        ]);

        return $response;
    }

    public function update($query){
        $client = new GuzzleHttp\Client(['base_uri' => $this->service.'/update']);
        $response = $client->request('POST', '', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/sparql-results+json; charset=utf-8application/sparql-results+json; charset=utf-8'
            ],
            'body' => 'update='.$query
        ]);
        return $response;
    }


}