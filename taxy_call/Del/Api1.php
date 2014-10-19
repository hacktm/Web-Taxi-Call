<?php
    
    $input = 'oradea';
    $key = 'AIzaSyA0yVzDKNBQVYh8qwg1ovB9ST13h2cLilg';
    $url = 'https://maps.googleapis.com/maps/api/place/autocomplete/xml?input=$input&key=$key';
    
    $xml = simplexml_load_file($url);
    
    $status = $xml -> status;
    $predictions = $xml -> prediction;
    if($status == 'OK') {
        foreach($predictions as $predictions_value) {
            $description = $predictions_value -> description;
            echo $description.'<br></br>';
        }
    } else {
        echo 'Este o problema la preluare !';
    }
?>  