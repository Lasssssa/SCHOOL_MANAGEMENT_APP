<?php 
    session_start();
    if(!isset($_SESSION['identifiedEtudiant']) || $_SESSION['identifiedEtudiant'] == false){
        header("Location: ../loginEtudiant.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link href="stylePersoEtudiant.css" rel="stylesheet">
        <title>Page Étudiant</title>
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

            <div id="account">
            <?php echo '<div id="info"><a href="infoAdmin.php">'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].'    <span class="material-symbols-outlined">account_circle</span></a></div>'; ?>
            </div>
            <div id="deconnexion">
                <a href="../loginAdmin.php"><span class="material-symbols-outlined">logout</span></a>
            </div>
        </div>

        <form>
            <select class="form-select" id = "selectPerso" aria-label="Default select example" name = "semestre">
                <?php 
                require_once('../database.php');
                $db = dbConnect();
                $semesters = getAllSemesters($db);
                foreach($semesters as $semester) {
                    echo "<option value = ".$semester['id_semestre'].">"."Semestre : ".$semester['numero_semestre']." / "." Année : ".$semester['numero_annee']."</option>";
                }
                ?>
            </select>

            <input type="submit" value="Valider" class="btn btn-primary" id="valider">
        </form>


        <div id = "tabPerso">
            <table class="table table-striped">
                <tr><th>Matière</th><th>DS 1</th><th>DS 2</th><th>DS 3</th><th>Moyenne</th><th>Moyenne de Classe</th><th>Classement</th><th>Appréciation</th><th>Rattrapage</th></tr>
                <?php
                    require_once('../database.php');
                    $db = dbConnect();
                    if(isset($_POST['semestre'])) {
                        $allCoursesForStudent = getCoursesBySemesterAndStudents($db, $_POST['semestre'], $_SESSION['id_etudiant']);
                        
                        
                        
                        // Affichage une fois qu'on a toutes les variables
                        /*foreach($allCoursesForStudent as $course) {
                            echo "<tr><td>".$course['nom_matiere']."</td><td>".$course['note_ds1']."</td><td>".$course['note_ds2']."</td><td>".$course['note_ds3']."</td><td>".$course['moyenne']."</td><td>".$course['moyenne_classe']."</td><td>".$course['classement']."</td><td>".$course['appreciation']."</td><td>".$course['rattrapage']."</td></tr>";
                        }*/
                    }

                ?>

            </table>
        </div>


    </body>
</html>