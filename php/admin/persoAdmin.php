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
    
    <!-- A voir pour plutot avoir un récapitulatif en fonction de ce que l'on demande -->

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

        <div id="container">
            <a href="addingEnseignant.php">
                <div class="card text-bg-primary mb-3" id="blockCard">
                    <div class="card-header">
                        <span class="material-symbols-outlined" style="font-size : 400%">person_add</span>
                        <h4>Enseignants</h4>
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Ajouter / Modifier des enseignants</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </a>
            <a href="addingEtudiant.php">
                <div class="card text-bg-danger mb-3" id="blockCard">
                    <div class="card-header">
                    <span class="material-symbols-outlined" style="font-size : 400%">group</span>
                        <h4>Étudiants</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Ajouter / Modifier des étudiants</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </a>
            <a href="addingCours.php">
                <div class="card text-bg-dark mb-3" id="blockCard">
                    <div class="card-header">
                        <span class="material-symbols-outlined" style="font-size : 400%">settings</span>
                        <h4>Cours</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Ajouter / Modifier des cours</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </a>
        </div>


    </body>
</html>