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
    'utilisateur' => ['voir_profil_public', 'voir_profil_prive'],
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
                    <li><a href="connexion.php">Connexion</a></li>
                    <li><a href="inscription.php">Inscription</a></li>
                    <?php if (in_array('envoyer_messages', $droits_utilisateur)) : ?>
                        <li><a href="messages.php">Messages</a></li>
                    <?php endif; ?>
                    <?php if (in_array('gerer_utilisateurs', $droits_utilisateur)) : ?>
                        <li><a href="admin.php">Administration</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <section class="users">
        
            <div class="container">
                <h2>Derniers utilisateurs inscrits</h2>
                <div class="users-grid">
                    <?php
                    // Lire les utilisateurs depuis le fichier txt
                    $file = fopen("utilisateurs.txt", "r");
                    $users = [];
                    if ($file) {
                        while (($line = fgets($file)) !== false) {
                            list($id, $nom, $prenom, $photo) = explode(",", trim($line));
                            $users[] = [
                                'id' => $id,
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'photo' => $photo
                            ];
                        }
                        fclose($file);
                    }

                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            echo "<div class='user'>";
                            echo "<img src='images/" . $user['photo'] . "' alt='Photo de " . $user['prenom'] . "'>";
                            echo "<h3>" . $user['prenom'] . " " . $user['nom'] . "</h3>";
                            echo "<p>Âge: N/A</p>"; // Modifier si l'âge est disponible dans le fichier
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Aucun utilisateur trouvé</p>";
                    }
                    ?>
                </div>
                
            </div>
        </section>
        <section id="hero" class="hero">
            <div class="container">
                <h2>Trouvez l'amour de votre vie</h2>
                <p>Rejoignez notre communauté dès maintenant et commencez votre voyage vers une relation significative.</p>
                <a href="inscription.php" class="cta-button">Inscrivez-vous maintenant</a>
            </div>
        </section>
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

