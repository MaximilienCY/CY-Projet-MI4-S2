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
            <form action="" method="post"> <!-- Utilisation de la même action pour les deux formulaires -->
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required> <!-- Correction du type d'entrée à email -->
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
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $file = fopen("utilisateurs.txt", "r");
    $found = false;

    while (!feof($file)) {
        $line = fgets($file);
        $data = explode(",", $line);

        // Assuming $data[1] contains the email and $data[2] contains the password
        if ($data[3] == $email && trim($data[4]) == $password) {
            $found = true;
            $user_type = trim($data[13]); // Assuming $data[3] contains the user type
            break;
        }
    }
    fclose($file);

    if ($found) {
        $_SESSION['user_type'] = $user_type;
        header("Location: index.php");
    } else {
        echo "<div class='message'>Nom d'utilisateur ou mot de passe incorrect.</div>";
    }
}
?>
