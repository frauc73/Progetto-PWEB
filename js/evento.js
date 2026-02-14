//Variabili di stato per gestire i menù a tendina delle squadre
let ultimaSquadraCasa = "";
let ultimaSquadraOspite = "";
// Al caricamento della pagina: popolo i menù a tendina
document.addEventListener("DOMContentLoaded", inizializza);

function inizializza(){
  attivaListeners();
}

function attivaListeners(){
  const paese = document.getElementById("paese");
  paese.addEventListener("change", ()=>{
    paeseSelezionato(paese.value)
  });
  const squadraCasa = document.getElementById("squadra_casa");
  squadraCasa.addEventListener("change", (e) => { 
    mostraSquadra(e,"casa");
    aggiornaBottone();
  })
  const squadraOspite = document.getElementById("squadra_ospite");
  squadraOspite.addEventListener("change", (e) => { 
    mostraSquadra(e,"ospite");
    aggiornaBottone();
  })

  const punteggioCasa = document.getElementById("punteggio_casa");
  punteggioCasa.addEventListener("change", aggiornaBottone);

  const punteggioOspite = document.getElementById("punteggio_ospite");
  punteggioOspite.addEventListener("change", aggiornaBottone);

  const dataPartita = document.getElementById("data_partita");
  dataPartita.addEventListener("change", aggiornaBottone);

  const inputFoto = document.getElementById("select_foto");
  inputFoto.addEventListener("change", mostraAnteprimaFoto);

  const caption = document.getElementById("caption");
  caption.addEventListener("input", aggiornaBottone);

  const form = document.getElementById("eventoForm");
  form.addEventListener("submit", inviaForm);

  const bottoneBackHome = document.getElementById("back_home");
  bottoneBackHome.addEventListener("click", ()=>{
    window.location.href = "../index.php";
  });
}

function paeseSelezionato(paese){
  const tabella = document.getElementById("table_evento");
  if(paese == ""){
    //nascondiamo tutto
    tabella.classList.add("hidden");
  } else {
    //svuoto eventuali campi option precedenti
    const casa = document.getElementById("squadra_casa");
    casa.innerHTML = "";
    const ospite = document.getElementById("squadra_ospite");
    ospite.innerHTML = "";
    const punteggioCasa = document.getElementById("punteggio_casa");
    punteggioCasa.value = "";
    const punteggioOspite = document.getElementById("punteggio_ospite");
    punteggioOspite.value = "";
    const dataPartita = document.getElementById("data_partita");
    dataPartita.value = "";
    //inserisco la option di default
    const optionDefaultCasa = document.createElement("option");
    optionDefaultCasa.value  = "";
    optionDefaultCasa.textContent = "-- Seleziona una squadra --";
    casa.appendChild(optionDefaultCasa);
    const optionDefaultOspite = optionDefaultCasa.cloneNode(true);
    ospite.appendChild(optionDefaultOspite);
    //pulisco le immagini, il nome dello stadio e della competizione
    const competizione = document.getElementById("competizione");
    competizione.textContent = "";
    const stadio = document.getElementById("stadio");
    stadio.textContent = "";
    const logoCasa = document.getElementById("logo_casa");
    logoCasa.classList.add("hidden");
    logoCasa.removeAttribute("src");
    const logoOspite = document.getElementById("logo_ospite");
    logoOspite.classList.add("hidden");
    logoOspite.removeAttribute("src");
    //recupero le squadre di quel paese
    recuperaSquadre(paese);
    //mostro la tabella
    tabella.classList.remove("hidden");
  }
}

function recuperaSquadre(paese){
  fetch('fetchData.php?action=get_squadre&paese=' + encodeURIComponent(paese))      
      .then(res => res.json())      
      .then(data => {
        const casa = document.getElementById("squadra_casa");
        const ospite = document.getElementById("squadra_ospite");
        data.forEach(s => {
          const opt1 = document.createElement("option");
          const opt2 = document.createElement("option");
          opt1.value = s.Nome;
          opt1.textContent = s.Nome;
          opt2.value = s.Nome;
          opt2.textContent = s.Nome;
          casa.appendChild(opt1);
          ospite.appendChild(opt2);
        });
      });
}

