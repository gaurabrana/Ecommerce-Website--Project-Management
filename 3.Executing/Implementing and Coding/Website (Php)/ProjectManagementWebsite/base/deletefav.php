<?php
if(!isset($_SESSION)){
    session_start();
}
if(isset($_GET['id'])=='one'){
    $id=$_GET['id'];
setcookie("User[$id]", $id, time()-(60*60*24*30), "/");
header ('location: ../favourite.php?delete=success');
}
   else if(isset($_GET['delete'])=='all'){
        foreach($_COOKIE['User'] as $name => $values) {
        setcookie("User[$values]", $values, time()-(60*60*24*30), "/");   
        header ('location: ../favourite.php');     
    }
        }  
?>