<?php
include "db.class.php";
require "../vendor/PHPMailerAutoload.php";

class Crud extends db{


////////////////////////////////
    //creating the token//    
///////////////////////////////


public function Token(){
        $length = 64;
        $keyspace="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $pieces = [];
        $max = mb_strlen($keyspace,"8bit")-1;
        for($i=0;$i<$length;++$i){
            $pieces[]=$keyspace[random_int(0,$max)];
        }
        return implode("",$pieces);
    }


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


    ///////////////////////////////////////
            //storing the token//
    //////////////////////////////////////
    
    public function storeToken($email){

        $token = $this->Token();
        $sql = "Select * from users where email=:email";
        $stmt=$this->connect()->prepare($sql);
        $stmt->execute(["email"=>$email]);
        $row = $stmt->fetch();
        $id= $row["id"];
        $count = $stmt->rowCount();
        if($count>0){
            $sql = "select * from users where id=:id";
            $stmt=$this->connect()->prepare($sql);
            $stmt->execute(["id"=>$id]);
            $row = $stmt->fetch();
            $verify= $row["verify"];
            if($verify == "1"){
                return "existing acc doesnt need auth";
            }else{
                $sql="insert into authenticate(userId,token)values(:id,:token)";
                $stmt= $this->connect()->prepare($sql);
                $objects = [
                    "id"=>$id,
                    "token"=>$token
                ];
                $stmt->execute($objects);
                   
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->Port= 456;
            $mail->SMTPAuth=true;
            $mail->SMTPSecure="ssl";
            $mail->Username="sabirbarahi41@gmail.com";
            $mail->Password="dragon-force99";
            $mail->setFrom("sabirbarahi41@gmail.com","test@noreply");
            $mail->addAddress($email);
            $mail->addReplyTo("no@reply");
            $mail->isHTML(true);
            $mail->Subject="test";
            $mail->Body="Thank you for using Authenticate you can authenticate your account by clicking <a href='https://login-system1125.herokuapp.com/handlers/verification.php?t=$token&&i=$id'>here</a>";
            if(!$mail->send()){
                return false;
            }else{
                return true;
            }
            }
                
    
            }else{
                return "Token for this user already exists.Check your email";
            }
            
            }


            public function login($username,$password){

                $sql = "select * from users where username = :username";
                $stmt=$this->connect()->prepare($sql);
                $stmt->execute(["username"=>$username]);
                $count = $stmt->rowCount();

                if($count>0){
                    $row = $stmt->fetch();
                    $verify = $row["verify"];
                    if($verify == "1"){
                        $hash = password_verify($password,$row["password"]);
                        if($hash == true){
                            $_SESSION["username"]= $row["username"];
                            $_SESSION["id"]=$row["id"];
                        return true;
                        }else{
                         return false;
                        }

                    }else{
                        return false;
                    }
                }else{
                   return false;
                }


            }

            
              
            }
     
    

