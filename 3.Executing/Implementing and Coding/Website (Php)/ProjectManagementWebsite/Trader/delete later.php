<?php
include('../base/connect.php');
$error = 0;
$discount_id = 0;
$filename = null;
$userid = $_SESSION['userid'];
$shopid = $_SESSION['shopid'];
$productID = $_SESSION['id'];                
if(isset($_POST['submit'])){    
    //name
    $name =$_POST['name'];

    //description
    $details =$_POST['details'];

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
                $query = "UPDATE PRODUCT SET NAME='$name', DESCRIPTION='$details', PRICE='$price', QTYINSTOCK='$stock', IMAGE_NAME= '$filename' where PRODUCTID = $productID";                
             }
            else{
                if($discountexist==true){
                    $query = "UPDATE PRODUCT SET NAME='$name', DESCRIPTION='$details', PRICE='$price', QTYINSTOCK='$stock', DISCOUNTID='$discount_id', IMAGE_NAME='$filename' where PRODUCTID = $productID";
                } 
                else{
                    $query = "UPDATE PRODUCT SET NAME='$name', DESCRIPTION='$details', PRICE='$price', QTYINSTOCK='$stock', IMAGE_NAME= '$filename' where PRODUCTID = $productID";  
                }               
            }
            $result = oci_parse($conn, $query);
            oci_execute($result);        
            //header("Location: products.php?prod=$discount");
        }
        else{
            //$sql = "DELETE FROM DISCOUNT where USERID = '$userid'";
            $result = oci_parse($conn,$sql);
            oci_execute($result);
            //header("Location: updateproduct.php?id=$productID&dis_id=$disc_id&message=$msg");            
        }               
    }
?>