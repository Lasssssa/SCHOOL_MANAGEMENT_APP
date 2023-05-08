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
        <title>Page Administrateur </title>
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
                    <a class="navbar-brand" href="persoEnseignant.php">
                        <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end text-bg-dark colorSe" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header"> 
                            <h6 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu Enseignant</h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body" id="menu">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="consultation.php">Consultation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notes.php">Notes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="appreciation.php">Appréciations</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            require_once('../database.php');
            $db = dbConnect();
            if(isset($_POST['modifier'])){
                $id_etu = $_POST['id_etu'];
                $id_matiere = $_POST['id_matiere'];
                if(isset($_POST['appreciation'])){
                    $appreciation = $_POST['appreciation'];
                    updateAppreciation($db, $id_etu, $id_matiere, $appreciation);
                }
                $nbDs = getNumberOfDS($db, $id_matiere)['nb'];
                for($i = 1; $i <= $nbDs; $i++){
                    if(isset($_POST['note_'.$i])){
                        $note = $_POST['note_'.$i];
                        updateNoteByStudentAndCourse($db, $id_etu, $id_matiere, $i, $note);
                    }
                }
            }
        ?>

        <?php
            require_once('../database.php');
            $db = dbConnect();
            $allSemesters = getAllSemesters($db);
            foreach($allSemesters as $semester){
                $coursesOfAProfessor = getCoursesByProfessorAndSemester($db, $_SESSION['id'],$semester['id_semestre']);
                foreach($coursesOfAProfessor as $cours){
                    echo '
                    <div class="modal" id="rattrapage_'.$cours['id_matiere'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Étudiant aux rattrapages</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped">
                                    <tr><th>Nom</th><th>Prénom</th><th>Note</th></tr>
                                    ';
                                    $students = getStudentOfCourse($db, $cours['id_matiere']);
                                    foreach($students as $student){
                                        $average = getAverageNoteOfCourseOfStudent($db, $student['id_etu'], $cours['id_matiere']);
                                        if($average < 10){
                                            echo '<tr><td>'.$student['nom_etu'].'</td><td>'.$student['prenom_etu'].'</td><td>'.$average.'</td></tr>';
                                        }
                                    }
                                    echo '</table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                    $students = getStudentOfCourse($db, $cours['id_matiere']);
                    foreach($students as $student){
                        echo '
                        <div class="modal" id="modif_'.$student['id_etu'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modification des saisies</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="titre">
                                        <form action="consultation.php" method="post">';
                                        echo '<h2>'.$student['nom_etu'].' '.$student['prenom_etu'].'</h2>';
                                        // $nb_DS = getNumberOfDS($db, $cours['id_matiere'])['nb'];
                                        $epreuves = getEpreuvesOfACourse($db, $cours['id_matiere']);

                                        foreach($epreuves as $epreuve){
                                            $note = getNoteOfEpreuveOfStudent($db, $epreuve['id_epreuve'], $student['id_etu']);
                                            if($note != null){
                                                echo '<h4>'.$epreuve['nom_epreuve'].'</h4>';
                                                echo '<input type="number" class="form-control" min="0" max="20" step="0.05" name="note_'.$epreuve['id_epreuve'].'" value="'.$note['note'].'"><br>';	
                                            }
                                        }

                                        echo '<h4>Appréciation</h4>';
                                        $appreciation = getAppreciationOfStudent($db, $student['id_etu'], $cours['id_matiere']);
                                        if($appreciation != null){
                                            echo '<input type="text" class="form-control" name="appreciation" value="'.$appreciation['commentaire'].'"><br>';
                                        }
                                        else{
                                            echo '<input type="text" class="form-control" name="appreciation" value=""><br>';
                                        }
                                    echo'
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id_etu" value="'.$student['id_etu'].'">
                                        <input type="hidden" name="id_matiere" value="'.$cours['id_matiere'].'">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" class="btn btn-primary" name="modifier">Enregistrer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }

                }
            }

        ?>


        <div id="bodyNotes">
            <form action="consultation.php" method="post">
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
                                    <h1>'.$course['nom_matiere'].'</h1>
                                    </button>
                                    </h2>';
                                // echo '<h1>'.$course['nom_matiere'].'</h1>';
                                echo '<div id="collapse'.$i.'" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">';
                                $studentOfCourse = getStudentOfCourse($db, $course['id_matiere']);
                                if($studentOfCourse != null){
                                    echo '<div id="epreuveNotes">';
                                    echo '<table class="table table-striped">';
                                    echo '<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Mail</th><th>Cycle</th><th>Appréciation</th>';
                                    $numberOfDS = getNumberOfDS($db, $course['id_matiere']);
                                    for($i = 1; $i <= $numberOfDS['nb']; $i++){
                                        echo '<th>DS'.$i.'</th>';
                                    }
                                    echo '<th>Moyenne</th>
                                    <th>Classement</th><th>Modification</th></tr>';
                                    foreach($studentOfCourse as $student){
                                        $average = getAverageNoteOfCourseOfStudent($db, $student['id_etu'], $course['id_matiere']);
                                        if($average != null){
                                            if($average < 10 ){
                                                echo '<tr class="table-danger">';
                                            }
                                        }
                                        echo '<td>'.$student['id_etu'].'</td><td>'.$student['nom_etu'].'</td><td>'.$student['prenom_etu'].'</td><td>'.$student['mail_etu'].'<td>'.$student['nom_cycle'].$student['annee_cursus'].'</td>';
                                        $appreciation = getAppreciationOfStudent($db, $student['id_etu'], $course['id_matiere']);
                                        if($appreciation == null){
                                            echo '<td>Non renseigné</td>';
                                        }
                                        else{
                                            echo '<td>'.$appreciation['commentaire'].'</td>';
                                        }
                                        $epreuves = getEpreuvesOfACourse($db, $course['id_matiere']);
                                        foreach($epreuves as $epreuve){
                                            $note = getNoteOfEpreuveOfStudent($db, $epreuve['id_epreuve'], $student['id_etu']);
                                            if($note == null){
                                                echo '<td>Non renseigné</td>';
                                            }
                                            else{
                                                echo '<td>'.number_format($note['note'],2).'</td>';
                                            }
                                        }
                                        if($average == null){
                                            echo '<td>Non renseigné</td>';
                                        }
                                        else{
                                            echo '<td>'.number_format($average,2).'</td>';
                                        }
                                        $ranking = getRankOfCourse($db, $student['id_etu'], $course['id_matiere']);
                                        if($ranking == null){
                                            echo '<td>Non renseigné</td>';
                                        }
                                        else{
                                            echo '<td>'.$ranking.'</td>';
                                        }
                                        echo '<td><button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modif_'.$student['id_etu'].'" name="supp_'.$student['id_etu'].'">Modifier
                                        </button></td></tr>';
                                    }
                                    echo '</table>';
                                    echo '<br>';
                                    echo '<button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rattrapage_'.$course['id_matiere'].'" name="supp_'.$cours['id_matiere'].'">Rattrapages
                                    </button>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<br>';
                                    }
                        }
                        echo '</div>';
                        echo '</div>';
                        
                        }
                    }
            ?>
        </div>

        
    </body>
</html>