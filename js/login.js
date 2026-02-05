document.addEventListener("DOMContentLoaded", init)
function init(){
    const bottone = document.getElementById("login");
    bottone.addEventListener("click", invia);
}
function invia(e){
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    //controllo se l'input è valido
    if(username.validity.invalid || username.value === "" || password.validity.invalid || password.value === ""){
        //se c'è un errore di input fermo l'invio del form
        e.preventDefault();
    }
}
