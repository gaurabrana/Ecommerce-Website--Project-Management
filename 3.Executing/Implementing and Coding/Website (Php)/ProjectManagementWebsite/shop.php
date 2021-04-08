<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop
    </title>
    <link rel="stylesheet" href="styles/shop.css">
  </head>
  <body>
    <?php
    //navigation area
include('base/navbar.php');
?>
    <div class="container">
      <div class="row">
        <!---Product Filter By Traders--->
        <div class="col-xl-2 col-lg-2 col-md-3 col-12">
          <div class="sidebar-categories">
            <div class="head">Trader Type
            </div>
            <ul class="main-categories">
              <li class="common-filter">
                <ul>
                  <li class="filter-list">
                    <a href="shop.php?shoptype=butcher">Butcher
                    </a>
                  </li>
                  <li class="filter-list">
                    <a href="shop.php?shoptype=greengrocer">GreenGrocer
                    </a>
                  </li>
                  <li class="filter-list">
                    <a href="shop.php?shoptype=fishmonger">Fishmonger
                    </a>
                  </li>
                  <li class="filter-list">
                    <a href="shop.php?shoptype=bakery">Bakery
                    </a>
                  </li>
                  <li class="filter-list">
                    <a href="shop.php?shoptype=delicatessen">Delicatessen
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <!---Product Filter By Food Type--->
          <div class="sidebar-filter">
            <div class="top-filter-head">Product Filters
            </div>
            <div class="common-filter">
              <ul>
                <li class="filter-list">
                  <a href="shop.php?foodtype=veg">Vegetables
                  </a>
                </li>
                <li class="filter-list">
                  <a href="shop.php?foodtype=non-veg">Non-Veg
                  </a>
                </li>
                <li class="filter-list">
                  <a href="shop.php?foodtype=fruit">Fruits
                  </a>
                </li>
                <li class="filter-list">
                  <a href="shop.php?foodtype=baked">Baked Items
                  </a>
                </li>
                <li class="filter-list">
                  <a href="shop.php?foodtype=packed">Instant Foods
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!---Product Filter By Specific Sort Filters--->
        <div class="col-xl-10 col-lg-10 col-md-9">
          <div class="row">
            <div class="topnav">
              <form method="POST" action="shop.php?sort=on">
                <select name="sortbytype">
                  <option value="Price"
                          <?php echo (isset($_POST['sortbytype']) && $_POST['sortbytype']=="Price") ? 'selected="selected"' : '';?>>Price
                  </option>
                <option value="Discount"
                        <?php echo (isset($_POST['sortbytype']) && $_POST['sortbytype']=="Discount") ? 'selected="selected"' : '';?>>Discounted Products
                </option>
              <option value="Alphabet"
                      <?php echo (isset($_POST['sortbytype']) && $_POST['sortbytype']=="Alphabet") ? 'selected="selected"' : '';?>>Alphabet
              </option>
            </select>
          <select name="sortbyorder">
            <option value="Ascending"
                    <?php echo (isset($_POST['sortbyorder']) && $_POST['sortbyorder']=="Ascending") ? 'selected="selected"' : '';?>>Ascending
            </option>
          <option value="Descending"
                  <?php echo (isset($_POST['sortbyorder']) && $_POST['sortbyorder']=="Descending") ? 'selected="selected"' : '';?>>Descending
          </option>
        </select>
      <input type="submit" name="sort" value="Sort By">
      <?php
      //clear sort filters
if(!empty($_GET['sort'])){
echo'<a class="clear_sort" href="shop.php">Clear Sort</a>';  
}      
?>
      </form>
    </div>
  </div>
<div class="row">
  <?php

  //databse connection
include('base/connect.php');
if(isset($_SESSION['userid'])){
$id = $_SESSION['userid'];      
}              
//sorting filter on     
if(!empty($_GET['sort'])){
if(isset($_POST['sort'])){
  
$sorttype = $_POST['sortbytype'];
$sortorder = $_POST['sortbyorder'];
if($sortorder=='Ascending'){
if($sorttype=='Price'){
$sql = "Select * from product order by price asc";
}
else if($sorttype=='Discount'){
$sql = "Select * from product where discountid >0 order by name asc ";
}
else if($sorttype=='Alphabet'){
$sql = "Select * from product order by name asc";
}
}
else{
if($sorttype=='Price'){
$sql = "Select * from product order by price desc";
}
else if($sorttype=='Discount'){
$sql = "Select * from product where discountid >0 order by name desc ";
}
else if($sorttype=='Alphabet'){
$sql = "Select * from product order by name desc";
}
}                      
}
}

//search option on
if(!empty($_GET['search'])){
if(isset($_POST['searchsubmit'])){
$search = strtoupper($_POST['searchtext']);         
$sql="Select * from product where upper(description) like '% $search%' OR upper(description) like '%$search %' OR upper(name) like '%$search%'";
}
}

