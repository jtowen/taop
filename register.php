<?php
// register.php
// Register a user in the system to allow them
// to login.
//
require_once 'class/Db.class.php';
require_once 'class/User.class.php';
$db = new DB;
//get the user object from the session
//$userID = $_SESSION["user_ID"];
//$userID = 0;
//$uTool = new UserTools();
//$user = $uTool->get($userID);
// This function is only available to administrators.
//if ($user->userPriv != 'A') {
//header("Location: login.php");
//}
//initialize php variables used in the form
$password = "";
$password_confirm = "";
$error = "";
$email = "";
$firstName = "";
$lastName = "";
$address_street = "";
$address_city = "";
$address_state = "";
$address_zip = "";
$phone = "";
//check to see that the form has been submitted
if(isset($_POST['submit-form'])) {
//retrieve the $_POST variables

$password = $_POST['password'];
$password_confirm = $_POST['password-confirm'];
$email = $_POST['email'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$address_street = $_POST['address_street'];
$address_city = $_POST['address_city'];
$address_state = $_POST['address_state'];
$address_zip = $_POST['address_zip'];
$phone = $_POST['phone'];
//initialize variables for form validation
$success = true;
//$userTools = new UserTools();
//validate that the form was filled out correctly
//check to see if user name already exists
if($db->checkEmailExists($email)) {
    $success = false;
    $error .= "That email already exists.  Please use another.<br/> \n\r";
}
//check to see if passwords match
if($password != $password_confirm) {
$error .= "Passwords do not match.<br/> \n\r";
$success = false;
}
if($success)
{
  $pswd = md5($password);
  //$db->insertUser2($email,$pswd,$firstName,$lastName,$address_street,$address_city,$address_state,$address_zip);
//prep the data for saving in a new user object

$data['firstName'] = $firstName;
$data['lastName'] = $lastName;
$data['address_street'] = $address_street;
$data['address_city'] = $address_city;
$data['address_state'] = $address_state;
$data['address_zip'] = $address_zip;
$data['email'] = $email;
$data['phone'] = $phone;
$data['password'] = md5($password); //encrypt the password for storage

$a_param_type = array("s", "s", "s", "s", "s", "s", "s", "s", "s");
$data_for_bind=array_values($data);
$userID = $db->prep($data_for_bind, $a_param_type);
echo $userID;
//log them in
//$userTools->login($email, $password);
//redirect them to the main page
//header("Location: index.php");
//$db->insertUser($data, "users");
//$error = $db->errorMsg;
//*/
}
}
//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>



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
  <li class="active">Register</li>
</ol>
      <div class="jumbotron">

        <h2>Registration</h2>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;Please fill out the form below to register for an account with TAOP.  Your username is your email address, and the password must be 8 or more characters long.  We use account information strictly for ordering purposes, and never sell your information to anyone else.  </p>

<form role="form-horizontal" id="myForm" name="myForm" action="register.php" method="post">
<fieldset>
  <p class="text-center text-danger"><?php print $error; ?></p>
<div class="form-group" id="emailDiv">
	<label for="email" class="col-sm-offset-1 col-sm-2 control-label">Email Address:</label>
	 	<div class="col-sm-8">
		<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
		<h6>Your email address will be your username.</h6>
		</div>
	</div>
<div class="form-group" id="passwordDiv">
	<label for="password" class="col-sm-offset-1 col-sm-2 control-label">Password:</label>
	 	<div class="col-sm-8">
		<input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
		</div>
	</div>
<div class="form-group" id="cpasswordDiv">
	<label for="password-confirm" class="col-sm-3 control-label">Confirm Password:</label>
	 	<div class="col-sm-8">
		<input type="password" class="form-control" id="password-confirm" name="password-confirm" value="<?php echo $password; ?>" required>
		</div>
	</div>
<div class="form-group" id="firstDiv">
	<label for="firstName" class="col-sm-offset-1 col-sm-2 control-label">First Name:</label>
	 	<div class="col-sm-8">
		<input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>
		</div>
	</div>
<div class="form-group" id="lastDiv">
	<label for="lastName" class="col-sm-offset-1 col-sm-2 control-label">Last Name:</label>
		<div class="col-sm-8">
		<input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>
		</div>
	</div>
<div class="form-group" id="addressDiv">
	<label for="address_street" class="col-sm-offset-1 col-sm-2 control-label">Address:</label>
		<div class="col-sm-8">
		<input type="text" class="form-control" id="address_street" name="address_street" value="<?php echo $address_street; ?>"required>
		</div>
	</div>
<div class="form-group" id="cityDiv">
	<label for="address_city" class="col-sm-offset-1 col-sm-2 control-label">City:</label>
		<div class="col-sm-8">
		<input type="text" class="form-control" id="address_city" name="address_city" value="<?php echo $address_city; ?>" required>
		</div>
	</div>
<div class="form-group" id="stateDiv">
	<label for="address_state" class="col-sm-offset-1 col-sm-2 control-label">State:</label>
		<div class="col-sm-8">
<select class="form-control" id="address_state" name="address_state" value="<?php echo $address_state; ?>">
  <option>TN</option>
  <option>GA</option>
  <option>SC</option>
  <option>NC</option>
  <option>AL</option>
</select>
		</div>
	</div>
<div class="form-group" id="zipDiv">
	<label for="address_zip" class="col-sm-offset-1 col-sm-2 control-label">Zip Code:</label>
		<div class="col-sm-8">
		<input type="text" class="form-control" id="address_zip" name="address_zip" value="<?php echo $address_zip; ?>" required>
		</div>
	</div>
<div class="form-group" id="phoneDiv">
  <label for="phone" class="col-sm-offset-1 col-sm-2 control-label">Phone #:</label>
     <div class="col-sm-8">
    <input type="tel"  class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
    </div>
  </div>


      <div class = "col-sm-offset-5 col-sm-4">  <button type="submit" class="btn btn-lg btn-primary btn-block" value="Register" name="submit-form" />Submit</button>
	</div>

</fieldset>
</form><?php print $error; ?>
</div>
	</div><!-- /jumbo -->
	</div><!-- /col-md-9 -->
 </div><!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
