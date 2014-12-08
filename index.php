<?php
require_once 'includes/global.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>

  <title>T.A.O.P. - Turtley Awesome Outdoor Products</title>

    <!-- Bootstrap core CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="newnav.css" rel="stylesheet">
	 </head>

  <body>
<div class="container">
<?php
require("includes/topbar.inc.php");
?>
<?php
require("includes/sidebar.inc.php");
?>

<div class="col-md-9">
<ol class="breadcrumb">
  <li><a href="./index.html">Home</a></li>
  <li class="active">Welcome!</li>
</ol>
      <div class="jumbotron">
        <h2>Welcome</h2>
        
        <p><?php print $_SESSION['userID'] . " " . $_SESSION['UID'];
        print_r($user);
        ?>
          &nbsp;&nbsp;&nbsp;&nbsp;This site's purpose is to demonstrate and make available gear that can be used to lighten your load while in the great outdoors.  We specialize in hammocks and items used in conjunction with them.  If you'd like to learn a little about how all this works,
		just click the "more info" button below.  If you're ready to see what's available here, check out the store!  We also have fabric samples available for the do-it-yourself types out there.  Happy Hangin'!</p>
        <p>
          <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">More Info &raquo;</a>
		  <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">Start Shopping &raquo;</a>
        </p>
      </div>
</div>
</div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
