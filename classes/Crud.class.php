<?php

class Crud extends db{

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
            $sql = "Insert into users Values(:username,:email,:password)";
            $stmt = $this->connect()->prepare($sql);
            $objects=[
                "username"=>$username,
                "email"=>$email,
                "password"=>$password
            ];
            $stmt->execute($objects);
        }
    }

    
    public function storeToken($id){

    }

}