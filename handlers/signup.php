<?php
include_once "../bootstrap.php";
include "loader.php";

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $empty = empty($username)||empty($email)||empty($password);
}













echo $twig->render("signup.twig");