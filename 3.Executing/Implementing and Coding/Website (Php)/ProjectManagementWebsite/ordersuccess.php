<?php
date_default_timezone_set("Asia/Kathmandu");
include('base/connect.php');
if(!empty($_GET['success'])){
    $paiddate = date("Y-m-d H:i:s"); 
    $orderid = $_GET['success'];
    if(empty($_GET['refresh'])){
      $sql = "UPDATE ORDERS SET PURCHASED='YES' where orderid = '$orderid'";
      $res = oci_parse($conn, $sql);
      oci_execute($res);
      oci_free_statement($res);
      $paymentid = 0;
      $sql = "Select * from payment";
      $res = oci_parse($conn, $sql);    
      oci_execute($res);
      while($row=oci_fetch_assoc($res)){
        $paymentid++;
      }
      $paymentid++;
      oci_free_statement($res);
      //entry of payment info
      $total = 0;
      $user_id = $_SESSION['userid'];
      $sql = "Select * from orderdetails where orderid='$orderid'";    
      $res = oci_parse($conn, $sql);    
      oci_execute($res);
      while($row=oci_fetch_assoc($res)){
        $total = $total + $row['TOTALPRICE'];
      }
      $shipping_charge = 2;
      $total = $total + $shipping_charge;
      $sql = "INSERT INTO PAYMENT(PAYMENTID,USERID,ORDERID,TOTALPRICE,PAIDDATE) VALUES ('$paymentid','$user_id','$orderid','$total',to_date('$paiddate', 'YYYY-mm-dd HH24:mi:ss'))";
      $res = oci_parse($conn, $sql);
      oci_execute($res);
      oci_free_statement($res);
      $sql = "Select * from cart where userid='$user_id'";    
      $res = oci_parse($conn, $sql);    
      oci_execute($res);
      while($row=oci_fetch_assoc($res)){
        $cartid = $row['CARTID'];
      }
      oci_free_statement($res);
      $sql = "Delete from product_cart where cartid = $cartid";
      $res  = oci_parse($conn, $sql);
      oci_execute($res);    
      if($res){
        include("email_invoice.php");      
      }
      header("Location: ordersuccess.php?success=$orderid&refresh=on");  
    }         
}

if(!empty($_GET['slot'])){
  $orderid = $_GET['slot'];
  if(empty($_GET['revisit'])){         
    if(isset($_POST['slotchoose'])){
        $slotid = $_POST['day'];
            $sql = "SELECT NUMBER_OF_ORDERS FROM COLLECTIONSLOT WHERE SLOTID='$slotid'";
            $res = oci_parse($conn, $sql);
            oci_execute($res);
            while($row=oci_fetch_assoc($res)){
              $numberoforders=$row['NUMBER_OF_ORDERS'];
            }            
            $numberoforders++;
        oci_free_statement($res);          
        $sql = "UPDATE ORDERS SET SLOTID='$slotid' WHERE ORDERID = '$orderid'";
        $res = oci_parse($conn, $sql);
        oci_execute($res);
        if($res){  
          $sql = "UPDATE COLLECTIONSLOT SET NUMBER_OF_ORDERS='$numberoforders' where SLOTID=$slotid";     
          $res = oci_parse($conn, $sql);
          oci_execute($res);     
          header("Location: ordersuccess.php?slot=$orderid&slotchoosed=true");
        }
    }
  }
}

?>
<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" 
    href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" 
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" 
    crossorigin="anonymous"/>
       <link rel="stylesheet" href="styles/ordersuccess.css" type="text/css"/>          
       <title>Order Confirmed</title>
