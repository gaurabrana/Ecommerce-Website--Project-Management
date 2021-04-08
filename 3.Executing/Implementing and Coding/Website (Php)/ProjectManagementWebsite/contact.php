<?php
if(isset($_POST['sendmessage'])){
echo'<script>alert("Welcome '.$_POST["name"].' Thank You for contacting us.")</script>';
echo"<script>setTimeout(function() {window.location.href= 'contact.php';}, 1000);</script>";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Networked Appetite </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="styles/style.css" type="text/css">
</head>
<?php
//Navigation Area
include('base/navbar.php');
?>

<div align="center" class="contact">
<img src="images/contactus.jpg">
</div>


<div class="container-fluid cont">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
        <p>Address : Cleckhudderfax, UK</p>
        <p>Street Suite 721 London</p>
        <p>10016</p>
        	
        </div>
        <div class="col-md-2">
        <p>Phone number: +2 392 3929 210</p>
        </div>
        <div class="col-md-3">
        <p>Email : info@networkedappetite.com</p>
        </div>
        <div class="col-md-3">
        <p>Website : www.networkappetite.com</p>
        </div>

</div>
</div>

<div class="container-fluid mapp">
<div class="row">
<div class="col-md-1">
	
</div>
<div class="col-md-7">
<p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2299.1671121250865!2d-2.4445455346532388!3d54.81217968031232!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487dac5171b6cd75%3A0x2e2745e42fc457df!2sAlston%20CA9%203HX%2C%20UK!5e0!3m2!1sen!2snp!4v1592451840301!5m2!1sen!2snp" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></p>
</div>
<div class="col-md-4">
  <form action="" method="POST">
  Name: <input type="text" name="name" required autocomplete="off"><br>
 <br> E-mail:  <input type="text" name="email" required autocomplete="off"><br>
  <br>Subject: <input type="text" name="Subject" requird autocomplete="off"><br>
  <br>Message: <input type="text" name="Message" required autocomplete="off"><br>

 <br> <input type="submit" name="sendmessage" value="Send Message">
</form>

  
</div>
</div>
</div>

















<?php
//Footer Area
include('base/footer.php');
?>
<script src="js/functions.js"></script>

</body>
</html>