<?php
session_start();
if(isset($_SESSION['Num_Comit'])){
    include 'myparam.inc.php';

 // Paramètres de connexion Oracle
    $tns = MYHOST;
    $username = MYUSER;
    $password = MYPASS;

    // Connexion à la base de données Oracle
    $conn = oci_connect($username, $password, $tns);

    // Vérification de la connexion à la base de données Oracle
    if (!$conn) {
        die("Connexion Impossible : " . oci_error());
    }

    function ajouterParticipant($nom, $prenom, $DateNaissance, $idp, $nat, $idc) {
        global $conn;
        if(empty($nom) || empty($prenom) || empty($DateNaissance) || empty($nat) || empty($idc) || empty($idp)) {
            echo "Tous les champs sont requis.";
            return;
        }
        $sql = "INSERT INTO Participant (Nom_P, Prenom_P, DateNaissanceP, Num_P, Nationalite_P, Num_Chambre) 
                VALUES ('$nom', '$prenom', TO_DATE('$DateNaissance','DD/MM/YYYY'), '$idp', '$nat', '$idc')";
        $stmt = oci_parse($conn, $sql);
        if (oci_execute($stmt)) {
            echo "Participant ajouté";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt)['message']);
        }
    }

    function supprimerParticipant($id) {
        global $conn;
        $sql = "DELETE FROM Participant 
                WHERE Num_P='$id'";
        $stmt = oci_parse($conn, $sql);
        if (oci_execute($stmt)) {
            echo "Participant supprimé";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt)['message']);
        }
    }

    function modifierParticipant($id, $idc, $nom, $prenom, $nat, $DateNaissance) {
        global $conn;
        if(empty($nom) || empty($prenom) || empty($DateNaissance) || empty($nat) || empty($idc)) {
            echo "Tous les champs sont requis.";
            return;
        }
        $sql = "UPDATE Participant SET Nom_P='$nom', Prenom_P='$prenom', DateNaissanceP='$DateNaissance', Num_Chambre='$idc', Nationalite_P='$nat'
                WHERE Num_P='$id'";
              $sql =str_replace('   ','', $sql);
        $stmt = oci_parse($conn, $sql);
        if (oci_execute($stmt)) {
            echo "Participant modifié";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt)['message']);
        }
    }
    
     function ajouterEquipe($num, $result, $nb, $numd, $nume, $numa) {
        global $conn;
        if(empty($num) || empty($result) || empty($nb) || empty($nume) || empty($numa) || empty($numd)) {
            echo "Tous les champs sont requis.";
            return;
        }
        $sql = "INSERT INTO Equipe (NUM_EQ, RESULTAT_EQ, NB_ATHLETES, NUM_D, NUM_ENTRAINEUR, NUM_ARBITRE) 
                VALUES ('$num', '$result', $nb , '$numd', '$nume', '$numa')";
        $stmt2 = oci_parse($conn, $sql);
        if (oci_execute($stmt2)) {
            echo "Equipe ajouté";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt2)['message']);
        }
    }

    function supprimerEquipe($id) {
        global $conn;
        $sql = "DELETE FROM EQUIPE 
                WHERE NUM_EQ='$id'";
        $stmt2 = oci_parse($conn, $sql);
        if (oci_execute($stmt2)) {
            echo "Equipe supprimé";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt2)['message']);
        }
    }

    function modifierEquipe($num, $result, $nb, $numd, $nume, $numa) {
        global $conn;
        if(empty($num) || empty($result) || empty($nb) || empty($numd) || empty($numa)) {
            echo "Tous les champs sont requis.";
            return;
        }
        $sql = "UPDATE Equipe SET NUM_ARBITRE='$numa', RESULTAT_EQ='$result', NB_ATHLETES='$nb', NUM_D='$numd', NUM_ENTRAINEUR='$nume'
                WHERE NUM_EQ='$num'";
              $sql =str_replace('   ','', $sql);
        $stmt2 = oci_parse($conn, $sql);
        if (oci_execute($stmt2)) {
            echo "Equipe modifié";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt2)['message']);
        }
    }
    
    function ajouterDiscipline($numd, $nomd, $record, $numc) {
        global $conn;
        if(empty($numd) || empty($nomd) || empty($record) || empty($numc)) {
            echo "Tous les champs sont requis.";
            return;
        }
        $sql = "INSERT INTO Discipline (NUM_D, NOM_D, RECORD_D, NUM_D, NUM_C) 
                VALUES ('$numd', '$nomd', '$record' , '$numc')";
        $stmt3 = oci_parse($conn, $sql);
        if (oci_execute($stmt3)) {
            echo "Equipe ajouté";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt3)['message']);
        }
    }

    function supprimerDiscipline($numd) {
        global $conn;
        $sql = "DELETE FROM Discipline 
                WHERE NUM_D='$numd'";
        $stmt3 = oci_parse($conn, $sql);
        if (oci_execute($stmt3)) {
            echo "Discipline supprimé";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt3)['message']);
        }
    }

    function modifierDiscipline($numd, $nomd, $record, $numc) {
        global $conn;
        if(empty($numd) || empty($nomd) || empty($record) || empty($numc)) {
            echo "Tous les champs sont requis.";
            return;
        }
        $sql = "UPDATE Discipline SET NOM_D='$nomd', RECORD_D='$record', NUM_C='$numc'
                WHERE NUM_D='$numd'";
              $sql =str_replace('   ','', $sql);
        $stmt3 = oci_parse($conn, $sql);
        if (oci_execute($stmt3)) {
            echo "Discipline modifié";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt3)['message']);
        }
    }
    
    
    function ajouterPersonnel($numperso, $typep, $villep, $datep, $numa, $nump) {
        global $conn;
        if(empty($numperso) || empty($typep) || empty($villep) || empty($datep)  || empty($numa) || empty($nump)) {
            echo "Tous les champs sont requis.";
            return;
        }
        $sql = "INSERT INTO Personnel (NUM_PERSO, TYPE_PERSO, VILLE_PERSO, DATENAISSANCEP, NUM_ARBITRE, NUM_P) 
                VALUES ('$numperso', '$typep', '$villep' , TO_DATE('$datep','DD/MM/YYYY'), '$numa', '$nump'; ";
        $stmt4 = oci_parse($conn, $sql);
        if (oci_execute($stmt4)) {
            echo "Personnel ajouté";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt3)['message']);
        }
    }

    function supprimerPersonnel($numd) {
        global $conn;
        $sql = "DELETE FROM Personnel 
                WHERE NUM_PERSO='$numd'";
        $stmt4 = oci_parse($conn, $sql);
        if (oci_execute($stmt4)) {
            echo "Discipline supprimé";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt4)['message']);
        }
    }

    function modifierPersonnel($numperso, $typep, $villep, $datep, $numa, $nump) {
        global $conn;
        if(empty($numperso) || empty($typep) || empty($villep) || empty($datep) || empty($numa) || empty($nump) ) {
            echo "Tous les champs sont requis.";
            return;
        }
        $sql = "UPDATE Personnel SET NUM_PERSO='$nomd', TYPE_PERSO='$record', VILLE_PERSO='$numc', DATENAISSANCEP=TO_DATE('$datep','DD/MM/YYYY'), NUM_A='$numA', NUM_P='$nump'
                WHERE NUM_D='$numperso'";
              $sql =str_replace('   ','', $sql);
        $stmt4 = oci_parse($conn, $sql);
        if (oci_execute($stmt4)) {
            echo "Personnel modifié";
        } else {
            echo "Erreur: " . htmlentities(oci_error($stmt3)['message']);
        }
    }


    // Traitement des actions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['ajouter'])) {
            ajouterParticipant($_POST['nom'], $_POST['prenom'], $_POST['age'], $_POST['idp'], $_POST['nat'], $_POST['idc']);
        } elseif (isset($_POST['supprimer'])) {
            supprimerParticipant($_POST['id']);
        } elseif (isset($_POST['modifier'])) {
            $id = $_POST['id'];
            $idc = $_POST['idc'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $nat = $_POST['nat'];
            $DateNaissance = $_POST['age'];
            modifierParticipant($id, $idc, $nom, $prenom, $nat, $DateNaissance);
        }
        
  
         if (isset($_POST['ajouter1'])) {
            ajouterEquipe($_POST['numE'], $_POST['resultatE'], $_POST['nbE'], $_POST['idD'], $_POST['idE'], $_POST['idA']);
        } elseif (isset($_POST['supprimer1'])) {
            supprimerEquipe($_POST['id']);
        } elseif (isset($_POST['modifier1'])) {
            $num = $_POST['numE'];
            $result = $_POST['resultatE'];
            $numd = $_POST['idD'];
            $nume = $_POST['idE'];
            $numa = $_POST['idA'];
            $nb = $_POST['nbE'];
            modifierEquipe($num, $result, $nb, $numd, $nume, $numa);
        }
        // function ajouterDiscipline($numd, $nomd, $record, $numc) {
        //
         if (isset($_POST['ajouter2'])) {
            ajouterDiscipline($_POST['numd'], $_POST['nomd'], $_POST['recordd'], $_POST['numcc']);
        } elseif (isset($_POST['supprimer2'])) {
            supprimerDiscipline($_POST['numd']);
        } elseif (isset($_POST['modifier2'])) {

            $numd = $_POST['numd'];
            $nomd = $_POST['nomd'];
            $record = $_POST['recordd'];
            $numc = $_POST['numcc'];
           modifierDiscipline($numd, $nomd, $record, $numc) ;
        }
        
         if (isset($_POST['ajouter3'])) {
            ajouterPersonnel($_POST['numd'], $_POST['nomd'], $_POST['recordd'], $_POST['numcc']);
        } elseif (isset($_POST['supprimer3'])) {
            supprimerPersonnel($_POST['numd']);
        } elseif (isset($_POST['modifier3'])) {

            $numd = $_POST['numd'];
            $nomd = $_POST['nomd'];
            $record = $_POST['recordd'];
            $numc = $_POST['numcc'];
           ajouterPersonnel($numperso, $typep, $villep, $datep, $numa, $nump) ;
        }
    }

    // Récupérer la liste des participants
    $sql = "SELECT * FROM Participant";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    
    
    $sql2 = "SELECT * FROM Equipe";
    $stmt2 = oci_parse($conn, $sql2);
    oci_execute($stmt2);

    $sql3 = "SELECT * FROM Discpline";
    $stmt3 = oci_parse($conn, $sql3);
    oci_execute($stmt3);
    
    $sql4 = "SELECT * FROM Personnel";
    $stmt4 = oci_parse($conn, $sql4);
    oci_execute($stmt4);
    
    $sql5 = "SELECT * FROM Entraineur";
    $stmt4 = oci_parse($conn, $sql4);
    oci_execute($stmt4);


    $sql6 = "SELECT * FROM Arbitre";
    $stmt6 = oci_parse($conn, $sql6);
    oci_execute($stmt6);

    
    $sql7 = "SELECT * FROM Categorie";
    $stmt7 = oci_parse($conn, $sql7);
    oci_execute($stmt7);

   
    $sql8 = "SELECT * FROM Competition";
    $stmt8 = oci_parse($conn, $sql8);
    oci_execute($stmt8);




