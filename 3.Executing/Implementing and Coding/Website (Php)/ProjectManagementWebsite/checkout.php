<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" 
    href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" 
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" 
    crossorigin="anonymous"/>
       <link rel="stylesheet" href="styles/checkout.css" type="text/css"/>    
       <script
    src="https://www.paypal.com/sdk/js?client-id=ASuU6IiEEaGi7LkNNG34sXMbHIx0FEbRQmJb8Fxa1JyOWS4Ou6oYAFCp_2BS_9Av83Sr4I6BPgEtLCEI"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
  </script>
       <title>Checkout</title>
</head>
<body>
    <?php     
include('base/connect.php');
include('base/navbar.php');
$user = $_SESSION['userid'];
$sql = "Select * from cart where userid= $user";
$res = oci_parse($conn, $sql);
oci_execute($res);
while($row=oci_fetch_assoc($res)){
    $cartid = $row['CARTID'];
}
oci_free_statement($res);
$sql = "Select orderid from orders where cartid='$cartid' and purchased='NO'";
$res = oci_parse($conn, $sql);
oci_execute($res);
while($row=oci_fetch_assoc($res)){
$order_id = $row['ORDERID'];
}
oci_free_statement($res);
?>
<div class="container">
<div class="row">
            <div id="checkout" class="col-lg-8 bill">  
            <button hidden type="button" id="paypal" class="btn btn-primary" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#exampleModal">
  Launch Paypal Modal Box
</button>            
<?php
if(!empty($_GET['orderid'])){
    $orderid = $_GET['orderid'];
    $_SESSION['order'] = $orderid;
    echo'<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment with Paypal</h5>                      
          </button>
        </div>
        <div class="modal-body">
        <p>Please Do not Close Or Refresh The Page.</p>
        <p>It will take some time to verify your transaction. You will be automatically redirected.</p>
        <div id="paypal-button-container"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>          
        </div>
      </div>
    </div>
    </div>';
}
?>
                    <h3>Shipping Details</h3>
                    <hr>
                    <?php                     
                     $cartexist = false;
                     $purchased = false;
                     $sql = "Select * from orders where cartid='$cartid' and PURCHASED='NO'";
                     $res = oci_parse($conn, $sql);
                     oci_execute($res);
                     while($row=oci_fetch_assoc($res)){
                         $cartexist = true;                         
                         if($row['PURCHASED']=="NO"){                                
                             $purchased = false;
                         }
                         else{
                             $purchased = true;
                         }                            
                     }
                     oci_free_statement($res);
                    echo'<form class="row contact_form" action="confirmorder.php?cart='.$cartid.'" method="post">';
                    ?>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="first" placeholder="First name" name="fname" autocomplete="off" required>                            
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="last" placeholder="Last name" name="lname" autocomplete="off" required>                            
                        </div>                        
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="number" placeholder="Phone number" name="number" autocomplete="off" required>                            
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="email" class="form-control" id="email" placeholder="Email Address" name="emailaddress" autocomplete="off" required>                            
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <select class="form-control" name="town" required>
                                 <option>Town/City</option>
                                <option value="Manchester">Manchester</option>
                                <option value="Barnsley">Barnsley</option>
                                <option value="Halifax">Halifax</option>
                                <option value="Huddersfield">Huddersfield</option>
                                <option value="Cleckheaton">Cleckheaton</option>
                                <option value="Bradfor">Bradford</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="add1" placeholder="Address line 01" name="add1" autocomplete="off" required>                            
                        </div>                        
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="Postcode/ZIP" autocomplete="off" required>
                        </div>                                                                   
                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        <ul class="list">
                            <li><a href="#"><h4>Product <span>Total</span></h4></a></li>
                            <?php             
                            $items=0;               
                            $total = 0;
                              $sql = "Select * from product_cart, product where product_cart.cartid = '$cartid' and product_cart.productid = product.productid";
                              $res = oci_parse($conn, $sql);
                              oci_execute($res);
                              while($row=oci_fetch_assoc($res)){ 
                                $items++; 
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
                                  $discountedprice = $row['PRICE'] - ($amount/100);
                                }                                         
                                echo'<li><a href="singleproduct.php?id='.$row['PRODUCTID'].'">'.$row['NAME'].' X'.$row['QUANTITY'].'<span class="last">';
                                if($amount>0){
                                  echo'$'.($discountedprice*$row['QUANTITY']).'</span></a></li>'; 
                                  $total = $total +  ($discountedprice*$row['QUANTITY']);
                                }
                                else{
                                  echo'$'.($row['PRICE']*$row['QUANTITY']).'</span></a></li>';  
                                  $total = $total + (($row['PRICE']*$row['QUANTITY']));
                                }                                                                                                
                              }
                              if($items==0){
                                echo"<script>alert('Add Some Products To Cart First');</script>";
                                echo"<script>setTimeout(function() {window.location.href= 'shop.php';}, 100);</script>";
                              }
                            ?>                            
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">Subtotal <span>$<?php echo $total; ?></span></a></li>
                            <li><a href="#">Shipping <span>Flat rate: $2.00</span></a></li>
                            <li><a href="#">Total <span>$<?php echo ($total+2); ?></span></a></li>
                        </ul>                                               
                        <div class="creat_account">
                            <input type="checkbox" id="f-option4" name="selector" required>
                            <label for="f-option4">I’ve read and accept the </label>
                            <a href="#">terms &amp; conditions*</a>
                        </div>                        
                        <div id="confirm-order">                                              
                       <?php
                        if($cartexist){
                            if(!$purchased){
                                echo'<a href="checkout.php?orderid='.$order_id.'" class="button button-paypal">Payment waiting.</a>';                                
                            }                            
                        }
                        else{
                            echo'<input type="submit" name="placeorder" class="button button-paypal" value="Place Order">';
                        }
                        ?>                        
                            </form>           
                            </div>                                                    
                    </div>
                </div>
            </div>            
</div>
<?php
include('base/footer.php');
?>
<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      //Get data from cart of logged in user
      return fetch('pricefromcart.php',{method:'GET'})
      .then(response => {
        return response.json()
      })
      .then(data => {
        const price = {purchase_units: [{
                        amount: {
                          value: data
                        }
                      }]};
        return actions.order.create(price);
      })
    },
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
                
        window.location.href = "ordersuccess.php?success=<?php echo $order_id ; ?>";
        //alert('Transaction completed by ' + details.payer.name.given_name);
      });
    }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
</script>
<script>
    document.getElementById("paypal").click();    
</script>
</html>