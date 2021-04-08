<?php
date_default_timezone_set("Asia/Kathmandu");
require 'base/email/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
include('base/connect.php');
$useremail = $_SESSION['email'];
if(!empty($_GET['cart'])){
    $cart = $_GET['cart'];
}
$orderid = 0;
$sql = "Select * from orders";
$result = oci_parse($conn, $sql);
oci_execute($result);
while($row=oci_fetch_assoc($result))
{
    $orderid++;
}
$orderid++;
if(isset($_POST['placeorder'])){
    $firstname =$_POST['fname'];    
    $lastname =$_POST['lname'];    
    $phone_number=  $_POST['number'];    
    $email =strtolower($_POST['emailaddress']);    
    $town = $_POST['town'];        
    $address1 = $_POST['add1'];            
    $zipcode = $_POST['zip'];        
    
    $name = $firstname." ".$lastname;    
    $order_date = date("Y-m-d H:i:s");   
    echo $order_date; 
  
          $res2 = oci_parse($conn, $sql);
          oci_execute($res2);    
   $sql = "Insert into orders (orderid,name,phonenumber,email,town,address,zipcode,orderdate,cartid,purchased) values('$orderid','$name','$phone_number','$email','$town','$address1','$zipcode','$order_date','$cart','NO')";
    $res = oci_parse($conn, $sql);
    oci_execute($res);    
    oci_free_statement($res);
    $sql = "Select * from product_cart, product where product_cart.cartid = '$cart' and product_cart.productid = product.productid";
    $res = oci_parse($conn, $sql);
    oci_execute($res);
    while($row=oci_fetch_assoc($res)){
        $productid = $row['PRODUCTID'];
        $quantity = $row['QUANTITY'];
        $QuantityInStock = $row['QTYINSTOCK'];  
        $changedstock = ($QuantityInStock - $quantity);              
        if(!empty($row['DISCOUNTID'])){          
            $discount_id = $row['DISCOUNTID'];
            $sql1 = "Select AMOUNT from DISCOUNT where DISCOUNTID=$discount_id";
            $res1 = oci_parse($conn, $sql1);
            oci_execute($res1);
            while($hi = oci_fetch_assoc($res1)){            
              $amount = $hi['AMOUNT'];                                    
            }
          }
          else{           
           $amount = 0; 
          }                           
          if($amount>0){          
                $price = $row['PRICE']-($amount/100);          
                $total = ($price*$row['QUANTITY']);
          }
          else{        
              $price = $row['PRICE'];
            $total = ($row['PRICE']*$row['QUANTITY']);        
          }                          
     $sql = "Insert into orderdetails (productid,orderid,quantity,price,totalprice) values('$productid','$orderid','$quantity','$price','$total')"; 
        $res1 = oci_parse($conn,$sql);
        oci_execute($res1);   
        if($res1){          
          $sql3 = "UPDATE PRODUCT SET QTYINSTOCK = '$changedstock' where productid = '$productid'";
          $res3 = oci_parse($conn,$sql3);
        oci_execute($res3);   
        }    
    }
}    
        $message = "<div class='container'>";            
            $username = $_SESSION['fullname'];
            $message .= "<h3>Your Order Has Been Confirmed.</h3>"; 
            $message.="<hr>
            <table style='border:1px solid black;width:500px !important;'>
            <thead>
              <tr style='padding:20px;'>
                <th style='padding-top: 12px;  padding-bottom: 12px; text-align: center; background-color: #4CAF50; color: white;'scope='col'>Product</th>
                <th style='padding-top: 12px;  padding-bottom: 12px; text-align: center; background-color: #4CAF50; color: white;'scope='col'>Quantity</th>
                <th style='padding-top: 12px;  padding-bottom: 12px; text-align: center; background-color: #4CAF50; color: white;'scope='col'>Price</th>
                <th style='padding-top: 12px;  padding-bottom: 12px; text-align: center; background-color: #4CAF50; color: white;'scope='col'>Total Price</th>      
              </tr>
            </thead>
            <tbody>";                               
                    $sql2 = "Select * from orderdetails,product where orderdetails.productid = product.productid and orderdetails.orderid=$orderid";                                              
                      $total = 0;                        
                      $res1 = oci_parse($conn, $sql2);
                      oci_execute($res1);
                      while($invoice=oci_fetch_assoc($res1)){                                                  
                          $message.="<tr style='background-color: #f2f2f2;'>
                          <th style='text-align:center;' scope='row'>".$invoice['NAME']."</th>
                          <td style='text-align:center;'>".$invoice['QUANTITY']."</td>
                          <td style='text-align:center;'> $".$invoice['PRICE']."</td>
                          <td style='text-align:center;'> $".$invoice['TOTALPRICE']."</td></tr>";            
                          $total += $invoice['TOTALPRICE'];                                        
                      }          
                        $message.="</tbody></table>            
                        <hr><p>Subtotal Price: $".$total."</p>
                        <p>Shipping Price: $2.00</p>
                        <h4>Total Price: $".($total+2)."</h4>            
                        <br>
                        <hr>
                        <i>Please don't reply to this email.<br>            
                        NetworkedApptetite respects your privacy, and you can view our Privacy Statement on our website.<br>
                        Copyright ©2020 NetworkedApptetite. All rights reserved.<br></i>
                        </div>";            				                                                                 
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
                              $mail->addAddress($useremail);              				        
                             
                              //Content
                              $mail->isHTML(true);                                  
                              $mail->Subject = 'Ordered Confirmed.';
                              $mail->Body    = $message;                                    
                              $mail->send();                                                          
                              header("Location: checkout.php?orderid=$orderid");
?>