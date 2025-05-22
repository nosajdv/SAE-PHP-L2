<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérifier si l'utilisateur est connecté
if(isset($_SESSION['Num_Comit'])) {
    include 'myparam.inc.php';
    /*Paramètre de connexion pour mon PC perso */
    $servernom = MYHOST;
    $identif = MYUSER;
    $password = MYPASS;
    $connexion = oci_connect($identif, $password, $servernom);

    if (!$connexion) {
        echo "Connexion Impossible : " . oci_error();
        exit();
    } 
function genererChaineAleatoire($longueur = 5)
{
 $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 $longueurMax = strlen($caracteres);
 $chaineAleatoire = '';
 for ($i = 0; $i < $longueur; $i++)
 {
 $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
 }
 return $chaineAleatoire;
}
    // Traiter la création de ticket si le formulaire est soumis
        if (isset($_POST['GO'])) {
            // Validation des données du formulaire
            if (!empty($_POST['title']) && !empty($_POST['email']) && !empty($_POST['msg'])) {
                // Préparer et exécuter la requête d'insertion dans la base de données
                $title = $_POST['title'];
                $email = $_POST['email'];
                $msg = $_POST['msg'];
                $id= genererChaineAleatoire();
                
               
                 $sql = "INSERT INTO TICKETS (NUM_T,TITRE,MSG,EMAIL,STATUT) VALUES (:id ,:title, :msg, :email, 'ouvert')";
                $stmt = oci_parse($connexion, $sql);
                oci_bind_by_name($stmt, ':title', $id);
                oci_bind_by_name($stmt, ':title', $title);
                oci_bind_by_name($stmt, ':email', $email);
                oci_bind_by_name($stmt, ':msg', $msg);
                oci_bind_by_name($stmt, ':id', $id);
               
                
        if (oci_execute($stmt)) {
            echo "Ticket ajouté";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt)['message']);
        }

                oci_free_statement($stmt);
            }
        }

    // Récupérer les tickets existants
    $sql = "SELECT * FROM TICKETS";
    $stmt = oci_parse($connexion, $sql);

    if ($stmt == false) {
        echo "Erreur de préparation de la requête.";
        exit();
    }

    oci_execute($stmt);
    $tickets = array();

    while ($row = oci_fetch_assoc($stmt)) {
        $tickets[] = $row;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket</title>
    <link rel="icon" type="image/png" href="res/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div>
        <a href="deconnexion.php">Déconnexion</a>
        <a href="pageacceuil.php">Retour</a>
     </div>
    <h2>Tickets existants</h2>
    <p>Bienvenue sur la page Support, envoyer un ticket en cas de problème.</p>
    <div class="tickets-list">
        <?php foreach ($tickets as $ticket): ?>
            <a href="infoticket.php?id=<?=$ticket['NUM_T']?>" class="ticket">
                <span class="con">
                    <?php if ($ticket['STATUT'] == 'ouvert'): ?>
                        <i class="far fa-clock fa-2x status1"></i><br>Ouvert<br>
                    <?php elseif ($ticket['STATUT'] == 'resolu'): ?>
                        <i  class="fas fa-check fa-2x status2"></i><br>Résolu<br>
                    <?php elseif ($ticket['STATUT'] == 'fermer'): ?>
                        <i  class="fas fa-times fa-2x status3"></i><br>Fermé<br>
                    <?php endif; ?>
                </span>
                <span class="con">
                    <span class="title"><?=htmlspecialchars($ticket['TITRE'], ENT_QUOTES)?></span>
                    <br>
                </span>
               
            </a>
        <?php endforeach; ?>
    </div>

    <div class="content create">
        <h2>Creer votre Ticket</h2>
        <form method="post" action="support.php">
            <label for="title">Rédiger votre ticket ici</label> 
            <input type="text" name="title" placeholder="Titre" required><br>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="mail@example.com" required><br>
            <label for="msg">Message</label>
            <textarea name="msg" placeholder="Rédige message ici..." required></textarea><br>
            <input name="GO" type="submit" value="Create">
        </form>
        
    </div>
</body>
</html>

<?php

}else{

    header("Location: index.php");
    exit();
}
?>
