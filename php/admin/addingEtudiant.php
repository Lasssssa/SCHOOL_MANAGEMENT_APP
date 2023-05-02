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
            <a href="addingEtudiant.php">Ajout</a>
            <a href="modifyStudents.php">Modification</a>
        </div>

        <?php
            if(isset($_POST['envoyer']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['emailConfirmed']) && isset($_POST['password']) && isset($_POST['passwordConfirmed']) && isset($_POST['annee']) && isset($_POST['cycle'])){
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
                    $annee = $_POST['annee'];
                    $cycle = $_POST['cycle'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    require_once('../database.php');
                    $db = dbConnect();
                    $id_classe = getIdClassWithYearAndCycle($db, $annee, $cycle);
                    $isAddedStudent = addStudent($db, $prenom, $nom, $email, $password,$id_classe);
                    if($isAddedStudent){
                        echo '<div class="alert alert-success" role="alert">
                        L\'élève a bien été ajouté
                        </div>';
                    }
                    else{
                        echo '<div class="alert alert-danger" role="alert">
                        L\'élève n\'a pas été ajouté car il existe déjà ou il y a eu une erreur
                        </div>';
                    }
                }
            }
        ?>

        <div id="mainAdding">
            <div id="formAdding">
                <h2>Ajout d'un élève</h2>
                <form action="addingEtudiant.php" method="post">
                    <div class="row">
                        <div class="col">
                            <h4>Prénom</h4>
                            <input type="text" class="form-control" name ="prenom">
                        </div>
                        <div class="col">
                            <h4>Nom</h4>
                            <input type="text" class="form-control" name ="nom">
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="form-group">
                            <h4>Email</h4>
                            <input type="email" class="form-control" id="inputEmail4" name ="email">
                            <h4>Confirmation email</h4>
                            <input type="email" class="form-control" id="inputEmail4" name ="emailConfirmed">
                        </div>
                        <br>
                        <div class="form-group">
                            <h4>Mot de passe</h4>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-check form-switch" id="ecarted">
                                <input class="form-check-input" type="checkbox" role="switch" id="showPassword" onchange="togglePassword()">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                            </div>
                            <h4>Confirmation mot de passe</h4>
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
                            <h4>Année</h4>
                            <?php 
                            require_once('../database.php');
                            $db = dbConnect();
                            echo '<select class="form-select" aria-label="Default select example" name="annee">';
                                echo '<option value="impossible">Choisir une année</option>';
                                $allYears = getAllYearsClass($db);
                                foreach($allYears as $year){
                                    echo '<option value="'.$year['annee_cursus'].'">'.$year['annee_cursus'].'</option>';
                                }
                                echo '
                            </select>';
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h4>Cycle</h4>
                            <?php
                                require_once('../database.php');
                                $db = dbConnect();
                                $cycles = getAllCycles($db);
                                echo '<select class="form-select" aria-label="Default select example" name="cycle">';
                                foreach($cycles as $cycle){
                                    echo '<option value="'.$cycle['nom_cycle'].'">'.$cycle['nom_cycle'].'</option>';
                                }
                                echo '</select>';
                            ?>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name ="envoyer">Inscrire un nouvel élève</button>
                </form>
            </div>
        </div>
    </body>
</html>