<?php
session_start();
session_destroy();
if(!empty($_GET['admin'])){
    echo'<script>window.location.href ="http://127.0.0.1:8080/apex/r/team5/dashboard/login"</script>';
}
else{
    header ('location: ../index.php');
}
?>