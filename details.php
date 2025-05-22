<?php

session_start();

  //$url='details.php?table='.$table.'&id='. $col['NUM_C'];

if(isset($_SESSION['Num_Comit']) && isset($_SESSION['Num_Comit'])){
    include 'myparam.inc.php';
    /*Paramètre de connexion pour mon PC perso */
    $servernom = MYHOST;
    $identif = MYUSER;
    $password = MYPASS;

    // Connexion à la base de données
    $conn = oci_connect($identif, $password, $servernom);

    // Vérification de la connexion à la base de données
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Récupérer le nom de la table sélectionnée
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table'])) {
        $table = strtoupper($_GET['table']);
    } else {
        // Utiliser une valeur par défaut si aucune table n'est sélectionnée
        $table = "PARTICIPANT";
    }
    
    

    // Vérifier si l'identifiant de l'élément est passé en tant que paramètre GET
    if(isset($_GET['id'])) {
        // Récupérer l'identifiant de l'élément depuis le paramètre GET
        $id = $_GET['id'];
        $nomcle="";
        if($table=="PARTICIPANT") $nomcle="NUM_P";
        if($table=="EQUIPE") $nomcle="NUM_EQ";
        if($table=="COMPETITION") $nomcle="NUM_C";
        
        

        // Séparer l'identifiant en attribut et valeur
       
       

        // Requête SQL de base
        $BASEsql = "SELECT * FROM $table WHERE $nomcle = '$id'";

     

        $stmt = oci_parse($conn, $BASEsql);
        oci_execute($stmt);

        // Vérifier s'il y a des résultats
        
            // Afficher les détails de l'élément
            echo "<h2>Détails de l'élément :</h2>";
            echo "<table>";
           while ($row = oci_fetch_assoc($stmt)) {
            foreach ($row as $key => $value) {
                echo "<tr><td>$key :</td><td>$value</td></tr>";
            }
            echo "</table>";

        }
       }
       

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/png" href="res/favicon.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php  ?></title>
</head>
<body>
 <div><a href="deconnexion.php">D&eacuteconnexion</a>
            <a href="recherche.php">Retour</a>
    </div>
    

</body>
</html>

<?php 

}else{
    header("Location: index.php");
    exit();
}
?>

