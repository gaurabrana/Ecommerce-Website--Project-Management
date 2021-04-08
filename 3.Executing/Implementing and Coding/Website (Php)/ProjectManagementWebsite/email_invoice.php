<?php
include('base/connect.php');
require 'base/email/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
if(!empty($_GET['success'])){    
	$userid = $_SESSION['userid'];                          
    $orderid = $_GET['success'];
    $sql6 ="Select * from users where types!=2";
                    $res6 = oci_parse($conn, $sql6);
                    oci_execute($res6);
                    while($row=oci_fetch_assoc($res6)){
                        $addresses[] = $row['EMAIL'];
                        if($row['TYPES']==0){
                          $adminemail = $row['EMAIL'];
                        }
                    }
					oci_free_statement($res6);
					 $sql6 ="Select email from orders where orderid=$orderid";
                    $res6 = oci_parse($conn, $sql6);
                    oci_execute($res6);
                    while($ros=oci_fetch_assoc($res6)){						
					$shipping_email = $ros['EMAIL'];
					}
					oci_free_statement($res6);
                    $useremail = $_SESSION['email'];
					$addresses[] = $useremail;
					if($useremail!=$shipping_email){
					$addresses[] = $shipping_email;	
					}					
    foreach($addresses as $email){               
            $message = "<div class='container'>";                        
            $username = $_SESSION['fullname'];
            $message .= "<h3>Invoice of Customer: $username.</h3>";                              
                $sql ="Select * from orders where orderid =$orderid and purchased='YES'";
                $res = oci_parse($conn, $sql);
                oci_execute($res);
                while($data1=oci_fetch_assoc($res)){                                                                                                                                                                                        
                        $message.="<h4>Order ID: ".$data1['ORDERID']."</h4>
                        </tr><h4>Order Date: ".$data1['ORDERDATE']."<hr></h4>";
                          $message.="<u><h4>Shipping Details: </h4></u>
                                  <table class='shipping_details'>
                                  <tbody>                            
                                  <tr>
                                  <td>Name</td>
                                  <td>: ".$data1['NAME']."</td>
                                </tr>
                                <tr>
                                  <td>Email</td>
                                  <td>: ".$data1['EMAIL']."</td>
                                </tr>
                                <tr>
                                  <td>Town</td>
                                  <td>: ".$data1['TOWN']."</td>
                                </tr>
                                <tr>
                                  <td>Address</td>
                                  <td>: ".$data1['ADDRESS']."</td>
                                </tr>
                                <tr>
                                  <td>Zip Code</td>
                                  <td>: ".$data1['ZIPCODE']."</td>
                                </tr>
                              </tbody></table>";                                 
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
                      if($email==$useremail OR $email==$adminemail OR $email==$shipping_email){   
                        $shipping_price_info = true;                                                    
                        $sql2 = "Select * from orderdetails,product where orderdetails.productid = product.productid and orderdetails.orderid=$orderid";                          
                      }
                      else{                               
                        $shipping_price_info = false;    
                        $midsql = "Select * from users where email='$email'";
                        $midres= oci_parse($conn,$midsql);
                        oci_execute($midres);
                        while($midrow=oci_fetch_assoc($midres)){
                          $traderuserid = $midrow['USERID'];
                        }
                        oci_free_statement($midres);                        
                        $sql2 = "Select name,orderdetails.price,quantity,totalprice from orderdetails,product where orderdetails.productid = product.productid and orderdetails.orderid=$orderid 
                        and product.userid=$traderuserid";  
                      } 
                      $items=0;
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
                          $items++;                                                  
                        }                                                                                               
                      if($items>0){                                                
                        $message.="</tbody></table>";
                        if($shipping_price_info){
                          $message .= "<hr><p>Subtotal Price: $".$total."</p>
                          <p>Shipping Price: $2.00</p>
                          <h4>Total Price: $".($total+2)."</h4>";              
                        }
                        else{
                          $message .= "<hr><p>Total Price: $".$total."</p>";                          
                        }                                    
                        $message .= "<br>
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
                              $mail->addAddress($email);              				        
                             
                              //Content
                              $mail->isHTML(true);                                  
                              $mail->Subject = 'Customer product invoice.';
                              $mail->Body    = $message;                                    
                            $mail->send();   
                                                          
                    }
                  }                                                		                        
        }
}
?>