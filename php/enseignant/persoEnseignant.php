<?php 
    session_start();
        if($_SESSION['identifiedEnseignant'] == false || !isset($_SESSION['identifiedEnseignant'])){
            header("Location: ../loginEnseignant.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <title>Page Enseignant</title>
        <link href="stylePersoEnseignant.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
        <script src="../script.js"></script>
    </head>
    
    <!-- A réadapter -->

    <body>
        <h1>Connexion Enseignant</h1>
    </body>
</html>