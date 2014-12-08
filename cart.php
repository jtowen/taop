<?php
require_once 'includes/global.inc.php';
$db = new DB;
@$cartItem = $_POST['prodID'];
@$quant = $_POST['qty'];
@$operation = $_POST['operation'];
@$key = $_POST['key'];
//if($cartItem) {
if(isset($_POST['submit-form'])) {
  if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    $_SESSION['numItems'] = 0;
    $_SESSION['totalPrice'] = '0.00';
  }
/*  if(isset($_SESSION['cart'][$cartItem])) {
    $_SESSION['cart'][$cartItem]++;
  } else {
    $_SESSION['cart'][$cartItem] = 1;
  }*/
  if(isset($_SESSION['cart'][$cartItem])) {
    $_SESSION['cart'][$cartItem] = $_SESSION['cart'][$cartItem] + $quant;
  } else {
    $_SESSION['cart'][$cartItem] = $quant;
  }
  //$_SESSION['numItems'] =  getNumItems($_SESSION['cart']);
  //$_SESSION['totalPrice'] = getTotalPrice($_SESSION['cart']);
}

//if(isset($_POST['updateCart'])) {
if($operation == "updateCart")  {
  foreach ($_SESSION['cart'] as $prodID => $qty) {
    if($_POST[$prodID] == "0") {
      unset ($_SESSION['cart'][$prodID]);
    } else {
      $_SESSION['cart'][$prodID] = $_POST[$prodID];
    }
  }
  //$_SESSION['numItems'] =  getNumItems($_SESSION['cart']);
  //$_SESSION['totalPrice'] = getTotalPrice($_SESSION['cart']);
}

if($operation == "delete")  {
unset ($_SESSION['cart'][$key]);
} else if($operation == "deleteAll")  {
unset ($_SESSION['cart']);
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
    <script>
    function doClick(operation, key) {
    myForm = document.getElementById("myForm");
    myOperation = document.getElementById("myOperation");
    myKey = document.getElementById("myKey");
    myOperation.value = operation;
    myKey.value = key;
    myForm.submit();
    }
    </script>
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
<!-- Table -->
<form id="myForm" method="post" action="cart.php">

<?php
if(empty($_SESSION['cart'])) {
echo 'No items in your cart.  Please <a href="product.php">choose some</a> and the check back!';
} else {
  echo'<table class="table table-striped">';
echo'<th><button type="button" class="btn btn-default btn-sm" onclick=doClick(\'deleteAll\', \'null\');><span class="glyphicon glyphicon-remove"></span></button><h6>Remove All</h6></th><th><br>Product Name</th><th><br>Quantity</th><th><br>Price</th><th></th>';
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
$subTotal += $itemSubtotal;
$numItems += $qty;

echo'<tr>';
  echo'<td class="col-md-3"><button type="button" class="btn btn-default btn-sm" onclick="doClick(\'delete\',' . $products_id . ');"><span class="glyphicon glyphicon-remove"></span></button><h6>Remove</h6></td>';
  echo'<td class="col-md-8"><a href="productDetails.php?PID='.$products_id.'">'. $products_title .'</a></td>';
  echo'<td><input type="text" name="' .$productID. '" value="' .$qty. '" size="4"></td>';
  echo'<td>$'. $itemSubtotal .'</td>';
  echo'<td></td>';
echo'</tr>';
}
$_SESSION['numItems'] = $numItems;
$_SESSION['subTotal'] = $subTotal;
}


?>
</table>
<input type="hidden" id="myOperation" name="operation">
<input type="hidden" id="myKey" name="key">
<button type="button" class="btn btn-default btn-sm" onclick="doClick('updateCart', null);">Update Cart</button>
</form>
<form id="checkout" method="post" action="checkout.php">

<button type="submit" class="btn btn-lg btn-primary btn-block" value="checkout" name="submit-form" />Checkout</button>

</form>
      </div>
</div>
</div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
