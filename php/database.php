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
            $query = 'SELECT * FROM etudiant JOIN classe c ON etudiant.id_classe = c.id_classe';
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
            $query = 'SELECT * FROM cours c JOIN enseignant e ON c.id_prof = e.id_prof JOIN semestre s ON c.id_semestre = s.id_semestre JOIN annee a ON s.id_annee = a.id_annee JOIN classe cl ON c.id_classe = cl.id_classe';
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

    
    function modifyStudent($dbConnection, $nom, $prenom, $mail,$id,$id_classe){
        try{
            $query = 'UPDATE etudiant SET nom_etu = :nom, prenom_etu = :prenom, mail_etu = :mail, id_classe = :id_classe WHERE id_etu = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':nom', $nom);
            $statement->bindParam(':prenom', $prenom);
            $statement->bindParam(':mail', $mail);
            $statement->bindParam(':id_classe', $id_classe);
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
    function addStudent($dbConnection, $prenom, $nom, $mail, $password,$id_classe){
        $queryTest = 'SELECT * FROM etudiant WHERE mail_etu = :mail';
        $statementTest = $dbConnection->prepare($queryTest);
        $statementTest->bindParam(':mail', $mail);
        $statementTest->execute();
        $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'INSERT INTO etudiant (nom_etu, prenom_etu, mail_etu, password_etu, id_classe) VALUES (:nom, :prenom, :mail, :passwordetu, :id_classe)';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':prenom', $prenom);
                $statement->bindParam(':mail', $mail);
                $statement->bindParam(':passwordetu', $password);
                $statement->bindParam(':id_classe', $id_classe);
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
            $query = 'SELECT * FROM etudiant JOIN classe c ON etudiant.id_classe = c.id_classe WHERE c.nom_cycle = :cycle';
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
            $query = 'SELECT * FROM etudiant JOIN classe c ON etudiant.id_classe = c.id_classe WHERE c.annee_cursus = :years';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':years', $year);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    function getStudentsByCycleAndYear($dbConnection, $cycle, $year){
        try{
            $query = 'SELECT * FROM etudiant JOIN classe c ON etudiant.id_classe = c.id_classe WHERE c.nom_cycle = :cycle AND c.annee_cursus = :years';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->bindParam(':years', $year);
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
    function addCours($dbConnection, $nom, $duree, $id_prof, $id_semestre, $id_classe){
        $queryTest = 'SELECT * FROM cours WHERE nom_matiere = :nom AND id_prof = :id_prof AND id_semestre = :id_semestre AND id_classe = :id_classe';
        $statementTest = $dbConnection->prepare($queryTest);
        $statementTest->bindParam(':nom', $nom);
        $statementTest->bindParam(':id_prof', $id_prof);
        $statementTest->bindParam(':id_semestre', $id_semestre);
        $statementTest->bindParam(':id_classe', $id_classe);
        $statementTest->execute();
        $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'INSERT INTO cours (nom_matiere, duree, id_prof, id_semestre,id_classe) VALUES (:nom, :duree, :id_prof, :id_semestre, :id_classe)';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':duree', $duree);
                $statement->bindParam(':id_prof', $id_prof);
                $statement->bindParam(':id_semestre', $id_semestre);
                $statement->bindParam(':id_classe', $id_classe);
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
    function updateCours($dbConnection, $id, $nom, $duree, $id_prof, $id_semestre, $id_classe){
        $queryTest = 'SELECT * FROM cours WHERE nom_matiere = :nom AND id_prof = :id_prof AND id_semestre = :id_semestre AND id_classe = :id';
        $statementTest = $dbConnection->prepare($queryTest);
        $statementTest->bindParam(':nom', $nom);
        $statementTest->bindParam(':id_prof', $id_prof);
        $statementTest->bindParam(':id_semestre', $id_semestre);
        $statementTest->bindParam(':id', $id_classe);
        $statementTest->execute();
        $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'UPDATE cours SET nom_matiere = :nom, duree = :duree, id_prof = :id_prof, id_semestre = :id_semestre , id_classe = :id_classe WHERE id_matiere = :id';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':duree', $duree);
                $statement->bindParam(':id_prof', $id_prof);
                $statement->bindParam(':id_semestre', $id_semestre);
                $statement->bindParam(':id_classe', $id_classe);
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

    function getAllClass($dbConnection){
        try{
            $query = 'SELECT * FROM classe';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function getIdClassWithYearAndCycle($db, $annee, $cycle){
        try{
            $query = 'SELECT id_classe FROM classe WHERE annee_cursus = :annee AND nom_cycle = :cycle';
            $statement = $db->prepare($query);
            $statement->bindParam(':annee', $annee);
            $statement->bindParam(':cycle', $cycle);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['id_classe'];
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function addEpreuve($dbConnection, $id_matiere, $nom_epreuve, $coefficient){
        $queryTest = 'SELECT * FROM epreuve WHERE nom_epreuve = :nom AND id_matiere = :id_matiere';
        $statementTest = $dbConnection->prepare($queryTest);
        $statementTest->bindParam(':nom', $nom_epreuve);
        $statementTest->bindParam(':id_matiere', $id_matiere);
        $statementTest->execute();
        $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'INSERT INTO epreuve (id_matiere, nom_epreuve, coefficient) VALUES (:id_matiere, :nom_epreuve, :coefficient)';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':id_matiere', $id_matiere);
                $statement->bindParam(':nom_epreuve', $nom_epreuve);
                $statement->bindParam(':coefficient', $coefficient);
                $statement->execute();
                return true;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }

    function getCoursesBySemesterAndStudents($dbConnection, $id_semestre, $id_student){
        try{
            $query = 'Select * from cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN etudiant ON etudiant.id_classe = classe.id_classe WHERE etudiant.id_etu = :id_etu AND semestre.id_semestre = :id_semestre';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_etu', $id_student);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
    }

    function getEpreuves($dbConnection, $id_matiere){
        try{
            $query = 'SELECT * FROM epreuve e JOIN cours c ON c.id_matiere = e.id_matiere WHERE e.id_matiere = :id_matiere';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_matiere', $id_matiere);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function deleteEpreuve($dbConnection, $id_epreuve){
        try{
            $query = 'DELETE FROM epreuve WHERE id_epreuve = :id_epreuve';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_epreuve', $id_epreuve);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    ?>
