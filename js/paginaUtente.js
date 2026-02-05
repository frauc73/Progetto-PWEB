const paesiSquadre = ["Francia", "Germania", "Inghilterra", "Italia", "Spagna"];
const srcDefault = "../src/posts/Default.png";
document.addEventListener("DOMContentLoaded",inizializza);
function inizializza(){
    //se la pagina è quella personale dell'utente loggato allora setto i listeners
    const isOwner = document.body.dataset.isOwner === "true";
    const usernameProfilo = document.body.dataset.currentProfileUser;
    const following = document.body.dataset.following === "true";
    if(isOwner)
        settaListeners();
    else
        attivaListenerSegui(following, usernameProfilo);
    //setto il listener per il cambio filtro
    const filtri = document.querySelectorAll('input[name="filtro_post"]');;
    filtri.forEach(radio => {
        radio.addEventListener("change", (e) => {
            // e.target.value conterrà "tutti", "eventi" o "recensioni"
            filtroPost(e.target.value); 
        });
    });
    riempiBacheca(usernameProfilo,isOwner);
}

function settaListeners(){
    //setto i listener per i bottoni
    const bottoneFotoProfilo = document.getElementById("modifica_foto_profilo");
    bottoneFotoProfilo.addEventListener("click", ()=>{
        apriDialog("foto_profilo");
    });
    const bottoneDescrizione = document.getElementById("modifica_descrizione");
    bottoneDescrizione.addEventListener("click", ()=>{
        apriDialog("descrizione");
    });
    const bottoneSquadra = document.getElementById("modifica_squadra");
    bottoneSquadra.addEventListener("click", ()=>{
        apriDialog("squadra");
    });

    //setto il listener per chiudere la dialog
    const annullaDialog = document.getElementById("annulla_dialog");
    annullaDialog.addEventListener("click", () => {
        const dialog = document.getElementById("dialog_modifiche");
        if (typeof dialog.close === "function") {
            dialog.close();
        } else {
            // Fallback per Firefox < 98
            dialog.removeAttribute("open");
            document.body.classList.remove("modal-open-fallback");
        }
    });

    //setto il listener per modificare il campo del profilo
    const confermaModifiche = document.getElementById("conferma_modifiche");
    confermaModifiche.addEventListener("click", () => {
        setModificheCampi();
    });
}

function attivaListenerSegui(following,username){
    if(!following){
        const bottoneFollow = document.getElementById("follow_utente");
        bottoneFollow.addEventListener("click", ()=>{
            aggiornaFollowingUser("follow", username);
        })
    } else {
        const bottoneUnfollow = document.getElementById("unfollow_utente");
        bottoneUnfollow.addEventListener("click", ()=>{
            aggiornaFollowingUser("unfollow", username);
        }) 
    }
}

function aggiornaFollowingUser(azione,username){
    fetch("seguiUtente.php?azione="+azione+"&followed=" + username)
            .then(res => res.json())
            .then(data =>{
                if(data.success){
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert("Error:" + data.message);
                }
            });
}

function filtroPost(parametro){
    const recensioni = document.querySelectorAll(".contenitore_recensione");
    const eventi = document.querySelectorAll(".contenitore_evento");
    recensioni.forEach(r => {
        if(parametro === "eventi")
            r.classList.add("hidden");
        else
            r.classList.remove("hidden");
    });
    eventi.forEach(e => {
        if(parametro === "recensioni")
            e.classList.add("hidden");
        else
            e.classList.remove("hidden");
    });
}

function riempiBacheca(username,isOwner){
    fetch('recuperaDatiBacheca.php?username=' + username)
        .then(res => res.json())
        .then(data =>{
            //svuoto la bacheca da contenuti precedenti
            const contenitorePost = document.getElementById("contenitore_post");
            contenitorePost.innerHTML = "";
            //recuperiamo i paragrafi delle statistiche da riempire
            const numEventi = document.getElementById("num_eventi");
            const numRecensioni = document.getElementById("num_recensioni_scritte");
            const numStadiVisitati = document.getElementById("num_stadi_visitati");
            const squadraPiuVista = document.getElementById("squadra_piu_vista");
            const logoSquadraPiuVista = document.getElementById("logo_squadra_statitstiche");

            let eventi = 0;
            let recensioni = 0;
            let stadiVisitati = [];
            let squadreViste = {};
            data.forEach(post =>{
                //qui devo costruire la struttura del post
                //quindi creando gli elementi creo lo scheletro e assegnandogli le classi posso modificare lo stile in CSS
                let nuovoPost = null;
                if(post.type === 'evento'){
                    nuovoPost = disegnaEvento(post,isOwner);
                    eventi++;
                    const squadreParita  = [post.HomeTeam,post.AwayTeam];
                    squadreParita.forEach(s =>{
                        if(squadreViste[s]){
                            squadreViste[s]++;
                        } else {
                            squadreViste[s] = 1;
                        }
                    });
                }
                else if (post.type === 'recensione'){
                    nuovoPost = disegnaRecensione(post, isOwner, true);
                    recensioni++;
                }
                if(nuovoPost){
                    contenitorePost.appendChild(nuovoPost);
                }
                if(!stadiVisitati.includes(post.NomeStadio)){
                    stadiVisitati.push(post.NomeStadio);
                }
            });

            let squadraTop = "-";
            let maxViste = 0;

            for (const [squadra, viste] of Object.entries(squadreViste)){
                if (viste > maxViste) {
                    maxViste = viste;
                    squadraTop = squadra;
                }
            }

            numEventi.textContent = eventi;
            numRecensioni.textContent = recensioni;
            numStadiVisitati.textContent = stadiVisitati.length;
            squadraPiuVista.textContent = squadraTop;
            if(eventi != 0 || recensioni != 0)
                disegnaLogoSquadra(squadraTop, logoSquadraPiuVista);
        })
}

