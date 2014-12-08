<?php
session_start();
require_once 'includes/global.inc.php';

$PID = (isset($_POST['PID'])) ? $_POST['PID'] : "";
$qty = (isset($_POST['qty'])) ? $_POST['qty'] : "";
if(isset($_POST["operation"]) && $_POST["operation"]=='addToCart') {
    $sql = "SELECT products_id, products_title, products_price from products where products_id = '$PID'";
    if($result = $db->connection->query($sql)) {
      while($row = $result->fetch_assoc()) {
        $PID = $row['products_id'];
        $name = $row['products_title'];
        $price = $row['products_price'];
      }
    }



    $sql = "INSERT INTO cart_items (product_name, product_id, product_price, cart_qty) VALUES ('$name', '$PID', '$price', '$qty')";
}
$SESSION['$turtle']='turtle1';
print_r($_SESSION);

?>
