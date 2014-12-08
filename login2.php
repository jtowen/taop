
<?php
// login.php
// Provides a form for users to attempt to login to
// the system. It uses UserTools to check credentials.
//
require_once 'includes/global.inc.php';
$error = "";
$email = "";
$password = "";
//check to see if they've submitted the login form
if(isset($_POST['submit-login'])) {
$email = $_POST['email'];
$password = $_POST['password'];
$userTools = new UserTools();
if($userTools->login($email, $password)){
//successful login, redirect them to a page
header("Location: index.php");
}
else{
$error = "<h2 class=\"text-danger\" style=\"text-align: center\">Incorrect username or password. Please try again.</h2>";
}
}
?><!DOCTYPE html>
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
require("topbar.php");
?> 
<?php
require("sidebar.php");
?> 

<div class="col-md-9">
<ol class="breadcrumb">
  <li><a href="./index.html">Home</a></li>
  <li class="active">Login</li>
</ol>
      <div class="jumbotron">
        <h2>Please Log In</h2>
        
<form class="form-signin" action="login.php" method="post">
<input type="text" class="form-control" placeholder="Email Address" value="<?php echo $email; ?>" autofocus name="email" /><br>
<input type="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>" name="password" />
<button type="submit" class="btn btn-lg btn-primary btn-block" value="Submit" name="submit-login" />Login</button>
</form>
<?php
echo $error."<br/>";
?>
          
      </div>
</div>
</div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>
   
  </body>
</html>
