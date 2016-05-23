<?php

    // configuration
    require("../includes/config.php"); 
    
    $rows = CS50::query("SELECT * FROM watched INNER JOIN movies ON movies.id = watched.movie_id WHERE user_id = ? ORDER BY date DESC;", $_SESSION['id']);  
    
    render("timeline.php", ["title" => "Timeline", "rows" => $rows]);
?>