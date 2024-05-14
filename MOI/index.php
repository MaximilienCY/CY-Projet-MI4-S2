<?php
session_start();

// Initialiser la session de base pour les visiteurs
if (!isset($_SESSION['user_type'])) {
    $_SESSION['user_type'] = 'visiteur';
}

$user_type = $_SESSION['user_type'];

// Définir les droits pour chaque type d'utilisateur
$droits = [
    'visiteur' => ['voir_profil_public'],
    'utilisateur' => ['voir_profil_public', 'voir_profil_prive', 'envoyer_messages', 'gerer_utilisateurs'],
    'abonne' => ['voir_profil_public', 'voir_profil_prive', 'envoyer_messages'],
    'administrateur' => ['voir_profil_public', 'voir_profil_prive', 'envoyer_messages', 'gerer_utilisateurs']
];

$droits_utilisateur = $droits[$user_type];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinity'love - RencontreSite</title>
    <link rel="stylesheet" href="accueil.css">
    <style>
        /* Styles pour masquer les indications visuelles des liens */
        .feature-card-link {
            text-decoration: none;
            color: inherit;
        }
        .feature-card-link:hover .feature-card-image {
            opacity: 0.8; /* Optionnel : un léger changement visuel au survol */
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <h1>Infinity'love</h1>
            <nav>
                <ul>
                    <li><a href="#hero">Accueil</a></li> 
                    <li><a href="#features">Offres</a></li>
                    <li><a href="#search">Recherche</a></li>
                    <?php
                    // Vérifiez si l'utilisateur est connecté
                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'visiteur') {
                        echo '<li><a href="index.php?action=logout">Déconnexion</a></li>';
                    } else {
                        echo '<li><a href="inscription.php">Inscription</a></li>';
                        echo '<li><a href="connexion.php">Connexion</a></li>';
                    }

                    if (in_array('envoyer_messages', $droits_utilisateur)) {
                        echo '<li><a href="messages.php">Messages</a></li>';
                    }
                    if (in_array('gerer_utilisateurs', $droits_utilisateur)) {
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
        </div>
    </header>
    
    <main>
        <?php if ($user_type !== 'visiteur') : ?>
        <section class="users">
            <div class="container">
                <h2>Derniers utilisateurs inscrits</h2>
                <div id="scroll-gallery-feature-cards" class="gallery gallery-align-start gallery-feature-cards">
                    <div class="scroll-container">
                        <div class="item-container">
                            <ul class="card-set" role="list">
                                <?php
                                // Inclure le fichier contenant les fonctions
                                require_once 'fonctions.php';

                                // Utiliser la fonction pour obtenir les 10 profils les plus récents
                                $filePath = "utilisateurs.txt";
                                $recentProfiles = getRecentProfiles($filePath);

                                if (count($recentProfiles) > 0) {
                                    foreach ($recentProfiles as $user) {
                                        echo "<li role='listitem' class='gallery-item grid-item'>";
                                        echo "<a href='profil.php?id=" . urlencode($user['id']) . "' class='feature-card-link'>";
                                        echo "<div class='feature-card card-container'>";
                                        echo "<figure class='feature-card-image-container'>";
                                        echo "<img src='" . htmlspecialchars($user['photo']) . "' alt='Photo de " . htmlspecialchars($user['prenom']) . "' class='feature-card-image'>";
                                        echo "</figure>";
                                        echo "<div class='card-modifier card-padding theme-dark fixed-width'>";
                                        echo "<div class='card-viewport-content'>";
                                        echo "<div class='feature-card-content'>";
                                        echo "<div class='feature-card-copy'>";
                                        echo "<p class='typography-feature-card-label feature-card-label'>" . htmlspecialchars($user['nom']) . " " . htmlspecialchars($user['prenom']) . "</p>";
                                        echo "<p class='typography-card-headline feature-card-headline'>Date d'inscription: " . htmlspecialchars($user['date_creation']) . "<br>Ville: " . htmlspecialchars($user['ville']) . "<br>Statut: " . htmlspecialchars($user['statut']) . "</p>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</a>";
                                        echo "</li>";
                                    }
                                } else {
                                    echo "<p>Aucun utilisateur trouvé</p>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="paddlenav paddlenav-alpha">
                        <ul class="sticky-element">
                            <li class="left-item"><button aria-label="Précédent" class="paddlenav-arrow paddlenav-arrow-previous" disabled="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36"><path d="M21.559,12.062 L15.618,17.984 L21.5221,23.944 C22.105,24.533 22.1021,25.482 21.5131,26.065 C21.2211,26.355 20.8391,26.4999987 20.4571,26.4999987 C20.0711,26.4999987 19.6851,26.352 19.3921,26.056 L12.4351,19.034 C11.8531,18.446 11.8551,17.4999987 12.4411,16.916 L19.4411,9.938 C20.0261,9.353 20.9781,9.354 21.5621,9.941 C22.1471,10.528 22.1451,11.478 21.5591,12.062 L21.559,12.062 Z"></path></svg>
                            </button></li>
                            <li class="right-item"><button aria-label="Suivant" class="paddlenav-arrow paddlenav-arrow-next">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36"><path d="M23.5587,16.916 C24.1447,17.4999987 24.1467,18.446 23.5647,19.034 L16.6077,26.056 C16.3147,26.352 15.9287,26.4999987 15.5427,26.4999987 C15.1607,26.4999987 14.7787,26.355 14.4867,26.065 C13.8977,25.482 13.8947,24.533 14.4777,23.944 L20.3818,17.984 L14.4408,12.062 C13.8548,11.478 13.8528,10.5279 14.4378,9.941 C15.0218,9.354 15.9738,9.353 16.5588,9.938 L23.5588,16.916 L23.5587,16.916 Z"></path></svg>
                            </button></li>
                            <div class="scrim"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php if ($user_type === 'visiteur') : ?>
        <section id="hero" class="hero">
            <div class="container">
                <h2>Trouvez l'amour de votre vie</h2>
                <p>Rejoignez notre communauté dès maintenant et commencez votre voyage vers une relation significative.</p>
                <a href="inscription.php" class="cta-button">Inscrivez-vous maintenant</a>
            </div>
        </section>
        <?php endif; ?>

        <section id="features" class="features">
            <div class="container">
                <h2>Nos Offres</h2>
                <div class="features-grid">
                    <div class="offer-card">
                        <div class="offer-img-wrapper">
                            <img src="images/offer1.jpg" alt="Offre 1" class="offer-img">
                        </div>
                        <div class="offer-content">
                            <h3 class="offer-title">Offre 1</h3>
                            <p class="offer-description">Description de l'offre 1.</p>
                            <p class="offer-price">À partir de <b>1 219 €</b></p>
                        </div>
                    </div>
                    <div class="offer-card">
                        <div class="offer-img-wrapper">
                            <img src="images/offer2.jpg" alt="Offre 2" class="offer-img">
                        </div>
                        <div class="offer-content">
                            <h3 class="offer-title">Offre 2</h3>
                            <p class="offer-description">Description de l'offre 2.</p>
                            <p class="offer-price">À partir de <b>719 €</b></p>
                        </div>
                    </div>
                    <div class="offer-card">
                        <div class="offer-img-wrapper">
                            <img src="images/offer3.jpg" alt="Offre 3" class="offer-img">
                        </div>
                        <div class="offer-content">
                            <h3 class="offer-title">Offre 3</h3>
                            <p class="offer-description">Description de l'offre 3.</p>
                            <p class="offer-price">À partir de <b>1 229 €</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="search" class="search">
            <div class="container">
                <h2>Recherche</h2>
                <form action="recherche.php" method="get">
                    <input type="text" name="query" placeholder="Recherchez des profils...">
                    <button type="submit">Rechercher</button>
                </form>
            </div>
        </section>
    </main>
    
    <footer>
        <div class="container">
            <p>&copy; 2024 Infinity'love - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>
