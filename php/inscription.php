<?php
include('functions.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    saveUser($username, $password);
    header("Location: completer_profil.php?username=$username");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    <form action="inscription.php" method="POST">
        <label for="username">Pseudo :</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" name="submit" value="S'inscrire">
    </form>
</body>
</html>