//product filter on
if(!empty($_GET['shoptype'])){
  $page = "shoptype";
  $type = $_GET['shoptype'];
if($_GET['shoptype']=='butcher'){
$sql="Select * from product where SHOPID=1";
}
else if($_GET['shoptype']=='greengrocer'){
$sql="Select * from product where SHOPID=2";
}
else if($_GET['shoptype']=='fishmonger'){
$sql="Select * from product where SHOPID=3";
}
else if($_GET['shoptype']=='bakery'){
$sql="Select * from product where SHOPID=4";
}
else {
$sql="Select * from product where SHOPID=5";
}
}

//Product Filter by food type
if(!empty($_GET['foodtype'])){
  $page="foodtype";
  $type = $_GET['foodtype'];
if($_GET['foodtype']=='veg'){
$sql="select * from product where product_type like '%VEG%'";
}
else if($_GET['foodtype']=='non-veg'){
$sql="select * from product where product_type like '%NON-V%'";
}
else if($_GET['foodtype']=='fruit'){
$sql="select * from product where product_type like '%FRUIT%'";
}
else if($_GET['foodtype']=='packed'){
  $sql="select * from product where product_type like '%PACKED%'";
}
else{
$sql="select * from product where product_type like '%BAKED%'";
}        
}         

//if every filter is off
if(!(isset($_GET['shoptype']) OR isset($_GET['foodtype']) OR isset($_GET['sort']) OR isset($_GET['search']))){
$sql="Select * from product";
$shop=0;
$page = "all";
$type = "all";
}                
$result = oci_parse($conn, $sql);
oci_execute($result);

//fetching data from database
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
//products display
echo'<div class="col-lg-3 col-md-4 col-6">';
echo'<div class="card text-center card-product outline">';
if($amount!=0){
echo'<span class="status">'.$amount.'%</span>';
}
//product overlay
echo'<div class="card-product__img">
<img class="card-img" src="images/products/'.$row['IMAGE_NAME'].'">
<ul class="card-product__imgOverlay">';

if(!empty($_GET['sort']) OR !empty($_GET['search'])){
  $type = "all";
  $page = "all";
}

//if customer or trader has logged in
if(isset($_SESSION['usertype'])){

//if customer has logged in
if($_SESSION['usertype']==2){        
if($row['QTYINSTOCK']>1){
  
echo'<li><button><a href="mycart.php?type='.$type.'&page='.$page.'&tocart='.$productid.'"><i class="fas fa-cart-plus"></i></a></button></li>';                        
}
echo'<li><button><a href="base/addfav.php?type='.$type.'&page='.$page.'&id='.$productid.'"><i class="fas fa-heart"></i></a></button></li>';                              							                              
}
//if trader has logged in
else{  
echo'<h4>'.$shoptype.'</h4>';
}
}
//if a customer is viewing shop without logging in
//when clicked to cart, will be redirected to login page.
else{
echo'<li><button><a href="login.php"><i class="fas fa-cart-plus"></i></a></button></li>';
echo'<li><button><a href="base/addfav.php?type='.$type.'&page='.$page.'&id='.$productid.'"><i class="fas fa-heart"></i></a></button></li>';                              							                              
}                             				                      
echo'</ul>
</div>

<div class="card-body">';

//these condition shows message according to their nature

//when adding to cart is successful
if(!empty($_GET['success'])){
if($productid == $_GET['success']){
echo'<p>Added to cart.</p>';  
}                      
}

//when adding to favourites is succesful
if(!empty($_GET['fav'])){
  if($productid == $_GET['id']){
  echo'<p>Added to favourite.</p>';  
  }                      
  }

  //when a product already exits in users cart
if(!empty($_GET['error'])){
if($productid == $_GET['error']){
echo'<p>Already in cart.</p>';  
}                      
}

if(isset($_SESSION['usertype'])){
  if($_SESSION['usertype']==1){                            
echo $shoptype;
  }
}

//this part is to redirect user to detail of single product when clicked on product
echo'<h4 class="card-product__title"><a href="singleproduct.php?id='.$productid.'">'.$row['NAME'].'</a></h4>';
if($amount!=0){
  echo'<span class="discount">$'.$row['PRICE'].'</span>';
  echo'<span class="card-product__price">$'.($row['PRICE']-(($row['PRICE']*$amount)/100)).'</span>';  
}
else{
  echo'<p class="card-product__price">$'.$row['PRICE'].'</p>';
}
echo'<p>'.($row['QTYINSTOCK']).' in stock</p>
</div>
</div>
</div>';			                          
}
oci_free_statement($result);       
?>      
</div>
</div>
</div>
<?php
//footer area
include('base/footer.php');
?>
</body>
</html>
