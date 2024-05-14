<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Inscription</title>
</head>
<body>

    <div class="container">
        <div class="box form-box">
        
            <header>S'inscrire</header>
            <form action="traitement_inscription.php" method="post" enctype="multipart/form-data">
            <div class="field input">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" autocomplete="off" required><br>
            </div>
            <div class="field input">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" autocomplete="off" required><br>
            </div>
            <div class="field input">
                <label for="gender">Sexe</label>
                <input type="text" name="gender" autocomplete="off" required><br>
            </div>
            <div class="field input">
                <label for="birthdate">Date de naissance</label>
                <input type="date" name="birthdate" autocomplete="off" required><br>
            </div>
            <div class="field input">
                <label for="profession">Profession</label>
                <input type="text" name="profession" autocomplete="off" required"><br>
            </div>
            <div class="field input">
                <label for="residence">Lieu de résidence</label>
                <input type="text" name="residence" autocomplete="off" required><br>
            </div>
            <div class="field input">
                <label for="relationship_status">Relations amoureuse et familliale</label>
                <input type="text" name="relationship_status" autocomplete="off" required><br>
            </div>
            <div class="field input">
                <label for="physical_description">Description physique</label>
                <input type="text" name="physical_description" autocomplete="off" required><br>
            </div>
            <div class="field input">
                <label for="personal_info">Informations personnelles</label>
                <textarea name="personal_info"></textarea><br>
            </div>
            <div class="field input">
                <label for="photo">Photo</label>
                <input type="file" name="photo" accept="image/*"><br>
            </div>
            <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="S'inscrire" required>
                </div>
                <div class="links">
                    Déjà inscrit ? <a href="connexion.php">Se connecter</a>
                </div>
        </form>
        </div>
    </div>
</body>
</html>
