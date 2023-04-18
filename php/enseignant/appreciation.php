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
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="header">
            <div class="container-fluid" id="space">
                <a class="navbar-brand" href="persoEnseignant.php">
                    <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item" id="ecart">
                            <a href="consultation.php">Consultation</a>
                        </li>
                        <li class="nav-item" id="ecart">
                            <a href="notes.php">Notes</a>
                        </li>
                        <li class="nav-item" id="ecart">
                            <a href="appreciation.php">Appréciations</a>
                        </li>
                    </ul>
                    <a href="infoAdmin.php">
                        <button type="button" class="btn btn-secondary">
                            <?php echo '<span class="material-symbols-outlined">account_circle</span>&nbsp&nbsp&nbsp'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].''; ?>
                        </button>
                    </a>
                    <a href="../loginEnseignant.php">
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


        <?php
                if(isset($_POST['validerAppreciation'])){
                    require_once('../database.php');
                    $db = dbConnect();
                    $studentNotCommentedForm = getStudentsNotCommented($db, $_POST['id_matiere']);
                    foreach($studentNotCommentedForm as $student){
                        if(isset($_POST['etu_'.$student['id_etu']]) && isset($_POST['appreciation_'.$student['id_etu']]) && $_POST['appreciation_'.$student['id_etu']] != ""){
                                $appreciation = addAppreciationToStudent($db, $student['id_etu'], $_POST['id_matiere'], $_POST['appreciation_'.$student['id_etu']]);
                            }
                        }
                }
            ?>



        <div id="bodyNotes">
            <form action="appreciation.php" method="post">
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



                <?php
                 if(isset($_SESSION['idSemestre']) || isset($_POST['validerSemestre'])){
                    $coursesOfAProfessor = getCoursesByProfessorAndSemester($db, $_SESSION['id'],$_SESSION['idSemestre']);
                    if($coursesOfAProfessor == null){
                        echo '<div class="alert alert-danger" role="alert">
                        Vous n\'avez pas de cours pour ce semestre.
                        </div>';
                    }
                    else{
                        echo '<div class="alert alert-success" role="alert">
                        Vous avez des cours pour ce semestre.
                        </div>';

                        foreach($coursesOfAProfessor as $course){
                            echo '<div id="coursNotes">';
                                echo '<h1>'.$course['nom_matiere'].'</h1>';
                                $studentOfCourseNotCommented = getStudentsNotCommented($db, $course['id_matiere']);
                                if($studentOfCourseNotCommented != null){
                                    echo '<div id="epreuveNotes">';
                                    echo '<form action="appreciation.php" method="post">';
                                    echo '<table class="table table-striped">';
                                    echo '<tr><th>Nom</th><th>Prénom</th><th>Moyenne</th><th>Commentaire</th></tr>';
                                    foreach($studentOfCourseNotCommented as $student){
                                        echo '<tr><td>'.$student['nom_etu'].'</td><td>'.$student['prenom_etu'].'</td>';
                                        $moyenne = getAverageNoteOfCourseOfStudent($db, $student['id_etu'], $course['id_matiere']);
                                        if($moyenne == null){
                                            echo '<td>Note manquante</td>';
                                        }else{
                                            echo '<td>'.$moyenne.'</td>';
                                        }
                                        echo '<td><input type="text" class="form-control" id="exampleFormControlInput1" name="appreciation_'.$student['id_etu'].'" placeholder="Entrez une appréciation"></td>
                                        </tr>';
                                        echo '<input type="hidden" name="etu_'.$student['id_etu'].'" value="'.$student['id_etu'].'">';
                                    }
                                    echo '</table>';
                                    echo '<input type="hidden" name="id_matiere" value="'.$course['id_matiere'].'">';
                                    echo '<input type="submit" name="validerAppreciation" value="Valider" id="center" class="btn btn-primary">';
                                    echo '</form>';
                                    echo '</div>';
                                    
                                }else{
                                    echo '<div class="alert alert-success" role="alert">
                                    Vous avez donné une appréciation tous les étudiants pour cette épreuve.
                                    </div>';
                                    
                                    
                                }
                                echo '</div>';
                        }
                        }
                    }
            ?>
        </div>
        
    </body>
</html>