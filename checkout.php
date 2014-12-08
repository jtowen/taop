<?php
require_once 'includes/global.inc.php';
$db = new DB;
$user_ID = $user->UID;
$email = $user->email;
$firstName = $user->firstName;
$lastName = $user->lastName;
$address_street = $user->address_street;
$address_city = $user->address_city;
$address_state = $user->address_state;
$address_zip = $user->address_zip;
$phone = $user->phone;
$error = "";
$order_date = date("Y-m-d");
$order_price = "";
$order_name = "";
$order_street = "";
$order_city = "";
$order_state = "";
$order_zip = "";

if(isset($_POST['checkout'])) {


    $order_price = $_SESSION['subTotal'];
    $order_name = $_POST['order_name'];
    $order_street = $_POST['order_street'];
    $order_city = $_POST['order_city'];
    $order_state = $_POST['order_state'];
    $order_zip = $_POST['order_zip'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address_street = $_POST['address_street'];
    $address_city = $_POST['address_city'];
    $address_state = $_POST['address_state'];
    $address_zip = $_POST['address_zip'];
    $phone = $_POST['phone'];
    $sqlUser = "UPDATE users SET firstName = ?, lastName = ?, address_street = ?, address_city = ?,
    address_state = ?, address_zip = ?, phone = ? WHERE email = ? AND user_id = ?";

  if($stmt = $db->connection->prepare($sqlUser)) {
    $stmt->bind_param("sssssssss", $firstName, $lastName, $address_street, $address_city, $address_state, $address_zip, $phone, $email, $user_id);
    $stmt->execute();
    printf("Error: %s.\n", $stmt->error);
    $stmt->close();
  }
  $sqlOrder = "INSERT INTO orders (order_date, order_price, user_id, user_email, ship_name, ship_address, ship_city, ship_zip) values (?, ?, ?, ?, ?, ?, ?, ?)";
  if($stmt = $db->connection->prepare($sqlOrder)) {
    $stmt->bind_param("siisssss", $order_date, $order_price, $user_id, $user_email, $ship_name, $ship_address, $ship_city, $ship_zip);
    $stmt->execute();
    printf("Error: %s.\n", $stmt->error);
    $order_id = $stmt->insert_id;
  }
  $sqlOrderDetails = "INSERT INTO order_details (order_id, product_id, product_price, quantity) values (?, ?, ?, ?)";
  foreach($_SESSION['cart'] as $productID => $quantity){
    $result = $db->getProductInfo($productID);
    if($stmt = $db->connection->prepare($sqlOrderDetails)) {
    $stmt->bind_param("iisi", $order_id, $product_id, $product_price, $quantity);
    $stmt->execute();
    printf("Error: %s.\n", $stmt->error);
    $stmt->close();
    }
  //return $order_id;

}
}

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


          <?php
          if(empty($_SESSION['cart'])) {
          echo 'No items in your cart.  Please <a href="product.php">choose some</a> and the check back!';
          } else {
            echo'<table class="table table-striped">';
          echo'<th></th><th><br>Product Name</th><th><br>Quantity</th><th><br>Price</th><th></th>';
          $products_title = NULL;
          $products_price = NULL;
          $itemSubtotal = "0.00";
          $subTotal = "0.00";
          $numItems = 0;
          $sql = "SELECT products_id, products_title, products_price FROM products WHERE products_id = ?";
          $stmt = $db->connection->prepare($sql);

          foreach ($_SESSION['cart'] as $productID => $qty) {

            $stmt->bind_param("i", $productID);
            $stmt->execute();
            $stmt->bind_result($products_id, $products_title, $products_price);
            $stmt->fetch();

          $itemSubtotal = ($products_price * $qty);
          echo'<tr>';
            echo'<td class="col-md-3"></td>';
            echo'<td class="col-md-8">'. $products_title .'</a></td>';
            echo'<td>' .$qty. '</td>';
            echo'<td>$'. $itemSubtotal .'</td>';
            echo'<td></td>';
          echo'</tr>';

        }
          $numItems = $_SESSION['numItems'];
          $subTotal = $_SESSION['subTotal'];
        }
      ?>
          <tr>
            <td></td>
            <td>Totals:</td>
            <td><?php echo $numItems; ?></td>
            <td><?php echo $subTotal; ?></td>
            <td></td>
          </tr>
        </table>
        <div id="checkoutDiv">
        Please ensure the above order information is correct.  After this step, you will not be able to modify your order through the interactive
        online shopping cart system.  Once your information is confirmed, an order will be dispatched to your shipping address
        within three business days.
<form role="form-horizontal" id="myForm" name="myForm" action="checkout.php" method="post">
<fieldset>
<p class="text-center text-danger"><?php print $error; ?></p>

<div class="form-group" id="firstDiv">
<label for="firstName" class="col-sm-offset-1 col-sm-3 control-label">First Name:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="firstName" name="firstName" value=<?php echo '"'.$firstName.'";' ?> required>
</div>
</div>
<div class="form-group" id="lastDiv">
<label for="lastName" class="col-sm-offset-1 col-sm-3 control-label">Last Name:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="lastName" name="lastName" value=<?php echo '"'.$lastName.'";' ?> required>
</div>
</div>
<div class="form-group" id="addressDiv">
<label for="address_street" class="col-sm-offset-1 col-sm-3 control-label">Address:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="address_street" name="address_street" value=<?php echo '"'.$address_street.'";' ?>required>
</div>
</div>
<div class="form-group" id="cityDiv">
<label for="address_city" class="col-sm-offset-1 col-sm-3 control-label">City:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="address_city" name="address_city" value=<?php echo '"'.$address_city.'";' ?> required>
</div>
</div>
<div class="form-group" id="stateDiv">
<label for="address_state" class="col-sm-offset-1 col-sm-3 control-label">State:</label>
<div class="col-sm-8">
<select class="form-control" id="address_state" name="address_state" value=<?php echo '"'.$address_state.'";' ?>>
<option>TN</option>
<option>GA</option>
<option>SC</option>
<option>NC</option>
<option>AL</option>
</select>
</div>
</div>
<div class="form-group" id="zipDiv">
<label for="address_zip" class="col-sm-offset-1 col-sm-3 control-label">Zip Code:</label>
<div class="col-sm-8">
<input type="text" class="form-control" id="address_zip" name="address_zip" value=<?php echo '"'.$address_zip.'";' ?> required>
</div>
</div>
<div class="form-group" id="phoneDiv">
<label for="phone" class="col-sm-offset-1 col-sm-3 control-label">Phone #:</label>
<div class="col-sm-8">
<input type="tel"  class="form-control" id="phone" name="phone" value=<?php echo '"'.$phone.'";' ?> required>
</div>
</div>


  <div class="form-group" id="order">
  <label for="order_name" class="col-sm-offset-1 col-sm-3 control-label"Ship To Name:</label>
  <div class="col-sm-8">
  <input type="text"  class="form-control" id="order_name" name="order_name" value=<?php echo '"'.$order_name.'";' ?> required>
  </div>
  </div>

  <div class="form-group" id="order_streetDiv">
  <label for="order_street" class="col-sm-offset-1 col-sm-3 control-label">Ship To Street:</label>
  <div class="col-sm-8">
  <input type="text"  class="form-control" id="order_street" name="order_street" value=<?php echo '"'.$order_street.'";' ?> required>
  </div>
  </div>

  <div class="form-group" id="order_cityDiv">
  <label for="order_city" class="col-sm-offset-1 col-sm-3 control-label">Ship To City:</label>
  <div class="col-sm-8">
  <input type="text"  class="form-control" id="order_city" name="order_city" value=<?php echo '"'.$order_city.'";' ?> required>
  </div>
  </div>

  <div class="form-group" id="order_stateDiv">
  <label for="order_state" class="col-sm-offset-1 col-sm-3 control-label">Ship To State:</label>
  <div class="col-sm-8">
  <input type="text"  class="form-control" id="order_state" name="order_state" value=<?php echo '"'.$order_state.'";' ?> required>
  </div>
  </div>
  <div class="form-group" id="order_zipDiv">
  <label for="order_zip" class="col-sm-offset-1 col-sm-3 control-label">Ship To Zip:</label>
  <div class="col-sm-8">
  <input type="text"  class="form-control" id="order_zip" name="order_zip" value=<?php echo '"'.$order_zip.'";' ?> required>
  </div>
  </div>







<div class = "col-sm-offset-5 col-sm-4">  <button type="submit" class="btn btn-lg btn-primary btn-block" value="Update" name="submit-form" />Update</button>
  <button type="submit" class="btn btn-lg btn-primary btn-block" value="chechout" name="checkout" />Checkout</button>
</div>

</fieldset>
</form><?php print $error; ?>



      </div>
</div>
</div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