function apriDialog(tipo){
    const dialog = document.getElementById("dialog_modifiche");
    dialog.dataset.azione = tipo;
    const contenitoreDialog = document.getElementById("contenuto_dialog");
    contenitoreDialog.innerHTML = "";
    const h2 = document.createElement("h2");
    contenitoreDialog.appendChild(h2);
    if(tipo === "squadra"){
        riempiDialogSquadra(contenitoreDialog, h2);
    } else if (tipo === "foto_profilo") {
        riempiDialogFotoProfilo(contenitoreDialog, h2);
    } else if (tipo === "descrizione") {
        riempiDialogDescrizione(contenitoreDialog, h2);
    } else {
        return;
    }
    document.getElementById("conferma_modifiche").disabled = true;
    if (typeof dialog.showModal === "function") {
        dialog.showModal();
    } else {
        // Fallback per Firefox < 98
        dialog.setAttribute("open", "");
        document.body.classList.add("modal-open-fallback");
    }
}

function riempiDialogSquadra(contenitoreDialog, h2){
    h2.textContent = "Modifica la tua squadra del cuore";

    //costruiamo la select per scegliere il Paese
    const selectPaese = document.createElement("select");
    selectPaese.name = "paese_dialog";
    selectPaese.id = "paese_dialog";
    contenitoreDialog.appendChild(selectPaese);

    //costruiamo la option di default
    const optionDefault = document.createElement("option");
    optionDefault.value = "";
    optionDefault.textContent = "-- Seleziona un Paese --";
    selectPaese.appendChild(optionDefault);

    //costruiamo le option del select
    paesiSquadre.forEach(p => {
        const option = document.createElement("option");
        option.value = p;
        option.textContent = p;
        selectPaese.appendChild(option);
    });

    //attiviamo un listener sul cambio del paese
    selectPaese.addEventListener("change", ()=>{
        paeseSelezionato(selectPaese.value);
    })

    //costruiamo la select per scegliere la squadra
    const select = document.createElement("select");
    select.name = "select_squadra";
    select.id = "select_squadra";
    select.required = true;
    select.classList.add("modifica_squadra");
    select.classList.add("hidden");
    select.addEventListener("change", (e)=>{
        const logo = document.querySelector(".logo_squadra_dialog");
        disegnaLogoSquadra(select.value,logo);
        attivaBottoneConferma(e);
    });
    contenitoreDialog.appendChild(select);
    //costruiamo lo spazio dove mettere l'img
    const logo = document.createElement("img");
    logo.src = srcDefault;
    logo.classList.add("logo_squadra_dialog");
    logo.classList.add("hidden");
    contenitoreDialog.appendChild(logo);
}

function paeseSelezionato(paese){
    //ripuliamo il contenuto precedente
    const select = document.querySelector(".modifica_squadra");
    select.value = "";
    select.classList.remove("hidden");
    const logo = document.querySelector(".logo_squadra_dialog");
    logo.src = srcDefault;
    logo.classList.add("hidden");
    //riempiamo l'option con le squadre
    recuperaSquadre(paese);
}

function recuperaSquadre(paese){
    fetch('fetchData.php?action=get_squadre&paese=' + paese)     
        .then(res => res.json())      
        .then(data => {
            const select = document.querySelector(".modifica_squadra");
            //ripuliamo il select dalle option precedenti
            select.innerHTML = ""
            const optionDefault = document.createElement("option");
            optionDefault.value = "";
            optionDefault.textContent = "-- Seleziona una squadra --";
            select.appendChild(optionDefault);
            data.forEach(o=>{
                const option = document.createElement("option");
                option.value = o.Nome;
                option.textContent = o.Nome;
                select.appendChild(option);
            });
        });
}

function disegnaLogoSquadra(squadra,logo){
    if(!squadra) {
        logo.classList.add("hidden");
        return;
    }
    fetch(`fetchData.php?action=get_info_squadra&Nome=${encodeURIComponent(squadra)}`)
    .then(res => res.json())
    .then(data => {
      logo.src = data.logo_path;
      logo.alt = "Logo della squadra";
      logo.classList.remove("hidden");
    });
}

