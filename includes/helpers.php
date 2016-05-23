<?php

    require_once("config.php");

    /**
     * Facilitates debugging by dumping contents of argument(s)
     * to browser.
     */
    function dump()
    {
        $arguments = func_get_args();
        require("../views/dump.php");
        exit;
    }
    
    /**
     * Proceeds errors
     */
    function error($message, $title, $error_box = 'errors1')
    {
        // $GLOBALS[$error_box][] = $message;
        
        // dump($GLOBALS);
        
        render(substr($_SERVER["PHP_SELF"], 1), ['title' => $title, $error_box => $message]); // /login.php -> login.php
    }
    
    /**
     * Checks the correctness of given email
     */
    function validate_email($email) 
    {
        return preg_match('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email);
    }


    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }


    /**
     * Redirects user to location, which can be a URL or
     * a relative path on the local host.
     *
     * http://stackoverflow.com/a/25643550/5156190
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($location)
    {
        if (headers_sent($file, $line))
        {
            trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
        }
        header("Location: {$location}");
        exit;
    }

    /**
     * Renders view, passing in values.
     */
    function render($view, $values = [])
    {
        // if view exists, render it
        if (file_exists("../views/{$view}"))
        {
            // extract variables into local scope
            extract($values);

            // render view (between header and footer)
            require("../views/header.php");
            require("../views/{$view}");
            require("../views/footer.php");
            exit;
        }

        // else err
        else
        {
            trigger_error("Invalid view: {$view}", E_USER_ERROR);
        }
    }
    
    function convert_runtime($str){
        $minutes = 0;
        preg_match("/^((?P<hours>\d+)h)?\s+(?P<minutes>\d+)min$/", $str, $match);
        //print_r($match);
        
        if (!empty($match['hours']))
            $minutes += (int)$match['hours'] * 60;
        if (!empty($match['minutes']))
            $minutes += (int)$match['minutes'];
            
        return $minutes;
    }
?>
