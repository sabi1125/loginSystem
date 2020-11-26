<?php

include_once "../bootstrap.php";
include_once("../classes/Crud.class.php");
session_start();

if(isset($_SESSION["username"])){
    header("location:loggedin.php?err=sesset");
}else{
    
if(isset($_POST["login"])){
    $username =$_POST["username"];
    $password = $_POST["password"];
    if(empty($username)||empty($password)){
        header("location:login.php?err=empty");
    }else{
        $login = new Crud;
       
        if($login->login($username,$password)){
            header("location:loggedin.php");
        }elseif($login->login($username,$password) == false ){
            header("location:login.php?err=error");
        }
        
        
        
    }
}

}














$fullurl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if(strpos($fullurl,"msg=verified")==true){

    $msg=[
     "status"=>true,
     "msg"=>"Your account has been scuccesfully verified.You can login form here."
    ];
echo $twig->render("login.twig",["msg"=>$msg]);

}else if(strpos($fullurl,"err=invalid")==true){
    $err=[
        "status"=>true,
        "err"=>"humm... That is an invalid token....."
       ];
   echo $twig->render("login.twig",["err"=>$err]);
   
}else if(strpos($fullurl,"err=error")==true){
    $err=[
        "status"=>true,
        "err"=>"Wrong Username or Password.Or maybe you havent verified your account yet. If so please check your email."
       ];
   echo $twig->render("login.twig",["err"=>$err]);
   
}else if(strpos($fullurl,"err=empty")==true){
    $err=[
        "status"=>true,
        "err"=>"You cant submit an empty form."
       ];
   echo $twig->render("login.twig",["err"=>$err]);
   
}


else{
    

echo $twig->render("login.twig");


}



