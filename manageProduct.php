<?php
require_once 'includes/global.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      $db = new DB;
      $PID = (isset($_GET['PID'])) ? $_GET['PID'] : "";
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
    $operation = (isset($_POST['operation'])) ? $_POST['operation'] : "null";
    $formgen = array("products_title" => "Product Name:",
                  "products_quantity" => "Quantity Available:",
                  "products_image" => "Image URL location:",
                  "products_price" => "Price:",
                  "products_date_available" => "Date Available (YYYY:MM:DD)",
                  "products_shipping_exception" => "Abnormal Shipping?(yes or no)",
                  "product_weight" => "Weight:",
                  "product_length" => "Length:",
                  "product_width" => "Width:",
                  "product_height" => "Height:",
                  "product_material" => "Materials:"

    );
    if(isset($_POST['submit-form'])) {


        $products_id = (isset($_POST['products_id'])) ? $_POST['products_id'] : "";
        $products_quantity = $_POST['products_quantity'];
        $products_category = (isset($_POST['products_category'])) ? $_POST['products_category'] : "";
        $products_image = $_POST['products_image'];
        $products_price = $_POST['products_price'];
        $products_date_added = (isset($_POST['products_date_added'])) ? $_POST['products_date_added'] : "";
        $products_last_modified = (isset($_POST['products_last_modified'])) ? $_POST['products_last_modified'] : "";
        $products_date_available = (isset($_POST['products_date_available'])) ? $_POST['products_date_available'] : "";
        $products_shipping_exception  = $_POST['products_shipping_exception'];
        $products_description = (isset($_POST['products_description'])) ? $_POST['products_description'] : "";
        $products_title = $_POST['products_title'];
        $category_description = (isset($_POST['category_description'])) ? $_POST['category_description'] : "";
        $product_weight = $_POST['product_weight'];
        $product_length = $_POST['product_length'];
        $product_width = $_POST['product_width'];
        $product_height = $_POST['product_height'];
        $product_material = $_POST['product_material'];

      }
//print $_POST["operation"];
      if($operation == "add") {
      $sql = "SELECT category_description from product_categories where category_name = ?";
      if($stmt = $db->connection->prepare($sql)) {
        $stmt->bind_param('s', $products_category);
        $stmt->execute();
        $stmt->bind_result($category_description);
        $stmt->fetch();
        $stmt->close();
      }
        $sql1 = "INSERT INTO products (products_quantity, products_category, products_image, products_price, products_last_modified, products_date_available, products_shipping_exception, products_description, products_title, category_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if($stmt = $db->connection->prepare($sql1)) {
        $stmt->bind_param('ississssss',$products_quantity,$products_category,$products_image,
          $products_price,$products_last_modified,$products_date_available,
          $products_shipping_exception,$products_description,$products_title,$category_description);
        $stmt->execute();
        printf("Error: %s.\n", $stmt->error);
        $product_attr_id = $stmt->insert_id;
        $stmt->close();
      }
      $sql2 = "INSERT INTO product_attributes (product_id, product_weight,
        product_length, product_width, product_height, product_material)
        VALUES (?, ?, ?, ?, ?, ?)";
        if($stmt = $db->connection->prepare($sql2)) {
        $stmt->bind_param('isssss',$product_attr_id, $product_weight,
          $product_length, $product_width, $product_height, $product_material);
        $stmt->execute();
        printf("Error: %s.\n", $stmt->error);
        $stmt->close();
      }
      } else if ($operation == 'update') {

      } else {




      }
      print_r($_POST);
    ?>
  </li>
</ol>
      <div class="container-fluid">
        <form role="form-horizontal" id="myForm" name="myForm" class="form-horizontal" action="manageProduct.php" method="post">
        <fieldset>

        <label for="products_category" class="col-sm-4 control-label">Category:</label>
          <div class="col-sm-8">
        <select class="form-control" id="products_category" name="products_category" value="<?php echo $category_name; ?>">

        <?php
        $sql = "SELECT * from product_categories";
        if($result = $db->connection->query($sql)) {
          while($row = $result->fetch_assoc()) {
          echo '<option value="'. $row['category_name'] .'">'. $row['category_description'] .'</option>';
          }
        }
        ?>
        </select>
          </div>
        </div>
        <?php

        foreach ($formgen as $key => $value) {
          echo '<div class="form-group" id="'.$key.'Div">';
            echo '<label for="'.$key.'" class="col-sm-4 control-label text-right">'. $value .'</label>';
              echo '<div class="col-sm-8">';
              echo '<input type="text" class="form-control" id="'.$key.'" name="'.$key.'" value="$'. $key .'">';
              echo '</div></div>';
        }
        ?>
      <div class="form-group" id="descDiv">
        <label for="products_description" class="col-sm-4 control-label text-right">Product Description:</label>
          <div class="col-sm-8">
            <textarea name="products_description" id="products_description" rows="4" class="form-control"></textarea>
          </div></div>
      <input type="hidden" id="operation" name="operation" value="add">
      <div class = "col-sm-offset-5 col-sm-4">  <button type="submit" class="btn btn-lg btn-primary btn-block" value="Register" name="submit-form" />Submit</button>
      </div>

      </fieldset>
      </form>

      </div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
