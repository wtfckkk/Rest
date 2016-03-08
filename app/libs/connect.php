<?php
if(!defined("CONST")){die("Acceso Denegado");}

function getConnection()
{
    try{
       $db_user = "admindb";
       $do_password = "p4ssword";
       $connection = new PDO("mysql:host=localhost;dbname=leadsius", $db_user, $do_password);                      
    }
    
    catch(PDOException $e){

        echo "Error : " . $e->getMessage();
        
    }
    
    return $connection; 
}