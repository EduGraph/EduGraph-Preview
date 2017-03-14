$( document ).ready(function() {
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results[1] || 0;
    }

    $('#url-input').val($.urlParam('url'));

    var data = {
        labels: [
            "Methods",
            "Management",
            "Information Systems",
            "Computer Science"]
        ,
        datasets: [
            {
                data: [0.2, 0.3, 0.4, 0.1],
                backgroundColor: [
                    "#ECEFF1",
                    "#FDB45C",
                    "#F7464A",
                    "#97BBCD"]
            }]
    };
    var bisePillars = $("#bisePillars");
    var bisePillarsDoughnutChart = new Chart(bisePillars, {
        type: 'doughnut',
        data: data,
        options: {
            animation : false,
            animateRotate : false,
            animateScale : false,
            tooltipTemplate: '<%=label%> <%= Math.round(circumference / 6.283 * 100) %> ',
            legend: {
                display: false
            }
        }
    });

    var jobProfiles = $("#jobProfiles");

    var data = {
        labels: ["Administration", "Consulting", "Computer Science", "IT management", "SW Engineering"],
        datasets: [
            {
                data: [0, 0, 0, 0, 0]
            }
        ]
    };

    var jobProfilesRadarChart = new Chart(jobProfiles, {
        type: 'radar',
        data: data,
        options: {
            scaleOverride: true,
            animation : false,
            scaleSteps: 4,
            scaleStepWidth: 0.125,
            showTooltips: false,
            legend: {
                display: false
            },
            scale: {
                ticks: {
                    display: false
                },
            }

        }
    });


    var map = L.map('map').setView([51.505, -0.09], 13);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([51.5, -0.09]).addTo(map)
        .bindPopup('University of London')
        .openPopup();


});