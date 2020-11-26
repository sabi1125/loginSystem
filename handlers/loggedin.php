<?php
include "../bootstrap.php";
session_start();
if(!$_SESSION["username"]){
    header("location:login.php?err=sesnotset");
}else{
    echo $twig->render("loggedin.twig");
}