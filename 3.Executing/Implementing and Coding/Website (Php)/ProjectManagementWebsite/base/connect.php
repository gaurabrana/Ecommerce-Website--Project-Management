<?php 
if(!isset($_SESSION))
{
    session_start();
}
$conn = oci_connect('TEAM5', '123456789', '//localhost/xe'); 
?>