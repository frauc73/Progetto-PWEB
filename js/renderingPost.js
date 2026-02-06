function disegnaEvento(post, isOwner, mostraUtente = false, usernameUtente = "" ,fotoUtente = "", homepage = false, paginaStadio = false){
    const contenitoreEvento = document.createElement("article");
    contenitoreEvento.classList.add("contenitore_evento");
    contenitoreEvento.id = "evento_" + post.IdPost;

    //se mostriamo la pagina dell'utente loggato inseriamo anche i bottoni per eliminare i post
    if(isOwner){
        aggiungiBottoneElimina(contenitoreEvento, "evento", post.IdPost);
    }
    if(mostraUtente){
        aggiungiDettagliUtente(contenitoreEvento, usernameUtente, fotoUtente, homepage);
    }
    //qua va aggiunto il codice per inserire la foto profilo dell'utente e il suo username
    //vanno aggiunti solo nella homepage
    const contenitorePF = document.createElement("div");
    contenitorePF.classList.add("contenitore_PF");
    contenitoreEvento.appendChild(contenitorePF);

    const contenitorePartita = document.createElement("div");
    contenitorePartita.classList.add("contenitore_partita");
    contenitorePF.appendChild(contenitorePartita);
    
    const grigliaPartita = document.createElement("div");
    grigliaPartita.classList.add("griglia_partita");
    contenitorePartita.appendChild(grigliaPartita);

    const squadraCasa = document.createElement("div");
    squadraCasa.classList.add("contenitore_squadra");
    grigliaPartita.appendChild(squadraCasa);
    const logoSquadraCasa = document.createElement("img");
    logoSquadraCasa.classList.add("logo_squadra");
    logoSquadraCasa.src = post.pathSquadraCasa;
    logoSquadraCasa.setAttribute("alt", "Logo della squadra di casa")
    squadraCasa.appendChild(logoSquadraCasa);
    const nomeSquadraCasa = document.createElement("p");
    nomeSquadraCasa.textContent = post.HomeTeam;
    nomeSquadraCasa.classList.add("nome_squadra");
    squadraCasa.appendChild(nomeSquadraCasa);

    const punteggio = document.createElement("div");
    punteggio.classList.add("punteggio");
    grigliaPartita.appendChild(punteggio);
    const stringaPunteggio = document.createElement("p");
    stringaPunteggio.textContent = post.GoalHT + "-" + post.GoalAT;
    punteggio.appendChild(stringaPunteggio);

    const squadraOspite = document.createElement("div");
    squadraOspite.classList.add("contenitore_squadra");
    grigliaPartita.appendChild(squadraOspite);
    const logoSquadraOspite = document.createElement("img");
    logoSquadraOspite.classList.add("logo_squadra");
    logoSquadraOspite.src = post.pathSquadraOspite;
    logoSquadraOspite.setAttribute("alt", "Logo della squadra ospite")
    squadraOspite.appendChild(logoSquadraOspite);
    const nomeSquadraOspite = document.createElement("p");
    nomeSquadraOspite.textContent = post.AwayTeam;
    nomeSquadraOspite.classList.add("nome_squadra");
    squadraOspite.appendChild(nomeSquadraOspite);

    if(!paginaStadio){
        const ancoraStadio = document.createElement("a");
        //costruisco il path in maniera diversa se mi trovo in homepage
        if(homepage)
            ancoraStadio.href = "./php/paginaStadio.php?stadio=" + encodeURIComponent(post.NomeStadio);
        else
            ancoraStadio.href = "paginaStadio.php?stadio=" + encodeURIComponent(post.NomeStadio);
        contenitorePartita.appendChild(ancoraStadio);
        const nomeStadio = document.createElement("p");
        nomeStadio.textContent = post.NomeStadio;
        ancoraStadio.appendChild(nomeStadio);
    } else {
        const nomeStadio = document.createElement("p");
        nomeStadio.textContent = post.NomeStadio;
        contenitorePartita.appendChild(nomeStadio);
    }

    const dataPartita = document.createElement("p");
    dataPartita.textContent = post.DataMatch;
    contenitorePartita.appendChild(dataPartita);

    const contenitoreFotoRicordo = document.createElement("div");
    contenitoreFotoRicordo.classList.add("contenitore_foto_ricordo");
    contenitorePF.appendChild(contenitoreFotoRicordo);

    if(post.PathFotoRicordo){
        const fotoRicordo = document.createElement("img");
        if(homepage)
            fotoRicordo.src = "./" + post.PathFotoRicordo;
        else
            fotoRicordo.src = "../" + post.PathFotoRicordo;
        fotoRicordo.setAttribute("alt", "Foto ricordo della partita")
        fotoRicordo.classList.add("foto_ricordo")
        contenitoreFotoRicordo.appendChild(fotoRicordo);
    }

    const contenitoreDescrizione = document.createElement("div");
    contenitoreDescrizione.classList.add("contenitore_descrizione");
    contenitoreEvento.appendChild(contenitoreDescrizione);

    const descrizione = document.createElement("p");
    descrizione.textContent = post.DescrizionePost;
    contenitoreDescrizione.appendChild(descrizione);

    return contenitoreEvento;
}

