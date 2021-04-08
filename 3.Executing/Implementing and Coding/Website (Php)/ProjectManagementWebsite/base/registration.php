<?php
include('connect.php');
date_default_timezone_set("Asia/Kathmandu");
require 'email/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
$id = 0;
$emails[] = "abc@example.com";
$shopid = 0;
$error_exist = 0;
$error = null;
$pass_error = 0;
$sql = "Select * from users";
$result = oci_parse($conn, $sql);
oci_execute($result);
while($row=oci_fetch_assoc($result))
{
    $emails[] = $row['EMAIL'];     
    $id++;                        
}
$id++;
oci_free_statement($result);
$sql = "Select * from shop";
$result = oci_parse($conn, $sql);
oci_execute($result);
while($row=oci_fetch_assoc($result))
{
    $shopid++; 
}
$shopid++;
oci_free_statement($result);
$cartid = 0;
$sql = "Select * from cart";
$result = oci_parse($conn, $sql);
oci_execute($result);
while($row=oci_fetch_assoc($result))
{
    $cartid++; 
}
$cartid++;
oci_free_statement($result);
if(isset($_POST['submit']))
{
    $_SESSION = array();   
    $fname = trim($_POST['firstname']);
    $lname = trim($_POST['lastname']);
    $address = trim($_POST['address']);
    if(ctype_digit($_POST['age']))
    {        
            if($_POST['age']>=18)
            {
                $age = $_POST['age'];
            }
            else
            {
                $error_exist++;
                $error = "User should be 18 or 18+ years old to continue. <br/>";                
            }
        }                          
    else
    {
        $error = $error."Age should be in digit(0-9). <br/>";
        $error_exist++;
    }
    $gender = $_POST['gender'];
    if(in_array($_POST['email'],$emails)){
        $error_exist++;
        $error = $error."Email already registered.<br/>"; 
    }  
    else{
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        {
          $error = $error."Invalid email format. <br/>";
          $error_exist++;
        }
        else
        {
          $email = strtolower(trim($_POST['email']));                    
        } 
    }
    if($_POST['password'] != $_POST['pass-repeat']) 
    {
        $error = $error."Confirmed Password Does Not Match. Please Re-Check! <br/>";
        $error_exist++;
    }
    else
    {
        if (strlen($_POST['password']) < '8') 
        {
            $error = $error."Your Password Must Contain At Least 8 Characters!<br/>";
            $error_exist++;
            $pass_error++;
        }
        else{
            if(!preg_match("#[0-9]+#",$_POST['password'])) 
            {
                $error = $error."Your Password Must Contain At Least 1 Number! <br/>";
                $error_exist++;
                $pass_error++;
            }
            if(!preg_match("#[A-Z]+#",$_POST['password'])) 
            {
                $error = $error."Your Password Must Contain At Least 1 Capital Letter! <br/>";
                $error_exist++;
                $pass_error++;
            }
            if(!preg_match("#[a-z]+#",$_POST['password'])) 
            {
                $error = $error."Your Password Must Contain At Least 1 Lowercase Letter! <br/>";
                $error_exist++;
                $pass_error++;
            }
        }        
        if($pass_error == 0){
            $password = md5($_POST['password']);
            $re_pass = $_POST['pass-repeat'];            
        }              
    }    
    if(isset($_POST['shoptype'])){
        $usertype = 1;
        $sql = "Select TRADERTYPE from shop";
        $result = oci_parse($conn, $sql);
        oci_execute($result);
        while($row=oci_fetch_assoc($result)){       
            $shops[] = $row['TRADERTYPE'];                            
        }
        if(in_array($_POST['shoptype'],$shops)){
            $error_exist++;
            $error = $error."<br/>Shop Type Already Exist."; 
        }  
        else{
            $shop = $_POST['shoptype'];
            $_SESSION = $shop;  
        }      
        oci_free_statement($result);    
    }
    else{
        $usertype = 2;
    }
    if($error_exist==0){
        $name = $fname.' '.$lname;
        // verification key
        $verification_key = md5(time().$name);       
        $joined_date = date("Y-m-d");        
        $sql = "Insert into Users (USERID, TYPES, NAME, ADDRESS, AGE, GENDER, EMAIL, PASSWORD, VERIFICATION_KEY, VERIFIED, JOINED_DATE) values ('$id','$usertype','$name','$address','$age','$gender','$email','$password','$verification_key','NO', to_date('$joined_date','YYYY-mm-dd'))";
        $result = oci_parse($conn, $sql);
        oci_execute($result);             
        if($result){
            if(isset($shop)){
                $sql1 = "Insert into SHOP (SHOPID, TRADERTYPE, USERID) values ('$shopid','$shop','$id')";
                $addtoshop = oci_parse($conn, $sql1);
                oci_execute($addtoshop);
            }
            else{
                $sql2 = "Insert into cart (cartid, userid) values ('$cartid','$id')";   
                $allocatecart = oci_parse($conn, $sql2);
                oci_execute($allocatecart);
                oci_free_statement($allocatecart);
            }            
        }
        if($result OR $addtoshop)
        {
            $message = "
						<h2>Thank you for Registering With NETWORKED APPETITE.</h2>
						<p>Your Account:</p>
						<p>Email: ".$email."</p>
						<p>Password: ".$_POST['password']."</p>
						<p>Please click the link below to activate your account.</p>
						<a href='http://localhost/ProjectManagementWebsite/base/verifyemail.php?vkey=$verification_key'>Activate Account!</a>
					";
				
		    		$mail = new PHPMailer(true);                             				    
				        //Server settings
				        $mail->isSMTP();                                     
				        $mail->Host = 'smtp.gmail.com';                      
				        $mail->SMTPAuth = true;                               
				        $mail->Username = 'networkedappetite@gmail.com';     
				        $mail->Password = 'Ericwinty90@gmail.com';                   
				        $mail->SMTPOptions = array(
				            'ssl' => array(
				            'verify_peer' => false,
				            'verify_peer_name' => false,
				            'allow_self_signed' => true
				            )
				        );                         
				        $mail->SMTPSecure = 'ssl';                           
				        $mail->Port = 465;                                   

				        $mail->setFrom('networkedappetite@gmail.com');
				        
				        //Recipients
				        $mail->addAddress($email);              				        
				       
				        //Content
				        $mail->isHTML(true);                                  
				        $mail->Subject = 'Networked Appetite Site Sign Up';
				        $mail->Body    = $message;

				        $mail->send();								        				        
       header("Location: ../login.php?verify=on&email=$email");
        } 
    
    }
    else
    {        
        if(!empty($_GET['page'])=='trader'){
            header("Location: ../TraderRegister.php?error=$error");
        }
        else{
            header("Location: ../Register.php?error=$error");
        }
      
    }
    
}

?>
