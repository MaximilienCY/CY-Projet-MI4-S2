<?php
function getRecentProfiles($filePath) {
    // Lire le contenu du fichier
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Tableau pour stocker les profils
    $profiles = [];

    // Parcourir chaque ligne du fichier
    foreach ($lines as $line) {
        // Diviser la ligne en champs
        $fields = explode(',', $line);

        // Créer un tableau associatif pour chaque profil
        $profiles[] = [
            'id' => $fields[0],
            'prenom' => $fields[1],
            'nom' => $fields[2],
            'email' => $fields[3],
            'motdepasse' => $fields[4],
            'sexe' => $fields[5],
            'date_creation' => $fields[6],
            'profession' => $fields[7],
            'ville' => $fields[8],
            'statut' => $fields[9],
            'yeux' => $fields[10],
            'extra' => $fields[11],
            'photo' => $fields[12],
            'role' => $fields[13]
        ];
    }

    // Trier les profils par date de création décroissante
    usort($profiles, function($a, $b) {
        return strtotime($b['date_creation']) - strtotime($a['date_creation']);
    });

    // Sélectionner les 10 profils les plus récents
    $recentProfiles = array_slice($profiles, 0, 10);

    return $recentProfiles;
}
?>
