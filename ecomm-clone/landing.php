<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};

if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'cart quantity updated successfully!';
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:index.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Circuit County | Shopping Cart</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

</head>
<style>
/* navbar styles */
.navbar {
  background-color: #D3D3D3;
  color: #fff;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  font-size:130%;
}

.navbar-brand {
  font-size: 1.5rem;
  font-weight: bold;
  text-transform: uppercase;
}

.navbar-nav {
  display: flex;
  justify-content: space-between;
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.navbar-nav li {
  margin: 0 10px;
}

.navbar-nav li a {
  color: #fff;
  text-decoration: none;
  transition: all 0.2s ease;
}

.navbar-nav li a:hover {
  color: var(--orange);
}

.btn:link,
.btn:visited {
    text-transform: uppercase;
    text-decoration: none;
    display: inline;
    border-radius: 100px;
    transition: all .2s; 
    margin:5px;  
}
.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
.btn:hover::after {
    transform: scaleX(1.4) scaleY(1.6);
    opacity: 0;
}
.img1 {
	width: 20%;
	height: auto;
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
   padding-top:5px;
}
.img1:hover {
	width: 25%;
}

</style>
<body>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
<nav class="navbar">
  <a class="navbar-brand" href="home.php" style="width=20%;"><img src="images/logo.png" alt="" class="img1"></a>
  <ul class="navbar-nav">
   <!-- ratings subject to change -->
    <li><a href="login.php">Login</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>
</nav>

<!-- <div class="everything">  </div>-->
<div class="container">

   <div class="user-profile">

      <p> Welcome to <span style="color:var(--blue); font-weight:700;"> Circuit County </span></p>
    <p> Login to Shop </p>
   <div class="flex">
   <a href="login.php" class="btn">login</a>
   <a href="register.php" class="option-btn btn">register</a>
</div>
</div>

<div class="products">

   <h1 class="heading">latest products</h1>

   <div class="box-container">

   <?php
      $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
      if(mysqli_num_rows($select_product) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_product)){
   ?>
      <form method="post" class="box" action="">
        <br> <br>
         <img src="images/<?php echo $fetch_product['image']; ?>" alt="">
         <br>
         <div class="name"><?php echo $fetch_product['name']; ?></div>
         <div class="price">₹ <?php echo $fetch_product['price']; ?>/-</div>
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      </form>
   <?php
      };
   };
   ?>
   </div>

</div>

<div class="shopping-cart">
  <h1 class="heading">Login now to shop</h1>
  <br>
   <div class="cart-btn"> 
      <br> 
      <a href="login.php" class="btn">Login to Circuit County</a>
   </div>

</div>

</div>
<div style="background-color: #f2f2f2; padding: 20px; text-align: center;">
   <p style="font-size: 120%; color: #555;">&copy; 2023 Circuit County. All rights reserved.</p>
</div>


</body>
</html>