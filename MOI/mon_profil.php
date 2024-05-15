<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="mon_profil.css">
</head>
<body>
    <div class="container">
        <h1>Profil de l'utilisateur</h1>
        <?php
        require_once 'fonctions.php';

        // Récupérer les données de l'utilisateur connecté
        $userData = getConnectedUserData();

        // Variable pour stocker le message de succès ou d'erreur
        $message = "";

        // Vérifier si le formulaire de modification a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Mettre à jour les données de l'utilisateur dans le fichier utilisateurs.txt
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Supprimer l'ancienne image
                if(file_exists($userData['photo'])) {
                    unlink($userData['photo']);
                }
                // Déplacer la nouvelle image téléchargée vers le répertoire uploads
                move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
                // Mettre à jour le chemin de l'image dans les données de l'utilisateur
                $userData['photo'] = $target_file;
            }
            // Mettre à jour les autres champs de données de l'utilisateur
            $userData['first_name'] = $_POST['first_name'];
            $userData['name'] = $_POST['name'];
            $userData['email'] = $_POST['email'];
            $userData['gender'] = $_POST['gender'];
            $userData['birthdate'] = $_POST['birthdate'];
            $userData['profession'] = $_POST['profession'];
            $userData['residence'] = $_POST['residence'];
            $userData['relationship_status'] = $_POST['relationship_status'];
            $userData['physical_description'] = $_POST['physical_description'];
            $userData['personal_info'] = $_POST['personal_info'];
            // Mettre à jour les données de l'utilisateur dans le fichier utilisateurs.txt
            updateUserData($userData);
            $message = "Modification bien enregistrée.";
        }

        // Afficher les données de l'utilisateur
        if (!empty($userData)) {
            echo "<h2>Informations de l'utilisateur</h2>";
            echo "<p>$message</p>"; // Afficher le message de succès ou d'erreur
            echo "<form method='post' enctype='multipart/form-data'>";
            echo "<ul>";
            echo "<li><label for='photo'>Photo:</label> <div class='img-container'><img src='" . $userData['photo'] . "' alt='Photo de profil' style='max-width: 200px;'></div><br>";
            echo "<input type='file' name='photo' id='photo' accept='image/*'></li>";
            echo "<li><strong>Identifiant:</strong> " . $userData['user_id'] . "</li>";
            echo "<li><label for='first_name'>Prénom:</label> <input type='text' name='first_name' id='first_name' value='" . $userData['first_name'] . "'></li>";
            echo "<li><label for='name'>Nom:</label> <input type='text' name='name' id='name' value='" . $userData['name'] . "'></li>";
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
            echo "</ul>";
            echo "<input type='submit' value='Enregistrer les modifications'>";
            echo "</form>";
        } else {
            echo "<p>Aucune donnée d'utilisateur trouvée.</p>";
        }
        ?>
    </div>

    <script>
        // JavaScript pour afficher le message de succès et rediriger vers index.php après la soumission du formulaire
        window.onload = function() {
            var successMessage = document.querySelector('.container p');
            if (successMessage.innerText.trim() !== '') {
                successMessage.style.display = 'block';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                    window.location.href = 'index.php';
                }, 1500); // Rediriger après 3 secondes
            }
        }
    </script>
</body>
</html>
