<?php

function getUserByEmail($email) {
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

    // Parcourir le tableau des utilisateurs pour trouver l'utilisateur avec l'adresse email donnée
    foreach ($users as $user) {
        $data = explode(",", $user);
        if ($data[3] === $email) {
            // Retourner l'utilisateur sous forme de tableau associatif
            return [
                'id' => $data[0],
                'first_name' => $data[1],
                'name' => $data[2],
                'email' => $data[3],
                'password' => $data[4],
                'gender' => $data[5],
                'birthdate' => $data[6],
                'profession' => $data[7],
                'residence' => $data[8],
                'relationship_status' => $data[9],
                'physical_description' => $data[10],
                'personal_info' => $data[11],
                'photo_address' => $data[12],
                'user_type' => $data[13],
                'ban' => $data[14]
            ];
        }
    }

    // Si aucun utilisateur avec l'adresse email donnée n'est trouvé, retourner null
    return null;
}

if (isset($_POST['modifier']) && isset($_POST['email'])) {
    // Récupérer l'utilisateur à modifier
    $user = getUserByEmail($_POST['email']);

    if ($user !== null) {
        // Trouver l'index de l'utilisateur à modifier dans le tableau
        $file = fopen("utilisateurs.txt", "r");
        $users = [];
        $index = -1;
        while (!feof($file)) {
            $userData = fgets($file);
            $data = explode(",", $userData);
            if ($data[3] === $_POST['email']) {
                $index = count($users);
            }
            $users[] = $userData;
        }
        fclose($file);

        // Mettre à jour les informations de l'utilisateur
        $users[$index] = implode(",", [
            $user['id'],
            $_POST['first_name'],
            $_POST['name'],
            $_POST['email'],
            $_POST['password'],
            $_POST['gender'],
            $_POST['birthdate'],
            $_POST['profession'],
            $_POST['residence'],
            $_POST['relationship_status'],
            $_POST['physical_description'],
            $_POST['personal_info'],
            $_POST['photo_address'],
            $_POST['user_type'],
            $user['ban']
        ]);

        // Écrire le contenu du tableau dans le fichier
        $file = fopen("utilisateurs.txt", "w");
        fwrite($file, implode("", $users));
        fclose($file);

        // Rediriger l'utilisateur vers la page d'administration
        header("Location: admin.php");
    } else {
        // Afficher un message d'erreur si l'utilisateur n'est pas trouvé
        echo "Aucun utilisateur avec cet email n'a été trouvé.";
    }
}

// Récupérer l'utilisateur à modifier
$user = getUserByEmail($_POST['email']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier utilisateur</title>
</head>
<body>
<h1>Modifier utilisateur</h1>
<form action="modifier_utilisateur.php" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
    <label for="first_name">User ID : <?php echo htmlspecialchars($user['id']); ?></label>
    <br>
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
    <label for="first_name">Prénom :</label>
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
    <br>
    <label for="name">Nom :</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
    <br>
    <label for="email">Email :</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
    <br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>">
    <br>
    <label for="gender">Genre :</label>
    <input type="text" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>">
    <br>
    <label for="birthdate">Date de naissance :</label>
    <input type="date" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>">
    <br>
    <label for="profession">Profession :</label>
    <input type="text" name="profession" value="<?php echo htmlspecialchars($user['profession']); ?>">
    <br>
    <label for="residence">Résidence :</label>
    <input type="text" name="residence" value="<?php echo htmlspecialchars($user['residence']); ?>">
    <br>
    <label for="relationship_status">Statut de la relation :</label>
    <input type="text" name="relationship_status" value="<?php echo htmlspecialchars($user['relationship_status']); ?>">
    <br>
    <label for="physical_description">Description physique :</label>
    <textarea name="physical_description"><?php echo htmlspecialchars($user['physical_description']); ?></textarea>
    <br>
    <label for="personal_info">Informations personnelles :</label>
    <textarea name="personal_info"><?php echo htmlspecialchars($user['personal_info']); ?></textarea>
    <br>
    <label for="photo_address">Adresse de la photo :</label>
    <input type="text" name="photo_address" value="<?php echo htmlspecialchars($user['photo_address']); ?>">
    <br>
    <label for="user_type">Type d'utilisateur :</label>
    <select name="user_type" id="user_type">
        <option value="utilisateur" <?php if ($user['user_type'] === 'utilisateur') echo 'selected'; ?>>utilisateur</option>
        <option value="administrateur" <?php if ($user['user_type'] === 'administrateur') echo 'selected'; ?>>administrateur</option>
    </select>
    <br>
    <input type="submit" name="modifier" value="Modifier">
</form>
</body>
</html>