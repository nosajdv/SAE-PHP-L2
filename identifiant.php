<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'myparam.inc.php';

// Paramètres de connexion Oracle
$tns = MYHOST;
$username = MYUSER;
$password = MYPASS;

// Connexion à la base de données Oracle
$conn = oci_connect('jasondaveiga', 'daveiga1', '10.1.16.56/oracle2');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Vérification des données postées
if (isset($_POST['Num_Comit']) && isset($_POST['MDP'])) {
    $identifiant = $_POST['Num_Comit'];
    $motdepasse = strtoupper(md5($_POST['MDP']));

    if (empty($identifiant) || empty($motdepasse)) {
        header("Location: index.php?error=Identifiant ou mot de passe manquant");
        exit();
    }

    // Requête SQL pour l'authentification
    $sql = "SELECT * FROM Comite WHERE Num_Comit = :identifiant AND MDP = :motdepasse";
    $stmt = oci_parse($conn, $sql);

    // Liaison des paramètres
    oci_bind_by_name($stmt, ":identifiant", $identifiant);
    oci_bind_by_name($stmt, ":motdepasse", $motdepasse);
   
    // Exécution de la requête
    $r = oci_execute($stmt);

    // Vérification du résultat
    if (!$r || oci_num_rows($stmt) !== 1) {

        // Redirection vers la page d'index avec l'erreur affichée en GET
        header('Location: index.php?error=Identifiant ou mot de passe incorrect');
        exit();
    }
    
    // Récupération des données
    $row = oci_fetch_assoc($stmt);

    // Requête SQL pour récupérer le nom de l'utilisateur
    $numutil = $row['NUM_P'];
    $sql_nom = "SELECT Prenom_P FROM Comite c, Participant p WHERE p.Num_P=c.Num_P AND c.Num_P = :numutil";
    $stmt_nom = oci_parse($conn, $sql_nom);
    oci_bind_by_name($stmt_nom, ":numutil", $numutil);
    oci_execute($stmt_nom);
    $nomFinale = oci_fetch_assoc($stmt_nom);

    // Stockage des informations de session
    $_SESSION['Num_Comit'] = $row['NUM_COMIT'];
    $_SESSION['MDP'] = $row['MDP'];
    $_SESSION['Prenom_P'] = $nomFinale['PRENOM_P'];



    //Redirection vers la page d'accueil
    header('Location: pageacceuil.php');
    exit();
}else{

// Redirection vers la page d'index si les données postées ne sont pas valides
header('Location: index.php');
exit();
}
?>

