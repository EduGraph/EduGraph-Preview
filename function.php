<?php

function extractRdfFromUrl($url){
    $service = 'http://rdf-translator.appspot.com/convert';
    $sourceFormat = 'json-ld';
    $targetFormat = 'n3';
    $client = new GuzzleHttp\Client(['base_uri' => $service.'/'.$sourceFormat.'/'.$targetFormat.'/']);
    $response = $client->request('GET', urlencode($url));
    return $response;
}

function postData($data, $id){
    $client = new GuzzleHttp\Client(['base_uri' => 'http://fbwsvcdev.fh-brandenburg.de:8080/fuseki/EduGraph-ESWC-extract/']);
    $response = $client->request('POST', 'data?graph='.$id, [
        'headers' => [
            'Content-Type' => 'text/turtle'
        ],
        'body' => $data
    ]);
    return $response;
}

function sparql($query){
    $service = 'http://fbwsvcdev.fh-brandenburg.de:8080/fuseki/EduGraph-ESWC-extract/query';
    $client = new GuzzleHttp\Client(['base_uri' => $service]);
    try {
        $response = $client->request('POST', '', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/sparql-results+json; charset=utf-8application/sparql-results+json; charset=utf-8'
            ],
            'form_params' => [
                'query' => $query
            ]
        ]);
    }
    catch(Exception $e) {
        $responseBody = $e->getResponse()->getBody(true);
        echo '<pre>';
        print_r ($e->getMessage());
        echo $responseBody;
        echo '</pre>';
    }

    return json_decode($response->getBody())->results->bindings;

}

function sparqlUpdate($query){
    $service = 'http://fbwsvcdev.fh-brandenburg.de:8080/fuseki/EduGraph-ESWC-extract/update';
    $client = new GuzzleHttp\Client(['base_uri' => $service]);


    try {
        $response = $client->request('POST', '', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/sparql-results+json; charset=utf-8application/sparql-results+json; charset=utf-8'
            ],
            'body' => 'update='.$query
        ]);
        return $response;
    }
    catch(Exception $e) {
        $responseBody = $e->getResponse()->getBody(true);
        echo '<pre>';
        print_r ($e->getMessage());
        echo $responseBody;
        echo '</pre>';
    }

}
