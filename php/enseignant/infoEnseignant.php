<?php 
    session_start();
        if($_SESSION['identifiedEnseignant'] == false || !isset($_SESSION['identifiedEnseignant'])){
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="../script.js"></script>
        <link href="stylePersoEnseignant.css" rel="stylesheet">
    </head>
    
    <!-- A voir pour plutot avoir un récapitulatif en fonction de ce que l'on demande -->

    <body>
        <div id="navbarEns">
            <nav class="navbar navbar-dark bg-dark fixed-top left" id="header">
                <div class="container-fluid">
                    <a class="navbar-brand" href="persoEnseignant.php">
                        <img src="../images/logoIsen.png" alt="Bootstrap" width="190">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end text-bg-dark colorSe" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header"> 
                            <h6 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu Enseignant</h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body" id="menu">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="consultation.php">Consultation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="notes.php">Notes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="appreciation.php">Appréciations</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo '<span class="material-symbols-outlined">account_circle</span>&nbsp&nbsp&nbsp'.$_SESSION['prenom'][0].'.'.$_SESSION['nom'].''; ?>
                                </a>
                                <div id="dropD">
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><a class="dropdown-item" href="infoEnseignant.php">Compte</a></li>
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
            <div class="title">
                <h1>Votre compte</h1>
                <div class="pp">
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
                <h5>Importer votre photo de profil</h5>
            </div>
            <div class="import">
                <form action="infoEnseignant.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="photo_profil" id="fileToUpload">
                    <br>
                    <button type="submit" class="btn btn-primary" name="submit_photo">Importer</button>
                </form>
            </div>

            
        

            <div class="info">
                
            </div>
        </div> 
        
    </body>
</html>