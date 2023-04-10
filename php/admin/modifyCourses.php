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
    
    <!-- A réadapter -->
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
            require_once('../database.php');
            $dbConnection = dbConnect();
            if(isset($_POST['modifier']) && $_POST['id_prof'] != 'impossible' && $_POST['id_semestre'] != 'impossible' && isset($_POST['annee']) && $_POST['annee'] != 'impossible' && isset($_POST['cycle']) && $_POST['cycle'] != 'impossible'){
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
        ?>

        <?php
            require_once('../database.php');
            $dbConnection = dbConnect();
            $allCourses = getAllCourses($dbConnection);
            foreach($allCourses as $cours){
                if(isset($_POST['supprimer'])){
                    deleteCours($dbConnection, $_POST['id_matiere']);
                    echo '
                    <div class="alert alert-success" role="alert">
                        Le cours a bien été supprimé.
                    </div>';
                    unset($_POST['supprimer']);
                }else if(isset($_POST['modif_'.$cours['id_matiere']])){
                    echo '
                        <div id="modificationProf">
                            <div id="modif2">
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
                                            <option value="impossible">Choisir un enseignant</option>';
                                            foreach($professors as $professor){
                                                echo '<option value="'.$professor['id_prof'].'">'.$professor['prenom_prof'].' '.$professor['nom_prof'].'</option>';
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
                                            <option value="impossible">Choisir un semestre</option>';
                                            foreach($dateOfTheCours as $date){
                                                echo '<option value="'.$date['id_semestre'].'">Semestre : '.$date['numero_semestre'].' Année : '.$date['numero_annee'].'</option>';
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
                                echo '<option value="impossible">Choisir une année</option>';
                                for ($i = 1; $i <= 5; $i++) {
                                    {
                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                }
                                echo '
                            </select>
                        </div>
                    </div>';
                    echo '<br>';
                    echo '<label for="mail" class="form-label">Cycle</label>';
                    $cycles = getCycles($dbConnection);
                    echo '<div><select class="form-select" aria-label="Default select example" name="cycle">';
                    echo '<option value="impossible">Choisir un cycle</option>';
                    foreach($cycles as $cycle){
                        if($cycle['nom_cycle'] != $student['nom_cycle'])
                        {
                            echo '<option value="'.$cycle['nom_cycle'].'">'.$cycle['nom_cycle'].'</option>';
                        }
                    }
                    echo '</select></div><br>';
                                    echo '<button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                                    <input type="hidden" name="id_matiere" value="'.$cours['id_matiere'].'" name="id_matiere">
                                </form>
                            </div> 
                        </div>';
                }else if(isset($_POST['supp_'.$cours['id_matiere']])){
                    echo '
                    <div id="deleteProf">
                        <div id="delete2">
                            <p>Êtes-vous sûr de vouloir supprimer ce cours ?</p>
                            <form action="modifyCourses.php" method="post">
                                <button type="submit" class="btn btn-success" name="supprimer">Supprimer</button>
                                <button type="submit" class="btn btn-danger" name="retour">Retour</button>
                                <input type="hidden" name="id_matiere" value="'.$cours['id_matiere'].'">
                            </form>
                        </div>
                    </div>';
                
                }else if(isset($_POST['ajout_ds_'.$cours['id_matiere']])){
                    echo "coucou";
                }
            }

        ?>
        <div id="modifyEnseignant">
            <table class="table table-dark table-striped">
                <?php
                    require_once('../database.php');
                    $dbConnection = dbConnect();
                    $allCourses = getAllCourses($dbConnection);
                    echo '<tr><th>ID</th><th>Matière</th><th>Durée</th><th>Professeur</th><th>Classe</th><th>Semestre</th><th>Année</th><th>Ajouter des épreuves</th><th>Modification</th><th>Supression</th></tr>';
                    foreach($allCourses as $cours){
                        echo '<tr><td>'.$cours['id_matiere'].'</td><td>'.$cours['nom_matiere'].'</td><td>'.$cours['duree'].'</td><td>'.
                        $cours['prenom_prof'].' '.$cours['nom_prof'].'</td>
                        <td>'.$cours['nom_cycle'].$cours['annee_cursus'].'</td>
                        <td>'.$cours['numero_semestre'].'</td><td>'.$cours['numero_annee'].'</td>
                        <td>
                            <form action="modifyCourses.php" method="post">
                            <button type="submit" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" name="ajout_ds_'.$cours['id_matiere'].'">Ajouter</button>
                            </form>
                        </td>
                        <td>
                            <form action="modifyCourses.php" method="post">
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" name="modif_'.$cours['id_matiere'].'">Modifier</button>
                            </form>
                        </td>
                        <td>
                            <form action="modifyCourses.php" method="post">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" name="supp_'.$cours['id_matiere'].'">Supprimer</button>
                            </form>
                        </td>
                        </tr>';
                    }
                ?>
            </table>
        </div>
        </div>
        
    </body>
</html>