<?php
session_start();

function searchProfiles($filePath, $query) {
    $results = [];
    $file = fopen($filePath, "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $data = explode(",", trim($line));
            if (stripos($data[1], $query) !== false || stripos($data[2], $query) !== false) {
                $results[] = [
                    'id' => $data[0],
                    'nom' => $data[1],
                    'prenom' => $data[2],
                    'photo' => $data[12]
                ];
            }
        }
        fclose($file);
    }
    return $results;
}

$query = isset($_GET['query']) ? $_GET['query'] : '';
$results = searchProfiles('utilisateurs.txt', $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'utilisateurs</title>
    <link rel="stylesheet" href="accueil.css">
    <style>
        .search-results {
            margin-top: 20px;
        }
        .search-results ul {
            list-style: none;
            padding: 0;
        }
        .search-results li {
            margin-bottom: 10px;
        }
        .search-results .result-item {
            display: flex;
            align-items: center;
        }
        .search-results .result-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .search-results .result-info h4 {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Recherche d'utilisateurs</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>Recherchez des profils</h2>
            <form action="recherche.php" method="get">
                <input type="text" name="query" placeholder="Recherchez des profils..." value="<?php echo htmlspecialchars($query); ?>">
                <button type="submit">Rechercher</button>
            </form>

            <div class="search-results">
                <?php if ($query): ?>
                    <h3>Résultats de la recherche pour "<?php echo htmlspecialchars($query); ?>"</h3>
                    <?php if (count($results) > 0): ?>
                        <ul>
                            <?php foreach ($results as $user): ?>
                                <li class="result-item">
                                    <a href="profil.php?id=<?php echo urlencode($user['id']); ?>" class="result-link">
                                        <img src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Photo de <?php echo htmlspecialchars($user['prenom']); ?>" class="result-image">
                                        <div class="result-info">
                                            <h4><?php echo htmlspecialchars($user['prenom']) . " " . htmlspecialchars($user['nom']); ?></h4>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Aucun résultat trouvé.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Veuillez entrer un terme de recherche.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Infinity'love - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>

