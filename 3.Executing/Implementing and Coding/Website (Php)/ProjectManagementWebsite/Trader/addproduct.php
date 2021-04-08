<?php
include('tradernavbar.php');
include('../base/connect.php');
$discount_id = 0;
$product_id = 0;
$error = 0;
$sql = "Select * from DISCOUNT";
$result = oci_parse($conn, $sql);
oci_execute($result);
while($row=oci_fetch_assoc($result))
{    
    $discount_id++;                        
}
$discount_id++;
oci_free_statement($result);

$sql = "Select * from PRODUCT";
$result = oci_parse($conn, $sql);
oci_execute($result);
while($row=oci_fetch_assoc($result))
{    
    $product_id++;                        
}
$product_id++;
oci_free_statement($result);
if(isset($_POST['submit'])){    
    $name = strtoupper($_POST['name']);    
    $details =strtoupper($_POST['details']);
    $product_type=$_POST['type'];
    if(is_numeric($_POST['price'])){
        $price = $_POST['price'];
    }
    else{
        $error++;
        $msg = "Price should be valid numeric value.";
    }    
    $stock = $_POST['stock'];
    if(!empty($_POST['discount'])){
        $discount = $_POST['discount'];    
    }  
    $userid = $_SESSION['userid'];
    $shopid = $_SESSION['shopid'];

    if(!empty($discount)){
        $sql = "INSERT INTO DISCOUNT (DISCOUNTID, AMOUNT, USERID) values ('$discount_id','$discount','$userid')";
        $res = oci_parse($conn, $sql);
        oci_execute($res);    
    }    
        if(isset($_FILES['image'])){            
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];            
            if(move_uploaded_file($file_tmp,"../images/products/".$file_name)){
                $error = 0;
            }
            else{
                $error++;
                $msg = "Cannot Upload file. Please try smaller size file.";
            }   
         if($error==0){
             if(!empty($discount)){
                $query = "INSERT INTO PRODUCT (PRODUCTID, NAME, DESCRIPTION, PRODUCT_TYPE, PRICE, QTYINSTOCK, SHOPID, USERID, DISCOUNTID, IMAGE_NAME) VALUES ('$product_id','$name','$details','$product_type','$price','$stock','$shopid','$userid','$discount_id','$file_name')";    
             }
            else{
                $query = "INSERT INTO PRODUCT (PRODUCTID, NAME, DESCRIPTION, PRODUCT_TYPE, PRICE, QTYINSTOCK, SHOPID, USERID, IMAGE_NAME) VALUES ('$product_id','$name','$details','$product_type','$price','$stock','$shopid','$userid','$file_name')";    
            }
            $result = oci_parse($conn, $query);
            oci_execute($result); 
            if($result){
                header("Location: products.php");
            }
            else{
                header("Location: addproduct.php?message=Error Try Again");
            }                   
        }
        else{
            $sql = "DELETE FROM DISCOUNT where DISCOUNTID = '$discount_id'";
            $result = oci_parse($conn,$sql);
            oci_execute($result);
            header("Location: addproduct.php?message=$msg");            
        } 
         }
                  
    }
?>
<link href="../styles/login.css" rel="stylesheet" type="text/css">
<div class="content" id="add">
<div class="container">  
        <div class="row justify-content-center">        
            <div class="col-md-6 col-sm-8">
            <div class="main">
            <p class="sign" align="center">Product Details</p>
            <?php 
            if(!empty($_GET['message'])){
                echo'<p>'.$_GET['message'].'</p>';
            }
            ?>
<form action="" method="POST" enctype="multipart/form-data">
<div class="row">
<div class="col-md-3">
<label class="text" for="product_name">Name:</label>    
</div>
<div class="col-md-8">
<input type="text" class="reg" placeholder="Product Name" name="name" autocomplete="off" required>
</div>
<div class="col-md-3">
<label class="text" for="product_description">Description:</label>    
</div>
<div class="col-md-8">
<textarea class="reg" name="details" placeholder="Allergy Info, Food Description" required="required" autocomplete="off"></textarea>    
</div>
<div class="col-md-3">
<label class="text" for="product_type">Type:</label>    
</div>
<div class="col-md-8">
    <select class="reg" name="type" required>
        <option value="">Select Food Type</option>
        <option value="VEG">VEG</option>
        <option value="NON-V">NON-VEG</option>
        <option value="BAKED">BAKED</option>
        <option value="PACKED">PACKED</option>
        <option value="FRUIT">FRUIT</option>
    </select>
</div>
<div class="col-md-3">
<label class="text" for="product_price">Price:</label>    
</div>
<div class="col-md-8">
<input type="text" class="reg" placeholder="Product Price" name="price" autocomplete="off" required>
</div>
<div class="col-md-3">
<label class="text" for="product_stock">Stock :</label>    
</div>
<div class="col-md-8">
<input type="number" class="reg" placeholder="Stock Quantity" name="stock" autocomplete="off" required>
</div>
<div class="col-md-3">
<label class="text" class="number" for="product_discount">Discount: </label>    
</div>
<div class="col-md-8">
<input type="number" class="reg" placeholder="Product Discount" name="discount" autocomplete="off">
</div>
<div class="col-md-4">
<label class="text" for="product_image">Image:</label>    
</div>
<div class="col-md-8">
<input type="file" name="image" accept='.jpg, .png, .jpeg, .gif' required>
</div>  
<div class="col-md-4">
</div>
<div class="col-md-8">
<input type="submit" class="regsubmit" name="submit" value="Add Product">
</div>
</div>
</form>
</div>
</div>        
</div>
</div> 
</div>