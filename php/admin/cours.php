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
        <title>Page Administrateur</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="../script.js"></script>
        <link href="stylePersoAdmin.css" rel="stylesheet">
    </head>
    
    <!-- A réadapter -->

    <body>
    <div id="navbarEns">
            <nav class="navbar navbar-dark bg-dark fixed-top left" id="header">
                <div class="container-fluid">
                    <a class="navbar-brand" href="persoAdmin.php">
                        <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end text-bg-dark colorSe" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header"> 
                            <a class="navbar-brand" href="persoAdmin.php">
                            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu Administrateur</h5>
                            </a>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body" id="menu">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active hovered" aria-current="page" href="enseignant.php"><span class="material-symbols-outlined">supervisor_account</span><?php echo"&nbsp&nbsp&nbsp";?>Enseignants</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hovered" href="etudiant.php"><span class="material-symbols-outlined">school</span><?php echo"&nbsp&nbsp&nbsp";?> Étudiants</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hovered" href="cours.php"><span class="material-symbols-outlined">auto_stories</span><?php echo"&nbsp&nbsp&nbsp";?> Cours</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hovered" href="cursus.php"><span class="material-symbols-outlined">settings</span><?php echo"&nbsp&nbsp&nbsp";?> Cursus</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle hovered" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo '<span class="material-symbols-outlined">account_circle</span>&nbsp&nbsp&nbsp'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].''; ?>
                                </a>
                                <div id="dropD">
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><a class="dropdown-item" href="infoAdmin.php">Compte</a></li>
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
        <div id ="board">
            
        </div>
        <?php
            if(isset($_POST['envoyer']) && isset($_POST['nom_matiere']) && isset($_POST['duree']) && isset($_POST['enseignant']) && isset($_POST['semestre']) && isset($_POST['annee']) && $_POST['annee']!= "impossible" && isset($_POST['cycle']) && $_POST['cycle'] != "impossible" && $_POST['enseignant'] != "impossible" && $_POST['semestre'] != "impossible"){
                require_once('../database.php');
                $db = dbConnect();
                $id_classe = getIdClassWithYearAndCycle($db, $_POST['annee'], $_POST['cycle']);
                $cours = addCours($db, $_POST['nom_matiere'], $_POST['duree'], $_POST['enseignant'], $_POST['semestre'], $id_classe);
                if($cours){
                    echo '
                    <div class="alert alert-success" role="alert">
                        Le cours a bien été ajouté !
                    </div>';
                }
                else{
                    echo '
                    <div class="alert alert-danger" role="alert">
                        Le cours n\'a pas pu être ajouté !
                    </div>';
                }
            }
            else if(isset($_POST['envoyer'])){
                echo '
                <div class="alert alert-danger" role="alert">
                    Le cours n\'a pas pu être ajouté !
                </div>';
            }
        ?>

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
                                <h5 class="modal-title" id="exampleModalLabel">MODIFICATION D\'UN COURS</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="cours.php" method="post">
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
                                echo '<button type="submit" class="btn btn-primary coloredV2" name="modifier">Modifier</button>
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
                                <h5 class="modal-title" id="exampleModalLabel">SUPPRESSION D\'UN COURS</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="cours.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer ce cours ?</p>
                                    <input type="hidden" name="id_matiere" value="'.$cours['id_matiere'].'">
                                    <button type="submit" class="btn btn-success colored" name="supprimer">Supprimer</button>
                                    <button type="submit" class="btn btn-danger coloredV4" name="retour">Retour</button>
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
                                <h5 class="modal-title" id="exampleModalLabel">AJOUT D\'UNE ÉPREUVE</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form action="cours.php" method="post">
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
                            echo '<button type="submit" class="btn btn-primary coloredV2" name="ajout_epreuve">Ajouter</button>
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
                                <h5 class="modal-title" id="exampleModalLabel">MODIFICATIONS DES ÉPREUVES</h5>
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
                                    <form action="cours.php" method="post">
                                    <button type="submit" class="btn btn-danger coloredV4" name="supprimer_epreuve">Supprimer</button>
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


        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item">
                    <div class="ecart">
                    <div class="titlePage">
                            <div></div>
                            <div class="title">
                                <h1>AJOUT DES COURS</h1>
                            </div>    
                            <div></div>
                        </div>
                        <div id="mainAdding">
                            <div id="formAdding">
                                <h2>FORMULAIRE</h2>
                                <form action="cours.php" method="post">
                                    <div class="form-group">
                                        <h4>Nom de la matière</h4>
                                        <input type="text" class="form-control" name ="nom_matiere">
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <h4>Nombre d'heures de cours</h4>
                                            <input type="number" class="form-control" name = "duree">
                                        </div>
                                    </div>
                                    <?php
                                        require_once('../database.php');
                                        $db = dbConnect();
                                        $professors = getAllProfessors($db);
                                        if($professors){
                                            echo '<div class="form-group">
                                            <h4>Enseignant responsable</h4>
                                            <select class="form-control" name="enseignant">';
                                            echo '<option value="impossible">Choisir un enseignant</option>';
                                            foreach($professors as $professor){
                                                echo '<option value="'.$professor['id_prof'].'">'.$professor['prenom_prof'].' '.$professor['nom_prof'].'</option>';
                                            }
                                            echo '</select>
                                            </div>';
                                        }    
                                        echo "<br>";
                                        $dateOfTheCours = getAllSemesters($db);
                                        if($dateOfTheCours){
                                            echo '<div class="form-group">
                                            <h4>Semestre</h4>
                                            <select class="form-control" name="semestre">';
                                            echo '<option value="impossible">Choisir un semestre</option>';
                                            foreach($dateOfTheCours as $date){
                                                echo '<option value="'.$date['id_semestre'].'">Semestre : '.$date['numero_semestre'].' Année : '.$date['numero_annee'].'</option>';
                                            }
                                            echo '</select>
                                            </div>';
                                        }
                                        echo "<br>";
                                        echo '
                                        <div class="row">
                                            <div class="col">';
                                        echo '
                                        <h4>Année du cursus</h4>';
                                        echo '      <select class="form-select" aria-label="Default select example" name="annee">';
                                                echo '<option value="impossible">Choisir une année</option>';
                                                $allYears = getAllYearsClass($db);
                                                foreach($allYears as $year){
                                                    echo '<option value="'.$year['annee_cursus'].'">'.$year['annee_cursus'].'</option>';
                                                }
                                                echo '
                                            </select>
                                        </div>
                                    </div>';
                                    echo '<br>';
                                    echo '<h4>Cycle</h4>';
                                    $cycles = getAllCycles($db);
                                    echo '<div><select class="form-select" aria-label="Default select example" name="cycle">';
                                    echo '<option value="impossible">Choisir un cycle</option>';
                                    foreach($cycles as $cycle){
                                        if($cycle['nom_cycle'] != $student['nom_cycle'])
                                        {
                                            echo '<option value="'.$cycle['nom_cycle'].'">'.$cycle['nom_cycle'].'</option>';
                                        }
                                    }
                                    echo '</select></div><br>';

                                    ?>
                                    <br>
                                    <button type="submit" class="btn btn-primary coloredV2" name ="envoyer">Créer un nouveau cours</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item active">
                    <div class="ecart">
                        <div class="titlePage">
                            <div></div>
                            <div class="title">
                                <h1>MODIFICATION DES COURS</h1>
                            </div>    
                            <div></div>
                        </div>
                        <div id="filtreCours">
                            <form action="cours.php" method ="post" id="formTri">
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
                                    <button type="submit" class="btn btn-primary coloredV5" name="submitFiltre">Appliquer des filtres</button>
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
                                        <button type="submit" class="btn btn-success colored" data-bs-toggle="modal" data-bs-target="#modalAjout_'.$cours['id_matiere'].'" name="'.$cours['id_matiere'].'">
                                        <span class="material-symbols-outlined">
                                            add_circle
                                            </span> Ajouter
                                        </button>
                                        </td>
                                        <td>
                                        <button type="submit" class="btn btn-success coloredV3" data-bs-toggle="modal" data-bs-target="#modifEpreuve_'.$cours['id_matiere'].'" name="'.$cours['id_matiere'].'">
                                        <span class="material-symbols-outlined">
                                        autorenew
                                        </span> Modifier
                                        </button>
                                        </td>
                                        
                                        <td>
                                        <button type="submit" class="btn btn-success coloredV2" data-bs-toggle="modal" data-bs-target="#modal_'.$cours['id_matiere'].'" name="'.$cours['id_matiere'].'">
                                        <span class="material-symbols-outlined">
                                        update
                                        </span> Modifier
                                        </button></td>
                                        <td>  
                                            <button type="submit" class="btn btn-danger coloredV4" data-bs-toggle="modal" data-bs-target="#modalSupp_'.$cours['id_matiere'].'" name="supp_'.$cours['id_matiere'].'">
                                            <span class="material-symbols-outlined">
                                            delete
                                            </span> Supprimer 
                                            </button>    
                                        </td>
                                        </tr>';
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" id="dropDE">
                <!-- <span class="carousel-control-prev-icon" aria-hidden="true" id="test2"></span> -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" id="dropDE"> 
                <!-- <span class="carousel-control-next-icon" aria-hidden="true" id="test2"></span> -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        
    </body>
</html>