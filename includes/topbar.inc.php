	<?php
	require_once 'includes/global.inc.php';
	$subTotal = "0.00";
	$numItems = 0;
	?>
	<div id="mycarousel" class="carousel slide" data-ride="carousel">
    		<div class="carousel-inner">
        		<div class="item active">
       	 		<img src="header.png" alt="" class="img-responsive">
            			<div class="title-caption">
           				<h2><b>Turtley Awesome Outdoor Products</b></h2>
		  	 	</div>
		        </div>
    		</div>
	</div>
	<nav class="navbar navbar-default" role="navigation">
  	<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">T.A.O.P.</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li  class="active"><a href="./index.php">Home</a></li>
        <li><a href="./howto.php">How to Use</a></li>
        <li class="dropdown">
          <a href="./product.php" class="dropdown-toggle" data-toggle="dropdown">Products <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
		  <li><a href="./product.php">Overview - Categories</a></li>
            <li class="divider"></li>
			<li><a href="./product.php?cat=hammock">Hammocks</a></li>
            <li><a href="./product.php?cat=insulation-tq">Topquilts</a></li>
	    <li><a href="./product.php?cat=shelter">Tarps/Shelter</a></li>
            <li><a href="./product.php?cat=rigging">Rigging & Rope</a></li>
            <li><a href="./product.php?cat=acc-stuffsacks">Sacks and Accessories</a></li>
            <li class="divider"></li>
            <li><a href="./product.php?cat=myog">DIY: Fabric & Supplies</a></li>
          </ul>
        </li>
		<li><a href="./about.php">About</a></li>
		<li><a href="./samples.php">Samples</a></li>
		<li><a href="./faq.php">FAQ</a></li>
			<?php

			if(isset($_SESSION['logged_in']) && $user->userPriv = "A") {
				echo'<li class="dropdown">';
				echo'	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<span class="caret"></span></a>';
				echo'	<ul class="dropdown-menu" role="menu">';
				echo'		<li class="divider"></li>';
				echo'		<li><a href="./manageProducts.php">Add Product</a></li>';
				echo'		<li><a href="./ERD.png">db schema pic</a></li>';
				echo'	</ul>';
				echo'</li>';
			}
				?>
	 </ul>
     <ul class="nav navbar-nav navbar-right">
	<?php
		if(!(empty($_SESSION['cart']))) {
			echo'<li class="dropdown">';
				echo'<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span>  Cart';
				//if(isset($_SESSION['numItems']))
				//echo'('.$_SESSION['numItems'].' items @ '.$_SESSION['subTotal'].')';
				echo'<span class="caret"></span></a>';
				echo'<ul class="dropdown-menu" role="menu">';
					echo'<li><a href="cart.php">&nbsp;&nbsp;&nbsp;   Shopping Cart  -  Click here for details   &nbsp;&nbsp;&nbsp;</a></li>';
					echo'<li class="divider"></li>';
					$products_title = NULL;
					$products_price = NULL;
					//$product_ID = NULL;
					$itemSubtotal = "0.00";

					$sql2 = "SELECT products_id, products_title, products_price FROM products WHERE products_id = ?";
					$stmt = $db->connection->prepare($sql2);

					foreach ($_SESSION['cart'] as $productID => $qty) {

							$stmt->bind_param("i", $productID);
						$stmt->execute();
						$stmt->bind_result($productid, $products_title, $products_price);
						$stmt->fetch();

					$itemSubtotal = ($products_price * $qty);
					$subTotal += $itemSubtotal;
					$numItems += $qty;
					$_SESSION['numItems'] = $numItems;
					$_SESSION['subTotal'] = $subTotal;
					echo'<li><a href="productDetails.php?PID='.$productid.'"><span class="text-right">&nbsp;&nbsp;$' .$itemSubtotal. ':&nbsp;  </span><span> &nbsp; ' .$qty. ' x </span><span>  ' .$products_title. '&nbsp;</span></a></li>';
				}
				$stmt->close();
			echo'<li class="divider"></li>';
			echo'<li><span>&nbsp;&nbsp;&nbsp;Total: $'.$subTotal.' </span><span> for ' .$numItems. ' items.</span></li>';
			echo'</ul>';
			echo'</li>';
			}
?>


<?php
	  if(isset($_SESSION['logged_in'])) {
        print '<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Hello, ';
				print($user->firstName);
				print '! <strong class="caret"></strong></a>';
				print'<ul class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;" role="menu">';
				print'<li><a href="user.php">My Account</a></li>';
				print'<li><a href="logout.php">Log Out</a></li>';
				print'</ul></li>';
			} else {
					print'<li><a href="register.php">Sign Up</a></li>';
        	print'<li class="divider-vertical"></li>';
					print'<li class="dropdown">';
					print'<a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>';
					print'<div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">';
					print'<form method="post" action="login.php" accept-charset="UTF-8">';
					print'<input style="margin-bottom: 15px;" type="text" placeholder="Email Address" id="email" name="email">';
					print'<input style="margin-bottom: 15px;" type="password" placeholder="Password" id="password" name="password">';
					print'<input style="float: left; margin-right: 10px;" type="checkbox" name="remember-me" id="remember-me" value="1">';
					print'<label class="string optional" for="user_remember_me"> Remember me</label>';
					print'<button type="submit" class="btn btn-primary btn-block" value="Register" name="submit-login" />Submit</button>';
					print'</form>';
					print'</div>';
					print'</li>';
			}

					?>
		</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
