<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<?php
setcookie('UserID', '', time() - 3600, '/');
setcookie('Contact', '',time()-3600, '/');

header("location: login-customer.php");
exit;
?>
