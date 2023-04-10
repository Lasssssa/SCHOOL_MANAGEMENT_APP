<?php 
    session_start();
      if($_SESSION['identifiedAdmin'] == false || !isset($_SESSION['identifiedAdmin'])){
        header("Location: ../loginAdmin.php");
        exit;
      }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <title>Page Administrateur </title>
        <link href="stylePersoAdmin.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="../script.js"></script> 
        
    </head>
    
    <!-- A réadapter -->
    <body>
        <div id="header">
            <div id="logo">
                <a href ="persoAdmin.php"><img src="../images/logoIsen.png" alt="logo" width ="190px"></a>
            </div>
            <div id="enseignant">
                <a href="addingEnseignant.php">Enseignants</a>
            </div>
            <div id="etudiant">
                <a href="addingEtudiant.php">Étudiants</a>
            </div>
            <div id="cours">
                <a href="addingCours.php">Cours</a>
            </div>
            <div>
            
            </div>
            <div id="account">
            <?php echo '<div id="info"><a href="infoAdmin.php">'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].'    <span class="material-symbols-outlined">account_circle</span></a></div>'; ?>
            </div>
            <div id="deconnexion">
                <a href="../loginAdmin.php"><span class="material-symbols-outlined">logout</span></a>
            </div>
        </div>
        <div id ="board">
            <a href="addingEtudiant.php">Ajout</a>
            <a href="modifyStudents.php">Modification</a>
        </div>

        <?php 
            if(isset($_POST['modifier'])){
                require_once('../database.php');
                $dbConnection = dbConnect();
                $id_classe = getIdClassWithYearAndCycle($dbConnection, $_POST['annee_cursus'], $_POST['cycle']);
                modifyStudent($dbConnection, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['id_etu'], $id_classe);
                echo '<div class="alert alert-success" role="alert">
                        L\'étudiant a bien été modifié.
                        </div>';
            }

        ?>
        
        <?php
        
            require_once('../database.php');
            $dbConnection = dbConnect();
            $allStudents = getAllStudents($dbConnection);
            foreach($allStudents as $student){
                if(isset($_POST['supprimer'])){
                    deleteStudent($dbConnection, $_POST['id_etu']);
                    echo '
                    <div class="alert alert-success" role="alert">
                        L\'élève a bien été supprimé.
                    </div>';
                    unset($_POST['supprimer']);
                }
                else if(isset($_POST['supp_'.$student['id_etu']])){
                    //Demander à l'utilisateur si il est sûr de vouloir supprimer l'enseignant :
                    echo '
                    <div id="deleteProf">
                        <div id="delete2">
                            <p>Êtes-vous sûr de vouloir supprimer cet élève ?</p>
                            <form action="modifyStudents.php" method="post">
                                <button type="submit" class="btn btn-success" name="supprimer">Supprimer</button>
                                <button type="submit" class="btn btn-danger" name="retour">Retour</button>
                                <input type="hidden" name="id_etu" value="'.$student['id_etu'].'">
                            </form>
                        </div>
                    </div>';
                }
                else if(isset($_POST[$student['id_etu']])){
                    echo '
                        <div id="modificationProf">
                            <div id="modif2">
                                <form action="modifyStudents.php" method="post">
                                    <div class="mb-3">
                                        <label for="nom" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="nom" name="nom" value="'.$student['nom_etu'].'">
                                    </div>
                                    <div class="mb-3">
                                        <label for="prenom" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="prenom" name="prenom" value="'.$student['prenom_etu'].'">
                                    </div>
                                    <div class="mb-3">
                                        <label for="mail" class="form-label">Mail</label>
                                        <input type="text" class="form-control" id="mail" name="mail" value="'.$student['mail_etu'].'">
                                    </div>
                                    <div class="row">
                                        <div class="col">';
                                        echo '<label for="mail" class="form-label">Année</label>';
                                        echo '<select class="form-select" aria-label="Default select example" name="annee_cursus">';
                                                echo '<option value="'.$student['annee_cursus'].'">'.$student['annee_cursus'].'</option>';
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if($i != $student['annee_cursus'])
                                                    {
                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                    }
                                                }
                                                echo '
                                            </select>
                                        </div>
                                    </div>';
                                    echo '<br>';
                                    echo '<label for="mail" class="form-label">Cycle</label>';
                                    $cycles = getCycles($dbConnection);
                                    echo '<div><select class="form-select" aria-label="Default select example" name="cycle">';
                                        echo '<option value="'.$student['nom_cycle'].'">'.$student['nom_cycle'].'</option>';
                                    foreach($cycles as $cycle){
                                        if($cycle['nom_cycle'] != $student['nom_cycle'])
                                        {
                                            echo '<option value="'.$cycle['nom_cycle'].'">'.$cycle['nom_cycle'].'</option>';
                                        }
                                    }
                                    echo '</select></div><br>';
                                    echo '<button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                                    <input type="hidden" name="id_etu" value="'.$student['id_etu'].'" name="id_etu">
                                </form>
                            </div>
                        </div>';
                }
            }
            
        ?>
        
        <div id="middleChoiceStudents">
            <form action="modifyStudents.php" method ="post" id="formCycle">
                <div id="titleChoice">
                    <h2>Filtre de tri</h2>
                </div>
                <div id="choiceCycleSelect">
                <?php
                        $db = dbConnect();
                        $cycles = getCycles($db);
                       
                        echo '<select class="form-select" aria-label="Default select example" name="choice_cycle">';
                        echo '<option value="all">Tous les cycles</option>';
                        foreach($cycles as $cycle){
                            echo '<option value="'.$cycle['nom_cycle'].'">'.$cycle['nom_cycle'].'</option>';
                        }
                        echo '</select>';
                    ?>
                </div>
                <div id="choiceAnneeSelect">
                    <select class="form-select" aria-label="Default select example" name="choice_annee">
                        <option selected value="all">Toutes les années</option>';
                        <option value="1">Année 1</option>
                        <option value="2">Année 2</option>
                        <option value="3">Année 3</option>
                        <option value="4">Année 4</option>
                        <option value="5">Année 5</option>
                    </select>
                </div>
                <div id="choiceSubmit">
                    <button type="submit" class="btn btn-primary" name="submitCycle">Appliquer des filtres</button>
                </div>
            </form>
        </div>
        <div id="modifyEnseignant">
            <table class="table table-dark table-striped">
                <?php
                    require_once('../database.php');
                    $dbConnection = dbConnect();
                    if(isset($_POST['choice_cycle']) && isset($_POST['choice_annee']) && isset($_POST['submitCycle']) && $_POST['choice_cycle'] != 'all' && $_POST['choice_annee'] != 'all'){
                        $allStudents = getStudentsByCycleAndYear($dbConnection, $_POST['choice_cycle'], $_POST['choice_annee']);
                    }
                    else if(isset($_POST['choice_cycle']) && isset($_POST['submitCycle']) && $_POST['choice_cycle'] != 'all'){
                        $allStudents = getStudentsByCycle($dbConnection, $_POST['choice_cycle']);
                    }
                    else if(isset($_POST['choice_annee']) && isset($_POST['submitCycle']) && $_POST['choice_annee'] != 'all'){
                        $allStudents = getStudentsByYear($dbConnection, $_POST['choice_annee']);
                    }
                    else{
                        $allStudents = getAllStudents($dbConnection);
                    }
                    echo '<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Mail</th><th>Classe</th><th>Modification</th><th>Supression</th></tr>';
                    foreach($allStudents as $student){
                        echo '<tr><td>'.$student['id_etu'].'</td><td>'.$student['nom_etu'].'</td><td>'.$student['prenom_etu'].'</td><td>'.
                        $student['mail_etu'].'</td><td>'.$student['nom_cycle'].' '.$student['annee_cursus'].'</td>
                        <td>
                            <form action="modifyStudents.php" method="post">
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" name="'.$student['id_etu'].'">Modifier</button>
                            </form>
                        </td>
                        <td>
                            <form action="modifyStudents.php" method="post">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" name="supp_'.$student['id_etu'].'">Supprimer</button></form>
                        </td>
                        </tr>';
                    }
                ?>
            </table>
        </div>
        </div>
        
    </body>
</html>