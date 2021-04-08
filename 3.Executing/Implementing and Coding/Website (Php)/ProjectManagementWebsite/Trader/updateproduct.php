<?php
include('tradernavbar.php');
include('../base/connect.php');
$error = 0;
$discount_id = 0;
$filename = null;                
if(isset($_POST['submit'])){    
    $userid = $_SESSION['userid'];
    $shopid = $_SESSION['shopid'];
    $productID = $_SESSION['id'];

    //name
    $name =strtoupper($_POST['name']);

    //description
    $details =strtoupper($_POST['details']);

    $product_type =$_POST['type'];

    //price
    if(is_numeric($_POST['price'])){
        $price = $_POST['price'];
    }
    else{
        $error++;
        $msg = "Price should be valid numeric value.";
    }    

    //stock
    $stock = $_POST['stock'];

    //discount

    //if discount id exist
    if(($_SESSION['discount'])>0){        
        $disc_id=$_SESSION['discount'];

        //if discount amount exist
        if(!empty($_POST['discount'])>0){
            $discount = $_POST['discount'];               
            $sql = "UPDATE DISCOUNT SET AMOUNT = '$discount' where DISCOUNTID = $disc_id";
            $res = oci_parse($conn, $sql);
            oci_execute($res);   
            oci_free_statement($res);
        }
        //if discount amount does not exist
        else{                
            $sql= "UPDATE PRODUCT SET DISCOUNTID='' where PRODUCTID ='$productID'";
            $res = oci_parse($conn, $sql);
            oci_execute($res);   
            oci_free_statement($res);
            $sql = "DELETE FROM DISCOUNT WHERE DISCOUNTID = $disc_id";
            $res = oci_parse($conn, $sql);
            oci_execute($res);   
            oci_free_statement($res);
        }  
    }

    //if discount id does not exist
    else{
        //if user has entered new discount amount for product
    if(!empty($_POST['discount'])>0){
    $discountexist = true;    
    $sql = "Select * from DISCOUNT";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    while($disc=oci_fetch_assoc($result))
    {    
    $discount_id++;                        
    }
    $discount_id++;
        oci_free_statement($result);
        $user = $_SESSION['userid'];    
        $discount = $_POST['discount'];        
        $sql = "INSERT INTO DISCOUNT (DISCOUNTID, AMOUNT, USERID) values ('$discount_id','$discount','$user')";
        $res = oci_parse($conn, $sql);
        oci_execute($res);    
        }
        else{
            $discountexist = false;
        }
    }
    
    if(isset($_FILES['image'])){          
        if(!empty($_FILES['image']['size'])){
            $filename = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];            
                $file_tmp = $_FILES['image']['tmp_name'];
                if (file_exists("../images/products/".$filename)) {
                    $error++;
                    $msg = "File Already Exist.";                                  
                }  
                else{
                    if(move_uploaded_file($file_tmp,"../images/products/".$filename)){
                        $error = 0;                    
                    }
                    else{
                        $error++;
                        $msg = "Cannot Upload file. Please try smaller size file.";                    
                    }          
            }                        
            }                            
        }                    
        if(!isset($filename)){
            $filename = $_POST['images'];
        }                                
         if($error==0){
            if(($_SESSION['discount'])>0){             
                $query = "UPDATE PRODUCT SET NAME='$name', DESCRIPTION='$details', PRODUCT_TYPE='$product_type',PRICE='$price', QTYINSTOCK='$stock', IMAGE_NAME= '$filename' where PRODUCTID = $productID";                
             }
            else{
                if($discountexist==true){
                    $query = "UPDATE PRODUCT SET NAME='$name', DESCRIPTION='$details', PRODUCT_TYPE='$product_type', PRICE='$price', QTYINSTOCK='$stock', DISCOUNTID='$discount_id', IMAGE_NAME='$filename' where PRODUCTID = $productID";
                } 
                else{
                    $query = "UPDATE PRODUCT SET NAME='$name', DESCRIPTION='$details', PRODUCT_TYPE='$product_type', PRICE='$price', QTYINSTOCK='$stock', IMAGE_NAME= '$filename' where PRODUCTID = $productID";  
                }               
            }
            $result = oci_parse($conn, $query);
            oci_execute($result);        
            if(!empty($_GET['basic'])){
                header("Location: products.php?basic=on");
              }
              else{
                header("Location: products.php");
              }              
        }
        else{
            $sql = "DELETE FROM DISCOUNT where USERID = '$userid'";
            $result = oci_parse($conn,$sql);
            oci_execute($result);
            header("Location: updateproduct.php?id=$productID&message=$msg");            
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
    <?php
    include('../base/connect.php');
    if(!empty($_GET['id'])){        
        $id = $_GET['id'];
        $_SESSION['id'] = $id;
        $sql ="Select * from product where PRODUCTID = $id";
        $result = oci_parse($conn, $sql);
        oci_execute($result);
        while($row=oci_fetch_assoc($result))
        {   
            $discount_id = $row['DISCOUNTID'];            
            if(!empty($discount_id)){                
                $_SESSION['discount'] = $discount_id;
                $sql = "Select AMOUNT from discount where DISCOUNTID = $discount_id";
                $res = oci_parse($conn, $sql);
                oci_execute($res);
                while($hi=oci_fetch_assoc($res))
                {
                    $amount =$hi['AMOUNT'];
                }
                oci_free_statement($res);
              }
              else{
                $_SESSION['discount'] = 0;
                  $amount = 0;
              }
            echo'<div class="col-md-3">
            <label class="text" for="product_name">Name:</label>    
            </div>
            <div class="col-md-8">
            <input type="text" class="reg" placeholder="Product Name" name="name" value="'.$row['NAME'].'" autocomplete="off" required>
            </div>
            <div class="col-md-3">
            <label class="text" for="product_description">Description:</label>    
            </div>
            <div class="col-md-8">
            <textarea class="reg" name="details" placeholder="Allergy Info, Food Type" required="required" autocomplete="off">'.$row['DESCRIPTION'].'</textarea>    
            </div>
            <div class="col-md-3">
            <label class="text" for="product_type">Type:</label>    
            </div>
            <div class="col-md-8">
                <select class="reg" name="type" required>
                    <option value="">Select Food Type</option>
                    <option value="VEG"';echo (isset($row['PRODUCT_TYPE']) && $row['PRODUCT_TYPE']=="VEG") ? 'selected="selected"' : '';echo'>VEG</option>
                    <option value="NON-V"';echo (isset($row['PRODUCT_TYPE']) && $row['PRODUCT_TYPE']=="NON-V") ? 'selected="selected"' : '';echo'>NON-VEG</option>
                    <option value="BAKED"';echo (isset($row['PRODUCT_TYPE']) && $row['PRODUCT_TYPE']=="BAKED") ? 'selected="selected"' : '';echo'>BAKED</option>
                    <option value="PACKED"';echo (isset($row['PRODUCT_TYPE']) && $row['PRODUCT_TYPE']=="PACKED") ? 'selected="selected"' : '';echo'>PACKED</option>
                    <option value="FRUIT"';echo (isset($row['PRODUCT_TYPE']) && $row['PRODUCT_TYPE']=="FRUIT") ? 'selected="selected"' : '';echo'>FRUIT</option>
                </select>
            </div>
            <div class="col-md-3">
            <label class="text" for="product_price">Price:</label>    
            </div>
            <div class="col-md-8">
            <input type="text" class="reg" placeholder="Product Price" name="price" value="'.$row['PRICE'].'" autocomplete="off" required>
            </div>
            <div class="col-md-3">
            <label class="text" for="product_stock">Stock :</label>    
            </div>
            <div class="col-md-8">
            <input type="number" class="reg" min="1" placeholder="Stock Quantity" name="stock" value="'.$row['QTYINSTOCK'].'" autocomplete="off" required>
            </div>
            <div class="col-md-3">
            <label class="text" class="number" for="product_discount">Discount: </label>    
            </div>
            <div class="col-md-8">
            <input type="number" min="0" class="reg" placeholder="Product Discount" name="discount" value="'.$amount.'" autocomplete="off">
            </div>
            <div class="col-md-4">
            <label class="text" for="product_image">Image:</label>    
            </div>
            <div class="col-md-8">
            <input hidden type="text" class="reg" placeholder="Product Image" name="images" value="'.$row['IMAGE_NAME'].'" autocomplete="off" required>
            <input type="file" name="image" accept=".jpg, .png, .jpeg, .gif">
            <p>Upload New Image or Leave As It Is.</p>
            </div>  
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
            <input type="submit" class="regsubmit" name="submit" value="Update">
            </div>';            
        }
        
    }    
    ?>
</div>
</form>
</div>
</div>        
</div>
</div> 
</div>