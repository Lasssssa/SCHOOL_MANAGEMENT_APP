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
                    <a href="../loginAdmin.php">
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

        <div id="mainAdding">
            <div id="formAdding">
                <h2>Ajout d'un cours</h2>
                <form action="addingCours.php" method="post">
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
                                <label for="mail" class="form-label">Année du cursus</label>';
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
                    echo '<label for="mail" class="form-label">Cycle</label>';
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
                    <button type="submit" class="btn btn-primary" name ="envoyer">Créer un nouveau cours</button>
                </form>
            </div>
        </div>
    </body>
</html>