<?php
include 'connect.php';
if(isset($_POST['login'])){
    $email= strtolower(trim($_POST['email']));
    $pass= md5($_POST['password']);
    $type = $_POST['usertype'];
$sql ="Select USERID,NAME,EMAIL,PASSWORD,TYPES,VERIFIED from users where EMAIL='$email' and TYPES=$type";
$result = oci_parse($conn, $sql);
oci_execute($result);
while($row=oci_fetch_assoc($result))
{
    $id++; 
    $password = $row['PASSWORD'];
    $name = explode(" ", $row['NAME']);
    $_SESSION['fullname'] = $row['NAME'];
    $_SESSION['user_name'] = $name['0'];
    $_SESSION['type'] = $row['TYPES'];
    $_SESSION['userid'] = $row['USERID'];
    $_SESSION['email'] = $row['EMAIL'];
    $verified = $row['VERIFIED'];
}
oci_free_statement($result);
if($id>0)
{
  //user found
  if($verified=='YES'){
    if($pass == $password){    
      $_SESSION['username'] = $_SESSION['user_name'];
      $_SESSION['usertype'] = $_SESSION['type'];      
      if($_SESSION['usertype']==1){
        $userid = $_SESSION['userid'];
        $sql = "SELECT * FROM SHOP WHERE USERID ='$userid'";
        $result = oci_parse($conn, $sql);
        oci_execute($result);
        while($row=oci_fetch_assoc($result)){
          $_SESSION['shopid'] = $row['SHOPID'];
          $_SESSION['tradertype'] = $row['TRADERTYPE'];
        }
        header("Location: ../Trader/products.php");
      }
      else if($_SESSION['usertype']==2){
        header("Location: ../shop.php");
      }
      else if($_SESSION['usertype']==0){
        header("Location: logout.php?admin=redirect");        
      }       
    }
    else
    {
        //password doesnot match error
        header("Location: ../login.php?Error=Incorrect Password.");
    }
  }
  else
  {
    header("Location: ../login.php?Error=User Not Verified.");
  }    
}
else
{
    //no user data found
    header("Location: ../login.php?Error=No user found. Please re-check your email address.");
}
}
?>