?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des participants</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/png" href="res/favicon.png">
</head>
<body>
    <div>
    <a href="deconnexion.php">Déconnexion</a>
    <a href="pageacceuil.php">Retour</a>
    
    </div>
    <h2>Liste des participants</h2>
    <div class="scrolltable">
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de Naissance</th>
                <th>Numéro de Chambre</th>
                <th>Nationalité</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = oci_fetch_assoc($stmt)) {
           
                echo "<tr>";
                echo "<td>".$row['NOM_P']."</td>";
                echo "<td>".$row['PRENOM_P']."</td>";
                echo "<td>".$row['DATENAISSANCEP']."</td>";
                echo "<td>".$row['NUM_CHAMBRE']."</td>";
                echo "<td>".$row['NATIONALITE_P']."</td>";
                echo "<td>
                        <form method='POST' action='gestion.php'>
                            <input type='hidden' name='id' value='".$row['NUM_P']."'>
                            <input type='text' name='nom' value='" .$row['NOM_P'] . "' required>
                            <input type='text' name='prenom' value='".$row['PRENOM_P']."' required>
                            <input type='text' name='age' value='".$row['DATENAISSANCEP']."' required>
                            <input type='text' name='idc' value='".$row['NUM_CHAMBRE']."' required>
                            <input type='text' name='nat' value='". $row['NATIONALITE_P']."' required>
                            <input type='submit' name='modifier' value='Modifier'>
                            <input type='submit' name='supprimer' value='Supprimer'>
                        </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <h2>Ajouter un participant</h2>
    <div class="form_a-m-s">
       <form method="POST" action="gestion.php">
            Nom: <input type="text" name="nom" required><br>
            Prénom: <input type="text" name="prenom" required><br>
            Date de Naissance: <input type="text" name="age" required><br>
            Identifiant: <input type="text" name="idp" required><br>
            Numéro de Chambre: <input type="text" name="idc" required><br>
            Nationalité: <input type="text" name="nat" required><br>
            <input type="submit" name="ajouter" value="Ajouter">
        </form>
    </div>
    
    <div class="scrolltable">
     <table>
            <h2>Liste des &eacutequipes</h2>
            <tr>

                <th>RESULTAT_EQ</th>
                <th>NB_ATHLETES</th>
                <th>NUM_D</th>
                <th>NUM_E</th>
                <th>NUM_A</th>
            </tr>
            <?php
            while ($row2 = oci_fetch_assoc($stmt2)) {
           
                echo "<tr>";
                echo "<td>".$row2['RESULTAT_EQ']."</td>";
                echo "<td>".$row2['NB_ATHLETES']."</td>";
                echo "<td>".$row2['NUM_D']."</td>";
                echo "<td>".$row2['NUM_E']."</td>";
                echo "<td>".$row2['NUM_A']."</td>";
                echo "<td>
                        <form method='POST' action='gestion.php'>
                         <input type='hidden' name='resultatE' value='" .$row2['NUM_EQ'] . "' required>
                            <input type='text' name='resultatE' value='" .$row2['RESULTAT_EQ'] . "' required>
                            <input type='text' name='nbE' value='".$row2['NB_ATHLETES']."' required>
                            <input type='text' name='idD' value='".$row2['NUM_D']."' required>
                            <input type='text' name='idE' value='".$row2['NUM_E']."' required>
                            <input type='text' name='idA' value='". $row2['NUM_A']."' required>
                            <input type='submit' name='modifier1' value='Modifier'>
                            <input type='submit' name='supprimer1' value='Supprimer'>
                        </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
        
        </div>
         <div class="form_a-m-s">
          <form method="POST" action="gestion.php">
            Numero d'&eacutequipe: <input type="text" name="numE" required><br>
            Résultat: <input type="text" name="resultatE" required><br>
            Nombre d'athlètes: <input type="text" name="nbE" required><br>
            ID Discipline: <input type="text" name="idD" required><br>
            ID Entraineur: <input type="text" name="idE" required><br>
            ID Arbitre: <input type="text" name="idA" required><br>
            <input type="submit" name="ajouter1" value="Ajouter">
        </form>
    </div>   
    
        <div class="scrolltable">
     <table>
            <h2>Liste des Discipline</h2>
             <tr>

                <th>NOM_D</th>
                <th>RECORD_D</th>
                <th>NUM_C</th>
            </tr>
            <?php
            while ($row3 = oci_fetch_assoc($stmt3)) {
           
                echo "<tr>";

                echo "<td>".$row3['NOM_D']."</td>";
                echo "<td>".$row3['RECORD_D']."</td>";
                echo "<td>".$row3['NUM_C']."</td>";
                echo "<td>
                        <form method='POST' action='gestion.php'>
                            <input type='hidden' name='numd' value='" .$row3['NUM_D'] . "' required>

                            <input type='text' name='nomd' value='" .$row3['NOM_D'] . "' required>
                            <input type='text' name='recordd' value='".$row3['RECORD_D']."' required>
                            <input type='text' name='numcc' value='".$row3['NUM_C']."' required>
                            <input type='submit' name='modifier2' value='Modifier'>
                            <input type='submit' name='supprimer2' value='Supprimer'>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
        

      </div>
       <div class="form_a-m-s">
          <form method="POST" action="gestion.php">
            NUM_D: <input type="text" name="numd" required><br>
            NOM_D: <input type="text" name="nomd" required><br>
            RECORD_D: <input type="text" name="recordd" required><br>
            NUM_C: <input type="text" name="numcc" required><br>
            <input type="submit" name="ajouter2" value="Ajouter">
        </form>
       </div>   
   
   
    <div class="scrolltable">
     <table>
            <h2>Liste des Personnel</h2>
             <tr>

                <th>Type_Perso</th>
                <th>Ville_Perso</th>
                <th>DateNaissanceP</th>
                <th>Num_Arbitre</th>
                <th>Num_P</th>
            </tr>
            <?php
            while ($row4 = oci_fetch_assoc($stmt4)) {
           
                echo "<tr>";

                echo "<td>".$row4['TYPE_PERSO']."</td>";
                echo "<td>".$row4['VILLE_PERSO']."</td>";
                echo "<td>".$row4['DATENAISSANCEP']."</td>";
                echo "<td>".$row4['NUM_ARBITRE']."</td>";
                echo "<td>".$row4['NUM_P']."</td>";
                echo "<td>
                        <form method='POST' action='gestion.php'>
                         <input type='hidden' name='nomd' value='" .$row4['NUM_PERSO'] . "' required>
                            <input type='text' name='nomd' value='" .$row4['TYPE_PERSO'] . "' required>
                            <input type='text' name='recordd' value='".$row4['VILLE_PERSO']."' required>
                            <input type='text' name='numcc' value='".$row4['DATENAISSANCEP']."' required>
                            <input type='text' name='numcc' value='".$row4['NUM_ARBITRE']."' required>
                            <input type='text' name='numcc' value='".$row4['NUM_P']."' required>                  
                            <input type='submit' name='modifier3' value='Modifier'>
                            <input type='submit' name='supprimer3' value='Supprimer'>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
        

      </div>
       <div class="form_a-m-s">
          <form method="POST" action="gestion.php">
            NUM_PERSO: <input type="text" name="numperso" required><br>
            Type_Perso: <input type="text" name="typeperso" required><br>
            Ville_Perso: <input type="text" name="villeperso" required><br>
            DateNaissanceP: <input type="text" name="dateperso" required><br>
            Num_Arbitre: <input type="text" name="numarbitre" required><br>
            Num_P: <input type="text" name="numpart" required><br>
            <input type="submit" name="ajouter3" value="Ajouter">
        </form>
       </div>   
   
</body>
</html>

<?php
}else{
    oci_close($conn);
    header("Location: index.php");
    exit();
}

$conn->close();
?>