function mostraSquadra(e, tipo){
  const nome = e.target.value;
  const logo = document.getElementById("logo_" + tipo);
  if (!nome){ 
    //in questo pezzo gestisco la situazione di rollback
      logo.classList.add("hidden");
      if (tipo === "casa") {
        document.getElementById("competizione").textContent = "";
        document.getElementById("stadio").textContent = "";
        if (ultimaSquadraCasa !== "") {
          const daSbloccare = document.querySelector(`#squadra_ospite option[value="${ultimaSquadraCasa}"]`);
          if(daSbloccare) 
            daSbloccare.disabled = false;
        }
        ultimaSquadraCasa = "";
      } 
      else {
        if (ultimaSquadraOspite !== "") {
          const daSbloccare = document.querySelector(`#squadra_casa option[value="${ultimaSquadraOspite}"]`);
          if(daSbloccare) 
            daSbloccare.disabled = false;
        }
        ultimaSquadraOspite = "";
      }
      return; 
    }
  logo.classList.remove("hidden"); 
  fetch(`fetchData.php?action=get_info_squadra&Nome=${encodeURIComponent(nome)}`)
    .then(res => res.json())
    .then(data => {
      logo.src = data.logo_path;
      logo.style.display = "block";
      if(tipo ===  "casa"){
        const competizione = document.getElementById("competizione");
        competizione.textContent = data.Campionato;
        const stadio = document.getElementById("stadio");
        stadio.textContent = data.NomeStadio;
      }
    });
    //Devo aggiornare la disponibilità delle squadre
    if(tipo === "casa"){
      //Se sto inserendo la squadra di casa
      //Disabilito la possibilità di selezionare la stessa squadra all'ospite
      const ospite = document.querySelector(`#squadra_ospite option[value="${nome}"]`);
      ospite.disabled = true;
      //Riabilito la scelta della squadra di casa che avevo scelto precedentemente
      if(ultimaSquadraCasa !== ""){
        const daSbloccare = document.querySelector(`#squadra_ospite option[value="${ultimaSquadraCasa}"]`);
        daSbloccare.disabled = false;
      }
      ultimaSquadraCasa = nome;
    } else {
      //applico lo stesso meccanismo che funziona se scelgo prima la squadra ospite
      const casa = document.querySelector(`#squadra_casa option[value="${nome}"]`);
      casa.disabled = true;
      if(ultimaSquadraOspite !== ""){
        const daSbloccare = document.querySelector(`#squadra_casa option[value="${ultimaSquadraOspite}"]`);
        daSbloccare.disabled = false;
      }
      ultimaSquadraOspite = nome;
    }
    //gestisco la situazione di rollback
}

function aggiornaBottone(){
  const squadraCasa = document.getElementById("squadra_casa");
  const punteggioCasa = document.getElementById("punteggio_casa");
  const squadraOspite = document.getElementById("squadra_ospite");
  const punteggioOspite = document.getElementById("punteggio_ospite");
  const data = document.getElementById("data_partita");
  const dataSelezionata = new Date(data.value);
  const today = new Date();
  today.setHours(23, 59, 59, 999);
  const caption = document.getElementById("caption");
  const submitButton = document.getElementById("submit_button");
  //attivo il bottone solo se alcune condizioni sono valide
  if(squadraCasa.validity.valid
    && squadraOspite.validity.valid
    && caption.validity.valid
    && punteggioCasa.validity.valid && punteggioCasa.value >= 0 
    && punteggioOspite.validity.valid &&punteggioOspite.value >= 0 
    && data.validity.valid && dataSelezionata <= today){
    submitButton.disabled = false;
  } else {
    submitButton.disabled = true;
  }
}

function mostraAnteprimaFoto(e){
  const fileInput = e.target;
  const anteprima = document.getElementById("foto_ricordo");

  // Controllo se è stato selezionato almeno un file
  if (fileInput.files && fileInput.files[0]) {
    const reader = new FileReader();
    reader.onload = function(event) {
      anteprima.src = event.target.result; 
      anteprima.classList.toggle("hidden");
    };
    reader.readAsDataURL(fileInput.files[0]);
  } else {
    // Se l'utente deseleziona l'immagine, nascondo l'anteprima e rimetto un placeholder
    anteprima.src = "../src/posts/Default.png";
    anteprima.classList.toggle("hidden");
  }
}

function inviaForm(e){
  e.preventDefault();
  const formData = new FormData(e.target);
  fetch("setEvento.php", { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      if (data.success){
        e.target.reset();
        //reinderizzo l'utente alla sua homepage
        window.location.href = "../index.php";
      } else {
        alert("Errore: " + data.message);
      }
    });
  
}