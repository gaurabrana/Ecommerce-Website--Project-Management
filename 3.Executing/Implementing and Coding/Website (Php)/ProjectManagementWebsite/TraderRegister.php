<?php
if(!isset($_SESSION))
{
session_start();  
}
if(isset($_SESSION['username'])){
  header("Location: index.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Trader Register</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="styles/login.css" type="text/css">
</head>
<?php
//Navigation Area
include('base/navbar.php');
?>
<body>
<div class="container">  
        <div class="row justify-content-center">
        <div class="col-md-4 message">        
         <div class="displaymessage">
         <img class="logo" src="images/logo.png">
         <h5>Thrive Your Business With Us. <br/> Best Selling Price For Your Products. <br/> Secure Payment Methods. <br/> Millions of Satisfied Customers.</h5>
         <?php
        if(!empty($_GET['error']))
        {
          $error = $_GET['error'];
          echo"<p class='error'>".$error."</p>";
          echo"<p class='error'>Page will be reloaded. Please wait</p>";
         echo"<script>setTimeout(function() {window.location.href= 'TraderRegister.php';}, 6000);</script> ";
        }
         ?>
         </div>               
        </div>
            <div class="col-md-6 col-sm-8" id="register">
            <div class="main">
            <p class="sign" align="center">Trader Registration</p>
<form action="base/registration.php?page=trader" method="POST">
<div class="row">
<div class="col-md-3">
<label class="text" for="firstname"><b>First Name</b></label>
</div>
<div class="col-md-8">
<input type="text" class="reg" placeholder="Enter First Name" name="firstname" value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname'];} ?>" autocomplete="off" required>
</div>  
<div class="col-md-3">
<label class="text" for="lastname"><b>Last Name</b></label>
</div> 
<div class="col-md-8">
<input type="text" class="reg" placeholder="Enter Last Name" name="lastname" value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname'];} ?>" autocomplete="off" required>
</div>
<div class="col-md-3">
<label class="text" for="address"><b>Address</b></label>
</div>
<div class="col-md-8">
<input type="text" class="reg" placeholder="Enter Address" name="address" value="<?php if(isset($_POST['address'])){ echo $_POST['address'];} ?>" autocomplete="off" required>
</div>
<div class="col-md-3">
<label class="text" for="Age"><b>Age</b></label>
</div>
<div class="col-md-8">
<input type="text" maxlength="2" class="reg" placeholder="Enter Age" name="age" autocomplete="off" required> 
</div> 
<div class="col-md-3">
<label class="text" for="Shop"><b>Shop Type</b></label>
</div>
<div class="col-md-8"> 
<select name="shoptype" class="reg">
<option value="Butcher">Butcher</option>
<option value="Greengrocer">Greengrocer</option>
<option value="Fishmonger">Fishmonger</option>
<option value="Bakery">Bakery</option>
<option value="Delicatessen">Delicatessen</option>
</select>
</div>
<div class="col-md-3">
<label class="text" for="gender"><b>Gender</b></label>
</div>
<div class="col-md-8 rad">
    <input type="radio" name="gender" value="Male" <?php if (isset($_POST['size']) && $_POST['size']=="Male") echo "checked";?> required>
    <label class="radlabel" for="male">Male</label>
    <input type="radio" name="gender" value="Female" <?php if (isset($_POST['size']) && $_POST['size']=="Female") echo "checked";?>>
    <label class="radlabel" for="female">Female</label>
    <input type="radio" name="gender" value="Other" <?php if (isset($_POST['size']) && $_POST['size']=="Other") echo "checked";?>>
    <label class="radlabel" for="other">Other</label>  
</div>
<div class="col-md-3">
<label class="text" for="email"><b>Email</b></label>
</div>
<div class="col-md-8">
<input type="text" class="reg" placeholder="Enter Email" name="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email'];} ?>" readonly onfocus="this.removeAttribute('readonly');" autocomplete="off" required>  
</div>
<div class="col-md-3">
<label  class="text" for="psw"><b>Password</b></label>
</div>
<div class="col-md-8">
<input type="password" class="reg" placeholder="Enter Password" name="password" required>
</div>
<div class="col-md-3">
<label class="text" for="pass-repeat"><b>Confirm Password</b></label>
</div>
<div class="col-md-8">
<input type="password" class="reg" placeholder="Confirm Password" name="pass-repeat" required><br>
</div>
<div class="col-md-3">
</div>
<div class="col-md-8">
<input class="text" type="checkbox" name="terms" value="terms&Conds" <?php if(isset($_POST['terms']) && in_array("terms&Conds", $_POST['terms'])) echo "checked"; ?> required="required"/>I agree with all the terms and conditions. 
</div>
    <input type="submit" class="regsubmit" name="submit" value="Sign Up">
</div>
</form>
      <a href="login.php" class="btn btn-outline-info regbtn" role="button">Already have an account?</a>
</p>
                </div>
        </div>        
    </div>
  </div> 
<?php
//Footer Area
include('base/footer.php');
?>
</body>
<script src="js/fregctions.js"></script>
<script>
    AOS.init();
  </script>
</html>