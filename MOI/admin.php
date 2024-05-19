<?php

function banUser($email) {
    $users = file("utilisateurs.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($users as $key => $user) {
        $data = explode(",", $user);

        if ($data[3] === $email) {
            $data[14] = "oui";
            $users[$key] = implode(",", $data);
            break;
        }
    }

    file_put_contents("utilisateurs.txt", implode("\n", $users));
}

function getBannedUsers() {
    // Ouvrir le fichier utilisateurs.txt en mode lecture
    $file = fopen("utilisateurs.txt", "r");

    // Lire le contenu du fichier et le stocker dans un tableau
    $users = [];
    while (!feof($file)) {
        $user = fgets($file);
        $users[] = $user;
    }

    // Fermer le fichier
    fclose($file);

    // Parcourir le tableau des utilisateurs pour trouver les utilisateurs bannis
    $bannedUsers = [];
    foreach ($users as $user) {
        $data = explode(",", $user);
        if ($data[14] == "oui") {
            // Ajouter l'utilisateur banni au tableau
            $bannedUsers[] = $data;
        }
    }

    // Retourner le tableau des utilisateurs bannis
    return $bannedUsers;
}

function getUsers() {
    // Ouvrir le fichier utilisateurs.txt en mode lecture
    $file = fopen("utilisateurs.txt", "r");

    // Lire le contenu du fichier et le stocker dans un tableau
    $users = [];
    while (!feof($file)) {
        $user = fgets($file);
        $users[] = $user;
    }

    // Fermer le fichier
    fclose($file);

    // Retourner le tableau des utilisateurs
    return $users;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Utilisateurs</title>
</head>
<body>
<h1>Utilisateurs</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Mot de passe</th>
        <th>Genre</th>
        <th>Date de naissance</th>
        <th>Profession</th>
        <th>Résidence</th>
        <th>Statut de la relation</th>
        <th>Description physique</th>
        <th>Informations personnelles</th>
        <th>Adresse de la photo</th>
        <th>Type d'utilisateur</th>
        <th>Ban</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php

    if (isset($_POST['ban']) && isset($_POST['email'])) {
        $email = $_POST['email'];
        banUser($email);
    }

    // Appeler la fonction pour récupérer tous les utilisateurs
    $users = getUsers();

    // Parcourir le tableau des utilisateurs pour afficher leurs informations
    foreach ($users as $user) {
        $data = explode(",", $user);
        echo "<tr>";
        foreach ($data as $field) {
            echo "<td>" . htmlspecialchars($field) . "</td>";
        }

        echo "<td>";
        echo "<form action='admin.php' method='post'>";
        echo "<input type='hidden' name='email' value='" . htmlspecialchars($data[3]) . "'>";
        echo "<input type='submit' name='ban' value='Bannir'>";
        echo "</form>";
        echo "</td>";


        echo "</tr>";
    }

    ?>
    </tbody>
</table>
</body>
</html>