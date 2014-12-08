<?php
require_once 'includes/global.inc.php';
$db = new DB;
$PID = (isset($_GET['PID'])) ? $_GET['PID'] : "";
$operation = (isset($_POST['operation'])) ? $_POST['operation'] : "null";
$products_id = "";
$products_quantity = "";
$products_category ="";
$products_image =  "";
$products_price = "";
$products_date_added =  "";
$products_last_modified =  "";
$products_date_available = "";
$products_shipping_exception  = "";
$products_description = "";
$products_title = "";
$category_description = "";
$product_weight = "";
$product_length = "";
$product_width = "";
$product_height = "";
$product_material = "";

if($PID != "") {
  $sql = "SELECT * from products where products_id = '$PID'";
  if($result = $db->connection->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $products_id = $row['products_id'];
        $products_quantity = $row['products_quantity'];
        $products_category = $row['products_category'];
        $products_image = $row['products_image'];
        $products_price = $row['products_price'];
        $products_date_added = $row['products_date_added'];
        $products_last_modified = $row['products_last_modified'];
        $products_date_available = $row['products_date_available'];
        $products_shipping_exception  = $row['products_shipping_exception'];
        $products_description = $row['products_description'];
        $products_title = $row['products_title'];
        $category_description = $row['category_description'];

    }
  }

  $sql = "SELECT * from product_attributes where product_id = '$PID'";
  if($result = $db->connection->query($sql)) {
    while ($row = $result->fetch_assoc()) {
          $product_weight = $row['product_weight'];
          $product_length = $row['product_length'];
          $product_width = $row['product_width'];
          $product_height = $row['product_height'];
          $product_material = $row['product_material'];
    }
  }



}
if(isset($_POST['submit-form'])) {
        $products_id = (isset($_POST['products_id'])) ? $_POST['products_id'] : "";
        $products_quantity = (isset($_POST['products_quantity'])) ? $_POST['products_quantity'] : "";
        $products_category = (isset($_POST['products_category'])) ? $_POST['products_category'] : "";
        $products_image = (isset($_POST['products_image'])) ? $_POST['products_image'] : "";
        $products_price = (isset($_POST['products_price'])) ? $_POST['products_price'] : "";
        $products_date_added = (isset($_POST['products_date_added'])) ? $_POST['products_date_added'] : "";
        $products_last_modified = (isset($_POST['products_last_modified'])) ? $_POST['products_last_modified'] : "";
        $products_date_available = (isset($_POST['products_date_available'])) ? $_POST['products_date_available'] : "";
        $products_shipping_exception  = (isset($_POST['products_shipping_exception'])) ? $_POST['products_shipping_exception'] : "";
        $products_description = (isset($_POST['products_description'])) ? $_POST['products_description'] : "";
        $products_title = (isset($_POST['products_title'])) ? $_POST['products_title'] : "";
        $category_description = (isset($_POST['category_description'])) ? $_POST['category_description'] : "";
        $product_weight = (isset($_POST['product_weight'])) ? $_POST['product_weight'] : "";
        $product_length = (isset($_POST['product_length'])) ? $_POST['product_length'] : "";
        $product_width = (isset($_POST['product_width'])) ? $_POST['product_width'] : "";
        $product_height = (isset($_POST['product_height'])) ? $_POST['product_height'] : "";
        $product_material = (isset($_POST['product_material'])) ? $_POST['product_material'] : "";



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
        $sql = "SELECT category_description from product_categories where category_name = ?";
        if($stmt = $db->connection->prepare($sql)) {
          $stmt->bind_param('s', $products_category);
          $stmt->execute();
          $stmt->bind_result($category_description);
          $stmt->fetch();
          $stmt->close();
        }
      $product_params = array($products_quantity,$products_category,$products_image,
                            $products_price,$products_last_modified,$products_date_available,
                            $products_shipping_exception,$products_description,$products_title, $category_description, $products_id);
      $product_param_type = array("i", "s", "s", "s", "s", "s", "s", "s", "s", "s", "i");

        $productAttr_params = array($product_weight,
                                $product_length, $product_width, $product_height, $product_material, $products_id);
        $productAttr_param_type = array("s", "s", "s", "s", "s", "i");

        if($db->updateProduct($product_params, $product_param_type)) {
          echo 'Product record successfully updated';
            if($db->updateProductAttr($productAttr_params, $productAttr_param_type)){
              echo 'Product Attribute record successfully updated';
              header("Location: productDetails.php");
              } else {
                printf("Error: %s.\n", $db->stmt->error);
              }

        } else {
          printf("Error: %s.\n", $db->stmt->error);
        }

      } else if($operation == 'delete'){
       $sql = "DELETE from products where products_id = '$products_id'";
       if($result = $db->connection->query($sql)){
         $_SESSION['deleteSuccess'] = true;
       } else {
         //printf("Error: %s.\n", $db->connection->error);
       }
         $_SESSION['referer'] = $_POST['referer'];
         //echo $curURL;
         //echo ' post  referer: ';
         //echo $_POST['referer'];
         header("Location: dsuccess.php");
        }
      }
