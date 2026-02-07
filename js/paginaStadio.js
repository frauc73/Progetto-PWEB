document.addEventListener("DOMContentLoaded", inizializza)

function inizializza(){
    const nomeStadio = document.body.dataset.nomeStadio;
    if(nomeStadio){
        //di default mostro tutte le recensioni e calcolo le statistiche su tutte le recensioni
        riempiBacheca(nomeStadio, "tutti");
        calcolaStatistiche(nomeStadio, "tutti");
    }
    const filtri = document.querySelectorAll('input[name="filtro_recensione"]');;
    filtri.forEach(radio => {
        radio.addEventListener("change", (e) => {
            // e.target.value conterrà il settore scelto attraverso il radio button
            riempiBacheca(nomeStadio, e.target.value);
            calcolaStatistiche(nomeStadio, e.target.value);
        });
    });
}

function riempiBacheca(nomeStadio, settore){
    fetch("gestionePaginaStadio.php?azione=riempi_bacheca&stadio="+ encodeURIComponent(nomeStadio)+"&settore=" + encodeURIComponent(settore))
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
                testoBachecaVuota.textContent = "Nessuna recensione per quel settore dello stadio.";
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

function calcolaStatistiche(nomeStadio, settore){
    fetch("gestionePaginaStadio.php?azione=calcola_statistiche&stadio="+ encodeURIComponent(nomeStadio) +"&settore=" + encodeURIComponent(settore))
        .then(res => res.json())
        .then(data =>{
            const contenitoreValutazioni = document.getElementById("contenitore_valutazioni");
            contenitoreValutazioni.innerHTML = "";

            //gestisco i messaggi d'errore
            if(!Array.isArray(data) && data.success === false){
                alert("Errore: "+ data.message);
                return;
            }
            
            if(!data.ValutazioneGenerale){
                const testoBachecaVuota = document.createElement("p");
                testoBachecaVuota.textContent = "Nessuna recensione per quel settore dello stadio.";
                contenitoreValutazioni.appendChild(testoBachecaVuota);
                return;
            }
            //l'array data ha un solo elemento
            disegnaStatistiche(contenitoreValutazioni, data);
        });
}

function disegnaStatistiche(contenitore, statistiche){
    //Valutazione Generale
    const contenitoreValutazioneGenerale = document.createElement("div");
    contenitoreValutazioneGenerale.classList.add("contenitore_valutazione");
    contenitore.appendChild(contenitoreValutazioneGenerale);

    const valutazioneGenerale = document.createElement("h1");
    valutazioneGenerale.textContent = "Valutazione generale: " + parseFloat(statistiche.ValutazioneGenerale).toFixed(1);
    contenitoreValutazioneGenerale.appendChild(valutazioneGenerale);

    //Impianto
    const contenitoreValutazioneImpianto = document.createElement("div");
    contenitoreValutazioneImpianto.classList.add("contenitore_macrocampo");
    contenitore.appendChild(contenitoreValutazioneImpianto);

    const valutazioneImpianto = document.createElement("h1");
    valutazioneImpianto.textContent = "Impianto: " + parseFloat(statistiche.MediaImpianto).toFixed(1);
    contenitoreValutazioneImpianto.appendChild(valutazioneImpianto);

    const valutazioneVisibilita = document.createElement("h2");
    valutazioneVisibilita.textContent = "Visibilità: " + parseFloat(statistiche.MediaVisibilita).toFixed(1);
    contenitoreValutazioneImpianto.appendChild(valutazioneVisibilita);

    const valutazioneDistanzaCampo = document.createElement("h2");
    valutazioneDistanzaCampo.textContent = "Distanza dal campo: " + parseFloat(statistiche.MediaDistanzaCampo).toFixed(1);
    contenitoreValutazioneImpianto.appendChild(valutazioneDistanzaCampo);

    //Logistica
    const contenitoreValutazioneLogistica = document.createElement("div");
    contenitoreValutazioneLogistica.classList.add("contenitore_macrocampo");
    contenitore.appendChild(contenitoreValutazioneLogistica);

    const valutazioneLogistica = document.createElement("h1");
    valutazioneLogistica.textContent = "Logistica: " + parseFloat(statistiche.MediaLogistica).toFixed(1);
    contenitoreValutazioneLogistica.appendChild(valutazioneLogistica);

    const valutazioneAccessibilita = document.createElement("h2");
    valutazioneAccessibilita.textContent = "Accessibilità: " + parseFloat(statistiche.MediaAccessibilita).toFixed(1);
    contenitoreValutazioneLogistica.appendChild(valutazioneAccessibilita);

    const valutazioneParcheggio = document.createElement("h2");
    if(statistiche.MediaParcheggio){
        valutazioneParcheggio.textContent = "Parcheggio: " + parseFloat(statistiche.MediaParcheggio).toFixed(1);
        contenitoreValutazioneLogistica.appendChild(valutazioneParcheggio);
    }
    else{
        valutazioneParcheggio.textContent = "Parcheggio:";
        const parcheggioNull = document.createElement("p");
        parcheggioNull.textContent = "Nessuna informazione sui parcheggi.";
        contenitoreValutazioneLogistica.appendChild(valutazioneParcheggio);
        contenitoreValutazioneLogistica.appendChild(parcheggioNull);
    }

    const valutazioneGestioneIngressi = document.createElement("h2");
    valutazioneGestioneIngressi.textContent = "Gestione ingressi: " + parseFloat(statistiche.MediaGestioneIngressi).toFixed(1);
    contenitoreValutazioneLogistica.appendChild(valutazioneGestioneIngressi);

    //Servizi
    const contenitoreValutazioneServizi = document.createElement("div");
    contenitoreValutazioneServizi.classList.add("contenitore_macrocampo");
    contenitore.appendChild(contenitoreValutazioneServizi);

    const valutazioneServizi = document.createElement("h1");
    if(statistiche.MediaServizi){
        valutazioneServizi.textContent = "Servizi: " + parseFloat(statistiche.MediaServizi).toFixed(1);
        contenitoreValutazioneServizi.appendChild(valutazioneServizi);

        //se ci sono informazioni sui servizi mostriamo anche i sottocampi
        const valutazioneServiziIgenici = document.createElement("h2");
        if(statistiche.MediaServiziIgenici){
            valutazioneServiziIgenici.textContent = "Servizi igenici: " + parseFloat(statistiche.MediaServiziIgenici).toFixed(1);
            contenitoreValutazioneServizi.appendChild(valutazioneServiziIgenici);
        }
        else{
            valutazioneServiziIgenici.textContent = "Servizi igenici:";
            const serviziIgeniciNull = document.createElement("p");
            serviziIgeniciNull.textContent = "Nessuna informazione sui servizi igenici.";
            contenitoreValutazioneServizi.appendChild(valutazioneServiziIgenici);
            contenitoreValutazioneServizi.appendChild(serviziIgeniciNull);
        }

        const valutazioneRistorazione = document.createElement("h2");
        if(statistiche.MediaRistorazione){
            valutazioneRistorazione.textContent = "Ristorazione: " + parseFloat(statistiche.MediaRistorazione).toFixed(1);
            contenitoreValutazioneServizi.appendChild(valutazioneRistorazione);
        }
        else{
            valutazioneRistorazione.textContent = "Ristorazione:";
            const ristorazioneNull = document.createElement("p");
            ristorazioneNull.textContent = "Nessuna informazione sui servizi di ristorazione.";
            contenitoreValutazioneServizi.appendChild(valutazioneRistorazione);
            contenitoreValutazioneServizi.appendChild(ristorazioneNull);
        }
    } else {
        valutazioneServizi.textContent = "Servizi:";
        const serviziNull = document.createElement("p");
        serviziNull.textContent = "Nessuna informazione sui servizi.";
        contenitoreValutazioneServizi.appendChild(valutazioneServizi);
        contenitoreValutazioneServizi.appendChild(serviziNull);
    }
}