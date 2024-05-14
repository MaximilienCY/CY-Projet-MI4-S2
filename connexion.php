<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Connexion</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="traitement_connexion.php" method="post"> <!-- Ajout de l'action -->
                <div class="field input">
                    <label for="mail">Email</label>
                    <input type="email" name="mail" id="mail" autocomplete="off" required> <!-- Correction du type d'entrée -->
                </div>

                <div class="field input">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login"> <!-- Suppression de l'attribut required ici -->
                </div>
                <div class="links">
                    Pas encore inscrit(e) ? <a href="inscription.php">S'inscrire ici</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $file = fopen("utilisateurs.txt", "r");
    $found = false;
    while (!feof($file)) {
        $line = fgets($file);
        $data = explode(",", $line);
        if ($data[3] == $mail && trim($data[4]) == $password) {
            $found = true;
            break;
        }
    }
    fclose($file);
    if ($found) {
        echo "Vous êtes connecté.";
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

