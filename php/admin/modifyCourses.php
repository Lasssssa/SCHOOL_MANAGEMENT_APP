<?php 
    session_start();
      if($_SESSION['identifiedAdmin'] == false || !isset($_SESSION['identifiedAdmin'])){
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
        <link href="stylePersoAdmin.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="persoAdmin.php">
                        <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item" id="ecart">
                                <a href="addingEnseignant.php">Enseignants</a>
                            </li>
                            <li class="nav-item" id="ecart">
                                <a href="addingEtudiant.php">Étudiants</a>
                            </li>
                            <li class="nav-item" id="ecart">
                                <a href="addingCours.php">Cours</a>
                            </li>
                        </ul>
                        <a href="infoAdmin.php">
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
        <div id ="board">
            <a href="addingCours.php">Ajout</a>
            <a href="modifyCourses.php">Modification</a>
        </div>

        


        <?php
            require_once('../database.php');
            $dbConnection = dbConnect();
            if(isset($_POST['modifier'])){
                $id_classe = getIdClassWithYearAndCycle($dbConnection, $_POST['annee'], $_POST['cycle']);
                updateCours($dbConnection, $_POST['id_matiere'], $_POST['nom'], $_POST['duree'], $_POST['id_prof'], $_POST['id_semestre'], $id_classe);
                echo '
                <div class="alert alert-success" role="alert">
                    Le cours a bien été modifié.
                </div>';
                unset($_POST['modifier']);
            }else if(isset($_POST['modifier'])){
                echo '
                <div class="alert alert-danger" role="alert">
                    Veuillez remplir tous les champs.
                </div>';
            }
            if(isset($_POST['supprimer'])){
                deleteCours($dbConnection, $_POST['id_matiere']);
                echo '
                <div class="alert alert-success" role="alert">
                    Le cours a bien été supprimé.
                </div>';
                unset($_POST['supprimer']);
            }
        
            if(isset($_POST['ajout_epreuve']) && $_POST['coefficient'] && isset($_POST['nom_epreuve'])){
                $epreuve = 'DS'.$_POST['nom_epreuve'];
                addEpreuve($dbConnection, $_POST['id_matiere'], $epreuve, $_POST['coefficient']);
                echo '
                <div class="alert alert-success" role="alert">
                    L\'épreuve a bien été ajoutée.
                </div>';
                unset($_POST['ajout_epreuve']);
            }

            if(isset($_POST['supprimer_epreuve'])){
                deleteEpreuve($dbConnection, $_POST['id_epreuve']);
                echo '
                <div class="alert alert-success" role="alert">
                    L\'épreuve a bien été supprimée.
                </div>';
                unset($_POST['supprimer_epreuve']);
            }
            ?>

        <?php
            $dbConnection = dbConnect();
            $allCourses = getAllCourses($dbConnection);
            foreach($allCourses as $cours){
                echo '
                <div class="modal" id="modal_'.$cours['id_matiere'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modification d\'un cours</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="modifyCourses.php" method="post">
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom de la matière</label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="'.$cours['nom_matiere'].'">
                                </div>
                                <div class="mb-3">
                                    <label for="prenom" class="form-label">Durée</label>
                                    <input type="number" class="form-control" id="duree" name="duree" value="'.$cours['duree'].'">
                                </div>
                                ';
                                $professors = getAllProfessors($dbConnection);
                            if($professors){
                                echo '
                                <div class="form-group">
                                    <label for="nom" class="form-label">Enseignant responsable</label>
                                    <select class="form-control" name="id_prof">
                                        <option value="'.$cours['id_prof'].'">'.$cours['prenom_prof'].' '.$cours['nom_prof'].'</option>';
                                        foreach($professors as $professor){
                                            if($professor['id_prof'] != $cours['id_prof']){
                                                echo '<option value="'.$professor['id_prof'].'">'.$professor['prenom_prof'].' '.$professor['nom_prof'].'</option>';
                                            }
                                        }
                                        echo '
                                    </select>
                                </div>';
                            }    
                            echo "<br>";
                            $dateOfTheCours = getAllSemesters($dbConnection);
                            if($dateOfTheCours){
                                echo '
                                <div class="form-group">
                                <label for="nom" class="form-label">Semestre</label>
                                    <select class="form-control" name="id_semestre">
                                        <option value="'.$cours['id_semestre'].'">Semestre : '.$cours['numero_semestre'].' Année : '.$cours['numero_annee'].'</option>';
                                        foreach($dateOfTheCours as $date){
                                            if($date['id_semestre'] != $cours['id_semestre']){
                                                echo '<option value="'.$date['id_semestre'].'">Semestre : '.$date['numero_semestre'].' Année : '.$date['numero_annee'].'</option>';
                                            }
                                        }
                                        echo '
                                    </select>
                                </div>';
                            }
                            echo '
                    <div class="row">
                        <div class="col">';
                    echo '
                            <label for="mail" class="form-label">Année du cursus</label>';
                    echo '      <select class="form-select" aria-label="Default select example" name="annee">';
                    $allYears = getAllYearsClass($dbConnection);
                    echo '<option value="'.$cours['annee_cursus'].'">'.$cours['annee_cursus'].'</option>';
                    foreach($allYears as $year){
                        if($year['annee_cursus'] != $cours['annee_cursus'])
                        {
                            echo '<option value="'.$year['annee_cursus'].'">'.$year['annee_cursus'].'</option>';
                        }
                    }
                            echo '
                        </select>
                    </div>
                </div>';
                echo '<br>';
                echo '<label for="mail" class="form-label">Cycle</label>';
                $cycles = getAllCycles($dbConnection);
                echo '<div><select class="form-select" aria-label="Default select example" name="cycle">';
                echo '<option value="'.$cours['nom_cycle'].'">'.$cours['nom_cycle'].'</option>';
                foreach($cycles as $cycle){
                    if($cycle['nom_cycle'] != $cours['nom_cycle'])
                    {
                        echo '<option value="'.$cycle['nom_cycle'].'">'.$cycle['nom_cycle'].'</option>';
                    }
                }
                echo '</select></div><br>';
                                echo '<button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                                <input type="hidden" name="id_matiere" value="'.$cours['id_matiere'].'" name="id_matiere">
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                ';
                echo '
                <div class="modal" id="modalSupp_'.$cours['id_matiere'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Suppression d\'un cours</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="modifyCourses.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer ce cours ?</p>
                                    <input type="hidden" name="id_matiere" value="'.$cours['id_matiere'].'">
                                    <button type="submit" class="btn btn-success" name="supprimer">Supprimer</button>
                                    <button type="submit" class="btn btn-danger" name="retour">Retour</button>
                                </form>
                                 
                            </div>
                            
                        </div>
                    </div>
                </div>
                ';
                echo '
                <div class="modal" id="modalAjout_'.$cours['id_matiere'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajoute d\'un DS</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form action="modifyCourses.php" method="post">
                            <h4>Cours : '.$cours['nom_matiere'].'</h4>
                            <div class="mb-3">
                                <label for="nom" class="form-label">Numéro de l\'épreuve</label>
                                <input type="number" class="form-control" id="nom" name="nom_epreuve"">
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Coefficient</label>
                                <input type="number" class="form-control" id="duree" name="coefficient">
                            </div>
                            <input type="hidden" name="id_matiere" value="'.$cours['id_matiere'].'">';
                            echo '<button type="submit" class="btn btn-primary" name="ajout_epreuve">Ajouter</button>
                            </form>
                                 
                            </div>
                            
                        </div>
                    </div>
                </div>
                ';
                echo '
                <div class="modal" id="modifEpreuve_'.$cours['id_matiere'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modification des épreuves</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <table class="table table-striped">';
                                echo '<tr><th>Nom</th><th>Matière</th><th>Coefficient</th><th>Supression</th></tr>';
                                $epreuves = getEpreuvesOfACourse($dbConnection, $cours['id_matiere']);   
                                foreach($epreuves as $epreuve){
                                    echo '<tr><td>'.$epreuve['nom_epreuve'].'</td><td>'.$epreuve['nom_matiere'].'</td><td>'.$epreuve['coefficient'].'</td><td>
                                    <form action="modifyCourses.php" method="post">
                                    <button type="submit" class="btn btn-danger" name="supprimer_epreuve">Supprimer</button>
                                    <input type="hidden" name="id_epreuve" value="'.$epreuve['id_epreuve'].'">
                                    </form></td></tr>';
                                }
                echo'    
                                </table>
                                 
                            </div>
                            
                        </div>
                    </div>
                </div>
                ';
                
            }

        ?>
        <div id="filtreCours">
            <form action="modifyCourses.php" method ="post" id="formTri">
                <div id="titreCours">
                    <h2>Filtre de tri</h2>
                </div>
                <div id="choiceCycleCours">
                    <?php
                        $db = dbConnect();
                        $cycles = getAllCycles($db);
                        echo '<select class="form-select" aria-label="Default select example" name="choice_cycle">';
                        echo '<option value="all">Tous les cycles</option>';
                        foreach($cycles as $cycle){
                            echo '<option value="'.$cycle['nom_cycle'].'">'.$cycle['nom_cycle'].'</option>';
                        }
                        echo '</select>';
                    ?>
                </div>
                <div id="choiceProfessor">
                    <?php
                        $db = dbConnect();
                        $professors = getAllProfessors($db);
                        echo '<select class="form-select" aria-label="Default select example" name="choice_prof">';
                        echo '<option value="all">Tous les professeurs</option>';
                        foreach($professors as $professor){
                            echo '<option value="'.$professor['id_prof'].'">'.$professor['prenom_prof'].' '.$professor['nom_prof'].'</option>';
                        }
                        echo '</select>';
                    ?>
                </div>
                <div id="courSemestre">
                    <?php
                        $db = dbConnect();
                        $semestres = getAllSemesters($db);
                        echo '<select class="form-select" aria-label="Default select example" name="choice_semester">';
                        echo '<option value="all">Tous les semestres</option>';
                        foreach($semestres as $semestre){
                            echo '<option value="'.$semestre['id_semestre'].'">Semestre '.$semestre['numero_semestre'].' | Année '.$semestre['numero_annee'].'</option>';
                        }
                        echo '</select>';
                    ?>
                </div>
                <div id="choiceSubmit">
                    <button type="submit" class="btn btn-primary" name="submitFiltre">Appliquer des filtres</button>
                </div>
            </form>
        </div>


        <div id="modifyEnseignant">
            <table class="table table-striped">
                <?php
                    require_once('../database.php');
                    $dbConnection = dbConnect();
                    if(isset($_POST['submitFiltre'])){
                        $cycle = $_POST['choice_cycle'];
                        $prof = $_POST['choice_prof'];
                        $semestre = $_POST['choice_semester'];
                        if($cycle == 'all' && $prof == 'all' && $semestre == 'all'){
                            $allCourses = getAllCourses($dbConnection);
                        }else if($cycle == 'all' && $prof == 'all'){
                            $allCourses = getCoursesBySemester($dbConnection, $semestre);
                        }else if($cycle == 'all' && $semestre == 'all'){
                            $allCourses = getCoursesByProfessor($dbConnection, $prof);
                        }else if($prof == 'all' && $semestre == 'all'){
                            $allCourses = getCoursesByCycle($dbConnection, $cycle);
                        }else if($cycle == 'all'){
                            $allCourses = getCoursesByProfessorAndSemester($dbConnection, $prof, $semestre);
                        }else if($prof == 'all'){
                            $allCourses = getCoursesByCycleAndSemester($dbConnection, $cycle, $semestre);
                        }else if($semestre == 'all'){
                            $allCourses = getCoursesByCycleAndProfessor($dbConnection, $cycle, $prof);
                        }else{
                            $allCourses = getCoursesByCycleAndProfessorAndSemester($dbConnection, $cycle, $prof, $semestre);
                        }
                    }else{
                        $allCourses = getAllCourses($dbConnection);
                    }
                    echo '<tr><th>ID</th><th>Matière</th><th>Durée</th><th>Professeur</th><th>Classe</th><th>Semestre</th><th>Année</th><th>Ajouter des épreuves<th>Modifier des épreuves</th></th><th>Modification</th><th>Supression</th></tr>';
                    foreach($allCourses as $cours){
                        echo '<tr><td>'.$cours['id_matiere'].'</td><td>'.$cours['nom_matiere'].'</td><td>'.$cours['duree'].'</td><td>'.
                        $cours['prenom_prof'].' '.$cours['nom_prof'].'</td>
                        <td>'.$cours['nom_cycle'].$cours['annee_cursus'].'</td>
                        <td>'.$cours['numero_semestre'].'</td><td>'.$cours['numero_annee'].'</td>
                        <td>
                        <button type="submit" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalAjout_'.$cours['id_matiere'].'" name="'.$cours['id_matiere'].'">
                        Ajouter</button>
                        </td>
                        <td>
                        <button type="submit" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modifEpreuve_'.$cours['id_matiere'].'" name="'.$cours['id_matiere'].'">
                        Modifier</button>
                        </td>
                        
                        <td>
                        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_'.$cours['id_matiere'].'" name="'.$cours['id_matiere'].'">
                        Modifier</button></td>
                        <td>  
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalSupp_'.$cours['id_matiere'].'" name="supp_'.$cours['id_matiere'].'">Supprimer
                            </button>    
                        </td>
                        </tr>';
                    }
                ?>
            </table>
        </div>
        </div>
        
    </body>
</html>