<?php 
    session_start();
    $_SESSION['identifiedAdmin'] = false;
    $_SESSION['identifiedEnseignant'] = false;
    $_SESSION['identifiedEtudiant'] = false;
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <title>Connexion</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="script.js" defer></script>
        <link href="styleLoginPage.css" rel="stylesheet">
    </head>   
    <body>

    <?php
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
                require_once("database.php");
                $dbConnection = dbConnect();
                if(isset($_POST['envoyer']) && isset($_POST['email']) && isset($_POST['password'])){
                    $email = $_POST['email'];
                    $table = $_POST['table'];
                    if(isValidUser($email, $dbConnection,$table)){
                        $encryptedPassword = getEncryptedPassword($email, $dbConnection,$table);
                        if(password_verify($_POST['password'], $encryptedPassword)){
                            $user = getUser($email, $dbConnection,$table);
                            switch($table){
                                case 'etudiant':
                                    $_SESSION['identifiedEtudiant'] = true;
                                    $suffixe = 'etu';
                                    break;
                                case 'enseignant':
                                    $_SESSION['identifiedEnseignant'] = true;
                                    $suffixe = 'prof';
                                    break;
                                case 'administrateur':
                                    $_SESSION['identifiedAdmin'] = true;
                                    $suffixe = 'admin'; 
                                    break;
                            }
                            // echo $suffixe;
                            $_SESSION['email'] = $user['mail_'.$suffixe];
                            $_SESSION['nom'] = $user['nom_'.$suffixe];
                            $_SESSION['prenom'] = $user['prenom_'.$suffixe];
                            $_SESSION['id'] = $user['id_'.$suffixe];
                            if($suffixe == 'etu'){
                                header("Location: etudiant/persoEtudiant.php");
                            }
                            if($suffixe == 'prof'){
                                $_SESSION['telephone'] = $user['telephone_prof'];
                                header("Location: enseignant/persoEnseignant.php");
                            }
                            if($suffixe == 'admin'){
                                $_SESSION['telephone'] = $user['telephone_admin'];
                                header("Location: admin/persoAdmin.php");
                            }
                            // exit;
                        }else{
                            $_SESSION['erreurIdentification'] = true;
                        } 
                    }else{
                        $_SESSION['erreurIdentification'] = true;
                    }
                }
            ?>

    <div id="bodyLogin">
            <div id="leftLogin">
                <!-- DIV VIDE -->
            </div>
            <div id="centerLogin">
                <img src="images/logoIsenTest.png" width="300px">
                <div id="contentLogin">
                    <div id="center">
                        <img src="images/logoM.png" width="100px">
                        <div id="carouselExample" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div id="loginBox" class ="shadow">
                                        <h1>Connexion Étudiant</h1>
                                        <form action="loginPage.php" method="post">
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">alternate_email</span></label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" name="email" placeholder="Adresse Mail">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">lock</span></label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="password1" name="password" placeholder="Mot de passe">
                                                </div>
                                            </div>
                                            <div class="form-check form-switch" id="ecarted">
                                                <input class="form-check-input" id="showPassword1" type="checkbox" role="switch" onchange="togglePassword()">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                                            </div>
                                            <div class="d-grid gap-2" id="test">
                                                <button class="btn btn-primary color" type="submit" name="envoyer">Me connecter</button>
                                            </div>
                                            <?php
                                                if(isset($_SESSION['erreurIdentification'])){
                                                    if($_SESSION['erreurIdentification']){
                                                        echo '<p id="erreurParagraphe">Erreur d\'authentification</p>';
                                                        $_SESSION['erreurIdentification'] = false;
                                                    }
                                                }
                                            ?>
                                            <input type="hidden" name="table" value="etudiant">
                                        </form>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div id="loginBox" class ="shadow">
                                        <h1>Connexion Administrateur</h1>
                                        <form action="loginPage.php" method="post">
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">alternate_email</span></label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" name="email" placeholder="Adresse Mail">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">lock</span></label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="password2" name="password" placeholder="Mot de passe">
                                                </div>
                                            </div>
                                            <div class="form-check form-switch" id="ecarted">
                                                <input class="form-check-input" id="showPassword2" type="checkbox" role="switch" onchange="togglePassword()">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                                            </div>
                                            <div class="d-grid gap-2" id="test">
                                                <button class="btn btn-primary color" type="submit" name="envoyer">Me connecter</button>
                                            </div>
                                            <?php
                                                if(isset($_SESSION['erreurIdentification'])){
                                                    if($_SESSION['erreurIdentification']){
                                                        echo '<p id="erreurParagraphe">Erreur d\'authentification</p>';
                                                        $_SESSION['erreurIdentification'] = false;
                                                    }
                                                }
                                            ?>
                                            <input type="hidden" name="table" value="administrateur">
                                        </form>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div id="loginBox" class ="shadow">
                                        <h1>Connexion Enseignant</h1>
                                        <form action="loginPage.php" method="post">
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">alternate_email</span></label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" name="email" placeholder="Adresse Mail">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="material-symbols-outlined">lock</span></label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="password3" name="password" placeholder="Mot de passe">
                                                </div>
                                            </div>
                                            <div class="form-check form-switch" id="ecarted">
                                                <input class="form-check-input" id="showPassword3" type="checkbox" role="switch" onchange="togglePassword()">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Afficher votre mot de passe</label>
                                            </div>
                                            <div class="d-grid gap-2" id="test">
                                                <button class="btn btn-primary color" type="submit" name="envoyer">Me connecter</button>
                                            </div>
                                            <?php
                                                if(isset($_SESSION['erreurIdentification'])){
                                                    if($_SESSION['erreurIdentification']){
                                                        echo '<p id="erreurParagraphe">Erreur d\'authentification</p>';
                                                        $_SESSION['erreurIdentification'] = false;
                                                    }
                                                }
                                            ?>
                                            <input type="hidden" name="table" value="enseignant">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                    <!-- <span class="carousel-control-prev-icon" aria-hidden="true" id="test2"></span> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <!-- <span class="carousel-control-next-icon" aria-hidden="true" id="test2"></span> -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="rightLogin">
                <!-- DIV VIDE -->
            </div>
        </div>
        

        
    </body>
</html>