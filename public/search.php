<?php
    // headers for proxy servers
    $headers = [
        "Accept" => "*/*",
        "Connection" => "Keep-Alive",
        "User-Agent" => sprintf("curl/%s", curl_version()["version"])
    ];
    
    // open connection to Yahoo
    $context = stream_context_create([
        "http" => [
            "header" => implode(array_map(function($value, $key) { return sprintf("%s: %s\r\n", $key, $value); }, $headers, array_keys($headers))),
            "method" => "GET"
        ]
    ]);
    
    $query = rawurlencode($_GET["term"]);
    
    //$handle = @fopen("http://www.omdbapi.com/?s={$query}&y=&type=movie&plot=short&r=json", "r", false, $context);
    $handle = @fopen("http://www.imdb.com/xml/find?json=1&nr=1&tt=on&q={$query}", "r", false, $context);
    if ($handle === false)
    {
        // trigger (big, orange) error
        trigger_error("Could not connect to server!", E_USER_ERROR);
        exit;
    }
    
    $contents = stream_get_contents($handle);
    fclose($handle);
    
    $result = json_decode($contents, true);
    $list = (empty($result['title_exact'])) ? $result['title_popular'] : $result['title_exact'];
    foreach ($list as $key => $value){
        $list[$key]['value'] = $list[$key]['title'];
    }
    
    //print_r($list);
    //print($contents);
    print(json_encode($list, JSON_PRETTY_PRINT && JSON_UNESCAPED_UNICODE));
?>