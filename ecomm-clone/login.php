<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:index.php');
   }else{
      $message[] = 'Incorrect password or email! Please Try again';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Circuit County | Login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

</head>
<style>
   .navbar {
  background-color: transparent;
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
   body{
      background-image: url("images/background-login.jpg");
      background-size: cover;
      background-repeat: no-repeat;
   }
   input[type="email"]::placeholder,
   input[type="password"]::placeholder {
    font-size: 1.2em;
    font-weight:600;
}
   .mail{
  background-color: transparent;
  border: none;
  border-bottom: 2px solid rgb(78, 79, 80);
  outline: none;
  font-family: Arial, sans-serif;
  font-size: 1.2em;
  color:rgb(78, 79, 80);
  font-weight:600;
  padding: 5px 0;
   }
   .btn:link,
.btn:visited {
    text-transform: uppercase;
    text-decoration: none;
    padding: 15px 40px;
    display: inline-block;
    border-radius: 100px;
    transition: all .2s;
    position: absolute;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    background-color:orange;
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
.img2{
   width:60%;
   height:auto;
   -webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
.img2:hover {
	width: 65%;
   height:auto;

}

</style>

<body>
   <nav class="navbar">
  <a class="navbar-brand" href="home.php" style="width=20%;"><img src="images/logo.png" alt="" class="img1"></a>
  <ul class="navbar-nav">
   <!-- ratings subject to change -->
    <li><a href="Ratings.html">Ratings</a></li>
    <li><a href="about.html">About us</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>
</nav>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">
   <form action="" method="post" style="background-color:transparent;border: none;">
   <div class="login-box">
      <a href="landing.php"><img src="images/logo.png" alt="logo" width= 60% class="img2"></a>
      <h3 style="color:rgb(78, 79, 80)!important;font-size:250%;"  style="">login</h3>

      <input type="email" name="email" required placeholder="Enter Email" class="box mail">
      <input type="password" name="password" required placeholder="Enter Password" class="box mail">
      <br> <br>
      <input type="submit" name="submit" class="btn" value="login now">
      <br>
      <strong><p style="color:black; font-size: 140%;">Don't have an Account?</p></strong>
      <p  style="font-size:160%"><a href="register.php" style="color:rgb(196, 68, 33)!important">Register Now</a></p>
      </div>
   </form>

</div>
<div style="background-color: transperant; padding: 20px; text-align: center;">
   <p style="font-size: 120%; color: white;">&copy; 2023 Circuit County. All rights reserved.</p>
</div>
</body>
</html>