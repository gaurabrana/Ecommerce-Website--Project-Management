<?php
include('connect.php');
$data = 0;
$sql = "Select * from review";
$result = oci_parse($conn,$sql);
oci_execute($result);
while($row=oci_fetch_assoc($result)){
    $data++;
}
$data++;
oci_free_statement($result);
if(!empty($_GET['id'])){
    $productid = $_GET['id'];
    }
if(isset($_POST['review'])){
    $userid = $_SESSION['userid'];
    $rating = $_POST['rating'];
    $detail = $_POST['description'];    
    if(!empty($_GET['update'])){
        $revid = $_GET['update'];
        $sql = "UPDATE REVIEW set DESCRIPTION='$detail', RATE='$rating' where REVIEWID='$revid'";
    }    
    else{
        $sql = "INSERT INTO REVIEW(REVIEWID,DESCRIPTION,PRODUCTID,USERID,RATE) VALUES ('$data','$detail','$productid','$userid','$rating')";
    }    
    $result = oci_parse($conn,$sql);
    oci_execute($result);
    if($result){
        header("Location: ../singleproduct.php?id=$productid");
    }
}
if(!empty($_GET['delete'])){
    $revid = $_GET['delete'];
    $sql = "DELETE FROM REVIEW WHERE REVIEWID='$revid'";
    $result = oci_parse($conn,$sql);
    oci_execute($result);
    if($result){
        header("Location: ../singleproduct.php?id=$productid");
    }
}
?>