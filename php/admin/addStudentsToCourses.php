<?php 
    session_start();
      if($_SESSION['identifiedAdmin'] == false || !isset($_SESSION['identifiedAdmin'])){
        header("Location: ../loginAdmin.php");
        exit;
      }
      if(!isset($_POST['id_matiere'])){
        header("Location: modifyCourses.php");
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
        
        <div id="addStudentToCoursMain">

            <?php
                require_once('../database.php');
                $dbConnection = dbConnect();
                if(isset($_POST['id_etu'])){
                    if(isset($_POST['add_'.$_POST['id_etu']])){
                        addStudentToCourse($dbConnection,$_POST['id_etu'],$_POST['id_matiere']);
                    }
                    if(isset($_POST['supp_'.$_POST['id_etu']])){
                        deleteStudentFromCourse($dbConnection,$_POST['id_etu'],$_POST['id_matiere']);
                    }
                }
            ?>
            <div id="modifyEnseignant">
            <h1>Page de gestion du cours : </h1>
            <?php
                require_once('../database.php');
                $dbConnection = dbConnect();
                $matiere = getCoursWithId($dbConnection,$_POST['id_matiere']);
                echo '<h2>'.$matiere['nom_matiere'].'</h2>';
                $studentsInCourse = getStudentsInCourse($dbConnection,$_POST['id_matiere']);
                $studentsNotInCourse = getStudentsNotInCourse($dbConnection,$_POST['id_matiere']);
                echo '<table class="table table-dark table-striped">';
                echo '<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Année</th><th>Cycle</th><th>Supprimer</th></tr>';
                    foreach($studentsInCourse as $student){
                        echo '<tr><td>'.$student['id_etu'].'</td><td>'.$student['nom_etu'].'</td><td>'.$student['prenom_etu'].'</td><td>'.$student['annee_cursus'].'</td><td>'.$student['nom_cycle'].'</td>
                        <td>
                            <form action="addStudentsToCourses.php" method="post">
                            <input type="hidden" name="id_etu" value="'.$student['id_etu'].'">
                            <input type="hidden" name="id_matiere" value="'.$_POST['id_matiere'].'">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" name="supp_'.$student['id_etu'].'">Supprimer</button>
                            </form>
                        </td>
                        </tr>';
                    }
                    foreach($studentsNotInCourse as $student){
                        echo '<tr><td>'.$student['id_etu'].'</td><td>'.$student['nom_etu'].'</td><td>'.$student['prenom_etu'].'</td><td>'.$student['annee_cursus'].'</td><td>'.$student['nom_cycle'].'</td>
                        <td>
                            <form action="addStudentsToCourses.php" method="post">
                            <input type="hidden" name="id_etu" value="'.$student['id_etu'].'">
                            <input type="hidden" name="id_matiere" value="'.$_POST['id_matiere'].'">
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" name="add_'.$student['id_etu'].'">Ajouter</button>
                            </form>
                        </td>
                        </tr>';
                    }
                    echo '</table>';
                
            ?>
            </div>
        </div>

        
        
    </body>
</html>