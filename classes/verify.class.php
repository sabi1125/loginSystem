<?php
require "db.class.php";
require "../vendor/PHPMailerAutoload.php";


class Verify extends db{
    public function auth($recivedId,$recivedToken){
        $sql="Select * from authenticate where userId = :recivedId";
        $stmt=$this->connect()->prepare($sql);
        $stmt->execute(["recivedId"=>$recivedId]);
        $count =$stmt->rowCount();
        if($count > 0){
            $row = $stmt->fetch();
            $token =$row["token"];
            if($token === $recivedToken){
                $sql = "update users set verify = 1 where id=:recivedId";
                $stmt=$this->connect()->prepare($sql);
                $stmt->execute(["recivedId"=>$recivedId]);
                $sql2="select * from users where id = :recivedId";
                $stmt2=$this->connect()->prepare($sql2);
                $stmt2->execute(["recivedId"=>$recivedId]);

                $row = $stmt2->fetch();
                $verify = $row["verify"];
            
                if($verify == "1"){
                    
                $sql = "Delete from authenticate where userId = :recivedId";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute(["recivedId"=>$recivedId]);
                
                return true;
                }
                else{
                    return false;
            }
                }
                
            
        }
    }
}