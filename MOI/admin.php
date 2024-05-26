<?php

function banUser($email){
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

function unbanUser($email){
    $users = file("utilisateurs.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($users as $key => $user) {
        $data = explode(",", $user);

        if ($data[3] === $email) {
            $data[14] = "non";
            $users[$key] = implode(",", $data);
            break;
        }
    }

    file_put_contents("utilisateurs.txt", implode("\n", $users));
}

function getBannedUsers(){
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

function getUsers(){
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
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="admin.css">
 <title>Infinity'love - RencontreSite</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <header>
        <div class="navbar">
            <a href="index.php" class="logo">Infinity Love<span>.</span></a>
            <ul class="menu-links">
                <li><a href="index.php#hero-section">Accueil</a></li> 
                <li><a href="index.php#features">Offres</a></li>
                <li><a href="recherche.php">Recherche</a></li>
            </ul>
            <div class="auth-buttons">
                <?php
                // Vérifiez si l'utilisateur est connecté
                session_start();
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'visiteur') {
                    echo '<button onclick="window.location.href=\'index.php?action=logout\'">Déconnexion</button>';
                } else {
                    echo '<button onclick="window.location.href=\'inscription.php\'">Inscription</button>';
                    echo '<button onclick="window.location.href=\'connexion.php\'">Connexion</button>';
                }

                $droits_utilisateur = []; // Définir les droits utilisateur ici
                if (in_array('envoyer_messages', $droits_utilisateur)) {
                    echo '<button onclick="window.location.href=\'messages.php\'">Messages</button>';
                }
                if (in_array('gerer_utilisateurs', $droits_utilisateur)) {
                    echo '<button onclick="window.location.href=\'admin.php\'">Administration</button>';
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

                $user_id_session = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Stocker l'ID de l'utilisateur connecté
                ?>
            </div>
        </div>
    </header>

    <div class="title">
    <h1>Liste des utilisateurs</h1>
    </div>
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
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php

        if (isset($_POST['ban']) && isset($_POST['email'])) {
            $email = $_POST['email'];
            banUser($email);
        }

        if (isset($_POST['unban']) && isset($_POST['email'])) {
            $email = $_POST['email'];
            unbanUser($email);
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

            // Si l'utilisateur est un administrateur son profil ne peut pas être modifié, il ne peut pas être banni non plus
            if ($data[13] === 'administrateur'){
                // Ban, unban and edit button
                echo "<td>";
                echo "<form action='admin.php' method='post'>";
                echo "<input type='hidden' name='email' value='" . htmlspecialchars($data[3]) . "'>";
                echo "<input type='submit' class='sanction' name='ban' value='Bannir' disabled>";
                echo "<input type='submit' class='sanction' name='unban' value='Débannir' disabled>";
                echo "</form>";

                echo "<form action='modifier_utilisateur.php' method='post'>";
                echo "<input type='hidden' name='email' value='" . htmlspecialchars($data[3]) . "'>";
                echo "<input type='submit' class='edit' name='edit' value='Modifier' disabled>";
                echo "</form>";
                echo "</td>";
                echo "<tr>";
            }
            else {
                // Ban, unban and edit button
                echo "<td>";
                echo "<form action='admin.php' method='post'>";
                echo "<input type='hidden' name='email' value='" . htmlspecialchars($data[3]) . "'>";
                echo "<input type='submit' class='sanction' name='ban' value='Bannir'>";
                echo "<input type='submit' class='sanction' name='unban' value='Débannir'>";
                echo "</form>";

                echo "<form action='modifier_utilisateur.php' method='post'>";
                echo "<input type='hidden' name='email' value='" . htmlspecialchars($data[3]) . "'>";
                echo "<input type='submit' class='edit' name='edit' value='Modifier'>";
                echo "</form>";
                echo "</td>";
                echo "<tr>";
            }
        }
        ?>
    </tbody>
</table>
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
                    <li><a href="#hero-section">Accueil</a></li>
                    <li><a href="">A propos</a></li>
                    <li><a href="">Nous contacter</a></li>
                    <li><a href="">Notre équipe</a></li>
                    <li><a href="">Foire aux questions</a></li>
                </ul>
            </div>
        </div>
        <div class="footerBottom">
            <p>&copy; 2024 Infinity'love - Tous droits réservés</p>
        </div>
    </footer>

    <script>
        // JavaScript for toggling mobile menu
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const header = document.querySelector('header');

        hamburgerBtn.addEventListener('click', () => {
            header.classList.add('show-mobile-menu');
        });

        closeMenuBtn.addEventListener('click', () => {
            header.classList.remove('show-mobile-menu');
        });
    </script>
</body>
</html>
