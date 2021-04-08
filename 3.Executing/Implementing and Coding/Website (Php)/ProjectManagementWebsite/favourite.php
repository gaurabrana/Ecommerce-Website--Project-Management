<?php
include('base/connect.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Favourites</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="styles/cart.css" rel="stylesheet" type="text/css">
    <link href="styles/shop.css" rel="stylesheet" type="text/css">
</head>
<?php  
    include('base/navbar.php');
?>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-bodys">
          <h2>My Favourites</h2>
        </div>
      </div>
    </div>
    <div class="row">      
      <div class="col-md-12" style="overflow-x:auto;">   
  <?php             
if(isset($_COOKIE['User'])){
    echo"<div class='col-md-6'><a class='del' href='base/deletefav.php?delete=all'>Delete all favourites</a></div></div><div class='row'>";        
    foreach ($_COOKIE['User'] as $name => $values) {
            $products = "select * from product where productid='$values'";
            $result=oci_parse($conn, $products);
            oci_execute($result);
            while($row=oci_fetch_assoc($result)){
                $productid = $row['PRODUCTID'];
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
                    if($row['SHOPID']==1){
                        $shoptype = "Butcher";
                        }
                        else if($row['SHOPID']==2){
                        $shoptype = "GreenGrocer";
                        }
                        else if($row['SHOPID']==3){
                        $shoptype = "Fishmonger";
                        }
                        else if($row['SHOPID']==4){
                        $shoptype = "Bakery";
                        }
                        else{
                        $shoptype = "Delicatessen";
                        }
                echo'<div class="col-lg-3 col-md-4 col-6">';
                echo'<div class="card text-center card-product outline">';
                if($amount!=0){
                echo'<span class="status">'.$amount.'%</span>';
                }
                //product overlay
                echo'<div class="card-product__img">
                <img class="card-img" src="images/products/'.$row['IMAGE_NAME'].'">
                <ul class="card-product__imgOverlay">';
                if(isset($_SESSION['usertype'])){
                if($_SESSION['usertype']==2){        
                                      if($row['QTYINSTOCK']>1){
                                        echo'<li><button><a href="mycart.php?fromfav=on&tocart='.$productid.'"><i class="fas fa-cart-plus"></i></a></button></li>';                        
                                      }                
                }
                else{
                echo'<h4>'.$shoptype.'</h4>';
                }
                }
                else{
                echo'<li><button><a href="login.php"><i class="fas fa-cart-plus"></i></a></button></li>';
                }                             				                      
                echo'</ul>
                </div>
                <div class="card-body">';
                if(!empty($_GET['success'])){
                    if($productid == $_GET['success']){
                    echo'<p>Added to cart.</p>';  
                    }                      
                    }
                    if(!empty($_GET['error'])){
                        if($productid == $_GET['error']){
                        echo'<p>Already in cart.</p>';  
                        }                      
                        }                
                echo'<h4 class="card-product__title"><a href="singleproduct.php?id='.$productid.'">'.$row['NAME'].'</a></h4>';
                if($amount!=0){
                  echo'<span class="discount">$'.$row['PRICE'].'</span>';
                  echo'<span class="card-product__price">$'.($row['PRICE']-(($row['PRICE']*$amount)/100)).'</span>';  
                }
                else{
                  echo'<p class="card-product__price">$'.$row['PRICE'].'</p>';
                }
                echo'<p>'.($row['QTYINSTOCK']).' in stock</p><br>
                <a style="border:1px solid black;background-color:#82ae46;color:white !important; padding:8px;" href="base/deletefav.php?id='.$productid.'&delete=one">Remove</a>
                </div>
                </div>
                </div>';
            }
        }
        }
else {
echo"<div class='container'><div class='row'><div class='col-md-12'><h2>NO FAVOURITES FOUND</h2></div></div></div>";  
}  
?> 
    </div>    
  </div>
</div>
</body>
<?php
include('base/footer.php');
?>
</html>