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
  <li>Products</li>
  <li class="active">Categories</li>
</ol>
      <div class="jumbotron">
        <h2>Categories</h2>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;  Choose some products from the categories listed below:

        <?php
        $db = new DB;
        $cat = $_GET['cat'];

        if($cat != "all" || $cat !="") {
          $sql = "SELECT * from products where product_category = $cat";
          $result = $db->connection->query($sql);
          while ($row =$result->fetch_assoc()) {
            echo '<div class="col-md-4"><p>' . $row['category_description'] . '</p></div>';
          }
        } else {
          $sql = "SELECT * from product_categories";
          $result = $db->connection->query($sql);
        //  $result->fetch_assoc();
          //print_r($result);
          while ($row =$result->fetch_assoc()) {
            echo '<div class="col-md-4"><a href="categories.php?cat=' . $row['category_name'] .'">
            echo $row['category_description'] . '</a></div>';
          }
        }

        ?>
      </div>
</div>
</div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
