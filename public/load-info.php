<?php
    // CS50 Library
    require("../vendor/library50-php-5/CS50/CS50.php");
    CS50::init(__DIR__ . "/../config.json");

    $result = array();
    
    $rows = CS50::query("SELECT * FROM movies WHERE imdb_id=?", $_GET['imdb_id']);
    
    // if movie already exists in our datebase
    if (count($rows) == 1){
        
        $result = $rows[0];
        
        $result['imdb-rating'] = $result['rating_imdb'];
        $result['year'] = $result['released'];
        
        print(json_encode($result, JSON_PRETTY_PRINT));
        
        
    } else {
        // grab movie info from IMDb page
        include ('imdb-grabber.php');
    }
?>