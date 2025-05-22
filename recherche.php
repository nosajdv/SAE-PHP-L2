<?php
session_start();
// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['Num_Comit'])) {

    include 'myparam.inc.php';
    /* Paramètres de connexion pour mon PC perso */
    $servernom = MYHOST;
    $identif = MYUSER;
    $password = MYPASS;

    $connexion = oci_connect($identif, $password, $servernom);
    // Connexion à la base + vérification
    if (!$connexion) {
        $e = oci_error();
        die(htmlentities($e['message'], ENT_QUOTES) . "Connexion Impossible");
    }

    // Fonction pour vérifier si une colonne existe dans ma table
    function colonneExists($connexion, $table, $column)
    {
        $table=strtoupper($table);
        $column=strtoupper($column);
        $BASEsql = "SELECT column_name FROM all_tab_columns WHERE table_name = '$table' AND column_name = '$column'";
        $resultat = oci_parse($connexion, $BASEsql);
        oci_execute($resultat);
        return oci_fetch($resultat);
    }

    // Initialisation des variables
    $requete_recherche = "";
    $error_message = isset($_GET['error']) ? $_GET['error'] : '';

    // Détermination de la table à partir du paramètre d'URL
 
   
   if(!empty($_GET['parti'])){

   $table="PARTICIPANT";
   }else if(!empty($_GET['equipe'])){

   $table="EQUIPE";
   }else if(!empty($_GET['compet'])){
 
   $table="COMPETITION";
   }
   
   
   $cmpt=0;
    
    
    // Vérification de l'existence du paramètre de recherche
    if (isset($_GET['recherche_participant_nom']) || isset($_GET['recherche_equipe_nat']) || isset($_GET['recherche_competition_pays'])) {
        // Récupération des valeurs des paramètres de recherche
        $nom = $_GET['recherche_participant_nom'];
        $nat= $_GET['recherche_equipe_nat'];
        $prenom =$_GET['recherche_participant_prenom'];
        $nationalite = $_GET['recherche_participant_nationalite'];
        $numero_equipe = $_GET['recherche_equipe_numero'];
        $pays_competition = $_GET['recherche_competition_pays'];
        $numero_competition = $_GET['recherche_competition_numero'];

        // Analyse des valeurs pour construire les critères de recherche
        $critere = [];
        if (!empty($nom)) {
            $critere[] = "NOM_P = '$nom'";
        }
         if (!empty($nat)) {
            $critere[] = "NATIONALITE_EQ = '$nat'";
        }
        if (!empty($prenom)) {
            $critere[] = "PRENOM_P = '$prenom'";
        }
        if (!empty($nationalite)) {
            $critere[] = "NATIONALITE_P = '$nationalite'";
        }
        if (!empty($numero_equipe)) {
            $critere[] = "NUM_EQ = '$numero_equipe'";
        }
        if (!empty($pays_competition)) {
            $critere[] = "PAYS_COMP = '$pays_competition'";
        }
        if (!empty($numero_competition)) {
            $critere[] = "NUMERO_COMP = '$numero_competition'";
        }
  
        // Construction de la base de la requête SQL
        $BASEsql = "SELECT * FROM $table";

        if (!empty($critere)) {
            $BASEsql .= " WHERE " . implode(" AND ", $critere);
        }
       
        // Exécution de la requête SQL
       // echo $BASEsql;
        $resultat = oci_parse($connexion, $BASEsql);
         oci_execute($resultat);
         
        
       while($col=oci_fetch_array($resultat)){
          if($table=="PARTICIPANT")
          $url='details.php?table='.$table.'&id='. $col['NUM_P'];
          
          
          if($table=="EQUIPE")
          $url='details.php?table='.$table .'&id='. $col['NUM_EQ'];
          
          if($table=="COMPETITION")
          $url='details.php?table='.$table.'&id='. $col['NUM_C'];
          
          $hyperlien = "<a href='$url'>Details</a><br>";
          echo $hyperlien;
          
          //echo $col;
          $cmpt++;
       }
       
       

     oci_free_statement($resultat);
   }
     if($cmpt==0){
               echo '<p id=error1> Aucun résultat trouvé </p>';

            }
     
    oci_close($connexion);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="res/favicon.png">
    <script type="text/javascript" src="message.js"></script>  
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'informations</title>
    
