<?php

spl_autoload_register("auto");





    
    //////////////////////////////////////////
    //                                      //
    //         classes loader               //
    //                                      // 
    //////////////////////////////////////////
    


function auto($className){
    $url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

    if(strpos($url,"handler")){
        $path = "../classes/";
    }else{
        $path = "classes/";
    }
    $ext = ".class.php";
    $fullPath = $path.$className.$ext;

    include_once $fullPath;

}