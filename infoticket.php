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
        echo "Une erreur est survenue. Veuillez réessayer ultérieurement."; 
        exit();
    }


    // Vérifier si l'ID du ticket est passé dans l'URL
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "ID de ticket invalide.";
        exit();
    }

    // Récupérer l'ID du ticket depuis l'URL et le sécuriser
    $ticket_id = $_GET['id'];

    // Récupérer les détails du ticket depuis la base de données en fonction de l'ID
    $sql = "SELECT * FROM TICKETS WHERE NUM_T = :ticket_id";
    $stmt = oci_parse($connexion, $sql);

        
    oci_bind_by_name($stmt, ':ticket_id', $ticket_id);
    oci_execute($stmt);
   
    

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Détails du ticket</title>
    <link rel="icon" type="image/png" href="res/favicon.png">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="">
    <h2>Détails du ticket</h2>
    <div class="ticket-details">
    <?php
      while ($ticket = oci_fetch_assoc($stmt)) {
      echo "Numéro du ticket:".$ticket['NUM_T'].'<BR><br>';
      
      echo "Message: <br>".$ticket['MSG']."<br><br>";
      
      echo "Statut: <br>".$ticket['STATUT']."<br><br>";
      echo "Par: ".$ticket['EMAIL'].'';
      }
    ?>

    </div>

    <a href="support.php" class="btn">Retour à la liste des tickets</a>
    <div>
</body>
</html>

<?php
}else{
    header("Location: index.php");
    exit();
}

?>
