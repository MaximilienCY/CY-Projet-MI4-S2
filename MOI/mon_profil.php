<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Profil de l'utilisateur</h1>
        <?php
        require_once 'fonctions.php';

        // Variable pour stocker le message de succès ou d'erreur
        $message = "Succès";

        // Vérifier si le formulaire de modification a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Mettre à jour les données de l'utilisateur dans le fichier utilisateurs.txt
            if (updateUserData($_POST)) {
                $message = "Modification bien enregistrée.";
            } else {
                $message = "Modification non enregistrée. Erreur.";
            }
            // Rediriger l'utilisateur vers index.php
            header("Location: index.php");
            exit; // Assure que le script ne continue pas à s'exécuter après la redirection
        }

        // Récupérer les données de l'utilisateur connecté
        $userData = getConnectedUserData();

        // Vérifier si des données ont été récupérées
        if (!empty($userData)) {
            echo "<h2>Informations de l'utilisateur</h2>";
            echo "<p>$message</p>"; // Afficher le message de succès ou d'erreur
            echo "<form method='post'>";
            echo "<ul>";
            echo "<li><strong>Identifiant:</strong> " . $userData['user_id'] . "</li>";
            echo "<li><label for='first_name'>Prénom:</label> <input type='text' name='first_name' id='first_name' value='" . $userData['first_name'] . "'></li>";
            echo "<li><label for='last_name'>Nom:</label> <input type='text' name='last_name' id='last_name' value='" . $userData['name'] . "'></li>";
            echo "<li><label for='email'>Email:</label> <input type='email' name='email' id='email' value='" . $userData['email'] . "'></li>";
            echo "<li><label>Sexe:</label> 
                    <select name='gender' id='gender'>
                        <option value='homme'" . ($userData['gender'] == 'homme' ? ' selected' : '') . ">Homme</option>
                        <option value='femme'" . ($userData['gender'] == 'femme' ? ' selected' : '') . ">Femme</option>
                        <option value='autre'" . ($userData['gender'] == 'autre' ? ' selected' : '') . ">Autre</option>
                    </select>
                </li>";
            echo "<li><label for='birthdate'>Date de naissance:</label> <input type='date' name='birthdate' id='birthdate' value='" . $userData['birthdate'] . "'></li>";
            echo "<li><label for='profession'>Profession:</label> <input type='text' name='profession' id='profession' value='" . $userData['profession'] . "'></li>";
            echo "<li><label for='residence'>Résidence:</label> <input type='text' name='residence' id='residence' value='" . $userData['residence'] . "'></li>";
            echo "<li><label for='relationship_status'>Statut relationnel:</label> <input type='text' name='relationship_status' id='relationship_status' value='" . $userData['relationship_status'] . "'></li>";
            echo "<li><label for='physical_description'>Description physique:</label> <input type='text' name='physical_description' id='physical_description' value='" . $userData['physical_description'] . "'></li>";
            echo "<li><label for='personal_info'>Informations personnelles:</label> <textarea name='personal_info' id='personal_info'>" . $userData['personal_info'] . "</textarea></li>";
            echo "<li><label for='photo'>Photo:</label> <input type='file' name='photo' id='photo' accept='image/*' value='" . $userData['photo'] . "'></li>";
            echo "</ul>";
            echo "<input type='submit' value='Enregistrer les modifications'>";
            echo "</form>";
        } else {
            echo "<p>Aucune donnée d'utilisateur trouvée.</p>";
        }
        ?>
    </div>
</body>
</html>
