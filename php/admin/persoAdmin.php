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
    
    <!-- A voir pour plutot avoir un récapitulatif en fonction de ce que l'on demande -->

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="header">
            <div class="container-fluid" id="space">
                <a class="navbar-brand" href="persoAdmin.php">
                    <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="addingEnseignant.php">Enseignants</a>
                        </li>
                        <li class="nav-item">
                            <a href="addingEtudiant.php">Étudiants</a>
                        </li>
                        <li class="nav-item">
                            <a href="addingCours.php">Cours</a>
                        </li>
                    </ul>
                </div>
                <span class="navbar-text ms-auto">
                    <?php echo '<a href="infoAdmin.php">'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].'    <span class="material-symbols-outlined">account_circle</span></a>'; ?>
                </span>
                    <!-- <button type="button" class="btn btn-outline-danger">Danger</button> -->
                    <a href="../loginAdmin.php">Deconnexion</a>
            </div>
        </nav>
            
        <div id ="board2">
            <h1>Tableau de bord général</h1>
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
                                echo '<tr><td>'.$enseignant['nom_prof'].'</td><td>'.$enseignant['prenom_prof'].'</td><td>'.$enseignant['mail_prof'].'</td><td>'.$enseignant['telephone_prof'].'</td></tr>';
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
                                echo '<tr><td>'.$etudiant['nom_etu'].'</td><td>'.$etudiant['prenom_etu'].'</td><td>'.$etudiant['mail_etu'].'</td><td>'.$etudiant['annee_cursus'].'</td><td>'.$etudiant['nom_cycle'].'</td></tr>';
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
                                echo '<tr><td>'.$course['nom_matiere'].'</td><td>'.$course['duree'].'</td><td>'.$course['prenom_prof'].' '.$course['nom_prof'].'</td><td>'.$course['numero_semestre'].'</td><td>'.$course['numero_annee'].'</td></tr>';
                            }
                            echo '</table>';
                        echo '</div>';
                    }

                ?>
            </div>
        </div>
    </body>
</html>