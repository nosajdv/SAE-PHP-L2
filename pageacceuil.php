<?php
session_start();

if(isset($_SESSION['Num_Comit'])){
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page d'Accueil</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/png" href="res/favicon.png">
    </head>
    <body>
        <div class="page-acceuil"> 
            <div><a href="deconnexion.php">Déconnexion</a><div>
            <fieldset><h1><?php echo 'Bienvenue '.$_SESSION['Prenom_P'];?></h1></fieldset>
            
            <div class="button-grid">
                
                <a href="recherche.php" class="button">Rechercher des informations</a>
                <a href="gestion.php" class="button">Ajouter/supprimer/modifier des participant</a>
                <a href="support.php" class="button">Support</a>
            </div>
        </div>
    </body>
    </html>
    <?php
}
else{
    header("Location: index.php");
    exit();
}
?>
