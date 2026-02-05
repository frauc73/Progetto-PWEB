function init(){
    const bottone = document.getElementById("registration");
    bottone.addEventListener("click", invia);
}
function invia(e){
    const nome = document.getElementById("nome");
    const cognome = document.getElementById("cognome");
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const email = document.getElementById("email");
    //controllo se l'input è valido
    if(username.validity.invalid || username.value === "" || password.validity.invalid || password.value === "" || nome.validity.invalid || nome.value === "" || cognome.validity.invalid || cognome.value === "" || email.validity.invalid || email.value === ""){
        //se c'è un errore di input fermo l'invio del form
        e.preventDefault();
    }
}