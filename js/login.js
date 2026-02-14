document.addEventListener("DOMContentLoaded", inizializza)

function inizializza(){
    const username = document.getElementById("username");
    username.addEventListener("input", aggiornaBottone);
    const password = document.getElementById("password");
    password.addEventListener("input", aggiornaBottone);
}

function aggiornaBottone(){
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const bottone = document.getElementById("login");
    //controllo se l'input è valido
    if(username.validity.invalid || username.value === "" || password.validity.invalid || password.value === ""){
        //se c'è un errore di input fermo l'invio del form
        bottone.disabled = true;
    } else {
        bottone.disabled = false;
    }
}
