<?php 
    session_start();
    if(!isset($_SESSION['identifiedEtudiant']) || $_SESSION['identifiedEtudiant'] == false){
        header("Location: ../loginPage.php");
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="header">
            <div class="container-fluid" id="space">
                <a class="navbar-brand" href="persoEtudiant.php">
                    <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item" id="ecart">
                            <a href="recap.php">Récapitulatif</a>
                        </li>
                        <li class="nav-item" id="ecart">
                            <a href="bulletin.php">Bulletins</a>
                        </li>
                        <li class="nav-item" id="ecart">
                            <a href="appreciation.php">...</a>
                        </li>
                    </ul>
                    <a href="infoEtudiant.php">
                        <button type="button" class="btn btn-secondary">
                            <?php echo '<span class="material-symbols-outlined">account_circle</span>&nbsp&nbsp&nbsp'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].''; ?>
                        </button>
                    </a>
                    <a href="../loginPage.php">
                        <button type="button" class="btn btn-danger"><span class="material-symbols-outlined">logout</span></button>
                    </a>
                </div>
                
            </div>
        </nav>

        <?php
            require_once('../database.php');
            $db = dbConnect();
            if(isset($_POST['validerSemestre'])){
                $_SESSION['idSemestre'] = $_POST['semester'];
                $_SESSION['idAnnee'] = getIdYearOfSemester($db, $_SESSION['idSemestre']);
                $_SESSION['numero_annee'] = getYearOfSemester($db, $_SESSION['idSemestre']);
                $_SESSION['numero_semestre'] = getNumberOfSemester($db, $_SESSION['idSemestre']);
            }else if(isset($_SESSION['idSemestre'])){
                $_SESSION['idSemestre'] = $_SESSION['idSemestre'];
                $_SESSION['idAnnee'] = getIdYearOfSemester($db, $_SESSION['idSemestre']);
                $_SESSION['numero_annee'] = getYearOfSemester($db, $_SESSION['idSemestre']);
                $_SESSION['numero_semestre'] = getNumberOfSemester($db, $_SESSION['idSemestre']);
            }else{
                $_SESSION['idSemestre'] = 1;
                $_SESSION['idAnnee'] = getIdYearOfSemester($db, $_SESSION['idSemestre']);
                $_SESSION['numero_annee'] = getYearOfSemester($db, $_SESSION['idSemestre']);
                $_SESSION['numero_semestre'] = getNumberOfSemester($db, $_SESSION['idSemestre']);
            }
        ?>

        <form action="recap.php" method="post">
            <div id="choixSemestre">
                    <h1 id="titleSemestre">Choix du semestre</h1>
                        <?php
                            require_once('../database.php');
                            $db = dbConnect();
                            $allSemesters = getAllSemesters($db);
                            echo '<div id="selectSemestre">';
                            echo '<select class="form-select" aria-label="Default select example" name="semester">';
                            if(isset($_SESSION['idSemestre'])){
                                echo '<option value="'.$_SESSION['idSemestre'].'">Semestre '.$_SESSION['numero_semestre'].' | Année '.$_SESSION['numero_annee'].'</option>';
                            }
                            foreach($allSemesters as $semester){
                                if(isset($_SESSION['idSemestre'])){
                                    if($semester['id_semestre'] != $_SESSION['idSemestre']){
                                        echo '<option value="'.$semester['id_semestre'].'">Semestre '.$semester['numero_semestre'].' | Année '.$semester['numero_annee'].'</option>';
                                    }
                                }else{
                                    echo '<option value="'.$semester['id_semestre'].'">Semestre '.$semester['numero_semestre'].' | Année '.$semester['numero_annee'].'</option>';
                                }
                            }
                            echo '</select>';
                            echo '</div>';
                        ?>
                        <div id="buttonSemestre">
                            <input type="submit" name="validerSemestre" value="Valider" class="btn btn-primary">
                        </div>
                </div>
                </form>


    

        <div id = "tabPerso">
            <div id="recap">
                <h1>Votre moyenne sur le semestre</h1>
                <div id="moyenne">
                    <?php
                        require_once('../database.php');
                        $db = dbConnect();
                        $average = getGeneralAverageInSemester($db, $_SESSION['id'], $_SESSION['idSemestre']);
                        if($average != null){
                            echo '<h3>'.number_format($average,2).'</h3>';
                        }else{
                            echo '<h3>Non renseigné</h3>';
                        }
                    ?>
                </div>
            </div>
            <table class="table table-striped">
                <tr><th>Matière</th><th>Professeur</th><th>DS 1</th><th>DS 2</th><th>DS 3</th><th>Moyenne</th><th>Moyenne de classe</th><th>Classement</th><th>Appréciation</th><th>Rattrapage</th></tr>
                <?php
                    require_once('../database.php');
                    $db = dbConnect();
                    $allCoursesOfStudentsInSemester = getAllCoursesOfStudentsInSemester($db, $_SESSION['id'],$_SESSION['idSemestre']);
                    foreach($allCoursesOfStudentsInSemester as $course){
                        $average = getAverageNoteOfCourseOfStudent($db, $_SESSION['id'], $course['id_matiere']);
                        if($average !=null && $average < 10){
                            echo '<tr class="table-danger">';
                        }
                        else{
                            echo '<tr>';
                        }
                        echo '<td>'.$course['nom_matiere'].'</td>';
                        echo '<td>'.$course['nom_prof'].' '.$course['prenom_prof'].'</td>';
                        $numberOfDS = getNumberOfDS($db, $course['id_matiere']);
                        $epreuves = getEpreuvesOfACourse($db, $course['id_matiere']);
                        foreach($epreuves as $epreuve){
                            $note = getNoteOfEpreuveOfStudent($db, $epreuve['id_epreuve'],$_SESSION['id']);
                            if($note == null){
                                echo '<td>Non renseigné</td>';
                            }
                            else{
                                echo '<td>'.$note['note'].'</td>';
                            }
                        }
                        for($i = $numberOfDS['nb']+1; $i <= 3; $i++){
                            echo '<td>Pas de DS</td>';
                        }
                        echo '<td>'.number_format($average,2).'</td>';
                        $averageOfCourse = getAverageNoteOfCourse($db, $course['id_matiere']);
                        echo '<td>'.number_format($averageOfCourse,2).'</td>';
                        $rank = getRankOfCourse($db, $_SESSION['id'], $course['id_matiere']);
                        echo '<td>'.$rank.'</td>';
                        $appreciation = getAppreciationOfStudent($db, $_SESSION['id'], $course['id_matiere']);
                        if($appreciation == null){
                            echo '<td>Non renseigné</td>';
                        }else{
                            echo '<td>'.$appreciation['commentaire'].'</td>';
                        }
                        if($average < 10){
                            echo '<td>Oui</td>';
                        }else{
                            echo '<td>Non</td>';
                        }
                        echo '</tr>';
                    }
                ?>

            </table>
        </div>


    </body>
</html>