function disegnaRecensione(post, isOwner, utente = false, mostraUtente = false, usernameUtente = "" ,fotoUtente = "", homepage = false){
    const contenitoreRecensione = document.createElement("article");
    contenitoreRecensione.classList.add("contenitore_recensione");
    contenitoreRecensione.id = "recensione_" + post.IdRecensione;

    //se mostriamo la pagina dell'utente loggato inseriamo anche i bottoni per eliminare i post
    if(isOwner){
        aggiungiBottoneElimina(contenitoreRecensione, "recensione", post.IdRecensione);
    }

    //mostraUtente è true quando disegno la homepage e le pagine dello stadio
    if(mostraUtente){
        aggiungiDettagliUtente(contenitoreRecensione, usernameUtente, fotoUtente, homepage);
    }

    const contenitoreSD = document.createElement("div");
    contenitoreSD.classList.add("contenitore_SD");
    contenitoreRecensione.appendChild(contenitoreSD);

    //utente deve essere true nei rendering delle bacheche degli utenti (homepage e paginaUtente)
    //deve essere false nei rendering delle pagine per gli Stadi
    if(utente){
        const ancoraStadio = document.createElement("a");
        if(homepage)
            ancoraStadio.href = "./php/paginaStadio.php?stadio=" + encodeURIComponent(post.Stadio);
        else
            ancoraStadio.href = "paginaStadio.php?stadio=" + encodeURIComponent(post.Stadio);
        contenitoreSD.appendChild(ancoraStadio);
        const nomeStadio = document.createElement("p");
        nomeStadio.textContent = post.Stadio;
        ancoraStadio.appendChild(nomeStadio);
    }

    const settore = document.createElement("p");
    settore.textContent = post.Settore;
    contenitoreSD.appendChild(settore);

    const dataRecensione = document.createElement("p");
    dataRecensione.textContent = post.DataRecensione;
    contenitoreSD.appendChild(dataRecensione);

    const contenitoreVoti = document.createElement("div");
    contenitoreVoti.classList.add("contenitore_voti");
    contenitoreRecensione.appendChild(contenitoreVoti);

    //disegnamo il contenitore dei voti relativi all'impianto
    const impianto = document.createElement("div");
    impianto.classList.add("impianto");
    contenitoreVoti.appendChild(impianto);

    const h2Impianto = document.createElement("h2");
    h2Impianto.textContent = "Impianto";
    impianto.appendChild(h2Impianto);

    const h3Visibilita = document.createElement("h3");
    h3Visibilita.textContent = "Visibilità";
    impianto.appendChild(h3Visibilita);
    const votoVisibilita = disegnaVoto("visibilita", post.VotoVisibilita, homepage);
    impianto.appendChild(votoVisibilita);

    const h3Copertura = document.createElement("h3");
    h3Copertura.textContent = "Copertura";
    impianto.appendChild(h3Copertura);
    const copertura =  document.createElement("p");
    copertura.textContent = post.Copertura;
    impianto.appendChild(copertura);

    const h3DistanzaCampo = document.createElement("h3");
    h3DistanzaCampo.textContent = "Distanza dal campo";
    impianto.appendChild(h3DistanzaCampo);
    const votoDistanzaCampo = disegnaVoto("DistanzaCampo", post.VotoDistanzaCampo, homepage);
    impianto.appendChild(votoDistanzaCampo);

    //disegnamo il contenitore dei voti relativi alla logistica
    const logistica = document.createElement("div");
    logistica.classList.add("logistica");
    contenitoreVoti.appendChild(logistica);

    const h2Logistica = document.createElement("h2");
    h2Logistica.textContent = "Logistica";
    logistica.appendChild(h2Logistica);

    const h3Accessibilita = document.createElement("h3");
    h3Accessibilita.textContent = "Accessibilità";
    logistica.appendChild(h3Accessibilita);
    const votoAccessibilita = disegnaVoto("accessibilita", post.VotoAccessibilita, homepage);
    logistica.appendChild(votoAccessibilita);

    const h3Parcheggio = document.createElement("h3");
    h3Parcheggio.textContent = "Parcheggio";
    logistica.appendChild(h3Parcheggio);
    const votoParcheggio = disegnaVoto("parcheggio", post.VotoParcheggio, homepage);
    logistica.appendChild(votoParcheggio);

    const h3GestioneIngressi = document.createElement("h3");
    h3GestioneIngressi.textContent = "Gestione ingressi";
    logistica.appendChild(h3GestioneIngressi);
    const votoGestioneIngressi = disegnaVoto("gestione_ingressi", post.VotoGestioneIngressi, homepage);
    logistica.appendChild(votoGestioneIngressi);

    //disegnamo il contenitore dei voti relativi ai servizi
    const servizi = document.createElement("div");
    servizi.classList.add("servizi");
    contenitoreVoti.appendChild(servizi);

    const h2Servizi = document.createElement("h2");
    h2Servizi.textContent = "Servizi";
    servizi.appendChild(h2Servizi);

    const h3ServiziIgenici = document.createElement("h3");
    h3ServiziIgenici.textContent = "Servizi igenici";
    servizi.appendChild(h3ServiziIgenici);
    const votoServiziIgenici = disegnaVoto("servizi_igenici", post.VotoServiziIgenici, homepage);
    servizi.appendChild(votoServiziIgenici);


    const h3Ristorazione = document.createElement("h3");
    h3Ristorazione.textContent = "Ristorazione";
    servizi.appendChild(h3Ristorazione);
    const votoRistorazione = disegnaVoto("ristorazione", post.VotoRistorazione, homepage);
    servizi.appendChild(votoRistorazione);

    return contenitoreRecensione;
}

