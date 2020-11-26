<?php
include "db.class.php";
require "../vendor/PHPMailerAutoload.php";

class Crud extends db{




//////////////////////////////
    //creating account//
/////////////////////////////


      public function create($username,$email,$password){
        $sql="Select * From users where username =:username or email =:email";
        $stmt = $this->connect()->prepare($sql);
        $objects = [
            "username"=>$username,
            "email"=>$email
        ];
        $stmt->execute($objects);
        $count=$stmt->rowCount();

        if($count>0){
            return False;
            exit();
        }
        else{
            $sql = "Insert into users(username,email,password) Values(:username,:email,:password)";
            $stmt = $this->connect()->prepare($sql);

            $objects=[
                "username"=>$username,
                "email"=>$email,
                "password"=>$password
            ];
            $stmt->execute($objects);
            return true;
            exit();
        }   
    }


            public function login($username,$password){
                $sql = "select * from users where username=:username";
                $stmt=$this->connect()->prepare($sql);
                $stmt->execute(["username"=>$username]);
                $count=$stmt->rowCount();
                if($count>0){
                    $row=$stmt->fetch();
                    $hash = password_verify($password,$row["password"]);
                    if($hash){
                        $_SESSION["id"]=$row["id"];
                        $_SESSION["username"]=$row["username"];
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            
            }

            
              
            }
     
    

