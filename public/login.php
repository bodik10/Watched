<?php
  // configuration
  require("../includes/config.php"); 
  
  if ($_SERVER["REQUEST_METHOD"] == "GET")
  {
      // else render form
      render("login.php", ["title" => "Log In"]);
  }

  // else if user reached page via POST (as by submitting a form via POST)
  else if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
      // if user tried to log in
      if ($_POST["type"] == 'login')
      {
          // query database for user
          $rows = CS50::query("SELECT * FROM users WHERE email = ?", $_POST["login-email"]);
  
          // if we found user, check password
          if (count($rows) == 1)
          {
              // first (and only) row
              $row = $rows[0];
  
              // compare hash of user's input against hash that's in database
              if (password_verify($_POST["login-password"], $row["hash"]))
              {
                  // remember that user's now logged in by storing user's ID in session
                  $_SESSION["id"] = $row["id"];
                  $_SESSION["username"] = $row["name"];
  
                  redirect("/");
              }
          }
          
          error("Invalid email or password. Try again!", "Log In");
        
      }
      
      // or to register
      else if ($_POST["type"] == 'register')
      {
          if (empty($_POST['reg-name']) || empty($_POST['reg-password']) || empty($_POST['reg-email']))
              error("You haven't filled name, password or email", "Log In", "errors2");
            
          if ($_POST['reg-password'] != $_POST['reg-password2'])
              error("Passwords in both fields are not the same", "Log In", "errors2");
              
          $query = CS50::query("INSERT IGNORE INTO users (email, name, hash) VALUES(?, ?, ?);", $_POST["reg-email"], strip_tags($_POST["reg-name"]), password_hash($_POST["reg-password"], PASSWORD_DEFAULT));
          
          if (!$query)
              error("Sorry, that user already exists", "Log In", "errors2");
              
          $warnings = "Done! You've succesfully signed-up. Now you can log in via left form with your email and password.";
          
          render("login.php", ["warnings" => $warnings]);
      }
  }
?>

      
      
