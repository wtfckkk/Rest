<?php
if(!defined("CONST")){die("Acceso Denegado");}

function getConnection()
{
    try{
       $db_user = "admindb";
       $do_password = "4dmin!!";
       $connection = new PDO("mysql:host=45.55.223.65;dbname=leadsius", $db_user, $do_password);                      
    }
    
    catch(PDOException $e){

        echo "Error : " . $e->getMessage();
        
    }
    
    return $connection; 
}