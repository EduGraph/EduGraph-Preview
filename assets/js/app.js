$( document ).ready(function() {
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results[1] || 0;
    };

    var url = $.urlParam('url');
    $('#url-input').val(decodeURIComponent(url));

    $.ajax( "extract.php?url=" + url )
        .done(function(data) {
            if(data == ''){
                $('.spinner').hide();
                $.ajax( "view.php?url=" + url )
                    .done(function(data) {
                        $('#preview').append(data);
                        $('#preview').show();
                        pillar();
                        jobProfiles();


                        map();

                    })
                    .fail(function() {
                        alert( "error" );
                    });
            }
            else{
                alert( "error" );
            }

        })
        .fail(function() {
            alert( "error" );
        });









});

function pillar(){

    var bisePillars = $("#bisePillars");

    var data = {
        labels: [
            "Methods",
            "Management",
            "Information Systems",
            "Computer Science"]
        ,
        datasets: [
            {
                data: [bisePillars.data('pillarnn'), bisePillars.data('pillarbam'), bisePillars.data('pillarbis'), bisePillars.data('pillarcsc')],
                backgroundColor: [
                    "#ECEFF1",
                    "#FDB45C",
                    "#F7464A",
                    "#97BBCD"]
            }]
    };

    var bisePillarsDoughnutChart = new Chart(bisePillars, {
        type: 'doughnut',
        data: data,
        options: {
            animation : false,
            animateRotate : false,
            animateScale : false,
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var allData = data.datasets[tooltipItem.datasetIndex].data;
                        var tooltipLabel = data.labels[tooltipItem.index];
                        var tooltipData = allData[tooltipItem.index];
                        var total = 0;
                        for (var i in allData) {
                            total += allData[i];
                        }
                        var tooltipPercentage = Math.round((tooltipData / total) * 100);
                        //return tooltipLabel + ': ' + tooltipData + ' (' + tooltipPercentage + '%)';
                        return tooltipLabel + ': ' + tooltipPercentage + '%';
                    }
                }
            },
            legend: {
                display: false
            }
        }
    });
}

function jobProfiles(){
    var jobProfiles = $("#jobProfiles");
    var data = {
        labels: ["Administration", "Consulting", "Computer Science", "IT Management", "SW Engineering"],
        datasets: [
            {
                data: [
                    jobProfiles.data('jobadm'),
                    jobProfiles.data('jobcon'),
                    jobProfiles.data('jobinf'),
                    jobProfiles.data('jobitm'),
                    jobProfiles.data('jobswe')
                ],
                backgroundColor: "rgba(51,105,30,0.2)",
                borderColor: "rgba(51,105,30,1)",
                pointBackgroundColor: "rgba(51,105,30,1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(51,105,30,1)",
            }
        ]
    };

    var jobProfilesRadarChart = new Chart(jobProfiles, {
        type: 'radar',
        data: data,
        options: {
            scaleOverride: true,
            animation : false,
            scale: {
                ticks: {
                    min: 0,
                    max: 0.3
                }
            },
            tooltips: {
                enabled: false
            },
            pointLabels: {
                display: false
            },
            legend: {
                display: false
            },
            scale: {
                ticks: {
                    display: false,
                    min: 0,
                    max: 0.4,
                    stepSize: 0.1
                }
            }

        }
    });
}


function map(){
    var longitude = (($( "#map" ).data("longitude")));
    var latitude = (($( "#map" ).data("latitude")));


    console.log(latitude)
    console.log(longitude)

    var map = L.map('map').setView([latitude, longitude], 11);


    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
/*
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup('Technische Hochschule Brandenburg')
        .openPopup();
*/
}