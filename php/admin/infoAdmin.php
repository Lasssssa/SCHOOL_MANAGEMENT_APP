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

        <?php
            if(isset($_POST['submit_photo'])){
                move_uploaded_file($_FILES['photo_profil']['tmp_name'],"../photo_profil/".$_SESSION['nom'].'_'.$_SESSION['prenom'].".png");
            }
        ?>
        <div id="infoPerso">
            <div class="titlePerso">
                <div class="titlePage">
                    <div></div>
                    <div class="title">
                        <h1>VOTRE COMPTE</h1>
                    </div>    
                    <div></div>
                </div>
                <?php
                    require_once('../database.php');
                    $db = dbConnect();
                    echo "<br>";
                    if(isset($_POST['submit_password']) && isset($_POST['old_password']) && isset($_POST['new_password'])){
                        $table = "administrateur";
                        $suffixe = "admin";
                        $user = getUser($_SESSION['email'],$db,$table);
                        $encryptedPassword = getEncryptedPassword($_SESSION['email'], $db,$table);
                        if(password_verify($_POST['old_password'], $encryptedPassword)){
                            $new_encrypt = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                            $valid = updatePassword($_SESSION['id'], $new_encrypt, $db,$table,"admin");
                            echo '<div class="alert alert-success" role="alert" id="deleteAnnee">
                                Mot de passe modifié avec succès !
                                </div>';
                        }else{
                            echo '<div class="alert alert-danger" role="alert" id="deleteAnnee">
                                Ancien mot de passe incorrect !
                                </div>';
                        }
                    }
                ?>
                <div id="mainAdding">
                    <div id="formAdding">
                        <h2>INFORMATIONS PERSONNELLES</h2>
                        <br>
                        <div class="ppV2">
                            <?php
                                $name = $_SESSION['nom'].'_'.$_SESSION['prenom'];
                                require_once('../database.php');
                                $img = getProfilPicture($name);
                                if($img != null){
                                    echo '<img src="../photo_profil/'.$img.'" class="pp" alt="photo de profil">';
                                }else{
                                    echo '<img src="../images/profil_defaut.png" class="pp" alt="photo de profil">';
                                    }
                            ?>
                        </div>
                        <br>
                        <div class="import">
                            <h5>Importer votre photo de profil</h5>
                            <form action="infoAdmin.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input class="form-control" type="file" name="photo_profil" id="fileToUpload">
                                </div>
                                <button type="submit" class="btn btn-primary coloredV2" name="submit_photo">Importer</button>
                            </form>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h4>Prénom</h4>
                                <input class="form-control" type="text" placeholder="<?php echo $_SESSION['prenom']; ?>" aria-label="Disabled input example" disabled>
                            </div>
                            <div class="col">
                                <h4>Nom</h4>
                                <input class="form-control" type="text" placeholder="<?php echo $_SESSION['nom']; ?>" aria-label="Disabled input example" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <h4>Numéro de téléphone</h4>
                                <input class="form-control" type="text" placeholder="<?php echo $_SESSION['telephone']; ?>" aria-label="Disabled input example" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group">
                                <h4>Email</h4>
                                <input class="form-control" type="text" placeholder="<?php echo $_SESSION['email']; ?>" aria-label="Disabled input example" disabled>
                            </div>
                            <br>
                            <div class="form-group">
                                <h4>Mot de passe</h4>
                                <input class="form-control" type="text" placeholder="********" aria-label="Disabled input example" disabled>
                            </div>
                            <br>
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                            MODIFICATION DU MOT DE PASSE
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <form action="infoAdmin.php" method="post">
                                                <div class="form-group">
                                                    <h4>Ancien mot de passe</h4>
                                                    <input type="password" class="form-control" id="password5" name="old_password">
                                                    <h4>Nouveau mot de passe</h4>
                                                    <input type="password" class="form-control" id="password2" name="new_password">
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-primary coloredV2" name="submit_password">Modifier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>  
                    </div>   
                </div> 
            </div>
        </div>
    </body>
</html>