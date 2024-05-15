<?php
session_start();

// Vérifie si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données saisies dans le formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Lecture du fichier utilisateurs.txt
    $file = fopen("utilisateurs.txt", "r");

    // Boucle pour rechercher l'utilisateur dans le fichier
    while (!feof($file)) {
        $line = fgets($file);
        $data = explode(",", $line);

        // Vérification des identifiants
        if ($data[3] == $email && trim($data[4]) == $password) {
            // Si les identifiants sont valides, définir les informations de session
            $_SESSION['user_id'] = $data[0]; // ID de l'utilisateur
            $_SESSION['user_type'] = trim($data[13]); // Type d'utilisateur
            fclose($file);

            // Redirection vers la page d'accueil après la connexion
            header("Location: index.php");
            exit();
        }
    }

    // Si les identifiants ne correspondent à aucun utilisateur, afficher un message d'erreur
    echo "<div class='message'>Nom d'utilisateur ou mot de passe incorrect.</div>";
    fclose($file);
}
?>

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
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="links">
                    Pas encore inscrit(e) ? <a href="inscription.php">S'inscrire ici</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
