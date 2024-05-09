// Récupération des boutons Smash et Pass
const btnPass = document.querySelector('.btn-pass');
const btnSmash = document.querySelector('.btn-smash');

// Récupération de tous les profils
const profiles = document.querySelectorAll('.profile');

// Fonction pour déplacer un profil vers la droite (passer)
const moveRight = (profile) => {
    profile.style.transform = 'translateX(150%)'; // Modification de la valeur de translation
    setTimeout(() => {
        profile.style.display = 'none'; // Masquer le profil après la transition
    }, 500); // Temps de la transition (0.5s)
};

// Fonction pour déplacer un profil vers la gauche (smasher)
const moveLeft = (profile) => {
    profile.style.transform = 'translateX(-150%)'; // Modification de la valeur de translation
    setTimeout(() => {
        profile.style.display = 'none'; // Masquer le profil après la transition
    }, 500); // Temps de la transition (0.5s)
};

// Ajout des écouteurs d'événements sur les boutons
btnPass.addEventListener('click', () => {
    // Déplacement du premier profil vers la droite (passer)
    moveRight(profiles[0]);
});

btnSmash.addEventListener('click', () => {
    // Déplacement du premier profil vers la gauche (smasher)
    moveLeft(profiles[0]);
});

