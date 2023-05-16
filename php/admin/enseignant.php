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
        <title>Page Administrateur : Enseignant</title>
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
                    <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end text-bg-dark colorSe" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header"> 
                            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu Administrateur</h5>
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
                                <a class="nav-link hovered" href="cursus.php"><span class="material-symbols-outlined">medical_information</span><?php echo"&nbsp&nbsp&nbsp";?> Cursus</a>
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
            <!-- DIV VIDE -->
        </div>
        <?php 
            require_once('../database.php');
            $dbConnection = dbConnect();
            if(isset($_POST['modifier'])){
                $true = updateProfessor($dbConnection, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['telephone'], $_POST['id_prof']);
                if($true){
                    echo '<div class="alert alert-success" role="alert">
                    L\'enseignant a bien été modifié.
                    </div>';
                }else{
                    echo '<div class="alert alert-danger" role="alert">
                    L\'enseignant n\'a pas pu être modifié.
                    </div>';
                }

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
            if(isset($_POST['envoyer']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['emailConfirmed']) && isset($_POST['password']) && isset($_POST['passwordConfirmed']) && isset($_POST['telephone'])){
                if($_POST['email']!= $_POST['emailConfirmed']){
                    echo '<div class="alert alert-danger" role="alert">
                    Les emails ne correspondent pas
                    </div>';
                }
                else if($_POST['password']!= $_POST['passwordConfirmed']){
                    echo '<div class="alert alert-danger" role="alert">
                    Les mots de passe ne correspondent pas
                    </div>';
                }
                else{
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $email = $_POST['email'];
                    $telephone = $_POST['telephone'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    require_once('../database.php');
                    $db = dbConnect();
                    $isAddedProfessor = addProfessor($db, $prenom, $nom, $email, $password, $telephone);
                    if($isAddedProfessor){
                        echo '<div class="alert alert-success" role="alert">
                        L\'enseignant a bien été ajouté
                        </div>';
                    }
                    else{
                        echo '<div class="alert alert-danger" role="alert">
                        L\'enseignant n\'a pas été ajouté car il existe déjà ou il y a eu une erreur
                        </div>';
                    }
                }
            }
        ?>

        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item">
                    <div class="ecart">
                        <div class="titlePage">
                            <div></div>
                            <div class="title">
                                <h1>AJOUT DES ENSEIGNANTS</h1>
                            </div>    
                            <div></div>
                        </div>
                        <div id="mainAdding">
                            <div id="formAdding">
                                <h2>FORMULAIRE</h2>
                                <form action="enseignant.php" method="post">
                                    <div class="row">
                                        <div class="col">
                                            <h4><span class="material-symbols-outlined">
                                            badge
                                            </span>&nbspPrénom</h4>
                                            <input type="text" class="form-control" name ="prenom">
                                        </div>
                                        <div class="col">
                                            <h4><span class="material-symbols-outlined">
                                        badge
                                        </span>&nbspNom</h4>
                                            <input type="text" class="form-control" name ="nom">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <h4><span class="material-symbols-outlined">
                                                mail
                                                </span>&nbspEmail</h4>
                                            <input type="email" class="form-control" id="inputEmail4" name ="email">
                                            <h4><span class="material-symbols-outlined">
                                                mail
                                                </span>&nbspConfirmation email</h4>
                                            <input type="email" class="form-control" id="inputEmail4" name ="emailConfirmed">
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <h4><span class="material-symbols-outlined">
                                            lock
                                            </span>&nbspMot de passe</h4>
                                            <input type="password" class="form-control" name="password" id="password1">
                                            <div class="form-check form-switch" id="ecarted">
                                                <input class="form-check-input" type="checkbox" role="switch" id="showPassword1" onchange="togglePassword2()">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                                            </div>
                                            <h4><span class="material-symbols-outlined">
                                            lock
                                            </span>&nbspConfirmation Mot de passe</h4>
                                            <input type="password" class="form-control" id="password2" name="passwordConfirmed">
                                            <div class="form-check form-switch" id="ecarted">
                                                <input class="form-check-input" type="checkbox" role="switch" id="showPassword2" onchange="togglePassword2()">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <h4><span class="material-symbols-outlined">
                                            call
                                            </span>&nbspNuméro de téléphone</h4>
                                            <input type="number" class="form-control" name = "telephone">
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary coloredV2" name ="envoyer">Inscrire un nouvel enseignant</button>
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
                                <h1>MODIFICATION DES ENSEIGNANTS</h1>
                            </div>    
                            <div></div>
                        </div>
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
                                        <button type="submit" class="btn btn-success colored" data-bs-toggle="modal" data-bs-target="#modal_'.$enseignant['id_prof'].'" name="'.$enseignant['id_prof'].'">
                                        <span class="material-symbols-outlined">
                                        update
                                        </span> Modifier
                                            </button>
                                        </td>
                                        <td>  
                                            <button type="submit" class="btn btn-danger coloredV2" data-bs-toggle="modal" data-bs-target="#modalSupp_'.$enseignant['id_prof'].'" name="supp_'.$enseignant['id_prof'].'">
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" id="dropDE"> 
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
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
                                <h5 class="modal-title" id="exampleModalLabel">MODIFICATION D\'UN ENSEIGNANT</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="enseignant.php" method="post">
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
                                    <button type="submit" class="btn btn-primary coloredV2" name="modifier">Modifier</button>
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
                                <h5 class="modal-title" id="exampleModalLabel">SUPPRESSION D\'UN ENSEIGNANT</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="enseignant.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer cet enseignant ?</p>
                                    <input type="hidden" name="id_prof" value="'.$enseignant['id_prof'].'">
                                    <button type="submit" class="btn btn-success colored" name="supprimer">Supprimer</button>
                                    <button type="submit" class="btn btn-danger coloredV4" name="retour">Retour</button>
                                </form>
                                 
                            </div>
                            
                        </div>
                    </div>
                </div>
                ';
            }
        ?>
    </body>
</html>