function riempiDialogFotoProfilo(contenitoreDialog, h2){
    h2.textContent = "Modifica la tua foto profilo";
    
    //costruiamo l'input per selezionare il file
    const input = document.createElement("input");
    input.required = true;
    input.type = "file";
    input.name = "foto_profilo";
    input.id = "select_foto_profilo";
    input.setAttribute("accept",".jpg,.jpeg,.png");
    input.addEventListener("change", (e)=>{
        mostraAnteprimaFotoProfilo(e);
        attivaBottoneConferma(e);
    });
    contenitoreDialog.appendChild(input);

    //costruiamo lo spazio per mostrare l'anteprima dell'immagine
    const img = document.createElement("img");
    img.src = srcDefault;
    img.alt = "Anteprima foto profilo";
    img.id = "foto_profilo_dialog";
    img.classList.add("hidden");
    contenitoreDialog.appendChild(img);
}

function mostraAnteprimaFotoProfilo(e){
    const fileInput = e.target;
    const anteprima = document.getElementById("foto_profilo_dialog");
  
    // Controllo se è stato selezionato almeno un file
    if (fileInput.files && fileInput.files[0]) {
      const reader = new FileReader();
      reader.onload = function(event) {
        anteprima.src = event.target.result; 
        anteprima.classList.toggle("hidden");
      };
      reader.readAsDataURL(fileInput.files[0]);
    } else {
      // Se l'utente deseleziona l'immagine, nascondo l'anteprima o rimetto un placeholder
      anteprima.src = "../src/profile_pic/default.png";
      anteprima.classList.toggle("hidden");
    }
}

function riempiDialogDescrizione(contenitoreDialog, h2){
    h2.textContent = "Modifica la descrizione del tuo profilo";

    const textarea = document.createElement("textarea");
    textarea.name = "descrizione_dialog";
    textarea.id = "descrizione_dialog";
    textarea.required = "true";
    contenitoreDialog.appendChild(textarea);

    textarea.addEventListener("input", attivaBottoneConferma);
}

function attivaBottoneConferma(e){
    const btn = document.getElementById("conferma_modifiche");
    if(e.target.checkValidity()){
        btn.disabled = false;
    }
}

function setModificheCampi(){
    //recupero il tipo di azione da confermare
    const dialog = document.getElementById("dialog_modifiche");
    const azione = dialog.dataset.azione;

    //creo l'oggetto FormData
    const dati = new FormData;
    dati.append("azione", azione);

    //riempio il form con i dati che servono
    if(azione === "foto_profilo"){
        //recupero il path della foto caricata
        const nuovaFotoProfilo = document.getElementById("select_foto_profilo");
        if(nuovaFotoProfilo.files.length > 0){
            dati.append("foto_profilo", nuovaFotoProfilo.files[0]);
        } else {
            alert("Nessun file selezionato");
            return;
        }
    } else if (azione === "descrizione") {
        const nuovaDescrizione = document.getElementById("descrizione_dialog").value;
        dati.append("descrizione", nuovaDescrizione);
    } else if (azione === "squadra") {
        const nuovaSquadra = document.getElementById("select_squadra").value;
        dati.append("squadra", nuovaSquadra);
    } else {
        alert("Azione non consentita");
        return;
    }
    fetch("modificaCampiProfilo.php", {method : 'POST', body: dati})
        .then(res => res.json())
        .then(data =>{
            if (typeof dialog.close === "function") {
                dialog.close();
            } else {
                // Fallback per Firefox < 98
                dialog.removeAttribute("open");
                document.body.classList.remove("modal-open-fallback");
            }
            if(data.success){
                aggiornaInterfaccia(azione, dati);
                alert(data.message);
            } else {
                alert("Errore: "+ data.message + " " + data.squadra);
            }
        })
}

function aggiornaInterfaccia(azione, dati){
    if(azione === "squadra"){
        const p = document.getElementById("testo_squadra_supportata");
        p.textContent = dati.get("squadra");
        const logoSquadraSupportata = document.querySelector(".logo_squadra_supportata");
        disegnaLogoSquadra(dati.get("squadra"), logoSquadraSupportata);
    } else if(azione === "descrizione") {
        const p = document.getElementById("testo_descrizione");
        p.textContent = dati.get("descrizione");
    } else if(azione === "foto_profilo"){
        const file = dati.get("foto_profilo");
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Aggiorno la foto nella sidebar
                const imgProfilo = document.getElementById("foto_profilo");
                if (imgProfilo) 
                    imgProfilo.src = e.target.result;

                // Aggiorno la miniatura nell'header
                const imgHeader = document.querySelector(".profile-pic");
                if (imgHeader) 
                    imgHeader.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
}