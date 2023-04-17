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
            <a href="addingEnseignant.php">Ajout</a>
            <a href="modifyEnseignant.php">Modification</a>
        </div>

        <?php 
            require_once('../database.php');
            $dbConnection = dbConnect();
            if(isset($_POST['modifier'])){
                updateProfessor($dbConnection, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['telephone'], $_POST['id_prof']);
                echo '<div class="alert alert-success" role="alert">
                        L\'enseignant a bien été modifié.
                        </div>';
            }
            if(isset($_POST['supprimer'])){
                if(cantDeleteProfessor($dbConnection,$_POST['id_prof'])){
                    echo '<div class="alert alert-danger" role="alert">
                    Vous ne pouvez pas supprimer cet enseignant car il est responsable d\'un cours.
                    </div>';
                    unset($_POST['supprimer']);
                }else{
                    deleteProfessor($dbConnection, $_POST['id_prof']);
                    echo '<div class="alert alert-success" role="alert">
                        L\'enseignant a bien été supprimé.
                        </div>';
                    unset($_POST['supprimer']);
                }
            }

        ?>
        
        <?php
        require_once('../database.php');
            $dbConnection = dbConnect();
            $allProfessors = getAllProfessors($dbConnection);
            foreach($allProfessors as $enseignant){
                echo '
                <div class="modal" id="modal_'.$enseignant['id_prof'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modification d\'un enseignant</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="modifyEnseignant.php" method="post">
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
                                        <input type="email" class="form-control" id="mail" name="mail" value="'.$enseignant['mail_prof'].'">
                                    </div>
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" id="telephone" name="telephone" value="'.$enseignant['telephone_prof'].'">
                                    </div>
                                    <input type="hidden" name="id_prof" value="'.$enseignant['id_prof'].'">
                                    <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
                ';
                echo '
                <div class="modal" id="modalSupp_'.$enseignant['id_prof'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Suppression d\'un enseignant</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="modifyEnseignant.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer cet enseignant ?</p>
                                    <input type="hidden" name="id_prof" value="'.$enseignant['id_prof'].'">
                                    <button type="submit" class="btn btn-success" name="supprimer">Supprimer</button>
                                    <button type="submit" class="btn btn-danger" name="retour">Retour</button>
                                </form>
                                 
                            </div>
                            
                        </div>
                    </div>
                </div>
                ';
            }
       ?>
       
        
        <div id="modifyEnseignant">
            <table class="table table-striped">
                <?php
                    require_once('../database.php');
                    $dbConnection = dbConnect();
                    $allProfessors = getAllProfessors($dbConnection);
                    echo '<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Mail</th><th>Numéro de téléphone</th><th>Modification</th><th>Suppression</th></tr>';
                    foreach($allProfessors as $enseignant){
                        echo '<tr><td>'.$enseignant['id_prof'].'</td><td>'.$enseignant['nom_prof'].'</td><td>'.$enseignant['prenom_prof'].'</td><td>'.
                        $enseignant['mail_prof'].'</td><td>'.$enseignant['telephone_prof'].'</td><td>
                        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_'.$enseignant['id_prof'].'" name="'.$enseignant['id_prof'].'">
                        Modifier</button></td>
                        <td>  
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalSupp_'.$enseignant['id_prof'].'" name="supp_'.$enseignant['id_prof'].'">Supprimer
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