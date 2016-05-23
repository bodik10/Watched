<?php
    // CS50 Library
    require("../includes/config.php"); 
    
    if (empty($_GET['type']))
        exit;
        
    $type = $_GET['type'];
    $query = "";
    $result = ['result' => '', 'info' => '', 'advanced_info' => ''];
    
    switch($type){
        
        // USER'S statistic
        case "Total watched movies":
            $rows = CS50::query("SELECT COUNT(*) AS count FROM watched WHERE user_id = ?;", $_SESSION["id"]);
            $result['result'] = $rows[0]['count'];
            break;
        
        case "Your total runtime":
            $rows = CS50::query("SELECT runtime FROM movies INNER JOIN watched ON watched.movie_id = movies.id AND watched.user_id = ?;", $_SESSION["id"]);
            $runtime = 0;
            for ($i = 0; $i < count($rows); $i++)
                $runtime += convert_runtime($rows[$i]['runtime']);
            $result['result'] = $runtime . " minutes";
            $result['info'] = floor($runtime / 60) . " hours " . $runtime % 60 . " minutes";
            break;
        
        case "Year you watched a most movies":
            $rows = CS50::query("SELECT YEAR(date) AS year, COUNT(*) AS count FROM watched WHERE user_id = ? GROUP BY year ORDER BY count DESC LIMIT 1;", $_SESSION["id"]);
            if (!$rows)
                break;
            $year = $rows[0]['year'];
            $result['result'] = $year;
            $result['info'] = $rows[0]['count'] . " movie(s)";
            break;
            
        case "Year you watched a fewest movies":
            $rows = CS50::query("SELECT YEAR(date) AS year, COUNT(*) AS count FROM watched WHERE user_id = ? GROUP BY year ORDER BY count ASC LIMIT 1;", $_SESSION["id"]);
            if (!$rows)
                break;
            $year = $rows[0]['year'];
            $result['result'] = $year;
            $result['info'] = $rows[0]['count'] . " movie(s)";
            break;
            
        case "Your most popular genre":
            $rows = CS50::query("SELECT genre FROM movies INNER JOIN watched ON watched.movie_id = movies.id AND watched.user_id = ?;", $_SESSION["id"]);
            $count_genres = [];
            for ($i = 0; $i < count($rows); $i++){
                $genres = preg_split("/\s*,\s*/", $rows[$i]['genre']);
                foreach ($genres as $genre){
                    if (array_key_exists($genre, $count_genres)){
                        $count_genres[$genre]++;
                    } else {
                        $count_genres[$genre] = 1;
                    }
                }
            }
            if ($count_genres){
                $result['result'] = array_keys($count_genres, max($count_genres))[0];
                $result['info'] =  max($count_genres) . " movie(s)";
            }
            break;
            
        case "Your most unpopular genre":
            $rows = CS50::query("SELECT genre FROM movies INNER JOIN watched ON watched.movie_id = movies.id AND watched.user_id = ?;", $_SESSION["id"]);
            $count_genres = [];
            for ($i = 0; $i < count($rows); $i++){
                $genres = preg_split("/\s*,\s*/", $rows[$i]['genre']);
                foreach ($genres as $genre){
                    if (array_key_exists($genre, $count_genres)){
                        $count_genres[$genre]++;
                    } else {
                        $count_genres[$genre] = 1;
                    }
                }
            }
            if ($count_genres){
                $result['result'] = array_keys($count_genres, min($count_genres))[0];
                $result['info'] = min($count_genres) . " movie(s)";
            }
            break;
            
        case "Users with similar tastes":
            $users = [];
            $rows = CS50::query("SELECT movies.id, movies.name FROM movies INNER JOIN watched ON watched.movie_id = movies.id AND watched.user_id = ?;", $_SESSION["id"]);
            for ($i = 0; $i < count($rows); $i++){
                $rows2 = CS50::query("SELECT users.id, users.name FROM users INNER JOIN watched ON watched.user_id = users.id AND watched.movie_id = ? WHERE users.id != ?;", $rows[$i]['id'], $_SESSION["id"]);
                for ($j = 0; $j < count($rows2); $j++){
                    $username = $rows2[$j]['id'];
                    if (array_key_exists($username, $users)){
                        
                        $users[$username]['movies'][] = $rows[$i]['name'];
                    } else {
                        $users[$username]['name'] = $rows2[$j]['name'];
                        $users[$username]['movies'] = array($rows[$i]['name']);
                    }
                }
            }
            usort($users, function($a, $b){
                if (count($a['movies']) == count($b['movies'])) {
                    return 0;
                }
                return (count($a['movies']) > count($b['movies'])) ? -1 : 1;
            });
            //print_r($users);
            
            if ($result && $users){
                $result['result'] = $users[0]['name'];
                $result['info'] =  count($users[0]['movies']) . " movie(s)";
                $result['advanced_info'] = implode("<br>", $users[0]['movies']);
            }
            break;
            
        // GLOBAL statistic
        
        case "Total watched movies by everyone":
            $rows = CS50::query("SELECT COUNT(*) AS count FROM watched WHERE 1;");
            $result['result'] = $rows[0]['count'] . " movie(s)";
            $rows = CS50::query("SELECT COUNT(*) AS count FROM users WHERE 1;");
            $result['info'] = "Watched by " . $rows[0]['count'] . " users";
            break;
            
        case "User with most watched movies":
            $rows = CS50::query("SELECT users.name, COUNT(*) AS count FROM watched INNER JOIN users ON watched.user_id = users.id GROUP BY watched.user_id ORDER BY count DESC LIMIT 1;");
            $result['result'] = $rows[0]['name'];
            $result['info'] = $rows[0]['count'] . " movie(s)";
            break;
        
        case "Global runtime":
            $rows = CS50::query("SELECT runtime FROM movies INNER JOIN watched ON watched.movie_id = movies.id;");
            $runtime = 0;
            for ($i = 0; $i < count($rows); $i++)
                $runtime += convert_runtime($rows[$i]['runtime']);
            $result['result'] = $runtime . " minutes";
            $result['info'] = floor($runtime / 60) . " hours " . $runtime % 60 . " minutes";
            break;
            
        case "Year when watched a most movies":
            $rows = CS50::query("SELECT YEAR(date) AS year, COUNT(*) AS count FROM watched GROUP BY year ORDER BY count DESC LIMIT 1;");
            $result['result'] = $rows[0]['year'];
            $result['info'] = $rows[0]['count'] . " movie(s)";
            break;
            
        case "Year when watched a fewest movies":
            $rows = CS50::query("SELECT YEAR(date) AS year, COUNT(*) AS count FROM watched GROUP BY year ORDER BY count ASC LIMIT 1;");
            $result['result'] = $rows[0]['year'];
            $result['info'] = $rows[0]['count'] . " movie(s)";
            break;
            
        case "Most popular genre":
            $rows = CS50::query("SELECT genre FROM movies INNER JOIN watched ON watched.movie_id = movies.id;");
            $count_genres = [];
            for ($i = 0; $i < count($rows); $i++){
                $genres = preg_split("/\s*,\s*/", $rows[$i]['genre']);
                foreach ($genres as $genre){
                    if (array_key_exists($genre, $count_genres)){
                        $count_genres[$genre]++;
                    } else {
                        $count_genres[$genre] = 1;
                    }
                }
            }
            if ($count_genres){
                $result['result'] = array_keys($count_genres, max($count_genres))[0];
                $result['info'] = max($count_genres) . " movie(s)";
            }
            break;
            
        case "Most unpopular genre":
            $rows = CS50::query("SELECT genre FROM movies INNER JOIN watched ON watched.movie_id = movies.id;");
            $count_genres = [];
            for ($i = 0; $i < count($rows); $i++){
                $genres = preg_split("/\s*,\s*/", $rows[$i]['genre']);
                foreach ($genres as $genre){
                    if (array_key_exists($genre, $count_genres)){
                        $count_genres[$genre]++;
                    } else {
                        $count_genres[$genre] = 1;
                    }
                }
            }
            if ($count_genres){
                $result['result'] = array_keys($count_genres, min($count_genres))[0];
                $result['info'] = min($count_genres) . " movie(s)";
            }
            break;
            
            case "Movie most users have watched":
                $rows = CS50::query("SELECT movies.name, COUNT(*) AS count FROM movies INNER JOIN watched ON watched.movie_id = movies.id GROUP BY movies.id ORDER BY count DESC LIMIT 1;");
                $result['result'] = $rows[0]['name'];
                $result['info'] = $rows[0]['count'] . " users";
                break;
                
            case "Movie with the highest user rating":
                $rows = CS50::query("SELECT name, AVG(rating) AS rating FROM movies INNER JOIN watched ON watched.movie_id = movies.id WHERE rating > 0 GROUP BY movies.id ORDER BY rating DESC LIMIT 1;");
                $result['result'] = $rows[0]['name'];
                $result['info'] = sprintf("Average rating: %.2f", (float) $rows[0]['rating']);
                break;
                
            case "Movie with the lowest user rating":
                $rows = CS50::query("SELECT name, AVG(rating) AS rating FROM movies INNER JOIN watched ON watched.movie_id = movies.id WHERE rating > 0 GROUP BY movies.id ORDER BY rating ASC LIMIT 1;");
                $result['result'] = $rows[0]['name'];
                $result['info'] = sprintf("Average rating: %.2f", (float) $rows[0]['rating']);
                break;
    }
    
    print(json_encode($result, JSON_PRETTY_PRINT));
?>