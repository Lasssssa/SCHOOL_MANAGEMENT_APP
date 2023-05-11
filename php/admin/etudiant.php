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
            
        </div>
        <?php 
            require_once('../database.php');
            $dbConnection = dbConnect();
            if(isset($_POST['modifier'])){
                $id_classe = getIdClassWithYearAndCycle($dbConnection, $_POST['annee_cursus'], $_POST['cycle']);
                updateStudent($dbConnection, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['id_etu'], $id_classe, $_POST['telephone']);
                echo '<div class="alert alert-success" role="alert">
                        L\'étudiant a bien été modifié.
                        </div>';
            }
            if(isset($_POST['supprimer'])){
                deleteStudent($dbConnection, $_POST['id_etu']);
                echo '
                <div class="alert alert-success" role="alert">
                    L\'élève a bien été supprimé.
                </div>';
                unset($_POST['supprimer']);
            }

        ?>


<?php
        //Modal pour modifier un étudiant
        require_once('../database.php');
        $dbConnection = dbConnect(); 
        $allStudents = getAllStudents($dbConnection);
        foreach($allStudents as $student){
            echo '
                <div class="modal" id="modal_'.$student['id_etu'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">MODIFICATION D\'UN ÉLÈVES</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="etudiant.php" method="post">
                                    <div class="mb-3">
                                        <label for="nom" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="nom" name="nom" value="'.$student['nom_etu'].'">
                                    </div>
                                    <div class="mb-3">
                                        <label for="prenom" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="prenom" name="prenom" value="'.$student['prenom_etu'].'">
                                    </div>
                                    <div class="mb-3">
                                        <label for="mail" class="form-label">Mail</label>
                                        <input type="email" class="form-control" id="mail" name="mail" value="'.$student['mail_etu'].'">
                                    </div>
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" id="telephone" name="telephone" value="'.$student['telephone_etu'].'">
                                    </div>
                                    <div class="row">
                                        <div class="col">';
                                        echo '<label for="mail" class="form-label">Année</label>';
                                        echo '<select class="form-select" aria-label="Default select example" name="annee_cursus">';
                                                echo '<option value="'.$student['annee_cursus'].'">'.$student['annee_cursus'].'</option>';
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if($i != $student['annee_cursus'])
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
                                    $cycles = getAllCycles($dbConnection);
                                    echo '<div><select class="form-select" aria-label="Default select example" name="cycle">';
                                        echo '<option value="'.$student['nom_cycle'].'">'.$student['nom_cycle'].'</option>';
                                    foreach($cycles as $cycle){
                                        if($cycle['nom_cycle'] != $student['nom_cycle'])
                                        {
                                            echo '<option value="'.$cycle['nom_cycle'].'">'.$cycle['nom_cycle'].'</option>';
                                        }
                                    }
                                    echo '</select></div><br>';
                                    echo '<button type="submit" class="btn btn-primary coloredV2" name="modifier">Modifier</button>
                                    <input type="hidden" name="id_etu" value="'.$student['id_etu'].'" name="id_etu">
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
                ';
                echo '
                <div class="modal" id="modalSupp_'.$student['id_etu'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">SUPPRESSION D\'UN ÉLÈVES</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="etudiant.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer cet élève ?</p>
                                    <input type="hidden" name="id_etu" value="'.$student['id_etu'].'">
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
        <?php
            if(isset($_POST['envoyer']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['emailConfirmed']) && isset($_POST['password']) && isset($_POST['passwordConfirmed']) && isset($_POST['annee']) && isset($_POST['cycle']) && isset($_POST['telephone'])){
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
                    $telephone = $_POST['telephone'];
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $email = $_POST['email'];
                    $annee = $_POST['annee'];
                    $cycle = $_POST['cycle'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    require_once('../database.php');
                    $db = dbConnect();
                    $id_classe = getIdClassWithYearAndCycle($db, $annee, $cycle);
                    $isAddedStudent = addStudent($db, $prenom, $nom, $email, $password,$id_classe, $telephone);
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
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item">
                    <div class="ecart">
                        <div class="titlePage">
                            <div></div>
                            <div class="title">
                                <h1>AJOUT DES ÉLÈVES</h1>
                            </div>    
                            <div></div>
                        </div>
                        <div id="mainAdding">
                            <div id="formAdding">
                                <h2>FORMULAIRE</h2>
                                <form action="etudiant.php" method="post">
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
                                            <input type="password" class="form-control" id="password5" name="password">
                                            <div class="form-check form-switch" id="ecarted">
                                                <input class="form-check-input" type="checkbox" role="switch" id="showPassword5" onchange="togglePassword()">
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
                                            <h4>Numéro de téléphone</h4>
                                            <input type="number" class="form-control" name = "telephone">
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
                                    <button type="submit" class="btn btn-primary coloredV2" name ="envoyer">Inscrire un nouvel élève</button>
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
                                <h1>MODIFICATION DES ÉLÈVES</h1>
                            </div>    
                            <div></div>
                        </div>
                        <div id="middleChoiceStudents">
                        <form action="etudiant.php" method ="post" id="formCycle">
                                <div id="titleChoice">
                                    <h2>Filtre de tri</h2>
                                </div>
                                <div id="choiceCycleSelect">
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
                                <div id="choiceAnneeSelect">
                                    <select class="form-select" aria-label="Default select example" name="choice_annee">
                                        <option selected value="all">Toutes les années</option>';
                                        <option value="1">Année 1</option>
                                        <option value="2">Année 2</option>
                                        <option value="3">Année 3</option>
                                        <option value="4">Année 4</option>
                                        <option value="5">Année 5</option>
                                    </select>
                                </div>
                                <div id="choiceSubmitStudent">
                                    <button type="submit" class="btn btn-primary coloredV5" name="submitCycle">Appliquer des filtres</button>
                                </div>
                            </form>
                        </div>
                        <div id="modifyEnseignant">
                            <table class="table table-striped">
                                <?php
                                    require_once('../database.php');
                                    $dbConnection = dbConnect();
                                    if(isset($_POST['choice_cycle']) && isset($_POST['choice_annee']) && isset($_POST['submitCycle']) && $_POST['choice_cycle'] != 'all' && $_POST['choice_annee'] != 'all'){
                                        $allStudents = getStudentsByCycleAndYear($dbConnection, $_POST['choice_cycle'], $_POST['choice_annee']);
                                    }
                                    else if(isset($_POST['choice_cycle']) && isset($_POST['submitCycle']) && $_POST['choice_cycle'] != 'all'){
                                        $allStudents = getStudentsByCycle($dbConnection, $_POST['choice_cycle']);
                                    }
                                    else if(isset($_POST['choice_annee']) && isset($_POST['submitCycle']) && $_POST['choice_annee'] != 'all'){
                                        $allStudents = getStudentsByYear($dbConnection, $_POST['choice_annee']);
                                    }
                                    else{
                                        $allStudents = getAllStudents($dbConnection);
                                    }
                                    echo '<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Mail</th><th>Téléphone</th><th>Classe</th><th>Modification</th><th>Suppression</th></tr>';
                                    foreach($allStudents as $student){
                                        echo '<tr><td>'.$student['id_etu'].'</td><td>'.$student['nom_etu'].'</td><td>'.$student['prenom_etu'].'</td><td>'.
                                        $student['mail_etu'].'</td><td>'.$student['telephone_etu'].'</td><td>'.$student['nom_cycle'].' '.$student['annee_cursus'].'</td>
                                        <td>
                                            <button type="submit" class="btn btn-success colored" data-bs-toggle="modal" data-bs-target="#modal_'.$student['id_etu'].'" name="'.$student['id_etu'].'">
                                            <span class="material-symbols-outlined">
                                        update
                                        </span> Modifier
                                            </button>
                                        </td>
                                        <td>  
                                            <button type="submit" class="btn btn-danger coloredV2" data-bs-toggle="modal" data-bs-target="#modalSupp_'.$student['id_etu'].'" name="supp_'.$student['id_etu'].'">
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