<?php

    // configuration
    require("../includes/config.php"); 
    
    $rows = CS50::query("SELECT users.id, users.name, COUNT(*) AS count FROM users INNER JOIN watched ON users.id = watched.user_id GROUP BY watched.user_id;");  
    
    for ($i = 0; $i < count($rows); $i++){
        $id = $rows[$i]['id'];
        
        $runtimes = CS50::query("SELECT runtime FROM movies INNER JOIN watched ON watched.movie_id = movies.id AND watched.user_id = ?;", $id); 
        $rows[$i]['runtime'] = 0;
        for ($j = 0; $j < count($runtimes); $j++)
            $rows[$i]['runtime'] += convert_runtime($runtimes[$j]['runtime']);
        
        $rows[$i]['rating'] = "";
        $ratings = CS50::query("SELECT AVG(rating) AS rating FROM watched WHERE rating > 0 AND user_id = ? GROUP BY user_id;", $id); 
        if ($ratings)
            $rows[$i]['rating'] = $ratings[0]['rating'];
            
        $genres_rows = CS50::query("SELECT genre FROM movies INNER JOIN watched ON watched.movie_id = movies.id AND watched.user_id = ?;", $id);
        $count_genres = [];
        for ($j = 0; $j < count($genres_rows); $j++){
            $genres = preg_split("/\s*,\s*/", $genres_rows[$j]['genre']);
            foreach ($genres as $genre){
                if (array_key_exists($genre, $count_genres)){
                    $count_genres[$genre]++;
                } else {
                    $count_genres[$genre] = 1;
                }
            }
        }
        if ($count_genres){
            $rows[$i]['genre'] = array_keys($count_genres, max($count_genres))[0] . " (" . max($count_genres) . " movie(s))";
        }
        
        $watched = CS50::query("SELECT COUNT(*) AS count FROM `watched` INNER JOIN users ON users.id=watched.user_id AND users.id = ? WHERE watched.movie_id IN (SELECT movie_id FROM watched WHERE user_id = ?);", $id, $_SESSION["id"]);
        if ($watched)
            $rows[$i]['watched'] = $watched[0]['count'];
    }
    
    render("users.php", ["title" => "Users", "rows" => $rows]);
?>