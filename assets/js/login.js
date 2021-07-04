"Use strict";
/*******************************************************/
/*******************************************************/
/************ Vérification formulaire login ************/

let envoi_login = document.getElementById('login');
let mail =  document.getElementById('mail_login');
let password =  document.getElementById('password_login');
let erreur_login = document.getElementById('erreur_login');

envoi_login.addEventListener('submit',function(e) {
    if(mail.value.trim() == "" && password.value.trim() == "") {
        erreur_login.innerHTML = "Tous les champs sont requis";
        erreur_login.style.color = "red";
        e.preventDefault();
    }
    else if(mail.value.trim() == "") {
        erreur_login.innerHTML = "Le champ mail est requis";
        erreur_login.style.color = "red";
        e.preventDefault();
    }
    else if(password.value.trim() == "") {
        erreur_login.innerHTML = "Le champ password est requis";
        erreur_login.style.color = "red";
        e.preventDefault();
    }
})
