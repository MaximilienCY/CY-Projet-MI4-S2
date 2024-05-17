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

// Fonction pour obtenir le profil par ID
function getProfileById($filePath, $id) {
    $file = fopen($filePath, "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $data = explode(",", trim($line));
            if ($data[0] == $id) {
                fclose($file);
                return [
                    'id' => $data[0],
                    'prenom' => $data[1],
                    'nom' => $data[2],
                    'email' => $data[3],
                    'mot_de_passe' => $data[4],
                    'sexe' => $data[5],
                    'date_naissance' => $data[6], // date de naissance
                    'profession' => $data[7],
                    'ville' => $data[8],
                    'statut' => $data[9],
                    'description_physique' => $data[10],
                    'infos_personnelles' => $data[11],
                    'photo' => $data[12],
                    'type_utilisateur' => $data[13]
                ];
            }
        }
        fclose($file);
    }
    return null;
}

// Fonction pour calculer l'âge à partir de la date de naissance
function calculerAge($dateNaissance) {
    $aujourdhui = new DateTime();
    $naissance = new DateTime($dateNaissance);
    $age = $aujourdhui->diff($naissance)->y;
    return $age;
}

// Vérifier le type d'utilisateur connecté
$connectedUserType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'visiteur';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="profil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="#" class="logo">Infinity Love<span>.<span></a>
            <ul class="menu-links">
                <li><a href="index.php">Accueil</a></li> 
                <li><a href="#features">Offres</a></li>
                <li><a href="recherche.php">Recherche</a></li>
                <?php
                // Vérifiez si l'utilisateur est connecté
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'visiteur') {
                    echo '<li><a href="index.php?action=logout">Déconnexion</a></li>';
                    echo '<li><a href="mon_profil.php">Mon profil</a></li>';
                } else {
                    echo '<li><button onclick="window.location.href=\'inscription.php\'">Inscription</button></li>';
                    echo '<li><button onclick="window.location.href=\'connexion.php\'">Connexion</button></li>';
                }

                if (isset($_SESSION['droits_utilisateur']) && in_array('envoyer_messages', $_SESSION['droits_utilisateur'])) {
                    echo '<li><a href="messages.php">Messages</a></li>';
                }
                if (isset($_SESSION['droits_utilisateur']) && in_array('gerer_utilisateurs', $_SESSION['droits_utilisateur'])) {
                    echo '<li><a href="admin.php">Administration</a></li>';
                }

                // Si l'action de déconnexion est demandée
                if (isset($_GET['action']) && $_GET['action'] === 'logout') {
                    // Détruisez toutes les variables de session
                    $_SESSION = array();

                    // Détruisez la session
                    session_destroy();

                    // Redirigez l'utilisateur vers la page d'accueil après la déconnexion
                    header("Location: index.php");
                    exit;
                }
                ?>
            </ul>
        </nav>
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
                        <p>Sexe: <?php echo htmlspecialchars($profile['sexe']); ?></p>
                        <p>Âge: <?php echo calculerAge($profile['date_naissance']); ?> ans</p>
                        <p>Profession: <?php echo htmlspecialchars($profile['profession']); ?></p>
                        <p>Ville: <?php echo htmlspecialchars($profile['ville']); ?></p>
                        <p>Statut: <?php echo htmlspecialchars($profile['statut']); ?></p>
                        
                        <?php if ($connectedUserType == 'administrateur'): ?>
                            <p>Email: <?php echo htmlspecialchars($profile['email']); ?></p>
                            <p>Date de naissance: <?php echo htmlspecialchars($profile['date_naissance']); ?></p>
                            <p>Description physique: <?php echo htmlspecialchars($profile['description_physique']); ?></p>
                            <p>Informations personnelles: <?php echo htmlspecialchars($profile['infos_personnelles']); ?></p>
                            <p>Type d'utilisateur: <?php echo htmlspecialchars($profile['type_utilisateur']); ?></p>
                        <?php endif; ?>

                        <?php if ($connectedUserType == 'abonne' || $connectedUserType == 'administrateur'): ?>
                            <button onclick="window.location.href='suivre.php?id=<?php echo htmlspecialchars($profile['id']); ?>'">Suivre</button>
                            <button onclick="window.location.href='envoyer_message.php?id=<?php echo htmlspecialchars($profile['id']); ?>'">Envoyer un message</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p>Profil non trouvé.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="footerContainer">
            <div class="socialIcons">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-twitter"></i></a>
                <a href=""><i class="fa-brands fa-google-plus"></i></a>
                <a href=""><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="footerNav">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">A propos</a></li>
                    <li><a href="#">Nous contacter</a></li>
                    <li><a href="#">Notre équipe</a></li>
                    <li><a href="#">Foire aux questions</a></li>
                </ul>
            </div>
        </div>
        <div class="footerBottom">
            <p>&copy; 2024 Infinity'love - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>
