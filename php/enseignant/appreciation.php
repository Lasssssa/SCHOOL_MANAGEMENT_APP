<?php 
    session_start();
        if($_SESSION['identifiedEnseignant'] == false || !isset($_SESSION['identifiedEnseignant'])){
            header("Location: ../loginEnseignant.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <title>Page Administrateur </title>
        <link href="stylePersoEnseignant.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="../script.js"></script>
    </head>
    
    <!-- A voir pour plutot avoir un récapitulatif en fonction de ce que l'on demande -->

    <body>
        <div id="header">
            <div id="logo">
                <a href ="persoEnseignant.php"><img src="../images/logoIsen.png" alt="logo" width ="190px"></a>
            </div>
            <div id="consultation">
                <a href="consultation.php">Consultation</a>
            </div>
            <div id="notes">
                <a href="notes.php">Saisie</a>
            </div>
            <div>
            
            </div>
            <div id="account">
            <?php echo '<div id="info"><a href="infoEnseignant.php">'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].'    <span class="material-symbols-outlined">account_circle</span></a></div>'; ?>
            </div>
            <div id="deconnexion">
                <a href="../loginAdmin.php"><span class="material-symbols-outlined">logout</span></a>
            </div>
        </div>

        <div id="bodyNotes">
            <form action="notes.php" method="post">
            <div id="choixSemestre">
                    <h1 id="titleSemestre">Choix du semestre</h1>
                        <?php
                            require_once('../database.php');
                            $db = dbConnect();
                            $allSemesters = getAllSemesters($db);
                            echo '<div id="selectSemestre">';
                            echo '<select class="form-select" aria-label="Default select example" name="semester">';
                            foreach($allSemesters as $semester){
                                echo '<option value="'.$semester['id_semestre'].'">Semestre '.$semester['numero_semestre'].' | Année '.$semester['numero_annee'].'</option>';
                            }
                            echo '</select>';
                            echo '</div>';
                        ?>
                        <div id="buttonSemestre">
                            <input type="submit" name="validerSemestre" value="Valider" class="btn btn-primary">
                        </div>
                </div>
                </form>
            <?php
                if(isset($_POST['validerSemestre'])){
                    $coursesOfAProfessor = getCoursesByProfessorAndSemester($db, $_SESSION['id'],$_POST['semester']);
                    if($coursesOfAProfessor == null){
                        echo '<div class="alert alert-danger" role="alert">
                        Vous n\'avez pas de cours ni d\'épreuves à noter pour ce semestre.
                        </div>';
                    }
                    else{
                        echo '<div class="alert alert-success" role="alert">
                        Vous avez des épreuves à noter pour ce semestre.
                        </div>';

                        echo '<table class="table table-striped">';
                        echo '<tr><th>Matière</th><th>Classe</th><th>Année</th><th>Semestre</th></tr>';
                        foreach($coursesOfAProfessor as $course){
                            echo '<tr><td>'.$course['nom_matiere'].'</td><td>'.$course['nom_cycle'].$course['annee_cursus'].'</td><td>'.$course['numero_annee'].'</td><td>'.$course['numero_semestre'].'</td></tr>';
                        }   
                    }
                }
            ?>
        </div>




        <button onclick="afficherNotes()">Afficher les notes</button>

        <!-- Liste des notes (à renseigner avec les données appropriées) -->
        <ul id="listeNotes">
            <li>Cours 1 : Note 1</li>
            <li>Cours 2 : Note 2</li>
            <li>Cours 3 : Note 3</li>
            <!-- Ajoutez autant d'éléments de liste que nécessaire pour les notes à rentrer -->
        </ul>

        <script>
            // Fonction pour afficher la liste des notes
            function afficherNotes() {
                var listeNotes = document.getElementById("listeNotes");
                if(listeNotes.style.display == "block"){
                    listeNotes.style.display = "none";
                }
                else{
                    listeNotes.style.display = "block";
                } // Affiche la liste des notes
            }
        </script>

        
    </body>
</html>