<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $file = fopen("utilisateurs.txt", "r");
    $found = false;
    while (!feof($file)) {
        $line = fgets($file);
        $data = explode(",", $line);
        if ($data[0] == $username && trim($data[1]) == $password) {
            $found = true;
            break;
        }
    }
    fclose($file);
    if ($found) {
        echo "Vous êtes connecté.";
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

