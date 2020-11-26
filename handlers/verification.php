<?php

include_once("../bootstrap.php");
include_once("../classes/verify.class.php");












$recivedId=$_GET["i"];
$recivedToken=$_GET["t"];

$verify = new Verify;
$auth =$verify->auth($recivedId,$recivedToken);

if($auth == true){
       header("location:login.php?msg=verified");
}else{
        header("location:login.php?err=invalid");
}


