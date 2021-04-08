<?php 
include("base/connect.php");
$user = $_SESSION['userid'];
$sql = "Select * from cart where userid= $user";
$res = oci_parse($conn, $sql);
oci_execute($res);
while($row=oci_fetch_assoc($res)){
    $cartid = $row['CARTID'];
}
oci_free_statement($res);
$total = 0;
$sql = "Select * from product_cart, product where product_cart.cartid = '$cartid' and product_cart.productid = product.productid";
$res = oci_parse($conn, $sql);
oci_execute($res);
while($row=oci_fetch_assoc($res)){   
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
            $discountedprice = $row['PRICE']-($amount/100);          
            $total = $total + ($discountedprice*$row['QUANTITY']);
      }
      else{        
        $total = $total + ($row['PRICE']*$row['QUANTITY']);        
      }               
}
$shippingcharge=2;
$total = $total+ $shippingcharge;
echo $total;
?>