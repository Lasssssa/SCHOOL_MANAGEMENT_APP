<?php 
    session_start();
        if($_SESSION['identifiedEnseignant'] == false || !isset($_SESSION['identifiedEnseignant'])){
            header("Location: ../loginPage.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <title>Page Enseignant : Appréciations</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="../script.js"></script>
        <link href="stylePersoEnseignant.css" rel="stylesheet">
    </head>
    
    <!-- A voir pour plutot avoir un récapitulatif en fonction de ce que l'on demande -->

    <body>
        <div id="navbarEns">
            <nav class="navbar navbar-dark bg-dark fixed-top left" id="header">
                <div class="container-fluid">
                    <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end text-bg-dark colorSe" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header"> 
                            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu Enseignant</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body" id="menu">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active hovered" aria-current="page" href="consultation.php"><span class="material-symbols-outlined">supervisor_account</span><?php echo"&nbsp&nbsp&nbsp";?>Consultation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hovered" href="notes.php"><span class="material-symbols-outlined">school</span><?php echo"&nbsp&nbsp&nbsp";?> Notes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hovered" href="appreciation.php"><span class="material-symbols-outlined">auto_stories</span><?php echo"&nbsp&nbsp&nbsp";?> Appréciations</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle hovered" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo '<span class="material-symbols-outlined">account_circle</span>&nbsp&nbsp&nbsp'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].''; ?>
                                </a>
                                <div id="dropD">
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><a class="dropdown-item" href="infoEnseignant.php">Compte</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../loginPage.php">Deconnexion</a></li>
                                    </ul>
                                </div>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

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
                    <h1 id="titleSemestre">CHOIX DU SEMESTRE</h1>
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
                        <input type="submit" name="validerSemestre" value="Valider" class="btn btn-primary coloredV5">
                    </div>
                </div>
            </form>

                <?php
                 if(isset($_SESSION['idSemestre']) || isset($_POST['validerSemestre'])){
                    $coursesOfAProfessor = getCoursesByProfessorAndSemester($db, $_SESSION['id'],$_SESSION['idSemestre']);
                    if($coursesOfAProfessor == null){
                        echo '<div class="alert alert-danger" role="alert" id="cours">
                        Vous n\'avez pas de cours pour ce semestre.
                        </div>';
                    }
                    else{
                        echo '<div class="alert alert-success" role="alert" id="cours">
                        Vous avez des cours pour ce semestre.
                        </div>';

                        echo '<div id="coursAppreciation"> 
                              <div class="accordion" id="accordionPanelsStayOpenExample">';
                        $i = 1;
                        
                        foreach($coursesOfAProfessor as $course){
                                $i++;
                                echo '<div class="accordion-item" id="borderFull">';
                                echo '<h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$i.'" aria-expanded="false" aria-controls="collapse'.$i.'">
                                    <h1>
                                    <span class="material-symbols-outlined">
                                    clinical_notes
                                    </span>&nbsp&nbsp&nbsp'.$course['nom_matiere'].'</h1>
                                    </button>
                                    </h2>';
                                // echo '<h1>'.$course['nom_matiere'].'</h1>';
                                echo '<div id="collapse'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">';
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
                                            echo '<td>'.number_format($moyenne,2).'</td>';
                                        }
                                        echo '<td><input type="text" class="form-control" id="exampleFormControlInput1" name="appreciation_'.$student['id_etu'].'" placeholder="Entrez une appréciation"></td>
                                        </tr>';
                                        echo '<input type="hidden" name="etu_'.$student['id_etu'].'" value="'.$student['id_etu'].'">';
                                    }
                                    echo '</table>';
                                    echo '<input type="hidden" name="id_matiere" value="'.$course['id_matiere'].'">';
                                    echo '<input type="submit" name="validerAppreciation" value="Valider" id="center" class="btn btn-primary coloredV4">';
                                    echo '</form>';
                                    echo '</div>';
                                    
                                }else{
                                    echo '<div class="alert alert-success" role="alert">
                                    Vous avez donné une appréciation tous les étudiants pour cette épreuve.
                                    </div>';
                                    
                                    
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </body>
</html>