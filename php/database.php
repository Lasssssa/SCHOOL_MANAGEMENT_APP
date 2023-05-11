<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once("constants.php");
    
    function getProfilPicture($lastname_firstname){
        //Récupérer une image de profil dans le dossier photo_profil
        $dir = '../photo_profil';
        $files = scandir($dir);
        $img = null;
        foreach($files as $file){
            if($file != '.' && $file != '..'){
                $name = explode('.',$file)[0];
                if($name == $lastname_firstname){
                    $img = $file;
                }

            }
        }
        return $img;
    }

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
        }catch(Exception $e){
            echo $e->getMessage();
        }
        if(count($result) > 0){
            return true;
        }else{
            return false;
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
        }catch(Exception $e){
            echo $e->getMessage();
        }
        if($result!=null){
            return $result[0]['password_'.$tableRaccourci];
        }else{
            return null;
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
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getAllProfessors($dbConnection){
        try{
            $query = 'SELECT * FROM enseignant';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }
    
    function getAllStudents($dbConnection){
        try{
            $query = 'SELECT * FROM etudiant JOIN classe c ON etudiant.id_classe = c.id_classe';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }
    
    function getAllCourses($dbConnection){
        try{
            $query = 'SELECT * FROM cours c JOIN enseignant e ON c.id_prof = e.id_prof JOIN semestre s ON c.id_semestre = s.id_semestre JOIN annee a ON s.id_annee = a.id_annee JOIN classe cl ON c.id_classe = cl.id_classe';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getAllCycles($dbConnection){
        try{
            $query = 'SELECT * FROM cycle';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getAllYears($dbConnection){
        try{
            $query = 'SELECT * FROM annee';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getAllSemesters($dbConnection){
        try{
            $query = 'SELECT * FROM semestre JOIN annee ON semestre.id_annee = annee.id_annee';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getAllYearsClass($dbConnection){
        try{
            $query = 'SELECT DISTINCT annee_cursus FROM classe';
            $statement = $dbConnection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function addClass($db, $nom_cycle, $annee_cursus){
        try{
            $query = "INSERT INTO classe (nom_cycle, annee_cursus) VALUES (:nom_cycle, :annee_cursus)";
            $statement = $db->prepare($query);
            $statement->bindParam(':nom_cycle', $nom_cycle);
            $statement->bindParam(':annee_cursus', $annee_cursus);
            $statement->execute();
        }catch(exception $e) {
            echo $e->getMessage();
        }
    }

    function addCycle($db,$nom_cyle){
        try{
            $query = "SELECT * FROM cycle WHERE nom_cycle = :nom_cycle";
            $statement = $db->prepare($query);
            $statement->bindParam(':nom_cycle', $nom_cyle);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e) {
            echo $e->getMessage();
        }
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = "INSERT INTO cycle (nom_cycle) VALUES (:nom_cycle)";
                $statement = $db->prepare($query);
                $statement->bindParam(':nom_cycle', $nom_cyle);
                $statement->execute();
            }catch(exception $e) {
                echo $e->getMessage();
            }
            return true;
        }
    }

    function addYear($db, $year){
        try{
            $query = "SELECT * FROM annee WHERE numero_annee = :year";
            $statement = $db->prepare($query);
            $statement->bindParam(':year', $year);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = "INSERT INTO annee (numero_annee) VALUES (:year)";
                $statement = $db->prepare($query);
                $statement->bindParam(':year', $year);
                $statement->execute();
            }
            catch(exception $e) {
                echo $e->getMessage();
            }
            return true;
        }
    }

    function addProfessor($dbConnection, $nom, $prenom, $mail, $password, $telephone){
        try{
            $queryTest = 'SELECT * FROM enseignant WHERE mail_prof = :mail';
            $statementTest = $dbConnection->prepare($queryTest);
            $statementTest->bindParam(':mail', $mail);
            $statementTest->execute();
            $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
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

    function addStudent($dbConnection, $prenom, $nom, $mail, $password,$id_classe, $telephone){
        try{
            $queryTest = 'SELECT * FROM etudiant WHERE mail_etu = :mail';
            $statementTest = $dbConnection->prepare($queryTest);
            $statementTest->bindParam(':mail', $mail);
            $statementTest->execute();
            $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'INSERT INTO etudiant (nom_etu, prenom_etu, mail_etu, password_etu, id_classe, telephone_etu) VALUES (:nom, :prenom, :mail, :passwordetu, :id_classe, :telephone)';
                $statement = $dbConnection->prepare($query);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':prenom', $prenom);
                $statement->bindParam(':mail', $mail);
                $statement->bindParam(':passwordetu', $password);
                $statement->bindParam(':id_classe', $id_classe);
                $statement->bindParam(':telephone', $telephone);
                $statement->execute();
                return true;
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }

    function addCours($dbConnection, $nom, $duree, $id_prof, $id_semestre, $id_classe){
        try{
            $queryTest = 'SELECT * FROM cours WHERE nom_matiere = :nom AND id_prof = :id_prof AND id_semestre = :id_semestre AND id_classe = :id_classe';
            $statementTest = $dbConnection->prepare($queryTest);
            $statementTest->bindParam(':nom', $nom);
            $statementTest->bindParam(':id_prof', $id_prof);
            $statementTest->bindParam(':id_semestre', $id_semestre);
            $statementTest->bindParam(':id_classe', $id_classe);
            $statementTest->execute();
            $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            echo $e->getMessage();
        }
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
                if($statement->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }

    function addEpreuve($dbConnection, $id_matiere, $nom_epreuve, $coefficient){
        try{
            $queryTest = 'SELECT * FROM epreuve WHERE nom_epreuve = :nom AND id_matiere = :id_matiere';
            $statementTest = $dbConnection->prepare($queryTest);
            $statementTest->bindParam(':nom', $nom_epreuve);
            $statementTest->bindParam(':id_matiere', $id_matiere);
            $statementTest->execute();
            $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
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

    function addNoteToStudent($db,$id_etu,$id_epreuve,$note){
        try{
            $query = 'INSERT INTO fait_epreuve (id_etu,id_epreuve,note,est_note) VALUES (:id_etu,:id_epreuve,:note,\'true\')';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_epreuve', $id_epreuve);
            $statement->bindParam(':note', $note);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
    }

    function addAppreciationToStudent($db, $id_etu, $id_cours, $appreciation){
        try{
            $query = 'INSERT INTO recoit_appreciation (id_etu,id_matiere,commentaire) VALUES (:id_etu,:id_matiere,:appreciation)';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_matiere', $id_cours);
            $statement->bindParam(':appreciation', $appreciation);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
    }

    function addSemester($db,$id_annee, $numero_semestre ){
        if($numero_semestre > 2 || $numero_semestre < 1){
            return false;
        }
        try{
            $query = 'SELECT * FROM semestre WHERE id_annee = :id_annee AND numero_semestre = :numero_semestre';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_annee', $id_annee);
            $statement->bindParam(':numero_semestre', $numero_semestre);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        if(count($result) > 0){
            return false;
        }else{
            try{
                $query = 'INSERT INTO semestre (id_annee,numero_semestre) VALUES (:id_annee,:numero_semestre)';
                $statement = $db->prepare($query);
                $statement->bindParam(':id_annee', $id_annee);
                $statement->bindParam(':numero_semestre', $numero_semestre);
                $statement->execute();
                return true;
            }catch(exception $e){
                echo $e->getMessage();
            }
        }
    }

    function deleteCycle($db,$nom_cycle){
        try{
            $query = 'DELETE FROM cycle WHERE nom_cycle = :nom_cycle';
            $statement = $db->prepare($query);
            $statement->bindParam(':nom_cycle', $nom_cycle);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
        if($statement->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    function deleteSemester($db,$semester){
        try{
            $query = 'DELETE FROM semestre WHERE id_semestre = :id';
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $semester);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
        if($statement->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    function deleteYear($db,$id_annee){
        try{
            $query = 'DELETE FROM annee WHERE id_annee = :id';
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id_annee);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
        if($statement->rowCount() > 0){
            return true;
        }else{
            return false;
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

    function getStudentsByCycle($dbConnection, $cycle){
        try{
            $query = 'SELECT * FROM etudiant JOIN classe c ON etudiant.id_classe = c.id_classe WHERE c.nom_cycle = :cycle';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }
    
    function getStudentsByYear($dbConnection, $year){
        try{
            $query = 'SELECT * FROM etudiant JOIN classe c ON etudiant.id_classe = c.id_classe WHERE c.annee_cursus = :years';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':years', $year);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getStudentsByCycleAndYear($dbConnection, $cycle, $year){
        try{
            $query = 'SELECT * FROM etudiant JOIN classe c ON etudiant.id_classe = c.id_classe WHERE c.nom_cycle = :cycle AND c.annee_cursus = :years';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->bindParam(':years', $year);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function updateCours($dbConnection, $id, $nom, $duree, $id_prof, $id_semestre, $id_classe){
        try{
            $queryTest = 'SELECT * FROM cours WHERE nom_matiere = :nom AND id_prof = :id_prof AND id_semestre = :id_semestre AND id_classe = :id';
            $statementTest = $dbConnection->prepare($queryTest);
            $statementTest->bindParam(':nom', $nom);
            $statementTest->bindParam(':id_prof', $id_prof);
            $statementTest->bindParam(':id_semestre', $id_semestre);
            $statementTest->bindParam(':id', $id_classe);
            $statementTest->execute();
            $result = $statementTest->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            echo $e->getMessage();
        }
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

    function updateCoefficient($db,$id_epreuve,$coef){
        try{
            $query = 'UPDATE epreuve SET coefficient = :coef WHERE id_epreuve = :id_epreuve';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_epreuve', $id_epreuve);
            $statement->bindParam(':coef', $coef);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
    }
    
    function updateAppreciation($db,$id_etu,$id_cours,$appreciation){
        try{
            $query = 'UPDATE recoit_appreciation SET commentaire = :appreciation WHERE id_etu = :id_etu AND id_matiere = :id_cours';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_cours', $id_cours);
            $statement->bindParam(':appreciation', $appreciation);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
    }

    function updateNoteByStudentAndCourse($db,$id_etu,$id_matiere,$i,$note){
        try{
            $query = 'SELECT id_epreuve FROM epreuve ep JOIN cours c ON c.id_matiere = ep.id_matiere WHERE c.id_matiere = :id_matiere AND substr(ep.nom_epreuve,3) = CAST(:i AS CHAR)';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_matiere', $id_matiere);
            $statement->bindParam(':i', $i);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $id_epreuve = $result['id_epreuve'];
        }catch(exception $e){
            echo $e->getMessage();
        }

        try{
            $query = 'UPDATE fait_epreuve SET note = :note WHERE id_etu = :id_etu AND id_epreuve = :id_epreuve';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_epreuve', $id_epreuve);
            $statement->bindParam(':note', $note);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
    }

    function updatePassword($id,$encrypt, $db,$table,$suffixe){
        try{
            $query = 'UPDATE '.$table.' SET password_'.$suffixe.' = :encrypt WHERE id_'.$suffixe.' = :id';
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->bindParam(':encrypt', $encrypt);
            $statement->execute();
        }catch(exception $e){
            echo $e->getMessage();
        }
        return true;

    }

    function updateProfessor($dbConnection, $nom, $prenom, $mail, $telephone,$id){
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
    
    function updateStudent($dbConnection, $nom, $prenom, $mail,$id,$id_classe,$telephone){
        try{
            $query = 'UPDATE etudiant SET nom_etu = :nom, prenom_etu = :prenom, mail_etu = :mail, id_classe = :id_classe, telephone_etu = :telephone WHERE id_etu = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':nom', $nom);
            $statement->bindParam(':prenom', $prenom);
            $statement->bindParam(':mail', $mail);
            $statement->bindParam(':id_classe', $id_classe);
            $statement->bindParam(':id', $id);
            $statement->bindParam(':telephone', $telephone);
            $statement->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    function getClassesByCycle($db, $nom_cycle){
        try{
            $query = 'SELECT * FROM classe c JOIN cycle cy ON c.nom_cycle = cy.nom_cycle WHERE cy.nom_cycle = :nom_cycle';
            $statement = $db->prepare($query);
            $statement->bindParam(':nom_cycle', $nom_cycle);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }
    function getCoursWithId($dbConnection, $id){
        try{
            $query = 'SELECT * FROM cours c JOIN enseignant e ON c.id_prof = e.id_prof JOIN semestre s ON c.id_semestre = s.id_semestre JOIN annee a ON s.id_annee = a.id_annee WHERE id_matiere = :id';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getStudentById($db,$id_etu){
        try{
            $query = 'SELECT * FROM etudiant e JOIN classe cl ON cl.id_classe = e.id_classe JOIN cours c ON c.id_classe = cl.id_classe  WHERE id_etu = :id_etu';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getIdClassWithYearAndCycle($db, $annee, $cycle){
        try{
            $query = 'SELECT id_classe FROM classe WHERE annee_cursus = :annee AND nom_cycle = :cycle';
            $statement = $db->prepare($query);
            $statement->bindParam(':annee', $annee);
            $statement->bindParam(':cycle', $cycle);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        if($result != null){
            return $result['id_classe'];
        }else{
            return false;
        }
    }

    function getCoursesBySemesterAndStudents($dbConnection, $id_semestre, $id_student){
        try{
            $query = 'SELECT * FROM cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN etudiant ON etudiant.id_classe = classe.id_classe WHERE etudiant.id_etu = :id_etu AND semestre.id_semestre = :id_semestre';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_etu', $id_student);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function getEpreuvesOfACourse($dbConnection, $id_cours){
        try{
            $query = 'SELECT * FROM epreuve JOIN cours ON epreuve.id_matiere = cours.id_matiere JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN annee a ON a.id_annee = semestre.id_annee JOIN enseignant e ON e.id_prof = cours.id_prof WHERE epreuve.id_matiere = :id_cours ORDER BY substr(epreuve.nom_epreuve,3) ASC';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_cours', $id_cours);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function getCoursesBySemester($dbConnection, $id_semestre){
        try{
            $query = 'SELECT * FROM cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN annee a ON semestre.id_annee = a.id_annee JOIN enseignant e ON e.id_prof = cours.id_prof WHERE semestre.id_semestre = :id_semestre';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function getCoursesByProfessor($dbConnection, $id_prof){
        try{
            $query = 'SELECT * FROM cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN annee a ON semestre.id_annee = a.id_annee JOIN enseignant ON enseignant.id_prof = cours.id_prof WHERE enseignant.id_prof = :id_prof';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_prof', $id_prof);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function getCoursesByCycle($dbConnection, $cycle){
        try{
            $query = 'SELECT * FROM cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN annee a ON semestre.id_annee = a.id_annee  JOIN enseignant e ON e.id_prof = cours.id_prof WHERE classe.nom_cycle = :cycle';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }
    
    function getCoursesByProfessorAndSemester($dbConnection, $id_prof, $id_semestre){
        try{
            $query = 'SELECT * FROM cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN annee a ON semestre.id_annee = a.id_annee JOIN enseignant ON enseignant.id_prof = cours.id_prof WHERE enseignant.id_prof = :id_prof AND semestre.id_semestre = :id_semestre';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':id_prof', $id_prof);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function getCoursesByCycleAndSemester($dbConnection, $cycle, $id_semestre){
        try{
            $query = 'SELECT * FROM cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN enseignant e ON e.id_prof = cours.id_prof JOIN annee a ON a.id_annee = semestre.id_annee WHERE classe.nom_cycle = :cycle AND semestre.id_semestre = :id_semestre';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function getCoursesByCycleAndProfessor($dbConnection, $cycle, $id_prof){
        try{
            $query = 'SELECT * FROM cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN annee a ON a.id_annee = semestre.id_annee JOIN enseignant ON enseignant.id_prof = cours.id_prof WHERE classe.nom_cycle = :cycle AND enseignant.id_prof = :id_prof';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->bindParam(':id_prof', $id_prof);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function getCoursesByCycleAndProfessorAndSemester($dbConnection, $cycle, $id_prof, $id_semestre){
        try{
            $query = 'SELECT * FROM cours JOIN classe ON cours.id_classe = classe.id_classe JOIN semestre ON semestre.id_semestre = cours.id_semestre JOIN annee a ON a.id_annee = semestre.id_annee JOIN enseignant ON enseignant.id_prof = cours.id_prof WHERE classe.nom_cycle = :cycle AND enseignant.id_prof = :id_prof AND semestre.id_semestre = :id_semestre';
            $statement = $dbConnection->prepare($query);
            $statement->bindParam(':cycle', $cycle);
            $statement->bindParam(':id_prof', $id_prof);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    function getAllCoursesOfStudentsInSemester($db,$id_etu,$id_semestre){
        try{
            $query = 'SELECT DISTINCT * FROM cours c JOIN classe cl ON cl.id_classe = c.id_classe JOIN etudiant e ON e.id_classe = cl.id_classe JOIN semestre s ON s.id_semestre = c.id_semestre JOIN enseignant en ON en.id_prof = c.id_prof WHERE e.id_etu = :id_etu AND s.id_semestre = :id_semestre';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getStudentsNotNoted($db,$id_epreuve){
        try{
            $query = 'SELECT DISTINCT nom_etu,prenom_etu, id_etu FROM etudiant e JOIN classe cl ON cl.id_classe = e.id_classe JOIN cours c ON c.id_classe = cl.id_classe JOIN epreuve ep ON ep.id_matiere = c.id_matiere WHERE id_etu NOT IN (SELECT id_etu FROM fait_epreuve fep WHERE fep.id_epreuve = :id) AND ep.id_epreuve = :id';
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id_epreuve);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getStudentOfCourse($db,$id_cours){
        try{
            $query = 'SELECT DISTINCT * FROM etudiant e JOIN classe cl ON cl.id_classe = e.id_classe JOIN cours c ON c.id_classe = cl.id_classe WHERE c.id_matiere = :id';
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id_cours);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getAppreciationOfStudent($db,$id_etu,$id_cours){
        try{
            $query = 'SELECT commentaire FROM recoit_appreciation WHERE id_etu = :id_etu AND id_matiere = :id_cours';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_cours', $id_cours);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getStudentsNotCommented($db,$id_cours){
        try{
            $query = 'SELECT DISTINCT nom_etu,prenom_etu, e.id_etu FROM etudiant e JOIN classe cl ON cl.id_classe = e.id_classe JOIN cours c ON c.id_classe = cl.id_classe WHERE id_etu NOT IN (SELECT id_etu FROM recoit_appreciation ra WHERE id_matiere =:id) AND c.id_matiere = :id;';
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id_cours);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getNumberOfDS($db,$id_cours){
        try{
            $query = 'SELECT COUNT(*) as nb FROM epreuve ep JOIN cours c ON c.id_matiere = ep.id_matiere WHERE c.id_matiere = :id';
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id_cours);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getYearOfSemester($db, $id_semestre){
        try{
            $query = 'SELECT numero_annee FROM semestre s JOIN annee a ON a.id_annee = s.id_annee WHERE id_semestre = :id_semestre';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        if($result == null){
            return null;
        }else{
            return $result['numero_annee'];
        }
    }
    
    function getNumberOfSemester($db, $id_semestre){
        try{
            $query = 'SELECT numero_semestre FROM semestre WHERE id_semestre = :id_semestre';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        if ($result == null){
            return null;
        }else{
            return $result['numero_semestre'];
        }
    }

    function getIdYearOfSemester($db,$id_semestre){
        try{
            $query = 'SELECT id_annee FROM semestre WHERE id_semestre = :id_semestre';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_semestre', $id_semestre);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        if($result == null){
            return null;
        }else{
            return $result['id_annee'];
        }
    }

    function getNotesOfStudent($db, $id_etu,$id_matiere){
        try{
            $query = 'SELECT note,coefficient FROM fait_epreuve fep JOIN epreuve ep ON ep.id_epreuve = fep.id_epreuve JOIN cours c ON c.id_matiere = ep.id_matiere WHERE id_etu = :id_etu AND c.id_matiere = :id_matiere';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->bindParam(':id_matiere', $id_matiere);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getAllNotesOfEpreuve($db,$id_epreuve){
        try{
            $query = 'SELECT * FROM fait_epreuve WHERE id_epreuve = :id_epreuve';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_epreuve', $id_epreuve);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getNoteOfEpreuveOfStudent($db,$id_epreuve,$id_etu){
        try{
            $query = 'SELECT note FROM fait_epreuve WHERE id_epreuve = :id_epreuve AND id_etu = :id_etu';
            $statement = $db->prepare($query);
            $statement->bindParam(':id_epreuve', $id_epreuve);
            $statement->bindParam(':id_etu', $id_etu);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        }catch(exception $e){
            echo $e->getMessage();
        }
        return $result;
    }

    function getGeneralCoefficientOfCourse($db,$id_cours){
        $allDs = getEpreuvesOfACourse($db,$id_cours);
        $sum = 0;
        foreach($allDs as $ds){
            $sum += $ds['coefficient'];
        }
        return $sum;
    }

    function getAverageNoteOfCourse($db,$id_cours){
        $students = getStudentOfCourse($db,$id_cours);
        $sum = 0;
        $count = 0;
        foreach($students as $student){
            $average = getAverageNoteOfCourseOfStudent($db,$student['id_etu'],$id_cours);
            if($average != null){
                $sum += $average;
                $count++;
            }
        }
        if($count == 0){
            return null;
        }
        else{
            return $sum/$count;
        }
    }

    function getGeneralAverageInSemester($db,$id_etu, $id_semester){
        $courses = getAllCoursesOfStudentsInSemester($db,$id_etu,$id_semester);
        $sum = 0;
        $i = 0;
        foreach($courses as $course){
            $sum += getAverageNoteOfCourseOfStudent($db,$id_etu,$course['id_matiere']);
            $i++;
        }
        if($i == 0){
            return null;
        }
        else{
            return $sum/$i;
        }
    }
    
    function getRankOfEpreuve($db, $id_etu, $id_epreuve){
        $allNotes = getAllNotesOfEpreuve($db,$id_epreuve);
        $arrayOfNotes = array();
        foreach($allNotes as $note){
            $arrayOfNotes[$note['id_etu']] = $note['note'];
        }
        arsort($arrayOfNotes);
        $i = 1;
        foreach($arrayOfNotes as $key => $value){
            if($key == $id_etu){
                return $i;
            }
            $i++;
        }
        
    }
    
    function getRankOfCourse($db,$id_etu,$id_cours){
        $students = getStudentOfCourse($db,$id_cours);
        $arrayOfNotes = array();
        foreach($students as $student){
            $arrayOfNotes[$student['id_etu']] = getAverageNoteOfCourseOfStudent($db,$student['id_etu'],$id_cours);
        }
        arsort($arrayOfNotes);
        $i = 1;
        foreach($arrayOfNotes as $key => $value){
            if($key == $id_etu){
                return $i;
            }
            $i++;
        }
    }

    function getMinimalNoteOfEpreuve($db,$id_epreuve){
        $allNotes = getAllNotesOfEpreuve($db,$id_epreuve);
        if($allNotes == null){
            return null;
        }else{
            $min = $allNotes[0]['note'];
            foreach($allNotes as $note){
                if($note['note'] < $min){
                    $min = $note['note'];
                }
            }
            return $min;
        }
    }

    function getMaximalNoteOfEpreuve($db, $id_epreuve){
        $allNotes = getAllNotesOfEpreuve($db,$id_epreuve);
        if($allNotes == null){
            return null;
        }else{
            $max = $allNotes[0]['note'];
            foreach($allNotes as $note){
                if($note['note'] > $max){
                    $max = $note['note'];
                }
            }
            return $max;
        }
    }
    
    function getAverageNoteOfEpreuve($db,$id_epreuve){
        $allNotes = getAllNotesOfEpreuve($db,$id_epreuve);
        if($allNotes == null){
            return null;
        }else{
            $sum = 0;
            $i = 0;
            foreach($allNotes as $note){
                $sum += $note['note'];
                $i++;
            }
            return $sum/$i;
        }
    }

    function getAverageNoteOfCourseOfStudent($db,$id_etu,$id_cours){
        $arrayOfNotes = getNotesOfStudent($db,$id_etu,$id_cours);
        $sum = 0;
        $sumCoef = 0;
        if(count($arrayOfNotes) == 0){
            return null;
        }
        else{
            foreach($arrayOfNotes as $note){
                $sum += $note['note'] * $note['coefficient'];
                $sumCoef += $note['coefficient'];
            }
            return $sum/$sumCoef;
        }
    }

    function getMinimalAverageOfCourse($db,$id_cours){
        $studentsOfCourse = getStudentOfCourse($db,$id_cours);
        if($studentsOfCourse == null){
            return null;
        }else{
            $min = getAverageNoteOfCourseOfStudent($db,$studentsOfCourse[0]['id_etu'],$id_cours);
            foreach($studentsOfCourse as $student){
                $average = getAverageNoteOfCourseOfStudent($db,$student['id_etu'],$id_cours);
                if($average < $min){
                    $min = $average;
                }
            }
            return $min;
        }
    }

    function getMaximalAverageOfCourse($db,$id_cours){
        $studentsOfCourse = getStudentOfCourse($db,$id_cours);
        if($studentsOfCourse == null){
            return null;
        }
        else{
            $max = getAverageNoteOfCourseOfStudent($db,$studentsOfCourse[0]['id_etu'],$id_cours);
            foreach($studentsOfCourse as $student){
                $average = getAverageNoteOfCourseOfStudent($db,$student['id_etu'],$id_cours);
                if($average > $max){
                    $max = $average;
                }
            }
            return $max;
        }
    }

    ?>
