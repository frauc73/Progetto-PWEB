document.addEventListener("DOMContentLoaded", inizializza)

function inizializza(){
    const nomeStadio = document.body.dataset.nomeStadio;
    if(nomeStadio)
        riempiBacheca(nomeStadio);
}

function riempiBacheca(nomeStadio){
    fetch("gestionePaginaStadio.php?stadio="+ encodeURIComponent(nomeStadio))
        .then(res => res.json())
        .then(data =>{
            
        });
}