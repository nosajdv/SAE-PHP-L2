<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeux Olympique - Base de données</title>
    <link rel="icon" type="image/png" href="res/favicon.png">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
        <fieldset>
            <div class="temp">
                <form method="POST" action="identifiant.php">
                    <?php if(isset($_GET['error'])) { ?>
                        <p id="error1"> <?php echo $_GET['error']; ?></p>
                    <?php }?>
                    <label for="fname">Identifiant</label><br>
                    <input type="text" name="Num_Comit" placeholder="Identifiant" required><br>
                    <label for="lname">Mot de passe:</label><br>
                    <input type="password" id="MDP" name="MDP" placeholder="Mot de passe" required><br><br>
                    <input type="submit" value="Renvoyer"><br><br>
                    <input type="checkbox" onclick="myFunction()">Afficher mot de passe
                    <script>
                        function myFunction() {
                          var x = document.getElementById("MDP");
                          if (x.type === "password") {
                            x.type = "text";
                          } else {
                            x.type = "password";
                          }
                        }
                    </script> 
                </form>
            </div>
        </fieldset>
        

        <div class="copyright">
            © 2024 Jeux Olympiques, UPJV L2
        </div>
    

</body>
</html>
