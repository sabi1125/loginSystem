<?php

class db{

    private $dsn = "mysql:host=r1bsyfx4gbowdsis.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;port=3306;dbname=nttph9trp443g6sw";
    private $dbUser = "nk2dv6ux1iswgyo1";
    private $dbPass = "oza3d9bsuk4993lb";



    
protected function connect(){
    $pdo = new PDO($this->dsn,$this->dbUser,$this->dbPass);
    
    
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    return $pdo;
}

}
