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
        <div id="header">
            <div id="logo">
                <a href ="persoAdmin.php"><img src="../images/logoIsen.png" alt="logo" width ="190px"></a>
            </div>
            <div id="enseignant">
                <a href="addingEnseignant.php">Enseignants</a>
            </div>
            <div id="etudiant">
                <a href="addingEtudiant.php">Étudiants</a>
            </div>
            <div id="cours">
                <a href="addingCours.php">Cours</a>
            </div>
            <div>
            
            </div>
            <div id="account">
            <?php echo '<div id="info"><a href="infoAdmin.php">'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].'    <span class="material-symbols-outlined">account_circle</span></a></div>'; ?>
            </div>
            <div id="deconnexion">
                <a href="../loginAdmin.php"><span class="material-symbols-outlined">logout</span></a>
            </div>
        </div>
        <div id ="board">
            <a href="addingCours.php">Ajout</a>
            <a href="modifyCourses.php">Modification</a>
        </div>

        <?php
            if(isset($_POST['envoyer']) && isset($_POST['nom_matiere']) && isset($_POST['duree']) && isset($_POST['enseignant']) && isset($_POST['semestre']) && $_POST['enseignant'] != "impossible" && $_POST['semestre'] != "impossible"){
                require_once('../database.php');
                $db = dbConnect();
                $cours = addCours($db, $_POST['nom_matiere'], $_POST['duree'], $_POST['enseignant'], $_POST['semestre']);
                if($cours){
                    echo '<div class="alert alert-success" role="alert">
                            Le cours a bien été ajouté !
                            </div>';
                }
                else{
                    echo '<div class="alert alert-danger" role="alert">
                            Le cours n\'a pas pu être ajouté !
                            </div>';
                }
            }
            else if(isset($_POST['envoyer'])){
                echo '<div class="alert alert-danger" role="alert">
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

                    ?>
                    <br>
                    <button type="submit" class="btn btn-primary" name ="envoyer">Créer un nouveau cours</button>
                </form>
            </div>
        </div>
    </body>
</html>