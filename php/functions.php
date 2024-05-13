<?php

function saveUser($username, $password) {
    $file = fopen("utilisateurs.txt", "a");
    fwrite($file, "Pseudo: $username, Mot de passe: $password\n");
    fclose($file);
}

function saveProfile($username, $gender, $dob, $profession, $location, $status, $physical_description, $personal_info, $photos) {
    $file = fopen("utilisateurs.txt", "a");
    fwrite($file, "Pseudo: $username, Sexe: $gender, Date de naissance: $dob, Profession: $profession, Lieu de résidence: $location, Situation: $status, Description physique: $physical_description, Informations personnelles: $personal_info\n");
    fclose($file);

    // Enregistrer les photos
    if ($photos['error'][0] == 0) {
        $target_dir = "uploads/$username/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        foreach ($photos['tmp_name'] as $key => $tmp_name) {
            $target_file = $target_dir . basename($photos['name'][$key]);
            move_uploaded_file($tmp_name, $target_file);
        }
    }
}
function getUserData($username) {
    $file = fopen("utilisateurs.txt", "r");
    while (($line = fgets($file)) !== false) {
        if (strpos($line, "Pseudo: $username") !== false) {
            fclose($file);
            return $line;
        }
    }
    fclose($file);
    return null;
}

function updateUserProfile($username, $gender, $dob, $profession, $location, $status, $physical_description, $personal_info) {
    $contents = file("utilisateurs.txt");
    $new_contents = [];
    foreach ($contents as $line) {
        if (strpos($line, "Pseudo: $username") !== false) {
            $new_line = "Pseudo: $username, Sexe: $gender, Date de naissance: $dob, Profession: $profession, Lieu de résidence: $location, Situation: $status, Description physique: $physical_description, Informations personnelles: $personal_info\n";
            $new_contents[] = $new_line;
        } else {
            $new_contents[] = $line;
        }
    }
    file_put_contents("utilisateurs.txt", implode("", $new_contents));
}

function checkLogin($username, $password) {
    $file = fopen("utilisateurs.txt", "r");
    while (($line = fgets($file)) !== false) {
        if (strpos($line, "Pseudo: $username, Mot de passe: $password") !== false) {
            fclose($file);
            return true;
        }
    }
    fclose($file);
    return false;
}
?>

