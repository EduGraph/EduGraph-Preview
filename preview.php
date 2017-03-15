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





<div id="preview" class="container" style="margin-top:20px;display:none;">

</div>

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js" ></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js" ></script>

<script src="assets/js/app.js" ></script>

</body>
</html>