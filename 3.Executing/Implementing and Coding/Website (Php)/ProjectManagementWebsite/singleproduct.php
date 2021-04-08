<!DOCTYPE HTML>
<html>
<head>
    <title>Networked Appetite </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        .product_image img{
            width:100%;
        }
        .related_product img{
            width:100%;
            height:135px;
        }
        .related_product h5{
            text-align: center;
            margin-top:5px;
        }
        .checked{
            color:orange;
        }
        #write_review textarea{
            width: 600px !important;
            height:100px;
        }
        @media screen and (max-width: 700px) {  
            #write_review textarea{
            width: 500px !important;            
        }
        #write_review input{
            width:60%;
        }
    }
        @media screen and (max-width: 500px) {  
            #write_review textarea{
            width: 350px !important;            
        }
    }
        @media screen and (max-width: 350px) {  
            #write_review textarea{
            width: auto !important;            
        }           
    }   
.reg {
    font-family: 'Nova Round', cursive;
    width: 20%;
    color: rgb(38, 50, 56);
    font-weight: 700;
    font-size: 14px;
    letter-spacing: 1px;
    background: rgba(136, 126, 126, 0.04);
    padding: 10px 20px;
    border-radius: 20px;
    outline: none;
    box-sizing: border-box;
    border: 2px solid rgba(0, 0, 0, 0.02);
    text-align: center;
    margin-bottom:10px;
    }

    .reg:focus{
        border: 2px solid rgba(0, 0, 0, 0.18) !important;
        
    }
    .reg1 {
    font-family: 'Nova Round', cursive;
    width: 100%;
    color: rgb(38, 50, 56);
    font-weight: 700;
    font-size: 14px;
    letter-spacing: 1px;
    background: rgba(136, 126, 126, 0.04);
    padding: 10px 20px;
    border-radius: 20px;
    outline: none;
    box-sizing: border-box;
    border: 2px solid rgba(0, 0, 0, 0.02);
    text-align: center;
    margin-bottom:10px;
    }

    .reg1:focus{
        border: 2px solid rgba(0, 0, 0, 0.18) !important;
        
    }

    .userimage{
        width:60px;
        height: 60px;
    }
.edit{
    padding-left:5px;
    padding-right:5px;
    margin-left:10px;
    font-weight: bold;
}
.ratings{
    font-size: 50px;
    color:orange;
}
.total{
    font-size: 30px;
    color:orange;
}
.review_on{
    margin-left:30px;
    background: brown;
    border:1px solid brown;
    padding:10px;
    color:white;
    border-radius: 10px;
}
.review_on:hover{
    background: white;
    color:brown;
}

    </style>
</head>
<?php
include('base/connect.php');
include('base/navbar.php');
?>
<body>
<div class="container">
<div class="row">
<?php
if(!empty($_GET['id'])){
    $product_id = $_GET['id'];
    $total = 0;
$usereviews = 0;
$sql = "select rate from review where productid = $product_id";
$result = oci_parse($conn,$sql);
oci_execute($result);
while($row=oci_fetch_assoc($result)){    
    $total = $total + $row['RATE'];
    $usereviews++;
}
oci_free_statement($result);
    $sql = "Select * from product where productid = $product_id";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    while($row = oci_fetch_assoc($result)){
        $shop_id = $row['SHOPID'];
        echo'<div class="col-lg-6">  
        <div class="product_image">
        <img src="images/products/'.$row['IMAGE_NAME'].'" alt="product image">
        </div>
        </div>';        
                    echo'<div class="col-lg-6">
                    <h3>'.$row['NAME'].'</h3>
                    <hr>
                    <h4>Price: £'.$row['PRICE'].'</h4>';
                    if($row['PRODUCT_TYPE']=="NON-V"){
                        echo'<h4>Product Type: Non-Veg</h4>';
                    }
                    else{
                        echo'<h4>Product Type: '.$row['PRODUCT_TYPE'].'</h4>';
                    }                    
                    if($total>0 AND $usereviews>0){
                        if(intdiv($total, $usereviews) == 1){
                            echo'<span class="fas fa-star checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>';
                        }
                        else if(intdiv($total, $usereviews) == 2){
                            echo'<span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>';
                        }
                        else if(intdiv($total, $usereviews) == 3){
                            echo'<span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star"></span>
                            <span class="fas fa-star"></span>';
                        }
                        else if(intdiv($total, $usereviews) == 4){
                            echo'<span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star"></span>';
                        }
                        else{
                            echo'<span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star checked"></span>
                            <span class="fas fa-star chekced"></span>';
                        }
                    }                    
                    echo'</h4>';                    
                    echo'<hr>
                    <p>'.$row['DESCRIPTION'].'</p>
</div>';
    }
    oci_free_statement($result);
}
?>
</div>
<hr>
<h5>Related Products</h5>
<hr>
<div class="row">    
    <div class="col-lg-12">                 
        <div class="row">
    <?php
    $id = 0;
    $sql = "Select * from product where shopid = $shop_id and productid != $product_id";
    $result = oci_parse($conn,$sql);
    oci_execute($result);
    while($row=oci_fetch_assoc($result)){        
        if($id<4){
            echo'<div class="related_product col-lg-3">            
            <a href="singleproduct.php?id='.$row['PRODUCTID'].'"><img src="images/products/'.$row['IMAGE_NAME'].'"></a>
            <h5>'.$row['NAME'].'</h5>
            </div>';
        }
        $id++;        
    }
    oci_free_statement($result);
    ?>
    </div>
    </div>
