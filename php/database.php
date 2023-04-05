<?php 

    require_once("constants.php");
    
    function dbConnect(){
        $dsn = 'pgsql:dbname='.DB_NAME.';host='.DB_SERVER.';port='.DB_PORT;
        $user = DB_USER;
        $password = DB_PASSWORD;
        try {
            $dbConnect = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
        return $dbConnect;
    }

    function isValidUser($email, $dbConnection,$table){
        try{
            $query = 'SELECT * FROM :tableUser WHERE email = :email';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':tableUser', $table);
            $statement->bindParam(':email', $email);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if(count($result) > 0){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function getEncryptedPassword($email,$dbConnection,$table){
        try{
            $query = 'SELECT * FROM :tableUser WHERE email = :email';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':tableUser', $table);
            $statement->bindParam(':email', $email);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['passworduser'];
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function getUser($email, $dbConnection,$table){
        try{
            $query = 'SELECT * FROM :tableUser WHERE email = :email';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':tableUser', $table);
            $statement->bindParam(':email', $email);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

?>
