<?php
if(!defined("CONST")){die("Acceso Denegado");}


$app->get("/field/{field}", function ($request, $response, $args)
{   
    $route = $request->getAttribute('route');
    $field = $route->getArgument('field');
    
    try{
        $connection = getConnection();
        $dbh = $connection->prepare("SELECT * FROM information_schema.COLUMNS 
                                        WHERE TABLE_SCHEMA = 'leadsius' 
                                        AND TABLE_NAME = 'contact' 
                                        AND COLUMN_NAME = ?");
        $dbh->bindParam(1, $field);
        $dbh->execute();
        $fields = $dbh->fetchAll();
            if (count($fields)<1){
                $response->withHeader('Content-type', 'application/json');
                $response->withStatus(302);
                $body = $response->getBody();                
                $body->write(json_encode(array("Status"=>"nok","Desc"=>"Field not exists")));              
            }else{
            
                $dbh = $connection->prepare("SELECT * FROM contact order by $field asc");
                $dbh->execute();
                $contact = $dbh->fetchAll();
                $connection = null;
                    
                $response->withHeader('Content-type', 'application/json');
                $response->withStatus(200);
                $body = $response->getBody();
                $body->write(json_encode($contact));    
            }     
    }
    catch(PDOException $e){
        echo "Error : " . $e->getMessage();        
    }
});

$app->get("/sort/", function($request, $response, $args)
{   
    try{
         $connection = getConnection();
        if ($param == "field"){
            $dbh = $connection->prepare("SELECT * FROM contact WHERE id = ?");
            $dbh->bindParam(1, $id);
        }

                    
        $response->withHeader('Content-type', 'application/json');
        $response->withStatus(200);
        $body = $response->getBody();
        $body->write(json_encode($contact));         
    }
    catch(PDOException $e){
        echo "Error : " . $e->getMessage();        
    }
});

$app->post("/contacts/", function() use($app)
{
    $name = $app->request->post("name");
    $lastname = $app->request->post("lastname");
    $email = $app->request->post("email");
    $status = $app->request->post("status");
        
        try{
        $connection = getConnection();
        $dbh = $connection->prepare("SELECT * FROM status WHERE name = ?");
        $dbh->bindParam(1, $status);
        $dbh->execute();
        $status = $dbh->fetchObject();
        
        $dbh = $connection->prepare("INSERT INTO contact VALUES (null,?,?,?,? ");
        $dbh->bindParam(1, $title);
        $dbh->bindParam(2, $lastname);
        $dbh->bindParam(3, $email);
        $dbh->bindParam(4, $status['id']);
        $dbh->execute();
        $contactId = $connection->lastInsertId();
        $connection = null;
        
        $app->response->headers->set("Content-type", "application/json");
        $app->response->status(200);
        $app->response->body(json_encode($contactId));    
            
    }
    catch(PDOException $e){
        echo "Error : " . $e->getMessage();
        
    }    
});

$app->put("/contacts/", function() use($app)
{
    $name = $app->request->put("name");
    $lastname = $app->request->put("lastname");
    $email = $app->request->put("email");
    $status = $app->request->put("status");
    $id = $app->request->put("id");
    
    try{
        $connection = getConnection();
        $dbh = $connection->prepare("SELECT * FROM status WHERE name = ?");
        $dbh->bindParam(1, $status);
        $dbh->execute();
        $status = $dbh->fetchObject();
        
        $dbh = $connection->prepare("UPDATE contact SET name = ?, lastname = ?, email = ?, status = ? WHERE id = ?");        
        $dbh->bindParam(1, $name);
        $dbh->bindParam(2, $lastname);
        $dbh->bindParam(3, $email);
        $dbh->bindParam(4, $status['id']);
        $dbh->bindParam(5, $id);
        $dbh->execute();
        $connection = null;
        
        $app->response->headers->set("Content-type", "application/json");
        $app->response->status(200);
        $app->response->body(json_encode(array("res"=>1)));
        
    }
    catch(PDOException $e){
        echo "Error : " . $e->getMessage();
        
    }
});