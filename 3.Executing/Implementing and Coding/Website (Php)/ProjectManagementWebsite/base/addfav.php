<?php
if(!isset($_SESSION)){
    session_start();
}
if(!empty($_GET['id'])){    
    $page = $_GET['page'];
    $type = $_GET['type'];
    $id=$_GET['id']; 
    setcookie("User[$id]",$id, time()+(60*60*24*30), "/");        
    header ('location: ../shop.php?'.$page.'='.$type.'&id='.$id.'&fav=success');        
    
}
?>