?>
<?php

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php



    ?>
  <title>T.A.O.P. - Turtley Awesome Outdoor Products</title>
<?php
if($user->userPriv != "A"){
//successful login, redirect them to a page
//header("Location: index.php");
}
?>
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
  <li class="active">Insert/Update/Delete</li>
    <?php

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

    //  print_r($_POST);
    ?>
  </li>
</ol>
      <div class="container-fluid">
        <form role="form-horizontal" id="myForm" name="myForm" class="form-horizontal" action="manageProducts.php" method="post">
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

        <div class="form-group" id="products_titleDiv">
          <label for="products_title" class="col-sm-4 control-label text-right">Product Name:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="products_title" name="products_title" value="<?php echo $products_title; ?>">
          </div>
        </div>
        <div class="form-group" id="products_quantityDiv">
          <label for="products_quantity" class="col-sm-4 control-label text-right">Quantity Available:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="products_quantity" name="products_quantity" value="<?php echo $products_quantity; ?>">
          </div>
        </div>
        <div class="form-group" id="products_imageDiv">
          <label for="products_image" class="col-sm-4 control-label text-right">Image URL location:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="products_image" name="products_image" value="<?php echo $products_image; ?>">
          </div>
        </div>
        <div class="form-group" id="products_priceDiv">
          <label for="products_price" class="col-sm-4 control-label text-right">Price:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="products_price" name="products_price" value="<?php echo $products_price; ?>">
          </div>
        </div>
        <div class="form-group" id="products_date_availableDiv">
          <label for="products_date_available" class="col-sm-4 control-label text-right">Date Available (YYYY:MM:DD)</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="products_date_available" name="products_date_available" value="<?php echo $products_date_available; ?>">
          </div>
        </div>
        <div class="form-group" id="products_shipping_exceptionDiv">
          <label for="products_shipping_exception" class="col-sm-4 control-label text-right">Abnormal Shipping?(yes or no)</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="products_shipping_exception" name="products_shipping_exception" value="<?php echo $products_shipping_exception; ?>">
          </div>
        </div>
        <div class="form-group" id="product_weightDiv">
          <label for="product_weight" class="col-sm-4 control-label text-right">Weight:</label>
          <div class="col-sm-8"><input type="text" class="form-control" id="product_weight" name="product_weight" value="<?php echo $product_weight; ?>">
        </div>
      </div>
      <div class="form-group" id="product_lengthDiv">
        <label for="product_length" class="col-sm-4 control-label text-right">Length:</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="product_length" name="product_length" value="<?php echo $product_length; ?>">
        </div>
      </div>
      <div class="form-group" id="product_widthDiv">
        <label for="product_width" class="col-sm-4 control-label text-right">Width:</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="product_width" name="product_width" value="<?php echo $product_width; ?>">
        </div>
      </div>
      <div class="form-group" id="product_heightDiv">
        <label for="product_height" class="col-sm-4 control-label text-right">Height:</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="product_height" name="product_height" value="<?php echo $product_height; ?>">
        </div>
      </div>
      <div class="form-group" id="product_materialDiv">
        <label for="product_material" class="col-sm-4 control-label text-right">Materials:</label>
        <div class="col-sm-8">
          <input type="text" class="form-control" id="product_material" name="product_material" value="<?php echo $product_material; ?>">
        </div>
      </div>
      <div class="form-group" id="descDiv">
        <label for="products_description" class="col-sm-4 control-label text-right">Product Description:</label>
          <div class="col-sm-8">
            <textarea name="products_description" id="products_description" rows="4" class="form-control"><?php echo $products_description; ?></textarea>
          </div>
      </div>



<?php
if($PID != ""){
echo '<input type="hidden" id="operation" name="operation" value="update">';
echo '<input type="hidden" id="products_id" name="products_id" value="'.$PID.'">';
} else {
echo '<input type="hidden" id="operation" name="operation" value="add">';
}
?>


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
