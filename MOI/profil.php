<?php
session_start();

// Inclure le fichier contenant les fonctions
require_once 'fonctions.php';

// Vérifier si un ID de profil a été passé en paramètre
if (isset($_GET['id'])) {
    $profileId = $_GET['id'];

    // Utiliser la fonction pour obtenir les détails du profil correspondant
    $filePath = "utilisateurs.txt";
    $profile = getProfileById($filePath, $profileId);
} else {
    $profile = null;
}

function getProfileById($filePath, $id) {
    $file = fopen($filePath, "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $data = explode(",", trim($line));
            if ($data[0] == $id) {
                fclose($file);
                return [
                    'id' => $data[0],
                    'nom' => $data[1],
                    'prenom' => $data[2],
                    'email' => $data[3],
                    'mot_de_passe' => $data[4],
                    'sexe' => $data[5],
                    'date_creation' => $data[6],
                    'profession' => $data[7],
                    'ville' => $data[8],
                    'statut' => $data[9],
                    'yeux' => $data[10],
                    'taille' => $data[11],
                    'photo' => $data[12],
                    'type_utilisateur' => $data[13]
                ];
            }
        }
        fclose($file);
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Profil Utilisateur</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <?php if ($profile): ?>
                <div class="profile-card">
                    <figure class="profile-card-image-container">
                        <img src="<?php echo htmlspecialchars($profile['photo']); ?>" alt="Photo de <?php echo htmlspecialchars($profile['prenom']); ?>" class="profile-card-image">
                    </figure>
                    <div class="profile-card-content">
                        <h2><?php echo htmlspecialchars($profile['prenom']) . " " . htmlspecialchars($profile['nom']); ?></h2>
                        <p>Email: <?php echo htmlspecialchars($profile['email']); ?></p>
                        <p>Sexe: <?php echo htmlspecialchars($profile['sexe']); ?></p>
                        <p>Date d'inscription: <?php echo htmlspecialchars($profile['date_creation']); ?></p>
                        <p>Profession: <?php echo htmlspecialchars($profile['profession']); ?></p>
                        <p>Ville: <?php echo htmlspecialchars($profile['ville']); ?></p>
                        <p>Statut: <?php echo htmlspecialchars($profile['statut']); ?></p>
                        <p>Yeux: <?php echo htmlspecialchars($profile['yeux']); ?></p>
                        <p>Taille: <?php echo htmlspecialchars($profile['taille']); ?></p>
                        <p>Type d'utilisateur: <?php echo htmlspecialchars($profile['type_utilisateur']); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <p>Profil non trouvé.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Infinity'love - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>
