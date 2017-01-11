<?php
$weather = '';
$error = '';

if (! empty($_GET['city'])) {
    $cityName = urlencode($_GET['city']);
    $urlContents = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=$cityName,uk&appid=5c34ac8b5f40d8c7a6d327304f42d731");
    $weatherArray = json_decode($urlContents, true);

    $weatherCod = isset($weatherArray['cod']) ? $weatherArray['cod'] : '';

    if ($weatherCod == 200) {
        $weather = "The weather in {$_GET['city']} 
                is currently {$weatherArray['weather'][0]['description']}.";

        $tempInCelcius = intval($weatherArray['main']['temp'] - 273);
        $windSpeed = $weatherArray['wind']['speed'] . 'm/s';

        $weather .= " The temperature is $tempInCelcius &deg;C and the wind speed is $windSpeed.";
    } else {
        $error = "Could not find the city - please try again.";
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Weather Scraper</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <style type="text/css">
        html {
            background: url(../images/backgroundSecond.jpeg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        body {
            background: none;
        }

        .container {
            text-align: center;
            margin-top: 100px;
            width: 450px;
        }

        input {
            margin: 20px 0;
        }

        #weather {
            margin-top: 15px;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Whot's The Weather?</h1>

    <form>
        <div class="form-group">
            <label for="city">Enter the name of the city.</label>
            <input type="text" class="form-control" id="city" name="city" aria-describedby="emailHelp" placeholder="Eg. London, Tokyo">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div id="weather">
        <?php echo empty($weather) ? '' : '<div class="alert alert-success" role="alert">' . $weather . '</div>'?>
        <?php echo empty($error) ?  '' :  '<div class="alert alert-danger" role="alert">' . $error . '</div>'?>
    </div>
</div> 


<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>