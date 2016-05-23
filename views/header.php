<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Watched! - <?= htmlspecialchars($title); ?></title>
    
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/theme.css" rel="stylesheet">
    
    <link href="css/jquery-ui.css" rel="stylesheet">
    
    <link href="css/styles.css" rel="stylesheet">
    
    <!-- http://jquery.com/ -->
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/js/jquery-ui.js"></script>

    <!-- http://getbootstrap.com/ -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body role="document">
    
    <?php if (!empty($_SESSION["id"])): ?>
    
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header"><span class="navbar-brand" href="#">Hello, <?= $_SESSION["username"]; ?></span></div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="<?= ($_SERVER['REQUEST_URI']=='/add.php') ? "active" : "" ?>"><a href="add.php">Add Movie</a></li>
            <li class="<?= ($_SERVER['REQUEST_URI']=='/list.php') ? "active" : "" ?>"><a href="list.php">Your List</a></li>
            <li class="<?= ($_SERVER['REQUEST_URI']=='/timeline.php') ? "active" : "" ?>"><a href="timeline.php">Timeline</a></li>
            <li class="<?= ($_SERVER['REQUEST_URI']=='/users.php') ? "active" : "" ?>"><a href="users.php">Users</a></li>
            <li class="<?= ($_SERVER['REQUEST_URI']=='/statistic.php') ? "active" : "" ?>"><a href="statistic.php">Statistic</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Log Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <?php endif; ?>
    
    <div class="container theme-showcase" role="main">
      <div class="jumbotron">
        <h1>Watched!</h1>
        <?php if (empty($_SESSION["id"])): ?>
          <p>Welcome to the Watched! website. Here you can easily add all movies you had watched, rate them, see what other users like, and get some interesting statistical data.</p>
        <?php endif; ?>
      </div>