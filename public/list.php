<?php

    // configuration
    require("../includes/config.php"); 
    
    $rows = CS50::query("SELECT * FROM watched INNER JOIN movies ON movies.id = watched.movie_id WHERE user_id = ?;", $_SESSION['id']);  
    
    render("list.php", ["title" => "List", "rows" => $rows]);
?>