<?php
require_once 'includes/global.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      $db = new DB;
      $cat = (isset($_GET['cat'])) ? $_GET['cat'] : "";
    ?>
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
  <li><a href="./index.php">Home</a></li>
  <li><a href="product.php">Products</a></li>
  <li class="active">
  <?php
  $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

  ?>
  </li>
    <?php
    $sql = "SELECT category_name, category_description from product_categories where category_name = '$cat'";
    $result = $db->connection->query($sql);
      while($cats = $result->fetch_assoc()) {
        //print_r($cats);
        echo '<a href="product.php?cat='. $cats['category_name'].'">';
        echo $cats['category_description'] . '</a>';
      }
      $result->close();


    ?>
  </li>
</ol>
      <div class="container-fluid">

        <?php

        //if($_GET['cat']) {
          //$cat = $_GET['cat'];
        //}
        if($cat != "all" && $cat !="") {
          echo '<h2>Products</h2>';

          echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;  Choose a product from the listing page to view details:</p>';
          $sql = "SELECT * from products where products_category = '$cat'";
          $result = $db->connection->query($sql);
          while ($row=$result->fetch_assoc()) {
            echo '<div class="col-md-4"><a href="productDetails.php?PID='. $row['products_id'] .'">';
            echo '<img src="' . $row['products_image'] . '" class="img-responsive" alt=" ' . $row['products_title'] . ' ">';
            echo '<h5><span>' . $row['products_title'] . '</span><span class="pull-right"><small>$' . $row['products_price'] . '</small></span></h5></a>';
            if(isset($_SESSION['logged_in']) && $user->userPriv = "A"){
            echo '<div><span class="col-sm-6"><h6 class="text-center"><a href="manageProducts.php?PID='. $row['products_id'] .'"><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span>edit</button></a></h6></span>';
            echo '<form id="deleteForm" method="post" action="manageProducts.php"><input type="hidden" name="operation" value="delete"><input type="hidden" id="products_id" name="products_id" value="'. $row['products_id'] .'">';
            echo '<input type="hidden" name="referer" value="'. $_SERVER['REQUEST_URI'] .'">';
            echo '<span class="col-sm-6"><h6 class="text-center"><button type="submit" name="submit-form" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span>delete</button></h6></span></div>';
            }
            echo '</div>';
          }
        } else {
          echo '<h3>Categories</h3>';

          echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;  Choose some products from the categories listed below:</p>';
          $sql = "SELECT * from product_categories";
          $result = $db->connection->query($sql);
          //  $result->fetch_assoc();
          //print_r($result);
          while ($row=$result->fetch_assoc()) {
            echo '<div class="col-md-4"><a href="product.php?cat=' . $row['category_name'] .'">';
            echo '<img src="' . $row['image_location'] . '" class="img-responsive" alt=" ' . $row['category_description'] . ' ">';
            echo '<p class="text-center">'.$row['category_description'] . '</p></a></div>';
          }
        }

        ?>

</div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
