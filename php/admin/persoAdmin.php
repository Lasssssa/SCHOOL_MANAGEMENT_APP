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
        <div id="recap">
            <div id="recapEnseignant">
                <h1>Enseignants</h1>
                <div id="bouton">
                    <form action="persoAdmin.php" method="post">
                        <button type="submit" class="btn btn-success" name="afficherEnseignant">Afficher</button>
                        <button type="sumbit" class="btn btn-danger" name="retirerEnseignant">Retirer</button>
                    </form>
                </div>
                <?php
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL);
                    require_once('../database.php');
                    if(isset($_POST['afficherEnseignant'])){
                        $_SESSION['afficherEnseignant'] = true;
                    }
                    if(isset($_POST['retirerEnseignant'])){
                        $_SESSION['afficherEnseignant'] = false;
                    }
                    if(isset($_SESSION['afficherEnseignant']) && $_SESSION['afficherEnseignant'] == true){
                        echo '<div id="afficher">';
                            $dbConnection = dbConnect();
                            $allProfessors = getAllProfessors($dbConnection);
                            echo '<table class="table table-striped">';
                            echo '<tr><th>Nom</th><th>Prénom</th><th>Mail</th><th>Numéro de téléphone</th></tr>';
                            foreach($allProfessors as $enseignant){
                                echo '<tr><td>'.$enseignant['nom'].'</td><td>'.$enseignant['prenom'].'</td><td>'.$enseignant['mail'].'</td><td>'.$enseignant['telephone'].'</td></tr>';
                            }
                            echo '</table>';
                        echo '</div>';
                    }

                ?>
            </div>
            <div id="recapEtudiant">
                <h1>Étudiants</h1>
                <div id="bouton">
                    <form action="persoAdmin.php" method="post">
                        <button type="submit" class="btn btn-success" name="afficherEtu">Afficher</button>
                        <button type="sumbit" class="btn btn-danger" name="retirerEtu">Retirer</button>
                    </form>
                </div>
                <?php
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL);
                    require_once('../database.php');
                    if(isset($_POST['afficherEtu'])){
                        $_SESSION['afficherEtudiant'] = true;
                    }
                    if(isset($_POST['retirerEtu'])){
                        $_SESSION['afficherEtudiant'] = false;
                    }
                    if(isset($_SESSION['afficherEtudiant'])&& $_SESSION['afficherEtudiant'] == true){
                        echo '<div id="afficher">';
                            $dbConnection = dbConnect();
                            $allStudents = getAllStudents($dbConnection);
                            echo '<table class="table table-striped">';
                            echo '<tr><th>Nom</th><th>Prénom</th><th>Mail</th><th>Année</th><th>Cycle</th></tr>';
                            foreach($allStudents as $etudiant){
                                echo '<tr><td>'.$etudiant['nom'].'</td><td>'.$etudiant['prenom'].'</td><td>'.$etudiant['mail'].'</td><td>'.$etudiant['annee_cursus'].'</td><td>'.$etudiant['nom_cycle'].'</td></tr>';
                            }
                            echo '</table>';
                        echo '</div>';
                    }

                ?>
            </div>
            <div id="recapCours">
                <h1>Cours</h1>
                <div id="bouton">
                    <form action="persoAdmin.php" method="post">
                        <button type="submit" class="btn btn-success" name="afficherCours">Afficher</button>
                        <button type="sumbit" class="btn btn-danger" name="retirerCours">Retirer</button>
                    </form>
                </div>
                <?php
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL);
                    require_once('../database.php');
                    if(isset($_POST['afficherCours'])){
                        $_SESSION['afficherCours'] = true;
                    }
                    if(isset($_POST['retirerCours'])){
                        $_SESSION['afficherCours'] = false;
                    }
                    if(isset($_SESSION['afficherCours'])&& $_SESSION['afficherCours'] == true){
                        echo '<div id="afficher">';
                            $dbConnection = dbConnect();
                            $allCourses = getAllCourses($dbConnection);
                            echo '<table class="table table-striped">';
                            echo '<tr><th>Matière</th><th>Durée</th><th>Professeur</th><th>Semestre</th><th>Année</th></tr>';
                            foreach($allCourses as $course){   
                                echo '<tr><td>'.$course['nom_matiere'].'</td><td>'.$course['duree'].'</td><td>'.$course['nom'].'</td><td>'.$course['numero_semestre'].'</td><td>'.$course['numero_annee'].'</td></tr>';
                            }
                            echo '</table>';
                        echo '</div>';
                    }

                ?>
            </div>
        </div>
    </body>
</html>