<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Génération de l'identifiant utilisateur unique
    $user_id = "user_" . uniqid();

    $first_name = $_POST['first_name'];
    $name = $_POST['name'];
    $mail = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $profession = $_POST['profession'];
    $residence = $_POST['residence'];
    $relationship_status = $_POST['relationship_status'];
    $physical_description = $_POST['physical_description'];
    $personal_info = $_POST['personal_info'];

    // Traitement de l'image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    $photo_address = $target_file;

    // Formatage des données pour le stockage dans le fichier
    $data = $user_id . "," . $first_name . "," . $name . "," . $mail . "," . $password . "," . $gender . "," . $birthdate . "," . $profession . "," . $residence . "," . $relationship_status . "," . $physical_description . "," . $personal_info . "," . $photo_address . "\n";

    // Ouverture du fichier en mode append
    $file = fopen("utilisateurs.txt", "a");

    // Écriture des données dans le fichier
    fwrite($file, $data);

    // Fermeture du fichier
    fclose($file);

    // Redirection vers la page de connexion après l'inscription
    header("Location: connexion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Inscription</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>S'inscrire</header>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="field input">
                    <label for="first_name">Prénom</label>
                    <input type="text" name="first_name" autocomplete="off" required><br>
                </div>
                <div class="field input">
                    <label for="name">Nom</label>
                    <input type="text" name="name" autocomplete="off" required><br>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" autocomplete="off" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"><br>
                </div>
                <div class="field input">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" autocomplete="off" required><br>
                </div>
                <div class="field input">
                    <label for="gender">Sexe</label>
                    <select name="gender" required>
                        <option value="">Choisissez...</option>
                        <option value="femme">Femme</option>
                        <option value="homme">Homme</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                <div class="field input">
                    <label for="birthdate">Date de naissance</label>
                    <input type="date" name="birthdate" autocomplete="off" required><br>
                </div>
                <div class="field input">
                    <label for="profession">Profession</label>
                    <input type="text" name="profession" autocomplete="off" required><br>
                </div>
                <div class="field input">
                    <label for="residence">Lieu de résidence</label>
                    <input type="text" name="residence" autocomplete="off" required><br>
                </div>
                <div class="field input">
                    <label for="relationship_status">Relations amoureuses et familiales</label>
                    <input type="text" name="relationship_status" autocomplete="off" required><br>
                </div>
                <div class="field input">
                    <label for="physical_description">Description physique</label>
                    <input type="text" name="physical_description" autocomplete="off" required><br>
                </div>
                <div class="field input">
                    <label for="personal_info">Informations personnelles</label>
                    <textarea name="personal_info"></textarea><br>
                </div>
                <div class="field input">
                    <label for="photo">Photo</label>
                    <input type="file" name="photo" accept="image/*"><br>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="S'inscrire" required>
                </div>
                <div class="links">
                    Déjà inscrit ? <a href="connexion.php">Se connecter</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

