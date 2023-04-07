<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
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
        if($table=="administrateur"){
            $tableRaccourci = "admin";
        }else if($table=="enseignant"){
            $tableRaccourci = "prof";
        }
        else if($table=="etudiant"){
            $tableRaccourci = "etu";
        }
        try{
            $query = 'SELECT * FROM '.$table.' WHERE mail_'.$tableRaccourci.' = :email';
            $statement = $dbConnection->prepare($query);
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
        if($table=="administrateur"){
            $tableRaccourci = "admin";
        }else if($table=="enseignant"){
            $tableRaccourci = "prof";
        }
        else if($table=="etudiant"){
            $tableRaccourci = "etu";
        }
        try{
            $query = 'SELECT * FROM '.$table.' WHERE mail_'.$tableRaccourci.' = :email';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':email', $email);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $namePassword = "password_".$tableRaccourci;
            return $result[0][$namePassword];
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function getUser($email, $dbConnection,$table){
        if($table=="administrateur"){
            $tableRaccourci = "admin";
        }else if($table=="enseignant"){
            $tableRaccourci = "prof";
        }
        else if($table=="etudiant"){
            $tableRaccourci = "etu";
        }
        try{
            $query = 'SELECT * FROM '.$table.' WHERE mail_'.$tableRaccourci.' = :email';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':email', $email);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function getAllProfessors($dbConnection){
        try{
            $query = 'SELECT * FROM enseignant';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }	

    function getAllStudents($dbConnection){
        try{
            $query = 'SELECT * FROM etudiant';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function getAllCourses($dbConnection){
        try{
            $query = 'SELECT * FROM cours c JOIN enseignant e ON c.id_prof = e.id_prof JOIN semestre s ON c.id_semestre = s.id_semestre JOIN annee a ON s.id_annee = a.id_annee';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
?>
