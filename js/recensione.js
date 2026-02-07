const valutazioni = ["Pessimo", "Scarso", "Medio", "Buono", "Eccellente"];
document.addEventListener("DOMContentLoaded", inizializza);

function inizializza(){
    attivaListeners();
}

function attivaListeners(){
    const paese = document.getElementById("paese");
    paese.addEventListener("change", ()=>{
        paeseSelezionato(paese.value);
    });
    paese.addEventListener("change", aggiornaPagina);
    const stadio = document.getElementById("stadio");
    stadio.addEventListener("change", aggiornaPagina);
    const settore = document.getElementById("settore");
    settore.addEventListener("change", aggiornaPagina);
    const data = document.getElementById("data");
    data.addEventListener("change", aggiornaPagina);
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    radioButtons.forEach( r =>{
        r.addEventListener("change", aggiornaPagina);
    });
    //seleziono le labels perchè ho nascosto i radio button, quindi il mouse non gli passa mai sopra
    const labels = document.querySelectorAll('.rating label');
    labels.forEach(l => {
        l.addEventListener("mouseover", () => {
            aggiornaTesto(l, true);
        });
        l.addEventListener("mouseout", () => {
            aggiornaTesto(l, false);
        })
        l.addEventListener("click", () => {
            aggiornaTesto(l, true);
        })
    });
    const bottoneSubmit = document.getElementById("bottone_submit");
    bottoneSubmit.addEventListener("click", inviaForm);
    const bottoneBackHome = document.getElementById("back_home");
    bottoneBackHome.addEventListener("click", ()=>{
        window.location.href = "../index.php";
    });
}

function paeseSelezionato(paese){
    svuotaFormStadio();
    if(paese != ""){
        recuperaStadi(paese);
    }
}

function svuotaFormStadio(){
    //resettiamo le option
    const stadio = document.getElementById("stadio");
    stadio.innerHTML = "";
    const optionDefault = document.createElement("option");
    optionDefault.value  = "";
    optionDefault.textContent = "-- Seleziona uno stadio --";
    stadio.appendChild(optionDefault);
    //resettiamo il settore
    const settore = document.getElementById("settore");
    settore.value = "";
    //resettiamo la data
    const data = document.getElementById("data");
    const today = new Date();
    data.value = today.value;

}

function recuperaStadi(paese){
    fetch('fetchData.php?action=get_stadi&paese='+ encodeURIComponent(paese))
        .then(res => res.json())
        .then(data => {
            const stadio = document.getElementById("stadio");
            data.forEach(s => {
                const nodo = document.createElement("option");
                nodo.value = s.Stadium;
                nodo.textContent = s.Stadium;
                stadio.appendChild(nodo);
            });
        })
}

function aggiornaPagina(){
    const contenitoreRecensione = document.getElementById("contenitore_recensione");
    const bottoneSubmit = document.getElementById("bottone_submit");
    const paese = document.getElementById("paese");
    const stadio = document.getElementById("stadio");
    const settore = document.getElementById("settore");
    const data = document.getElementById("data");
    const dataSelezionata = new Date(data.value);
    const today = new Date();
    today.setHours(0,0,0,0);
    if(paese.validity.valid && stadio.validity.valid && settore.validity.valid && data.validity.valid && dataSelezionata <= today){
        //ci sono tutte le condizioni per mostrare lo spazio per lasciare la recensione
        contenitoreRecensione.classList.remove("hidden");
        //controllo se i parametri della recensione ci sono tutti
        const votoVisibilita = document.querySelector('input[name="visibilita"]:checked');
        const votoCopertura = document.querySelector('input[name="copertura"]:checked');
        const votoDistanzaCampo = document.querySelector('input[name="distanza_campo"]:checked');
        const votoAccessibilita = document.querySelector('input[name="accessibilita"]:checked');
        const votoGestioneIngressi = document.querySelector('input[name="gestione_ingressi"]:checked');
        if( votoVisibilita && votoCopertura && votoDistanzaCampo && votoAccessibilita && votoGestioneIngressi)
            bottoneSubmit.removeAttribute("disabled");
    } else {
        contenitoreRecensione.classList.add("hidden");
        bottoneSubmit.setAttribute("disabled","true");
    }
}

function aggiornaTesto(l, isHovering){
    const idParametro = l.getAttribute("for");
    const parametro = document.getElementById(idParametro);
    const idParagrafo = "testo_valutazione_" + parametro.name;
    const paragrafo = document.getElementById(idParagrafo);
    if(isHovering){
        paragrafo.textContent = valutazioni[parseInt(parametro.value) - 1];
    } else {
        //se sto facendo mouse out con il cursore allora
        //cerco un input con lo stesso name dell'input che ha attivato il listener, che sia anche :checked
        const checked = document.querySelector(`input[name="${parametro.name}" ]:checked`);
        //se checked esiste aggiorno il contenuto del paragrafo con la valutazione relativa, altrimenti lo svuoto
        paragrafo.textContent = (checked) ? valutazioni[parseInt(checked.value) - 1] : "";
    }
    
}

function inviaForm(e){
    e.preventDefault();
    const formRecensione = document.getElementById("recensione");
    const formData = new FormData(formRecensione);
    //ricostruisco manualmente i valori del form sullo stadio
    const stadioValue = document.getElementById("stadio").value;
    const settoreValue = document.getElementById("settore").value;
    const dataValue = document.getElementById("data").value;
    formData.append('stadio', stadioValue);
    formData.append('settore', settoreValue);
    formData.append('data', dataValue);
    fetch("setRecensione.php", { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
        alert(data.message);
        if (data.success){
            //reinderizzo l'utente alla sua homepage
            window.location.href = "../index.php";
        }
        });
}