</head>
<body>
    <h1>Recherche d'informations</h1>
    <p id="error1"> <?php echo $error_message; ?></p>

    <form method="GET" action="recherche.php">
    <input type="checkbox" name="parti" id="parti" onchange="myFunction1()" required><br>
    <h2>Participant</h2>
    <label for="recherche_participant_nom">Nom :</label><br>
    <input type="text" id="recherche_participant_nom" name="recherche_participant_nom"><br>
    <label for="recherche_participant_prenom">Prénom :</label><br>
    <input type="text" id="recherche_participant_prenom" name="recherche_participant_prenom"><br>
    <label for="recherche_participant_nationalite">Nationalité :</label><br>
    <input type="text" id="recherche_participant_nationalite" name="recherche_participant_nationalite"><br>
    <input type="submit" value="Rechercher" id="btn1"><br>

    <input type="checkbox" name="equipe" id="equipe" onchange="myFunction2()" required><br>
    <h2>Equipe</h2>
    <label for="recherche_equipe_nat">Nationalit&eacute &eacutequipe :</label><br>
    <input type="text" id="recherche_equipe_nat" name="recherche_equipe_nat"><br>
    <label for="recherche_equipe_numero">Numéro d'&eacutequipe :</label><br>
    <input type="text" id="recherche_equipe_numero" name="recherche_equipe_numero"><br>
    <input type="submit" value="Rechercher" id="btn2"><br>

    <input type="checkbox" name="compet" id="compet" onchange="myFunction3()" required><br>
    <h2>Compétition</h2>
    <label for="recherche_competition_pays">Pays :</label><br>
    <input type="text" id="recherche_competition_pays" name="recherche_competition_pays" ><br>
    <label for="recherche_competition_numero">Num&eacutero :</label><br>
    <input type="text" id="recherche_competition_numero" name="recherche_competition_numero"><br>
    <input type="submit" value="Rechercher" id="btn3"><br>
</form>

    <div><a href="deconnexion.php">D&eacuteconnexion</a>
            <a href="pageacceuil.php">Retour</a>
    </div>
    
  

</body>
<script>
function myFunction1() {
var checkBox = document.getElementById("parti");
if (checkBox.checked == true){
  document.getElementById("compet").disabled = true;
  document.getElementById("equipe").disabled = true;
  
  document.getElementById("recherche_equipe_numero").disabled = true;
  document.getElementById("recherche_equipe_nat").disabled = true;
  document.getElementById("recherche_competition_pays").disabled = true;
  document.getElementById("recherche_competition_numero").disabled = true;
  document.getElementById("btn2").disabled = true;
   document.getElementById("btn3").disabled = true;
   }else{
   document.getElementById("compet").disabled = false;
  document.getElementById("equipe").disabled = false;
  
  document.getElementById("recherche_equipe_numero").disabled = false;
  document.getElementById("recherche_equipe_nat").disabled = false;
   document.getElementById("recherche_competition_pays").disabled = false;
  document.getElementById("recherche_competition_numero").disabled = false;
  document.getElementById("btn2").disabled = false;
   document.getElementById("btn3").disabled = false;
   
   }

}

function myFunction2() {  
   
var checkBox = document.getElementById("equipe");
if (checkBox.checked == true){
  document.getElementById("parti").disabled = true;
  document.getElementById("compet").disabled = true;
  
  document.getElementById("recherche_competition_pays").disabled = true;
  document.getElementById("recherche_competition_numero").disabled = true;
  document.getElementById("recherche_participant_nom").disabled = true;
  document.getElementById("recherche_participant_prenom").disabled = true;
  document.getElementById("recherche_participant_nationalite").disabled = true;
    document.getElementById("btn1").disabled = true;
   document.getElementById("btn3").disabled = true;
}else{
  document.getElementById("parti").disabled = false;
  document.getElementById("compet").disabled = false;
  
  document.getElementById("recherche_competition_pays").disabled = false;
  document.getElementById("recherche_competition_numero").disabled = false;
  document.getElementById("recherche_participant_nom").disabled = false;
  document.getElementById("recherche_participant_prenom").disabled = false;
  document.getElementById("recherche_participant_nationalite").disabled = false;
  document.getElementById("btn1").disabled = false;
  document.getElementById("btn3").disabled = false;


}
}


function myFunction3() {
var checkBox = document.getElementById("compet");
if (checkBox.checked == true){
  document.getElementById("parti").disabled = true;
  document.getElementById("equipe").disabled = true;
  
  document.getElementById("recherche_equipe_nat").disabled = true;
  document.getElementById("recherche_equipe_numero").disabled = true;
  document.getElementById("recherche_participant_nom").disabled = true;
  document.getElementById("recherche_participant_prenom").disabled = true;
  document.getElementById("recherche_participant_nationalite").disabled = true;
    document.getElementById("btn1").disabled = true;
   document.getElementById("btn2").disabled = true;
}else{
  document.getElementById("parti").disabled = false;
  document.getElementById("equipe").disabled = false;
  
  document.getElementById("recherche_equipe_nat").disabled = false;
  document.getElementById("recherche_equipe_numero").disabled = false;
  document.getElementById("recherche_participant_nom").disabled = false;
  document.getElementById("recherche_participant_prenom").disabled = false;
  document.getElementById("recherche_participant_nationalite").disabled = false;
  document.getElementById("btn1").disabled = false;
  document.getElementById("btn2").disabled = false;
}
}
</script>

</html>
<?php
}
else{
    header("Location: index.php");
    exit();
}
?>
