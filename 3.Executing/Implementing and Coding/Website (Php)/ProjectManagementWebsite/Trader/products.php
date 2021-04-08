<?php
include('tradernavbar.php');
include('../base/connect.php');
if(!empty($_GET['deleteid'])){
$id_to_delete = $_GET['deleteid'];
$sql = "Select PRODUCTID from orderdetails where productid = $id_to_delete";
$result = oci_parse($conn, $sql);
oci_execute($result);
while($row=oci_fetch_assoc($result)){
  $exist = true;
}
if($exist){
  if(!empty($_GET['basic'])){
    header("Location: products.php?basic=on&delete=record");
  }
  else{
    header("Location: products.php?delete=record");
  }
}
else{
  $sql = "Delete from product where PRODUCTID = $id_to_delete";
  $result = oci_parse($conn, $sql);
  oci_execute($result);
  if($result){
    if(!empty($_GET['dis_id'])){
      $dis_id_to_delete = $_GET['dis_id'];
      $sql = "Delete from discount where DISCOUNTID = $dis_id_to_delete";
      $res = oci_parse($conn, $sql);
      oci_execute($res);
    }
    if(!empty($_GET['basic'])){
      header("Location: products.php?basic=on&id=$id_to_delete");
    }
    else{
      header("Location: products.php?id=$id_to_delete");
    } 
}
 
}
}
  ?>
  <style>
    .product{
      font-family: 'Acme', sans-serif !important;
      border: 1px solid #1CAC78;
      padding:10px;
      margin-top:10%;
      background-color: white;
    }
    .product img{
      width:100%;
      height:120px;
    }
    .product p{       
      height:80px;     
      overflow: scroll;
    }
    .tableimg{
      width:100%;
    }
    @media screen and (max-width: 320px) {     
      .product p{       
      height:20px;           
    }
    hr{
      margin-top:2px;
      margin-bottom:2px;
    }
    
    }
    @media screen and (max-width: 375px) {  
      .content{
        font-size:small !important;
      }   
      .product p{       
      height:25px;           
    }
    .add{      
      padding:2px;
    }
    .ok{        
        width:45%;
        padding:0px;
      }
    }
    @media screen and (max-width: 1024px) {
      .add{      
      padding:4px;
    }
    .ok{        
        width:48%;
        padding:0px;
      }
    }
  </style>
  <div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
      <a  style="margin-top:10px;" class="add btn btn-success" href="addproduct.php#add">Add New Product</a>      
      <?php
           if(!empty($_GET['basic'])){
            echo'<a  style="margin-top:10px;" class="add btn btn-warning" href="products.php">Comfortable Product View</a>';
            echo'<div class="col-md-12" style="overflow-x:auto; margin-top:5px;">
            <table class="table table-striped">            
            <thead>
              <tr>
                <th scope="col">SN</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Type</th>
                <th scope="col">Price</th>
                <th scope="col">QtyInStock</th>
                <th scope="col">Discount</th>
                <th scope="col">Action</th>                   
              </tr>
            </thead>
            <tbody>';
          } 
          else{
            echo'<a  style="margin-top:10px;" class="add btn btn-warning" href="products.php?basic=on">Basic Table View</a>';
          }
          if(!empty($_GET['delete'])){
            echo"<h4>Record Found In Orders. Cannot Delete Product.</h4>";            
          }
      if(!empty($_GET['id'])){        
        echo"<h4>Product ID: ".$_GET['id']." deleted.</h4>";
        if(!empty($_GET['basic'])){
          echo"<script>setTimeout(function() {window.location.href= 'products.php?basic=on';}, 3000);</script>";
        }
        else{
          echo"<script>setTimeout(function() {window.location.href= 'products.php';}, 3000);</script>";
        }          
      }
      if(!empty($_GET['prod'])){
        echo $_GET['prod'];
      }
      $id = $_SESSION['userid'];
      $no_data = 0;
      $sql="Select * from product where USERID=$id order by PRODUCTID asc";
      $result = oci_parse($conn, $sql);
      oci_execute($result);
      echo'<div class="row">';
      while($row=oci_fetch_assoc($result)){
        $no_data++;        
        $productid = $row['PRODUCTID'];        
        if(!empty($row['DISCOUNTID'])){
          $discount_id = $row['DISCOUNTID'];
          $sql1 = "Select AMOUNT from DISCOUNT where DISCOUNTID=$discount_id";
          $res = oci_parse($conn, $sql1);
          oci_execute($res);
          while($hi = oci_fetch_assoc($res)){
            $amount = $hi['AMOUNT']."%";
          }
        }
        else{           
         $amount = "Not Applied."; 
        }
        if(!empty($_GET['basic'])){          
          echo'<tr>
          <th scope="row">'.$no_data.'</th>
          <td style="width: 124px;"><img class="tableimg" src="../images/products/'.$row['IMAGE_NAME'].'"></td>
          <td>'.$row['NAME'].'</td>
          <td>'.$row['DESCRIPTION'].'</td>
          <td>'.$row['PRODUCT_TYPE'].'</td>
          <td>$'.$row['PRICE'].'</td>
          <td>'.$row['QTYINSTOCK'].'</td>
          <td>'.$amount.'</td>
          <td><a href="updateproduct.php?basic=on&id='.$productid.'">Update</a> / <a href="products.php?basic=on&deleteid='.$productid.'">Delete</a></td>          
        </tr>
        </div>';
        }
        else{          
          echo'<div class="col-lg-3 col-md-4 col-6">
          <div class="product">
          <img src="../images/products/'.$row['IMAGE_NAME'].'">
          <hr>
          Name: '.$row['NAME'].' <br/>
          <p>Description: '.$row['DESCRIPTION'].'</p>
          Product Type: '.$row['PRODUCT_TYPE'].'<br/>
          Price: $'.$row['PRICE'].'<br/>
          Stock Available: '.$row['QTYINSTOCK'].' Pieces<br/>
          Discount: '.$amount.'  
          <hr>
          <a class="ok btn btn-success" href="updateproduct.php?id='.$productid.'">Update</a>
          <a class="ok btn btn-danger" href="products.php?deleteid='.$productid.'">Delete</a>      
          </div>
          </div>';      
        }      
      }
      oci_free_statement($result);
      if($no_data==0){
        echo'<h2 style="margin-left:20px;color:red;">No Products Added.</h2>';
      }
      ?>
      </div>
      </div>
    </div>
  </div>
  </div>