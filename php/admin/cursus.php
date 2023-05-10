<?php 
    session_start();
    $_SESSION['erreurIdentification'] = false;
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="../script.js"></script>
        <link href="stylePersoAdmin.css" rel="stylesheet">
    </head>
    
    <!-- A voir pour plutot avoir un récapitulatif en fonction de ce que l'on demande -->

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
                                <a class="nav-link hovered" href="cursus.php"><span class="material-symbols-outlined">settings</span><?php echo"&nbsp&nbsp&nbsp";?> Cursus</a>
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
            require_once('../database.php');
            $db = dbConnect();
            $years = getAllYears($db);
            foreach($years as $year){
                echo '
                <div class="modal" id="modalSupp_'.$year['id_annee'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">SUPPRESSION D\'UNE ANNÉE UNIVERSITAIRE</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="cursus.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer cette année universitaire ?</p>
                                    <input type="hidden" name="id_annee" value="'.$year['id_annee'].'">
                                    <button type="submit" class="btn btn-success colored" name="supprimer">Supprimer</button>
                                    <button type="submit" class="btn btn-danger coloredV4" name="retour">Retour</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
            $semesters = getAllSemesters($db);
            foreach($semesters as $semester){
                echo '
                <div class="modal" id="modalSuppS_'.$semester['id_semestre'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">SUPPRESSION D\'UN SEMESTRE UNIVERSITAIRE</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="cursus.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer ce semestre universitaire ?</p>
                                    <input type="hidden" name="id_semestre" value="'.$semester['id_semestre'].'">
                                    <button type="submit" class="btn btn-success colored" name="supp_semestre">Supprimer</button>
                                    <button type="submit" class="btn btn-danger coloredV4" name="retour">Retour</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
            $cycles = getAllCycles($db);
            foreach($cycles as $cycle){
                echo '
                <div class="modal" id="modalSuppC_'.$cycle['nom_cycle'].'" data-bs-backdrop=”static” tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">SUPPRESSION D\'UN CYCLE D\'ÉTUDE </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="cursus.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer ce cycle ?</p>
                                    <p>Avertissement : Si des classes contenant des élèves lui sont associées, vous devez les supprimer avant de supprimer ce cycle.</p>
                                    <input type="hidden" name="nom_cycle" value="'.$cycle['nom_cycle'].'">
                                    <button type="submit" class="btn btn-success colored" name="supp_cycle">Supprimer</button>
                                    <button type="submit" class="btn btn-danger coloredV4" name="retour">Retour</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        ?>


        <div id ="board">
            
        </div>

    

        <div class="titlePage">
            <div></div>
            <div class="title">
                <h1>GESTION DU CURSUS</h1>
            </div>    
            <div></div>
        </div>


        

        <div class="gestion">

        <!-- Suppression des années -->
        <?php 
            require_once('../database.php');
            $db = dbConnect();
            if(isset($_POST['supprimer'])){
                $delete = deleteYear($db, $_POST['id_annee']);
                if($delete){
                    echo '
                    <div class="alert alert-success" role="alert" id="deleteAnnee">
                        L\'année universitaire a bien été supprimée.
                    </div>';
                }else{
                    echo '
                    <div class="alert alert-danger" role="alert" id="deleteAnnee">
                        L\'année universitaire n\'a pas pu être supprimée.
                        <br>
                        Des cours sont dispensés pendant cette année !
                    </div>';
                }
                unset($_POST['supprimer']);
            }
            if(isset($_POST['supp_semestre'])){
                $delete = deleteSemester($db, $_POST['id_semestre']);
                if($delete){
                    echo '
                    <div class="alert alert-success" role="alert" id="deleteAnnee">
                        Le semestre universitaire a bien été supprimé.
                    </div>';
                }else{
                    echo '
                    <div class="alert alert-danger" role="alert" id="deleteAnnee">
                        Le semestre universitaire n\'a pas pu être supprimé.
                        <br>
                        Des cours sont dispensés pendant ce semestre !
                    </div>';
                }
                unset($_POST['supp_semestre']);
            }
            if(isset($_POST['supp_cycle'])){
                $delete = deleteCycle($db, $_POST['nom_cycle']);
                if($delete){
                    echo '
                    <div class="alert alert-success" role="alert" id="deleteAnnee">
                        Le cycle d\'étude a bien été supprimé.
                    </div>';
                }else{
                    echo '
                    <div class="alert alert-danger" role="alert" id="deleteAnnee">
                        Le cycle d\'étude n\'a pas pu être supprimé.
                        <br>
                        Vous avez encore des classes contenant des élèves !
                    </div>';
                }
                unset($_POST['supp_cycle']);
            }

        ?>

        <!-- Ajout des années -->

        <?php
            
            if(isset($_POST['submit_annee']) && isset($_POST['annee'])){
                $valid = addYear($db, $_POST['annee']);
                if($valid){
                    echo '<div class="alert alert-success" role="alert" id="deleteAnnee">
                    L\'année universitaire a bien été ajoutée !
                    </div>';
                }
                else{
                    echo '<div class="alert alert-danger" role="alert" id="deleteAnnee">
                    L\'année universitaire n\'a pas pu être ajoutée !
                    </div>';
                }
                unset($_POST['submit_annee']);
            }

            if(isset($_POST['submit_semestre']) && isset($_POST['semestre'])){
                $valid = addSemester($db,$_POST['id_anneeS'], $_POST['semestre']);
                if($valid){
                    echo '<div class="alert alert-success" role="alert" id="deleteAnnee">
                    Le semestre universitaire a bien été ajouté !
                    </div>';
                }
                else{
                    echo '<div class="alert alert-danger" role="alert" id="deleteAnnee">
                    Le semestre universitaire n\'a pas pu être ajouté !
                    </div>';
                }
                unset($_POST['submit_semestre']);
            }

            if(isset($_POST['submit_cycle']) && isset($_POST['nom_cycle'])){
                $add = addCycle($db, $_POST['nom_cycle']);
                if($add){
                    echo '<div class="alert alert-success" role="alert" id="deleteAnnee">
                    Le cycle a bien été ajouté avec les classes correspondantes !
                    </div>';
                    for($i=1;$i<=5;$i++){
                        if(isset($_POST['annee_cursus'.$i])){
                            addClass($db,$_POST['nom_cycle'], $i);
                        }
                    }
                }
                else{
                    echo '<div class="alert alert-danger" role="alert" id="deleteAnnee">
                    Le cycle n\'a pas pu être ajouté !
                    </div>';
                }
            }
        ?>

            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                        <h1>
                            <span class="material-symbols-outlined">
                            terminal
                            </span>
                            ANNÉES UNIVERSITAIRES
                        </h1>
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="annee">
                                <h2>Gestion des années universitaires :</h2>
                                <div class="liste_annee">
                                    <h3>Liste des années universitaires</h3>
                                    <?php
                                        require_once('../database.php');
                                        $db = dbConnect();
                                        $years = getAllYears($db);
                                        echo "<table class='table table-striped'>";
                                        echo "<tr><th>ID</th><th>Année universitaire</th><th>Supprimer</th></tr>";
                                        foreach ($years as $year) {
                                            echo "<tr>";
                                            echo "<td>".$year['id_annee']."</td>";
                                            echo "<td>".$year['numero_annee']."</td>";
                                            echo '<td><button type="submit" class="btn btn-danger coloredV2" data-bs-toggle="modal" data-bs-target="#modalSupp_'.$year['id_annee'].'" name="supp_'.$year['id_annee'].'">
                                                <span class="material-symbols-outlined">
                                                delete
                                                </span> Supprimer 
                                            </button></a></td>';
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                        echo '<br>';
                                        echo "<h3>Ajouter une année universitaire :</h3>";
                                        echo "<br>";
                                        echo '
                                            <form action="cursus.php" method="post">
                                                <div class="space">
                                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Entrez une année universitaire" name="annee">
                                                    <br>
                                                    <button type="submit" class="btn btn-success colored" name="submit_annee">
                                                    <span class="material-symbols-outlined">
                                                    library_add
                                                    </span> Ajouter
                                                    </button>
                                                </div>
                                            </form>
                                        ';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        <h1>
                        <span class="material-symbols-outlined">
                        calendar_apps_script
                        </span>    
                        SEMESTRES UNIVERSITAIRES
                        </h1>
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="semestre">
                            <h2>Gestion des semestres universitaires :</h2>
                                <div class="liste_annee">
                                    <h3>Liste des semestres universitaires</h3>
                                    <?php
                                        require_once('../database.php');
                                        $db = dbConnect();
                                        $semesters = getAllSemesters($db);
                                        echo "<table class='table table-striped'>";
                                        echo "<tr><th>ID</th><th>Année universitaire</th><th>Numéro du semestre</th><th>Supprimer</th></tr>";
                                        foreach ($semesters as $semester) {
                                            echo "<tr>";
                                            echo "<td>".$semester['id_semestre']."</td>";
                                            echo "<td>".$semester['numero_annee']."</td>";
                                            echo "<td>".$semester['numero_semestre']."</td>";
                                            echo '<td><button type="submit" class="btn btn-danger coloredV2" data-bs-toggle="modal" data-bs-target="#modalSuppS_'.$semester['id_semestre'].'" name="suppS_'.$semester['id_semestre'].'">
                                                <span class="material-symbols-outlined">
                                                delete
                                                </span> Supprimer 
                                            </button></a></td>';
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                        echo '<br>';
                                        echo "<h3>Ajouter un semestre universitaire : </h3>";
                                        echo "<br>";
                                        echo '
                                            <form action="cursus.php" method="post">
                                                <div class="space">';
                                                    $years = getAllYears($db);
                                                    echo '<select class="form-select" aria-label="Default select example" name="id_anneeS">';
                                                    foreach ($years as $year) {
                                                        echo '<option value="'.$year['id_annee'].'">'.$year['numero_annee'].'</option>';
                                                    }
                                                    echo '</select>';
                                                    echo '<br>';
                                                    echo '<input type="number" class="form-control" id="exampleFormControlInput1" min="1" max="2" placeholder="Entrez un numéro de semestre" name="semestre">';
                                                    echo '<br><button type="submit" class="btn btn-success colored" name="submit_semestre">
                                                    <span class="material-symbols-outlined">
                                                    library_add
                                                    </span> Ajouter
                                                    </button>
                                                </div>
                                            </form>
                                        ';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        <h1>
                            <span class="material-symbols-outlined">
                            school
                            </span>
                            CYCLES D'ÉTUDES
                        </h1>
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="cycle">
                            <h2>Gestion des cycles d'études :</h2>
                                <div class="liste_annee">
                                    <h3>Liste des cycles d'études</h3>
                                    <?php
                                        require_once('../database.php');
                                        $db = dbConnect();
                                        $cycles = getAllCycles($db);
                                        echo "<table class='table table-striped'>";
                                        echo "<tr><th>Nom du cycle</th><th>Classes associées</th><th>Supprimer</th></tr>";
                                        foreach ($cycles as $cycle){
                                            echo "<tr>";
                                            echo "<td>".$cycle['nom_cycle']."</td>";
                                            $classes = getClassesByCycle($db, $cycle['nom_cycle']);
                                            echo "<td>";
                                            
                                            foreach ($classes as $classe) {
                                                echo $classe['nom_cycle'].$classe['annee_cursus']."<br>";
                                            }
                                            echo "</td>";
                                            echo '<td><button type="submit" class="btn btn-danger coloredV2" data-bs-toggle="modal" data-bs-target="#modalSuppC_'.$cycle['nom_cycle'].'" name="suppC_'.$cycle['nom_cycle'].'">
                                                <span class="material-symbols-outlined">
                                                delete
                                                </span> Supprimer 
                                            </button></a></td>';
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                        echo '<br>';
                                        echo "<h3>Ajouter un cycle d'étude : </h3>";
                                        echo "<br>";
                                        echo '
                                            <form action="cursus.php" method="post">
                                                <div class="space">';
                                                    echo '<input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Entrez le nom du cycle" name="nom_cycle">';
                                                    echo '<br><label for="exampleFormControlInput1" class="form-label">Année de cursus associées :</label>';
                                                    echo '<br>';
                                                    for ($i=1;$i<=5;$i++){
                                                        echo '<input class="form-check-input" type="checkbox" value="'.$i.'" name="annee_cursus'.$i.'">';
                                                        echo '<label class="form-check-label" for="annee'.$i.'">Année '.$i.'</label>';
                                                        echo '<br>';
                                                    }
                                                    echo '<br><button type="submit" class="btn btn-success colored" name="submit_cycle">
                                                    <span class="material-symbols-outlined">
                                                    library_add
                                                    </span> Ajouter
                                                    </button>
                                                </div>
                                            </form>
                                        ';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>



        

        
    </body>
</html>