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
            <a href="addingEnseignant.php">Ajout</a>
            <a href="modifyEnseignant.php">Modification</a>
        </div>

        <?php 
            if(isset($_POST['modifier'])){
                require_once('../database.php');
                $dbConnection = dbConnect();
                modifyProfessor($dbConnection, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['telephone'], $_POST['id_prof']);
                echo '<div class="alert alert-success" role="alert">
                        L\'enseignant a bien été modifié.
                        </div>';
            }

        ?>
        
        <?php
            require_once('../database.php');
            $dbConnection = dbConnect();
            $allProfessors = getAllProfessors($dbConnection);
            foreach($allProfessors as $enseignant){
                if(isset($_POST['supprimer'])){
                    deleteProfessor($dbConnection, $_POST['id_prof']);
                    echo '<div class="alert alert-success" role="alert">
                        L\'enseignant a bien été supprimé.
                        </div>';
                    unset($_POST['supprimer']);
                }
                else if(isset($_POST['supp_'.$enseignant['id_prof']])){
                    //Demander à l'utilisateur si il est sûr de vouloir supprimer l'enseignant :
                    if(cantDeleteProfessor($dbConnection, $enseignant['id_prof'])){
                        echo '<div class="alert alert-danger" role="alert">
                        Vous ne pouvez pas supprimer cet enseignant car il est responsable d\'un cours.
                        </div>';
                    }else{
                        echo '<div id="deleteProf"><div id="delete2"><p>Êtes-vous sûr de vouloir supprimer cet enseignant ?</p>
                        <form action="modifyEnseignant.php" method="post">
                        <button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
                        <input type="hidden" name="id_prof" value="'.$enseignant['id_prof'].'" name="id_prof">
                        </form></div></div>';
                    }
                }
                else if(isset($_POST[$enseignant['id_prof']])){
                    echo '<div id="modificationProf">
                    <div id="modif2">';
                    echo '<form action="modifyEnseignant.php" method="post">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="'.$enseignant['nom_prof'].'">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="'.$enseignant['prenom_prof'].'">
                    </div>
                    <div class="mb-3">
                        <label for="mail" class="form-label">Mail</label>
                        <input type="text" class="form-control" id="mail" name="mail" value="'.$enseignant['mail_prof'].'">
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Numéro de téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" value="'.$enseignant['telephone_prof'].'">
                    </div>
                    <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                    <input type="hidden" name="id_prof" value="'.$enseignant['id_prof'].'" name="id_prof">
                    </form></div> </div>';
                }
            }
        ?>
        <div id="modifyEnseignant">
            <table class="table table-dark table-striped">
                <?php
                    require_once('../database.php');
                    $dbConnection = dbConnect();
                    $allProfessors = getAllProfessors($dbConnection);
                    echo '<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Mail</th><th>Numéro de téléphone</th><th>Modification</th><td>Supprimer</td></tr>';
                    foreach($allProfessors as $enseignant){
                        echo '<tr><td>'.$enseignant['id_prof'].'</td><td>'.$enseignant['nom_prof'].'</td><td>'.$enseignant['prenom_prof'].'</td><td>'.
                        $enseignant['mail_prof'].'</td><td>'.$enseignant['telephone_prof'].'</td><td>
                        <form action="modifyEnseignant.php" method="post"><button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" name="'.$enseignant['id_prof'].'">
                        Modifier</button></form></td>
                        <td>
                            <form action="modifyEnseignant.php" method="post">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" name="supp_'.$enseignant['id_prof'].'">Supprimer</button></form>
                        </td>
                        </tr>';
                    }
                ?>
            </table>
        </div>
        </div>
        
    </body>
</html>