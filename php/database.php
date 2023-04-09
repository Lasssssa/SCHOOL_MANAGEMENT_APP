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

    function modifyProfessor($dbConnection, $nom, $prenom, $mail, $telephone,$id){
        try{
            $query = 'UPDATE enseignant SET nom_prof = :nom, prenom_prof = :prenom, mail_prof = :mail, telephone_prof = :telephone WHERE id_prof = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':nom', $nom);
            $statement->bindParam(':prenom', $prenom);
            $statement->bindParam(':mail', $mail);
            $statement->bindParam(':telephone', $telephone);
            $statement->bindParam(':id', $id);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function modifyStudent($dbConnection, $nom, $prenom, $mail, $annee,$id,$cycle){
        try{
            $query = 'UPDATE etudiant SET nom_etu = :nom, prenom_etu = :prenom, mail_etu = :mail, annee_cursus = :annee, nom_cycle = :cycle WHERE id_etu = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':nom', $nom);
            $statement->bindParam(':prenom', $prenom);
            $statement->bindParam(':mail', $mail);
            $statement->bindParam(':annee', $annee);
            $statement->bindParam(':cycle', $cycle);
            $statement->bindParam(':id', $id);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function addProfessor($dbConnection, $nom, $prenom, $mail, $password, $telephone){
        $queryTest = 'SELECT * FROM enseignant WHERE mail_prof = :mail';
        $statementTest = $dbConnection->prepare($queryTest);
        $statementTest->bindParam(':mail', $mail);
        $statementTest->execute();
        $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'INSERT INTO enseignant (nom_prof, prenom_prof, mail_prof, password_prof, telephone_prof) VALUES (:nom, :prenom, :mail, :passwordprof, :telephone)';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':prenom', $prenom);
                $statement->bindParam(':mail', $mail);
                $statement->bindParam(':passwordprof', $password);
                $statement->bindParam(':telephone', $telephone);
                $statement->execute();
                return true;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
    function addStudent($dbConnection, $nom, $prenom, $mail, $password, $annee, $cycle){
        $queryTest = 'SELECT * FROM etudiant WHERE mail_etu = :mail';
        $statementTest = $dbConnection->prepare($queryTest);
        $statementTest->bindParam(':mail', $mail);
        $statementTest->execute();
        $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'INSERT INTO etudiant (nom_etu, prenom_etu, mail_etu, password_etu, annee_cursus, nom_cycle) VALUES (:nom, :prenom, :mail, :passwordetu, :annee, :cycle)';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':prenom', $prenom);
                $statement->bindParam(':mail', $mail);
                $statement->bindParam(':passwordetu', $password);
                $statement->bindParam(':annee', $annee);
                $statement->bindParam(':cycle', $cycle);
                $statement->execute();
                return true;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }

    function deleteProfessor($dbConnection, $id){
        try{
            $query = 'DELETE FROM enseignant WHERE id_prof = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function deleteStudent($dbConnection, $id){
        try{
            $query = 'DELETE FROM etudiant WHERE id_etu = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id',$id);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function cantDeleteProfessor($dbConnection, $id){
        try{
            $query = 'SELECT * FROM cours WHERE id_prof = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id', $id);
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

    function getCycles($dbConnection){
        try{
            $query = 'SELECT * FROM cycle';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function getStudentsByCycle($dbConnection, $cycle){
        try{
            $query = 'SELECT * FROM etudiant WHERE nom_cycle = :cycle';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function getStudentsByYear($dbConnection, $year){
        try{
            $query = 'SELECT * FROM etudiant WHERE annee_cursus = :year';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':year', $year);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function getStudentsByCycleAndYear($dbConnection, $cycle, $year){
        try{
            $query = 'SELECT * FROM etudiant WHERE nom_cycle = :cycle AND annee_cursus = :year';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->bindParam(':year', $year);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function getAllYears($dbConnection){
        try{
            $query = 'SELECT * FROM annee';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function getAllSemesters($dbConnection){
        try{
            $query = 'SELECT * FROM semestre JOIN annee ON semestre.id_annee = annee.id_annee';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function addCours($dbConnection, $nom, $duree, $id_prof, $id_semestre){
        $queryTest = 'SELECT * FROM cours WHERE nom_matiere = :nom AND id_prof = :id_prof AND id_semestre = :id_semestre';
        $statementTest = $dbConnection->prepare($queryTest);
        $statementTest->bindParam(':nom', $nom);
        $statementTest->bindParam(':id_prof', $id_prof);
        $statementTest->bindParam(':id_semestre', $id_semestre);
        $statementTest->execute();
        $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'INSERT INTO cours (nom_matiere, duree, id_prof, id_semestre) VALUES (:nom, :duree, :id_prof, :id_semestre)';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':duree', $duree);
                $statement->bindParam(':id_prof', $id_prof);
                $statement->bindParam(':id_semestre', $id_semestre);
                $statement->execute();
                return true;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
    function deleteCours($dbConnection, $id){
        try{
            $query = 'DELETE FROM cours WHERE id_matiere = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function updateCours($dbConnection, $id, $nom, $duree, $id_prof, $id_semestre){
        $queryTest = 'SELECT * FROM cours WHERE nom_matiere = :nom AND id_prof = :id_prof AND id_semestre = :id_semestre';
        $statementTest = $dbConnection->prepare($queryTest);
        $statementTest->bindParam(':nom', $nom);
        $statementTest->bindParam(':id_prof', $id_prof);
        $statementTest->bindParam(':id_semestre', $id_semestre);
        $statementTest->execute();
        $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'UPDATE cours SET nom_matiere = :nom, duree = :duree, id_prof = :id_prof, id_semestre = :id_semestre WHERE id_matiere = :id';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':duree', $duree);
                $statement->bindParam(':id_prof', $id_prof);
                $statement->bindParam(':id_semestre', $id_semestre);
                $statement->bindParam(':id', $id);
                $statement->execute();
                return true;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
    function getCoursWithId($dbConnection, $id){
        try{
            $query = 'SELECT * FROM cours c JOIN enseignant e ON c.id_prof = e.id_prof JOIN semestre s ON c.id_semestre = s.id_semestre JOIN annee a ON s.id_annee = a.id_annee WHERE id_matiere = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function getStudentsInCourse($dbConnection, $id){
        try{
            $query = 'SELECT * FROM participe p JOIN etudiant e ON e.id_etu = p.id_etu JOIN cours c ON c.id_matiere = p.id_matiere WHERE p.id_matiere = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function getStudentsNotInCourse($dbConnection, $id){
        try{
            $query = 'SELECT * FROM etudiant WHERE id_etu NOT IN (SELECT id_etu FROM participe WHERE id_matiere = :id)';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function addStudentToCourse($dbConnection, $id_etu, $id_matiere){
        try{
            $query = 'INSERT INTO participe (id_etu, id_matiere) VALUES (:id_etu, :id_matiere)';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_matiere', $id_matiere);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function deleteStudentFromCourse($dbConnection, $id_etu, $id_matiere){
        try{
            $query = 'DELETE FROM participe WHERE id_etu = :id_etu AND id_matiere = :id_matiere';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_matiere', $id_matiere);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
?>
