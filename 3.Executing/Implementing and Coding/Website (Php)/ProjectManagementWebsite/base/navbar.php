<?php
//if session is not started, start the session
if (!isset($_SESSION)) {
  session_start();
}
?>
<head>
<!--all css styles and scripts links required are given here-->
<link rel="stylesheet" href="styles/navbarfooter.css" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/43e403f3dc.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<div class="container">
<!--Start Navbar Area-->
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="index.php"><img class="logo" src="images/logo.png"></a> <!---LOGO-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
          <div class="dropdown-menu" aria-labelledby="dropdown04">
            <a class="dropdown-item" href="shop.php">Shop</a>
            <a class="dropdown-item" href="favourite.php">Wishlist</a>            
            <a class="dropdown-item" href="checkout.php">Checkout</a>
          </div>
        </li>
        <li class="nav-item"><a href="contact.php" class="nav-link">Contact Us</a></li>
        <?php
        //checks if $_SESSION['username] is set
        if (isset($_SESSION['username'])) {
          echo'<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$_SESSION['username'].'</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">';
          //checks if $_SESSION['usertype] is set
          if(isset($_SESSION['usertype'])){
            //if $_SESSION['usertype] is set to 1 i.e trader
            if($_SESSION['usertype']==1){
              echo'<a class="dropdown-item" href="Trader/products.php">Trader Dashboard</a>';
            }
            //if $_SESSION['usertype] is set to 2 i.e customer
            else if($_SESSION['usertype']==2){
              echo'<a class="dropdown-item" href="base/Profile.php">My Profile</a>';
            }            
          }                      
          //Logout users
            echo'<a class="dropdown-item" href="base/logout.php">Logout</a>            
          </div>
        </li>';
        } else {
          echo '<li class="nav-item"><a href="login.php#loginpage" class="nav-link">Login</a></li>';
        }
        ?>
        <form class="form-inline my-2 my-lg-0" action="shop.php?search=on" method="POST">
          <input class="form-control mr-sm-2" type="search" name="searchtext" placeholder="Search.(Case Sensitive)">
          <input type="submit" name="searchsubmit" hidden>
        </form>
        <?php
        if(isset($_SESSION['usertype'])){
          //if $_SESSION['usertype] is set to 2 i.e customer, show cart.
          if($_SESSION['usertype']==2){
            include('connect.php');
            $no_of_data = 0;
            $userid = $_SESSION['userid'];
            $sql = "Select productid from cart, product_cart where cart.userid = $userid and product_cart.cartid = cart.cartid";
            $result = oci_parse($conn,$sql);
            oci_execute($result);    
            while($row=oci_fetch_assoc($result)){    
            $no_of_data++;        
            }
            echo '<li class="nav-item"><a href="mycart.php" class="nav-link"><i class="fas fa-shopping-cart"></i>['.$no_of_data.']</a></li>';
          }          
        }
        echo '<li class="nav-item"><a href="favourite.php" class="nav-link"><i class="fas fa-heart"></i></a></li>';
        ?>
      </ul>
    </div>
</nav>
<!--End Navbar Area-->
</div>