function disegnaVoto(classe, voto, homepage){
    const contenitore = document.createElement("div");
    contenitore.classList.add(classe);
    if(!voto){
        const testo = document.createElement("p");
        testo.textContent = "L'utente non ha usufruito del servizio."
        contenitore.appendChild(testo);
    } else {
        for(let i = 0; i < voto; i++){
            //dobbiamo disegnare n icone del pallone, dove n = voto
            const icona = document.createElement("img");
            if(homepage)
                icona.src = "./src/icons/icons8-calcio-2-30.png";
            else
                icona.src = "../src/icons/icons8-calcio-2-30.png";
            icona.classList.add("icona_pallone");
            contenitore.appendChild(icona);
        }
    }
    return contenitore;
}

function aggiungiBottoneElimina(contenitore, tipo, id){
    const contentioreBottoneElimina = document.createElement("div");
    contentioreBottoneElimina.classList.add("contenitore_bottone_elimina");
    contenitore.appendChild(contentioreBottoneElimina);
    const bottoneElimina = document.createElement("button");

    const iconaDelete = document.createElement("img");
    iconaDelete.src = "../src/icons/delete.png";
    iconaDelete.alt = "Icona delete";
    bottoneElimina.appendChild(iconaDelete);
    bottoneElimina.classList.add("bottone_elimina");
    bottoneElimina.addEventListener("click", ()=>{
        const dati = new FormData;
        dati.append("azione", "elimina_post");
        dati.append("tipo", tipo);
        dati.append("id_post", id);

        fetch("modificaCampiProfilo.php", {method : 'POST', body: dati})
            .then(res=> res.json())
            .then(data =>{
                //dopo aver eseguito la query di eliminazione aggiorno la pagina
                if(data.success){
                    contenitore.innerHTML = "";
                    contenitore.classList.add("hidden");
                    alert(data.message);
                } else {
                    alert("Errore: "+ data.message);
                }
            })
    })
    contentioreBottoneElimina.appendChild(bottoneElimina);
}

function aggiungiDettagliUtente(contenitore, usernameUtente, fotoUtente, homepage){
    const contenitoreDettagliUtente = document.createElement("div");
    contenitoreDettagliUtente.classList.add("contenitore_dettagli_utente");
    contenitore.appendChild(contenitoreDettagliUtente);

    const ancoraUtente = document.createElement("a");
    ancoraUtente.classList.add("ancora_utente");
    if(homepage)
        ancoraUtente.href = "./php/paginaUtente.php?username=" + usernameUtente
    else
        ancoraUtente.href = "paginaUtente.php?username=" + usernameUtente;
    contenitoreDettagliUtente.appendChild(ancoraUtente); 

    const immagineUtente = document.createElement("img");
    immagineUtente.classList.add("immagine_utente");
    if(homepage)
        immagineUtente.src = fotoUtente.replace("../", "./");
    else
        immagineUtente.src = fotoUtente;
    ancoraUtente.appendChild(immagineUtente);

    const testoUtente = document.createElement("p");
    testoUtente.classList.add("testo_utente");
    testoUtente.textContent = usernameUtente;
    ancoraUtente.appendChild(testoUtente); 
}