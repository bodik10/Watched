<?php

    // configuration
    require("../includes/config.php"); 
    
    $warnings = '';
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        
    }
    else if  ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST['movie']) || empty($_POST['date']) || empty($_POST['imdb-id']) || empty($_POST['released']) || empty($_POST['rating-imdb']) || empty($_POST['poster']) || empty($_POST['plot']) || empty($_POST['genre']) || empty($_POST['runtime']))
        {
            error("Some required fields are empty. Please try again.", "Add Movie");
        }
        
        $rows = CS50::query("SELECT * FROM movies WHERE imdb_id = ?;", $_POST['imdb-id']);
        if ($rows)
        {
            $movie_id = $rows[0]['id'];
        } 
        else 
        {
            CS50::query("INSERT INTO movies (imdb_id, name, released, rating_imdb, poster, plot, runtime, genre) VALUES (?,?,?,?,?,?,?,?);", $_POST['imdb-id'], $_POST['movie'], $_POST['released'], $_POST['rating-imdb'], $_POST['poster'], $_POST['plot'], $_POST['runtime'], $_POST['genre']);
            $rows = CS50::query("SELECT LAST_INSERT_ID() AS id;");
            $movie_id = $rows[0]['id'];
        }
        
        $query = CS50::query("INSERT IGNORE INTO watched (movie_id, user_id, date, rating) VALUES (?,?,?,?);", $movie_id, $_SESSION['id'], $_POST['date'], $_POST['rating']);
        if (!$query){
            error("Movie '{$_POST['movie']}' is already in Datebase!", "Add Movie");
        }
        else
        {
            CS50::query("UPDATE movies SET counter = counter + 1 WHERE id=?;", $movie_id);
            $warnings = "Done! Movie '{$_POST['movie']}' has been succesfuly added to your list of watched movies";
        }
            
    }

    render("add.php", ["title" => "Add Movie", "warnings" => $warnings]);

?>