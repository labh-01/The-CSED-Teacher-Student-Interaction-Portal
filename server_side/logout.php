<?php 
session_start(); 
session_destroy(); 
echo "<script>window.open('../html/login.html','_self')</script>";
?>