<?php
include_once "../bootstrap.php";
include_once "../classes/Crud.class.php";
require "../classes/phpmailer.class.php";
require "../classes/smtp.class.php";

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashPass = password_hash($password,PASSWORD_DEFAULT);
    $empty = empty($username)||empty($email)||empty($password);

    if($empty == true){
        header("location:signup.php?err=empty");
    }else{
        $create = new Crud();
        if($create->create($username,$email,$hashPass)){
            
        if($create->storeToken($email)){
            header("location:signup.php?msg=sent");
        }else{
            header("location:signup.php?err=notsent");
        }
        }else{
            header("location:signup.php?err=alreadyexists");
        }

           
    }
}



$fullurl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if(strpos($fullurl,"msg=sent")==true){

    $msg=[
     "status"=>true,
     "msg"=>"Your account has been scuccesfully created please visit your email to activate your account."
    ];
echo $twig->render("signup.twig",["msg"=>$msg]);

}else if(strpos($fullurl,"err=notsent")==true){
    $err=[
    "status"=>true,
    "err"=>"We could not setup your account for some reason remaking a new account might help"
    ];
    echo $twig->render("signup.twig",["err"=>$err]);
}else if(strpos($fullurl,"err=alreadyexists")== true){
    $err=[
        "status"=>true,
        "err"=>"this user already exists.. are you sure you havent forgot your password ???"
        ];
        echo $twig->render("signup.twig",["err"=>$err]);
}



else{
    

echo $twig->render("signup.twig");


}


