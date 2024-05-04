function togglePasswordVisibility() {
    var passwordField = document.getElementById("mot_de_passe");
    var toggleButton = document.querySelector(".toggle-password");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.innerHTML = "&#x1F440;"; // icône d'œil ouvert
    } else {
        passwordField.type = "password";
        toggleButton.innerHTML = "&#x1F441;"; // icône d'œil fermé
    }
}
