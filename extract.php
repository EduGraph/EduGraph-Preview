<?php

require 'vendor/autoload.php';


require_once 'function.php';

$url = $_GET['url'];


$query = 'DROP SILENT GRAPH <'.$url.'>';
$response = sparqlUpdate($query);

$responseExtraction = extractRdfFromUrl($url);
$data = $responseExtraction->getBody();
$responsePostData = postData($data, $url);

/*
function getURI($type){
    $query = '
        prefix schema: <http://schema.org/>
        prefix rdf:   <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
        prefix xml:   <http://www.w3.org/XML/1998/namespace>
        prefix xsd:   <http://www.w3.org/2001/XMLSchema#>
        prefix rdfs:  <http://www.w3.org/2000/01/rdf-schema#>
        prefix bise:   <http://akwi.de/ns/bise#>

        SELECT * WHERE {
          GRAPH <https://bmake.th-brandenburg.de/tests/EduGraph/thb.jsonld>
            { ?uri a '.$type.'}
        }';
    $response = sparql($query);
    $studyProgramURI = $response[0]->uri->value;
    return $studyProgramURI;
}


$placeURI = getURI('schema:Place');
$universityURI = getURI('schema:CollegeOrUniversity');
*/



// Enhancing
$query = '
PREFIX schema: <http://schema.org/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
PREFIX foaf: <http://xmlns.com/foaf/0.1/>
PREFIX bise:  <http://akwi.de/ns/bise#>
PREFIX dbpedia-de: <http://de.dbpedia.org/resource/>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX dbo: <http://dbpedia.org/ontology/>
PREFIX dbr: <http://dbpedia.org/resource/>
PREFIX wd: <http://www.wikidata.org/entity/>
PREFIX wdt: <http://www.wikidata.org/prop/direct/>
PREFIX wikibase: <http://wikiba.se/ontology#>
PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>

INSERT {
    GRAPH <'.$url.'> {
        ?placeURI schema:url ?wikipediaURL;
            foaf:depiction ?depiction;
            bise:desc ?comment.
        ?universityURI a schema:CollegeOrUniversity.
    }
}
WHERE {
    {
		SELECT * WHERE {
			GRAPH <'.$url.'> {
				{
					SELECT * WHERE {
    					?universityURI  a schema:CollegeOrUniversity.
    					?placeURI  a schema:Place.
					}
					LIMIT 1
				}
			}
			SERVICE <http://dbpedia.org/sparql/> {
				?placeURI rdfs:comment ?comment_lang;
          			foaf:isPrimaryTopicOf ?wikipediaURL;
					foaf:depiction ?depiction.

					FILTER (LANG(?comment_lang) = "de")
					BIND (str(?comment_lang) AS ?comment)
    		}
		}
	}
}
';
$response = sparqlUpdate($query);



$client = new GuzzleHttp\Client(['base_uri' => 'http://172.16.32.159:8080/ModulKatalogController/REST/ModulKatalogREST/Kataloge/'.urlencode('th-brandenburg.de/wirtschaftsinformatik')]);
$response = $client->request('GET', '');
$pillarObj = json_decode($response->getBody());


$query = '
PREFIX schema: <http://schema.org/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
PREFIX foaf: <http://xmlns.com/foaf/0.1/>
PREFIX bise:  <http://akwi.de/ns/bise#>
PREFIX dbpedia-de: <http://de.dbpedia.org/resource/>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX dbo: <http://dbpedia.org/ontology/>
PREFIX dbr: <http://dbpedia.org/resource/>
PREFIX wd: <http://www.wikidata.org/entity/>
PREFIX wdt: <http://www.wikidata.org/prop/direct/>
PREFIX wikibase: <http://wikiba.se/ontology#>
PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#>

INSERT {
    GRAPH <'.$url.'> {
        ?studyprogramURI bise:bisePillar  [ a  bise:BISEPillarShare ;
                          bise:pillarBAM  '.$pillarObj->bwl.';
                          bise:pillarBIS  '.$pillarObj->wi.';
                          bise:pillarCSC  '.$pillarObj->inf.';
                          bise:pillarNN   '.$pillarObj->nn.'
                        ] .
    }
}
WHERE {
    GRAPH <'.$url.'> {
            SELECT * WHERE {
                ?studyprogramURI  a bise:BISEBachelor .
            }
            LIMIT 1
    }
}
';
$response = sparqlUpdate($query);
exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/style.css" >
    <link rel="stylesheet" href="assets/css/spinner.css" >

    <link rel="shortcut icon" type="image/png" href="assets/img/edugraph-logo.png"/>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>

    <title>EduGraph University Preview</title></title>
</head>
<body>

<nav class="navbar card-3" style="background-color:#33691E; color:white;">
    <span class="navbar-brand" style="margin-bottom:10px;" href="#">EduGraph University Preview </span>


    <div class="input-group input-group-lg card-5" style="margin-bottom:10px;">
        <span class="input-group-addon" id="sizing-addon1" style="opacity: 0.5"><i class="material-icons">public</i></span>
        <input id="url-input" type="url" class="form-control" style="opacity: 0.5" name="url"  placeholder="Enter a URL to preview" aria-describedby="sizing-addon1">
        <span class="input-group-addon" id="sizing-addon2" style="opacity: 0.5"><i class="material-icons">refresh</i></span>
    </div>


</nav>


<div class="spinner">
    <div class="double-bounce1"></div>
    <div class="double-bounce2"></div>
</div>
</body>
</html>
