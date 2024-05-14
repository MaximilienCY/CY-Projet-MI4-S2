<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Génération de l'identifiant utilisateur unique
    $user_id = "user_" . uniqid();

    $username = $_POST['username'];
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
    $data = $user_id . "," . $username . "," . $password . "," . $gender . "," . $birthdate . "," . $profession . "," . $residence . "," . $relationship_status . "," . $physical_description . "," . $personal_info . "," . $photo_address . "\n";

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

