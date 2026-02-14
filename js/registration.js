document.addEventListener("DOMContentLoaded", inizializza);

function inizializza(){
    //setto i listener per aggiornare il bottone
    const nome = document.getElementById("nome");
    nome.addEventListener("input", aggiornaBottone);
    const cognome = document.getElementById("cognome");
    cognome.addEventListener("input", aggiornaBottone);
    const username = document.getElementById("username");
    username.addEventListener("input", aggiornaBottone);
    const password = document.getElementById("password");
    password.addEventListener("input", aggiornaBottone);
    const email = document.getElementById("email");
    email.addEventListener("input", aggiornaBottone);
}

function aggiornaBottone(){
    const nome = document.getElementById("nome");
    const cognome = document.getElementById("cognome");
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const email = document.getElementById("email");
    //controllo se l'input è valido
    const bottone = document.getElementById("registration");
    if(username.validity.invalid || username.value === "" || password.validity.invalid || password.value === "" || nome.validity.invalid || nome.value === "" || cognome.validity.invalid || cognome.value === "" || email.validity.invalid || email.value === ""){
        bottone.disabled = true;
    } else {
        bottone.disabled = false;
    }
}
