<?php
include('base/connect.php');
if(!isset($_SESSION['usertype'])){
  header("Location: shop.php");
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>My Cart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="styles/cart.css" rel="stylesheet" type="text/css">
</head>
<?php  
  $userid = $_SESSION['userid'];
  $sql ="Select cartid from cart where userid=$userid";
  $res = oci_parse($conn, $sql);
  oci_execute($res);
  while($row=oci_fetch_assoc($res)){
    $cartid = $row['CARTID'];
  }
  oci_free_statement($res);
  if(!empty($_GET['id'])AND!empty($_GET['cart'])){
    $cart = $_GET['cart'];
    $id = $_GET['id'];
    if(isset($_POST['quantityupdate'])){
      $quantityupdate = $_POST['quantity'];            
        $sql = "Update product_cart set quantity='$quantityupdate' where productid='$id' and cartid='$cart'";
        $result = oci_parse($conn,$sql);
        oci_execute($result);
        if($result){
          header("Location: mycart.php");        
      }      
    }
  }

  if(!empty($_GET['clearcart'])){
    $cartsid = $_SESSION['cartid'];    
    $sql = "Delete from product_cart where cartid = $cartsid";
  $result = oci_parse($conn,$sql);
  oci_execute($result);
  oci_free_statement($result);
  header("Location: mycart.php?message=deleted");
  }

  if(!empty($_GET['removeid'])){
    $cartsid = $_SESSION['cartid'];
    $removeid =$_GET['removeid'];
    $sql = "Delete from product_cart where productid = $removeid and cartid = $cartsid";
  $result = oci_parse($conn,$sql);
  oci_execute($result);
  oci_free_statement($result);
  header("Location: mycart.php?message=deleted");
  }  
  //check if item already exist in cart
  $no_of_data = 0;
  $alreadyproductincart[]=null;
  $sql = "Select * from cart, product_cart where cart.userid = $userid and product_cart.cartid = cart.cartid";
  $result = oci_parse($conn,$sql);
  oci_execute($result);    
  while($row=oci_fetch_assoc($result)){
    $alreadyproductincart[] = $row['PRODUCTID'];
    $_SESSION['cartid'] = $row['CARTID'];    
    $no_of_data++;        
  }
  oci_free_statement($result);  
  
if(!empty($_GET['tocart'])){
  $page = $_GET['page'];
    $type = $_GET['type'];
  $prod_id = $_GET['tocart'];  
  if(in_array($prod_id, $alreadyproductincart, TRUE)){
    if(!empty($_GET['fromfav'])){
      header("Location: favourite.php?error=$prod_id");    
    }
    else{      
      header("Location: shop.php?$page=$type&error=$prod_id");    
    }    
  }  
  else{
    $sql = "INSERT INTO product_cart(productid, cartid, quantity) values('$prod_id','$cartid','1')";
    $result = oci_parse($conn,$sql);
    oci_execute($result);
    if(!empty($_GET['fromfav'])){
      header("Location: favourite.php?success=$prod_id");
    }
    else{      
      header("Location: shop.php?$page=$type&success=$prod_id");
    }
    
  }  
}
include('base/navbar.php');
?>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-bodys">
          <h2>My Shopping Cart</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
      if(!empty($_GET['message'])){
        echo"<p>Product Removed From Cart.</p>";
        echo"<script>setTimeout(function() {window.location.href= 'mycart.php';}, 2000);</script>";
      }
      
      ?>
      <div class="col-md-12" style="overflow-x:auto;">
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Product</th>      
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php             
  if($no_of_data>0)
  {
    $subtotal = 0;
    $SN = 0;      
    $sql = "Select * from product_cart, product where product_cart.cartid = '$cartid' and product_cart.productid = product.productid";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    while($row=oci_fetch_assoc($result)){    
      $SN++;                              
        $cart_products = $row['PRODUCTID'];
        $quantity = $row['QUANTITY'];
        $stock = $row['QTYINSTOCK'] - 1;        
        if(!empty($row['DISCOUNTID'])){
          $discount_id = $row['DISCOUNTID'];
          $sql1 = "Select AMOUNT from DISCOUNT where DISCOUNTID=$discount_id";
          $res = oci_parse($conn, $sql1);
          oci_execute($res);
          while($hi = oci_fetch_assoc($res)){            
            $amount = $hi['AMOUNT'];
          }
        }
        else{           
         $amount = 0; 
        }                 
        $discountedprice = ($row['PRICE'])-($amount/100);        
        echo'
        <tr>        
        <form action="mycart.php?id='.$cart_products.'&cart='.$cartid.'" method="POST">
        <td><img class="image" src="images/products/'.$row['IMAGE_NAME'].'"> &nbsp; &nbsp;'.$row['NAME'].'</td>';        
        if($amount>0){
          echo'<td class="description"><span class="undiscount">$'.$row['PRICE'].'</span> / $'.$discountedprice.'</td>';   
          $total = ($discountedprice*$quantity);       
        }
        else{
          echo'<td class="description">$'.$row['PRICE'].'</td>';          
          $total = ($row['PRICE']*$quantity);
        }        
        echo'<td class="description"><input type="number" value="'.$quantity.'" min=1 max='.$stock.' name="quantity"></td>
        <td class="description"><span>$'.$total.'</span></td>                
        <td class="description">
        <input class="hi" type="submit" name="quantityupdate" value="Update Quantity"> /
        </form>
        <a href="mycart.php?removeid='.$cart_products.'">Remove</a></td>
      </tr>';   
        $subtotal = $subtotal + $total;
        }       
      } 
    else{
      echo'<tr>
      <th>0</th>
      <td>No Item in Cart</td>
      <td>No Item in Cart</td>
      <td>No Item in Cart</td>
      <td>No Item in Cart</td>
      <td>No Item in Cart</td>
      </tr>';
    }   
?>    
  </tbody>
</table>
<?php
if($no_of_data>0){
  echo'<a class="btn cartbutton" href="mycart.php?clearcart=true">Clear My Cart</a>';
}
?> 
    </div>    
  </div>
  <div class="row">
    
  <div class="col-md-12">
  <hr>
  <div class="row">
  <div class="col-md-8">
  </div>  
    <?php    
if($no_of_data>0){
  echo'<div class="col-md-4">
    <span>Subtotal</span>    
    <span style="float:right;">$'.$subtotal.'</span><br/>
    <span>Local Delivery</span>
    <span style="float:right;">Delivery Charge: $2.00</span>
    <hr>';
  echo'<a class="btn cartbutton" href="checkout.php">Proceed To Checkout</a>';
}
?> 
  </div>
  </div>
  <hr>
  </div>
    </div>
</div>
</body>
<?php
include('base/footer.php');
?>
</html>