</div>
<div class="row">
<div class="reviews col-lg-12">
<h5>Customer Reviews</h5>
<?php
if($total>0 AND $usereviews>0){
    $ratingnums = intdiv($total, $usereviews);
echo"<span class='ratings'>$ratingnums.0</span><span class='total'>/5</span><br/>";
if(intdiv($total, $usereviews) == 1){
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>';
}
else if(intdiv($total, $usereviews) == 2){
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>';
}
else if(intdiv($total, $usereviews) == 3){
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>';
}
else if(intdiv($total, $usereviews) == 4){
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star"></span>';
}
else{
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star chekced"></span>';
}
}
?>
<?php
if(isset($_SESSION['usertype'])){
    if($_SESSION['usertype']==2){
echo'<button class="review_on" onclick="myFunction()">Write Review</button>';
    }
    if($usereviews>0){
        echo"<br/>$usereviews reviews";
    }
}
?>
<?php
echo'<form action="base/addreview.php?id='.$product_id.'" method="POST">';
?>
<div id="write_review">    
</div>
</form>
</div>
</div>
<hr>
<?php
$sql = "select * from review, users where review.userid = users.userid and review.productid=$product_id";
$result = oci_parse($conn,$sql);
oci_execute($result);
while($row=oci_fetch_assoc($result)){    
    echo'<div class="row"><div class="col-md-5"><hr>';
    $reviewid = $row['REVIEWID'];
    $description =$row['DESCRIPTION'];
    $rate = $row['RATE'];
    if($row['IMAGE_NAME']!=null)
    {
        echo"<img class='userimage' src='images/users/".$row['IMAGE_NAME']."' alt='no avatar'>";
    }                                   
    else{
        echo"<img class='userimage' src='images/users/user.png' class='mx-auto img-fluid img-circle d-block' alt='avatar'>";
    }            
if($row['RATE']==1){
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>';
}
else if($row['RATE']==2){
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>';
}
else if($row['RATE']==3){
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star"></span>
    <span class="fas fa-star"></span>';
}
else if($row['RATE']==4){
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star"></span>';   
}
else{
    echo'<span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>
    <span class="fas fa-star checked"></span>';
}
echo" By ".$row['NAME'];
if(isset($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
    if($userid == $row['USERID']){
        echo"<a href='singleproduct.php?id=$product_id&edit=$reviewid' class='edit'>
        Edit Review<br>
        </a>";
    }
}
echo "<br>";
echo $row['DESCRIPTION'];
echo'</div></div>';
}
if($usereviews==0){
    echo'No reviews yet.';
}
if(!empty($_GET['edit'])){
echo'<button hidden id="editinitiate" onclick="edit()" type="button">Edit</button>';
}
?>
<button hidden type="button" id="edit_review" data-toggle="modal" data-target="#editreview">
  Edit Review
</button>
<div class="modal fade" id="editreview" tabindex="-1" role="dialog" aria-labelledby="reviewediting" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        if(!empty($_GET['edit'])){
            $revid = $_GET['edit'];
            $sql = "select * from review where reviewid = $revid";
            $result = oci_parse($conn,$sql);
            oci_execute($result);
while($row=oci_fetch_assoc($result)){
    $productid=$row['PRODUCTID'];
    echo'<form action="base/addreview.php?id='.$productid.'&update='.$revid.'" method="POST">';             
    echo"<input class='reg1' type='number' min=1 max=5 name='rating' placeholder='Rate 1-5' value='".$row['RATE']."'><br/>
    <textarea class='reg1' name='description' placeholder='Write Your Review'>".$row['DESCRIPTION']."</textarea><br/>";
}
        }       
        ?>        
      </div>
      <div class="modal-footer">        
      <?php
      echo'<a style="color:#fff !important;" href="base/addreview.php?id='.$productid.'&delete='.$revid.'" class="btn btn-secondary">Delete Review</a>';
      ?>      
        <input type='submit' class="btn btn-success" value="Save Changes" name='review'>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<hr>
</body>
<?php 
include('base/footer.php');
?>
<script>    
document.getElementById("editinitiate").click();
    function myFunction(){
        document.getElementById('write_review').innerHTML="<br/><input class='reg' type='number' min=1 max=5 name='rating' placeholder='Rate 1-5'><br/><textarea class='reg' name='description' placeholder='Write Your Review'></textarea><br/><input class='reg' type='submit' name='review'>";
    }   
    function edit(){
        document.getElementById("edit_review").click();
    }         
</script>
</html>