<?php

require 'vendor/autoload.php';
require_once 'function.php';


$_GET['url'] = 'https://bmake.th-brandenburg.de/tests/EduGraph/thb.jsonld';
$url = $_GET['url'];

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

    SELECT
        *
    WHERE {
        GRAPH <'.$url.'> {
            ?studyProgramURI  a bise:BISEBachelor ;
                bise:bisePillar [ a bise:BISEPillarShare ;
                               bise:pillarBAM  ?pillarBAM ;
                               bise:pillarBIS  ?pillarBIS ;
                               bise:pillarCSC  ?pillarCSC ;
                               bise:pillarNN   ?pillarNN ;
                ] ;
                bise:cpECTS           ?cpECTS ;
                bise:stPeriodOfStudy  ?stPeriodOfStudy ;
                schema:name           ?studyProgramName ;
                schema:provider       ?universityURI ;
                schema:url            ?studyProgramURL .

            ?rating  a schema:Rating ;
                    schema:itemReviewed  ?studyProgramURI ;
                    schema:ratingValue   ?ratingValue.

            ?universityURI  a schema:CollegeOrUniversity ;
                schema:alternateName  ?universityAlternateName ;
                schema:location       ?locationURI ;
                schema:name           ?universityName ;
                schema:url            ?universityURL .



            ?locationURI  a schema:Place ;
                schema:name  ?locationName;
                bise:desc ?locationDesc.

                OPTIONAL {
                    ?locationURI schema:geo   [ a                 schema:GeoCoordinates ;
                           schema:latitude   ?locationLatitude ;
                           schema:longitude  ?locationLongitude
                         ] .
                }
                OPTIONAL { ?locationURI schema:url ?localtionWikiURL. }
                OPTIONAL { ?locationURI foaf:depiction ?localtionDepiction. }

             BIND( (?pillarCSC) AS ?jobADM)
             BIND( ((?pillarBAM+?pillarBIS)/2 ) AS ?jobCON)
             BIND( (?pillarCSC) AS ?jobINF)
             BIND( ((?pillarBAM+?pillarBIS)/2) AS ?jobITM)
             BIND( (?pillarCSC) AS ?jobSWE)

        }
    }';


$result = sparql($query)[0];

#print_r($result);

?>

<div class="row">
        <div class="col-6 ">
            <div class="card card-2">

                <div class="card-block">
                    <h4 class="card-title" id="card-detail-title"><a href="<?php echo $result->studyProgramURL->value;?>"><?php echo $result->studyProgramName->value;?></a></h4>

                    <div class="icon-bar row" style="margin-top:20px; margin-bottom:30px;">
                        <div class="col-4 text-center">
                            <i class="material-icons">info_outline</i> <br />
                            <?php echo $result->cpECTS->value;?> ECTS
                        </div>
                        <div class="col-4 text-center">
                            <i class="material-icons">schedule</i> <br />
                            <?php echo $result->stPeriodOfStudy->value;?>
                        </div>
                        <div class="col-4 text-center">
                            <i class="material-icons">stars</i> <br />
                            <?php echo $result->ratingValue->value;?>
                        </div>
                    </div>
                    <div>
                        <h5>Pillar</h5>
                        <canvas id="bisePillars" width="200" height="100"
                                data-pillarBAM="<?php echo $result->pillarBAM->value;?>"
                                data-pillarBIS="<?php echo $result->pillarBIS->value;?>"
                                data-pillarCSC="<?php echo $result->pillarCSC->value;?>"
                                data-pillarNN="<?php echo $result->pillarNN->value;?>"
                        ></canvas>

                    </div>
                    <div>
                        <h5>Job profiles</h5>
                        <canvas id="jobProfiles" width="400" height="200px"
                                data-jobADM="<?php echo $result->jobADM->value;?>"
                                data-jobCON="<?php echo $result->jobCON->value;?>"
                                data-jobINF="<?php echo $result->jobINF->value;?>"
                                data-jobITM="<?php echo $result->jobITM->value;?>"
                                data-jobSWE="<?php echo $result->jobSWE->value;?>"
                        ></canvas>
                    </div>
                </div>
            </div>
        </div>

    <div class="col-6">

        <div class="card card-2">
            <div class="card-block">
                <h4 class="card-title" id="card-detail-title"><?php echo $result->universityName->value;?></h4>

                (alternate <?php echo $result->universityAlternateName->value;?>)

                <a href="<?php echo $result->universityURL->value;?>"><?php echo $result->universityURL->value;?></a>


            </div>
        </div>

        <div class="card card-2" style="margin-top:30px;">
            <img class="card-img-top" src="https://lh5.googleusercontent.com/proxy/6LrOygncTEdngNyKYxJbh6ufkN130LLvxnJLSwwEx29BRqMIU5ugUiEPGQL4tObVPu4LHMl9gz_szdswHYWxFLEN1m_muQ=w409-h256" alt="Card image cap">
            <h3 class="card-block" style="margin-top:-70px; color:white;"><?php echo $result->locationName->value;?></h3>
            <div class="card-block">
                <?php echo $result->locationDesc->value;?> <a href="<?php echo $result->localtionWikiURL->value;?>" target="_blank">(mehr)</a>

            </div>
        </div>
    </div>

    <div class="col-12" style="margin-top:20px; margin-bottom:20px;">
        <div class="card card-2">
            <div id="map" style="height:280px;"
                 data-longitude="<?php echo ($result->locationLongitude->value);?>"
                 data-latitude="<?php echo ($result->locationLatitude->value);?>"
            ></div>
        </div>

    </div>

</div>