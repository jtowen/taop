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
        <h2>Delete successful.</h2>

        <p><a href="<?php echo$_SESSION['referer']; ?>">click here to continue</a.>        </p>
      </div>
</div>
</div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
