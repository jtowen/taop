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
   <script>
     $(function () {
       $('#myTab a:last').tab('show')
     })
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
  <li><a href="./index.php">Home</a></li>
  <li><a href="product.php">Products</a></li>
  <li class="active">
    <?php
    $sql = "SELECT * from products where products_id = '$PID'";
    if($result = $db->connection->query($sql)) {
      while($row = $result->fetch_assoc()) {
        $products_id=$row['products_id'];
        $products_quantity=$row['products_quantity'];
        $products_category=$row['products_category'];
        $products_image=$row['products_image'];
        $products_price=$row['products_price'];
        $products_date_added=$row['products_date_added'];
        $products_last_modified=$row['products_last_modified'];
        $products_date_available=$row['products_date_available'];
        $products_shipping_exception =$row['products_shipping_exception'];
        $products_description=$row['products_description'];
        $products_title=$row['products_title'];
        $category_description=$row['category_description'];
      }
      $result->close();
    }


$sql = "SELECT * from product_attributes where product_id = '$PID'";
if($result = $db->connection->query($sql)) {
  while($attr = $result->fetch_assoc()) {
    $product_weight = $attr['product_weight'];
    $product_length = $attr['product_length'];
    $product_width = $attr['product_width'];
    $product_height = $attr['product_height'];
    $product_material = $attr['product_material'];
  }
  $result->close();
}

    $prodOptionsToFilter = array(
      "Date Added: " => "$products_date_added",
      "Last Modified: "=> "$products_last_modified",
      "Date Available: "=> "$products_date_available",
      "Non-standard Shipping: "=> "$products_shipping_exception"
    );
    $specOptionsToFilter = array(
      "Weight: "=> "$product_weight",
      "Height: "=> "$product_length",
      "Width: "=> "$product_width",
      "Height: "=> "$product_height",
      "Material: "=> "$product_material"
    );

    $prodOptions = array_filter($prodOptionsToFilter);

    $specOptions = array_filter($specOptionsToFilter);




        echo '<a href="product.php?cat='. $products_category.'">';
        echo $category_description . '</a>';

      //$result->close();


    ?>
  </li>
</ol>
      <div class="container-fluid">
        <div class="col-md-7">
          <h2 class="text-center"><?php echo $products_title; ?> </h2>

        </div>

        <div class="col-md-5">
        <ul class="nav nav-tabs" role="tablist" id="myTab">
          <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
          <li role="presentation"><a href="#specs" aria-controls="specs" role="tab" data-toggle="tab">Tech Specs</a></li>
        </ul>
        </div>


        <div class="col-md-7">
      <img src="<?php echo $products_image; ?>" class="img-responsive">
        <div class="col-md-6">
        <?php
        foreach ($prodOptions as $key => $value) {
          //if(!is_null($value)) {
            //if(!($value===NULL))
          echo '<div class="row"><span>'.$key.'</span><span class="pull-right">'.$value.'</span></div>';
        //}
        }

        //<form action = "addCart.php" method="POST" role="form">

        ?>
      </div>
      <div class="col-md-6">
    <?php
      echo '<form action = "cart.php" method="POST" class="form-horizontal" role="form">';
      echo '<fieldset>';
      echo '<input type = "hidden" name ="prodID" value ="'.$products_id.'">';
      //echo '<input type = "hidden" name ="product_title" value ="'.$products_title.'">';
      //echo '<input type = "hidden" name = "operation" value = "addToCart">';
      ?>
      <div class="form-group" id="qtyDiv">
        <label for="qty" class="col-sm-7 control-label text-center">Enter Qty:</label>
           <div class="col-sm-5">
          <input type="text" class="form-control" id="qty" value="1" name="qty" required>
          </div>
        </div>
        <div class="col-md-offset-2 col-md-8">
        <button type="submit" class="btn btn-primary btn-block" value="addToCart" name="submit-form" />Submit</button>
        </div>
        <fieldset>
      </form>
      </div>
        </div>
        <div class="col-md-5">



          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="details">
              <p><h4><?php echo $products_description; ?></h4></p>
            </div>

            <div role="tabpanel" class="tab-pane" id="specs"><?php
          foreach ($specOptions as $key => $value) {
            if(!is_null($value))
            echo '<div class="row"><span class="col-md-6"><h5 class="text-right">'.$key.'</h5>	</span><span class="col-md-6 pull-right">'.$value.'</span></div>';
          }

          //<form action = "addCart.php" method="POST" role="form">

          ?>  </div>
          </div>





        </div>



</div>

    </div> <!-- /container -->

 <script src="./jquery.min.js"></script>

 <script src="./bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