</head>
<?php
include('base/navbar.php');
?>
<body>
<div class="container">               
             <?php                    
             $totals = 0;
               $sql = "Select * from orders where orderid = $orderid and purchased='YES'";
               $res = oci_parse($conn,$sql);
               oci_execute($res);
               while($row=oci_fetch_assoc($res)){
                   $sql1 = "Select * from orderdetails where orderid=$orderid";
                   $res1 = oci_parse($conn, $sql1);
                   oci_execute($res1);
                   while($row1=oci_fetch_assoc($res1)){
                       $total = $row1['TOTALPRICE'];
                       $totals = $totals + $total;
                   }
                   oci_free_statement($res1);
                   $order_date = $row['ORDERDATE'];
                   echo'<div class="row">              
                  <div class="col-md-3 collectionslot">';                                         
              if($row['SLOTID']>0){
                  $slot = $row['SLOTID'];
                $sql2 = "Select * from collectionslot where slotid = $slot";
                $res2 = oci_parse($conn, $sql2);
                oci_execute($res2);
                while($row2=oci_fetch_assoc($res2)){                           
                    echo'</br><p>Your order is set to be collected at:</p>';
                    echo'<table>
                    <tbody><tr>
                <td>Week</td>
                <td>: '.$row2['WEEK_COUNT'].'</td>
              </tr>
              <tr>
                <td>Day</td>
                <td>: '.$row2['DAY'].'</td>
              </tr>
              <tr>
              <td>Time Between</td>
                <td>: '.$row2['COLLECTIONTIME'].'</td>
              </tr>
              </tbody>
              </table>
              ';                    
                }
              }
              else{                
                echo'<p>Please select your collection time.</p>';
                include('slottime.php');                                          
              }                 
                   echo'</div>';
                   echo'<div class="col-md-4">
                   <div class="order">
                   <h5>Order Details</h5>
                  <table>
                    <tbody><tr>
                <td>Order number</td>
                <td>: '.$row['ORDERID'].'</td>
              </tr>
              <tr>
                <td>Date</td>
                <td>: '.$order_date.'</td>
              </tr>
              <tr>
                <td>Total</td>
                <td>: USD '.($totals+2).'</td>
              </tr>
              <tr>
                <td>Payment method</td>
                <td>: Paypal payments</td>
              </tr>
            </tbody></table>                   
                   </div></div>';
                   echo'<div class="col-md-5">
                   <div class="shippingaddress">
                   <h5>Shipping Details</h5>
                  <table>
                    <tbody><tr>
                <td>Name</td>
                <td>: '.$row['NAME'].'</td>
              </tr>
              <tr>
                <td>Town</td>
                <td>: '.$row['TOWN'].'</td>
              </tr>
              <tr>
                <td>Address</td>
                <td>: '.$row['ADDRESS'].'</td>
              </tr>
              <tr>
                <td>Zip Code</td>
                <td>: '.$row['ZIPCODE'].'</td>
              </tr>
            </tbody></table>                   
                   </div></div>';
               }
             ?>       
     </div>
     <div class="row">
     <div class="col-lg-12">
         <div class="ordered_products">
         <?php
         if(!empty($_GET['slotchoosed']) OR !empty($_GET['revisit'])){
          echo'<a href="shop.php" style="float:right;background-color:#f1f6f7;border:1px solid black;" class="btn">Shop More</a>';    
         }    
         ?>     
         <h3>Ordered Products</h3>             
             <hr>
             <div class="order_box">
<h2>Your Order</h2>
<ul class="list">
<li><a href="#"><h4>Product <span>Total</span></h4></a></li>
    <?php                            
        $total = 0;
      $sql = "Select * from orderdetails, product where orderid =$orderid and orderdetails.productid = product.productid";
      $res = oci_parse($conn, $sql);
      oci_execute($res);
      while($row=oci_fetch_assoc($res)){                                        
        echo'<li><a href="singleproduct.php?id='.$row['PRODUCTID'].'">'.$row['NAME'].' X'.$row['QUANTITY'].'<span class="last">$'.$row['TOTALPRICE'].'</span></a></li>';
        $total = $total+$row['TOTALPRICE'];
      }
    ?>                            
</ul>
<ul class="list list_2">
    <li><a href="#">Subtotal <span>$<?php echo $total; ?></span></a></li>
    <li><a href="#">Shipping <span>Flat rate: $2.00</span></a></li> 
    <hr>
    <li><a href="#">Total <span>$<?php echo ($total+2); ?></span></a></li>
</ul>                                                                           
     </div>
     </div>
    </div>
     </div>
    </div>
</body>
<?php
include('base/footer.php');
?>
</html>