document.addEventListener("DOMContentLoaded", inizializza)

function inizializza(){
    const nomeStadio = document.body.dataset.nomeStadio;
    if(nomeStadio)
        riempiBacheca(nomeStadio);
}

function riempiBacheca(nomeStadio){
    fetch("gestionePaginaStadio.php?azione=riempi_bacheca&stadio="+ encodeURIComponent(nomeStadio))
        .then(res => res.json())
        .then(data =>{
            const contenitorePost = document.getElementById("contenitore_post");
            contenitorePost.innerHTML = "";

            //gestisco i messaggi d'errore
            if(!Array.isArray(data) && data.success === false){
                alert("Errore: "+ data.message);
                return;
            }
            
            if(data.length === 0){
                const testoBachecaVuota = document.createElement("p");
                testoBachecaVuota.textContent = "Nessuna recensione dello stadio.";
                contenitorePost.appendChild(testoBachecaVuota);
                return;
            }

            data.forEach(post =>{
                let nuovoPost = disegnaRecensione(post,false,true,true,post.Username,post.PathFotoProfilo);
                if(nuovoPost)
                    contenitorePost.appendChild(nuovoPost);
            })
        });
}