document.addEventListener("DOMContentLoaded", inizializza);
//uso questo timeout per gestire la ricerca, 
//evtiando di mandare troppe richieste al database
let timeoutRicerca = null;

function inizializza(){
    //setto il listener per la barra di ricerca
    const barraRicerca = document.getElementById("barra_ricerca");
    barraRicerca.addEventListener("input", aggiornaRicerca);
    //riempio la bacheca
    const utenteLoggato = document.body.dataset.utenteLoggato;
    riempiBacheca(utenteLoggato);
    gestioneMenuTendina();
    gestioneTendinaRicerca();
}

function aggiornaRicerca(e){
    //pulisco il vecchio timeout
    clearTimeout(timeoutRicerca);
    const testoRicerca = e.target.value.trim();
    //setto un nuovo timeout, in modo che la ricerca parta poco dopo che l'utente ha smesso di digitare
    timeoutRicerca = setTimeout(()=>{
        if(testoRicerca.length > 0){
            eseguiRicerca(testoRicerca);
        } else {
            const contenitoreRicerca = document.getElementById("contenitore_ricerca");
            contenitoreRicerca.innerHTML = "";
        }
    }, 500);
}

function eseguiRicerca(stringa){
    fetch('./php/gestioneHomepage.php?azione=ricerca&stringa='+ encodeURIComponent(stringa))
        .then(res => res.json())
        .then(data => {
            const contenitoreRicerca = document.getElementById("contenitore_ricerca");
            contenitoreRicerca.innerHTML = "";
            // Se data non è un array e ha la proprietà success === false, allora è un errore
            if(!Array.isArray(data) && data.success === false){
                alert("Errore: "+ data.message);
                document.getElementById("barra_ricerca").value = "";
                return;
            }
            data.forEach(elem => {
                const contenitoreRisulato = document.createElement("div");
                contenitoreRisulato.classList.add("contenitore_risultato_ricerca");
                contenitoreRicerca.appendChild(contenitoreRisulato);

                const anchor = document.createElement("a");
                if(elem.type === "stadio")
                    anchor.href = "./php/paginaStadio.php?stadio=" + encodeURIComponent(elem.NomeElemento);
                else
                    anchor.href = "./php/paginaUtente.php?username=" + encodeURIComponent(elem.NomeElemento);
                anchor.classList.add("elemento_lista_ricerca");
                contenitoreRisulato.appendChild(anchor);

                const iconaElemento = document.createElement("img");
                iconaElemento.classList.add("icona_elemento")
                if(elem.type === "stadio")
                    iconaElemento.src = "./src/icons/iconaStadio.png";
                else
                    iconaElemento.src = elem.PathFotoProfilo.replace("../", "./");
                anchor.appendChild(iconaElemento);

                const testoElemento = document.createElement("p");
                testoElemento.classList.add("testo_elemento");
                testoElemento.textContent = elem.NomeElemento;
                anchor.appendChild(testoElemento);

            });
        });
}

function riempiBacheca(username){
    fetch('./php/gestioneHomepage.php?azione=riempi&username=' + encodeURIComponent(username))
        .then(res => res.json())
        .then(data => {
            const contenitorePost = document.getElementById("contenitore_post");
            contenitorePost.innerHTML = "";

            if(!Array.isArray(data) && data.success === false){
                alert("Errore: "+ data.message);
                return;
            }

            if(data.length === 0){
                const testoBachecaVuota = document.createElement("p");
                testoBachecaVuota.textContent = "Nessun post nella tua bacheca."
                contenitorePost.appendChild(testoBachecaVuota);
                return;
            }
            data.forEach(post =>{
                let nuovoPost = null;
                if(post.type === 'evento')
                    nuovoPost = disegnaEvento(post,false,true,post.Followed,post.FotoProfiloFollowed, true);
                else if (post.type === 'recensione')
                    nuovoPost = disegnaRecensione(post,false,true,true,post.Followed,post.FotoProfiloFollowed, true);
                if(nuovoPost)
                    contenitorePost.appendChild(nuovoPost);
            });
        });
}

function gestioneMenuTendina(){
    //setto i listener per il menu a tendina
    const menuTendina = document.getElementById("menu_tendina");
    const iconaMenu = document.getElementById("icona_menu");
    iconaMenu.addEventListener("click", ()=>{
        menuTendina.classList.add("aperto");
    })

    const chiudiMenu = document.getElementById("chiudi_menu");
    chiudiMenu.addEventListener("click", ()=>{
        menuTendina.classList.remove("aperto");
    })

    //chiudo il menu se tocco qualche altro pezzo della pagina
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = menuTendina.contains(event.target);
        const isClickOnIcon = iconaMenu.contains(event.target);

        if (!isClickInsideMenu && !isClickOnIcon && menuTendina.classList.contains('aperto')) {
            menuTendina.classList.remove('aperto');
        }
    });
}

function gestioneTendinaRicerca(){
    const bottoneCerca = document.getElementById("ricerca");
    const tendinaRicerca = document.getElementById("tendina_ricerca");
    const barraRicerca = document.getElementById("barra_ricerca");

    bottoneCerca.addEventListener("click", (e)=>{
        //impedisco che il click si propaghi al document, che comporterebbe la chiusura della tendina
        e.stopPropagation();
        tendinaRicerca.classList.toggle("hidden");

        if(!tendinaRicerca.classList.contains("hidden")){
            barraRicerca.focus();
        }
    })

    //chiudo la tendina se clicco fuori dalla tendina
    document.addEventListener("click", (e)=>{
        const isClickInside = tendinaRicerca.contains(e.target);
        const isClickOnButton = bottoneCerca.contains(e.target);

        // Se il click NON è dentro la tendina E NON è sul bottone, chiudi
        if (!isClickInside && !isClickOnButton && !tendinaRicerca.classList.contains("hidden")) {
            tendinaRicerca.classList.add("hidden");
        }
    });
    
    // Evita che cliccare dentro la tendina la faccia chiudere
    tendinaRicerca.addEventListener("click", (e) => {
        e.stopPropagation();
    });
}