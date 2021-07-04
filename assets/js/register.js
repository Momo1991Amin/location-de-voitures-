"Use strict";
/************ Vérification formulaire register ************/
let envoi_register = document.getElementById('register');
let firstname = document.getElementById('firstname');
let lastname = document.getElementById('lastname');
let mail = document.getElementById('mail_register');
let avatar = document.getElementById('avatar');
let password1 = document.getElementById('password1_register');
// let password2 = document.getElementById('password2_register');
let erreur_register = document.getElementById('erreur_register');

envoi_register.addEventListener('submit',function(e){
    if(firstname.value.trim() == "" && lastname.value.trim() == "" && mail.value.trim() == "" && avatar.value.trim() == ""
        && password1.value.trim() == ""){
        erreur_register.innerHTML = "Tous les champs sont requis";
        erreur_register.style.color = "red";
        e.preventDefault();
    }
    else if(firstname.value.trim() == ""){
        erreur_register.innerHTML = "Votre mail est requis";
        erreur_register.style.color = "red";
        e.preventDefault();
    }
    else if(lastname.value.trim() == ""){
        erreur_register.innerHTML = "Votre nom est requis";
        erreur_register.style.color = "red";
        e.preventDefault();
    }
    else if(mail.value.trim() == ""){
        erreur_register.innerHTML = "Le champ mail est requis";
        erreur_register.style.color = "red";
        e.preventDefault();
    }
    else if(avatar.value.trim() == ""){
        erreur_register.innerHTML = "L'url de votre avatar est requis";
        erreur_register.style.color = "red";
        e.preventDefault();
    }
    else if(password1.value.trim() == ""){
        erreur_register.innerHTML = "Le champ password est requis";
        erreur_register.style.color = "red";
        e.preventDefault();
    }
})