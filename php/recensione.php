<?php
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Crea Recensione</title>
        <link rel="stylesheet" href="../css/shared.css">
        <link rel="stylesheet" href="../css/recensione.css">
        <link rel="icon" href="../src/images/logo_sito.png" type="image/ico">
        <script src="../js/recensione.js"></script>
    </head>
    <body>
        <img src="../src/images/logo_sito.png" alt="logo_sito" id="logo_sito" class="bordered">
        <div id="container">
            <div id="contenitore_stadio">
                <h2>Seleziona lo stadio da recensire</h3>
                <form id="form_stadio" enctype="multipart/form-data">
                    <select name="paese" id="paese" required class="campo_form_stadio">
                        <option value="">-- Seleziona una Nazione --</option>
                        <option value="Francia">Francia</option>
                        <option value="Germania">Germania</option>
                        <option value="Inghilterra">Inghilterra</option>
                        <option value="Italia">Italia</option>
                        <option value="Scozia">Scozia</option>
                        <option value="Spagna">Spagna</option>
                    </select>
                    <select name="stadio" id="stadio" required class="campo_form_stadio">
                        <option value="">--Seleziona lo stadio--</option>
                    </select>
                    <select name="settore" id="settore" required class="campo_form_stadio">
                        <option value="">--Seleziona il settore--</option>
                        <option value="Curva">Curva</option>
                        <option value="Distinti">Distinti</option>
                        <option value="Tribuna">Tribuna</option>
                        <option value="Tribuna Autorità">Tribuna Autorità</option>
                        <option value="Settore Ospiti">Settore Ospiti</option>
                    </select>
                    <input type="date" name="data" id="data" required class="campo_form_stadio">
                </form>
            </div>
            <div id="contenitore_recensione" class="hidden">
                <h2>È il tuo momento, valuta lo stadio!</h2>
                <form id="recensione" enctype="multipart/form-data">
                    <!--Visibilità-->
                    <h3>Visibilità:</h3>
                    <p>Dal settore in cui sei stato quanto si vede bene il campo? Ci sono ostacoli che ostruiscono la vista? Valuta la visibilità:</p>
                    <div id="contenitore_visibilita" class="contenitore_parametro">
                        <div class="rating">
                            <input type="radio" name="visibilita" id="vis-5" value="5">
                            <label for="vis-5" title="Eccezionale">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="visibilita" id="vis-4" value="4">
                            <label for="vis-4" title="Buono">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="visibilita" id="vis-3" value="3">
                            <label for="vis-3" title="Medio">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="visibilita" id="vis-2" value="2">
                            <label for="vis-2" title="Scarso">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="visibilita" id="vis-1" value="1">
                            <label for="vis-1" title="Pessimo">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>
                        </div>
                        <div class="contenitore_testo_valutazione">
                            <p id="testo_valutazione_visibilita" class="testo_valutazione"></p>
                        </div>
                    </div>
                    <!--Copertura--> 
                    <div id="contenitore_copertura">
                        <h3>Copertura:</h3>
                        <p>Il settore dove sei stato era coperto?</p>
                        <div class="rating_copertura">
                            <table>
                                <tr>
                                    <td>
                                        <input type="radio" name="copertura" id="cop-1" value="Si">
                                        <label for="cop-1" title="Si">
                                            <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                                        </label>
                                    </td>
                                    <td>Si</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="radio" name="copertura" id="cop-2" value="No">
                                        <label for="cop-2" title="No">
                                            <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                                        </label>
                                    </td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="radio" name="copertura" id="cop-3" value="Parzialmente">
                                        <label for="cop-3" title="Parzialmente">
                                            <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                                        </label>
                                    </td>
                                    <td>Parzialmente</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!--Distanza dal Campo-->
                    <h3>Distanza dal Campo:</h3>
                    <p>Eri attaccato al terreno di gioco o eri molto lontano? Valuta la posizione del tuo sediolino rispetto al campo:</p>
                    <div id="contenitore_distanza_campo" class="contenitore_parametro">
                        <div class="rating">
                            <input type="radio" name="distanza_campo" id="dc-5" value="5">
                            <label for="dc-5" title="Eccezionale">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="distanza_campo" id="dc-4" value="4">
                            <label for="dc-4" title="Buono">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="distanza_campo" id="dc-3" value="3">
                            <label for="dc-3" title="Medio">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="distanza_campo" id="dc-2" value="2">
                            <label for="dc-2" title="Scarso">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="distanza_campo" id="dc-1" value="1">
                            <label for="dc-1" title="Pessimo">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>
                        </div>
                        <div class="contenitore_testo_valutazione">
                            <p id="testo_valutazione_distanza_campo" class="testo_valutazione"></p>
                        </div>
                    </div>
                    <!--Accessibilità-->
                    <h3>Accessibilità:</h3>
                    <p>Quanto è stato facile raggiungere lo stadio dalla posizione in cui sei partito? Valuta i collegamenti con i mezzi pubblici e la viabilità della zona:</p>
                    <div id="contenitore_accessibilita" class="contenitore_parametro">
                        <div class="rating">
                            <input type="radio" name="accessibilita" id="acc-5" value="5">
                            <label for="acc-5" title="Eccezionale">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="accessibilita" id="acc-4" value="4">
                            <label for="acc-4" title="Buono">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="accessibilita" id="acc-3" value="3">
                            <label for="acc-3" title="Medio">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="accessibilita" id="acc-2" value="2">
                            <label for="acc-2" title="Scarso">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="accessibilita" id="acc-1" value="1">
                            <label for="acc-1" title="Pessimo">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>
                        </div>
                        <div class="contenitore_testo_valutazione">
                            <p id="testo_valutazione_accessibilita" class="testo_valutazione"></p>
                        </div>
                    </div>
                    <!--Parcheggio-->
                    <h3>Parcheggio:</h3>
                    <p>Trovare posto è stato un incubo o una passeggiata? Valuta la gestione dei parcheggi e i costi. Ignora se ti sei mosso a piedi o con i mezzi.</p>
                    <div id="contenitore_parcheggio" class="contenitore_parametro">
                        <div class="rating">
                            <input type="radio" name="parcheggio" id="par-5" value="5">
                            <label for="par-5" title="Eccezionale">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="parcheggio" id="par-4" value="4">
                            <label for="par-4" title="Buono">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="parcheggio" id="par-3" value="3">
                            <label for="par-3" title="Medio">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="parcheggio" id="par-2" value="2">
                            <label for="par-2" title="Scarso">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="parcheggio" id="par-1" value="1">
                            <label for="par-1" title="Pessimo">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>
                        </div>
                        <div class="contenitore_testo_valutazione">
                            <p id="testo_valutazione_parcheggio" class="testo_valutazione"></p>
                        </div>
                    </div>
                    <!--Gestione ingressi-->
                    <h3>Gestione ingressi:</h3>
                    <p>Gli steward ti hanno fatto spazientire o sono stati gentili? Valuta i tempi di attesa ai tornelli e i controlli di sicurezza:</p>
                    <div id="contenitore_gestione_ingressi" class="contenitore_parametro">
                        <div class="rating">
                            <input type="radio" name="gestione_ingressi" id="gi-5" value="5">
                            <label for="gi-5" title="Eccezionale">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="gestione_ingressi" id="gi-4" value="4">
                            <label for="gi-4" title="Buono">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="gestione_ingressi" id="gi-3" value="3">
                            <label for="gi-3" title="Medio">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="gestione_ingressi" id="gi-2" value="2">
                            <label for="gi-2" title="Scarso">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="gestione_ingressi" id="gi-1" value="1">
                            <label for="gi-1" title="Pessimo">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>
                        </div>
                        <div class="contenitore_testo_valutazione">
                            <p id="testo_valutazione_gestione_ingressi" class="testo_valutazione"></p>
                        </div>
                    </div>
                    <!--Servizi igenici-->
                    <h3>Servizi igenici:</h3>
                    <p>L'esperienza al bagno ti ha fatto pentire di aver bevuto quella birra o sei già in fila per prenderne un'altra? Valuta la pulizia e la qualità dei servizi igenici, in base al numero di tifosi. Ignora se non sei andato in bagno.</p>
                    <div id="contenitore_servizi_igenici" class="contenitore_parametro">
                        <div class="rating">
                            <input type="radio" name="servizi_igenici" id="si-5" value="5">
                            <label for="si-5" title="Eccezionale">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="servizi_igenici" id="si-4" value="4">
                            <label for="si-4" title="Buono">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="servizi_igenici" id="si-3" value="3">
                            <label for="si-3" title="Medio">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="servizi_igenici" id="si-2" value="2">
                            <label for="si-2" title="Scarso">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="servizi_igenici" id="si-1" value="1">
                            <label for="si-1" title="Pessimo">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>
                        </div>
                        <div class="contenitore_testo_valutazione">
                            <p id="testo_valutazione_servizi_igenici" class="testo_valutazione"></p>
                        </div>
                    </div>
                    <!--Ristorazione-->
                    <h3>Ristorazione:</h3>
                    <p>Cena stellata sugli spalti oppure meglio il buon vecchio pranzo al sacco? Valuta la qualità, la varietà e i prezzi dei servizi di bar e ristorazione presenti nello stadio. Ignora se la tensione della partita ti ha chiuso lo stomaco.</p>
                    <div id="contenitore_ristorazione" class="contenitore_parametro">
                        <div class="rating">
                            <input type="radio" name="ristorazione" id="ris-5" value="5">
                            <label for="ris-5" title="Eccezionale">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="ristorazione" id="ris-4" value="4">
                            <label for="ris-4" title="Buono">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="ristorazione" id="ris-3" value="3">
                            <label for="ris-3" title="Medio">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="ristorazione" id="ris-2" value="2">
                            <label for="ris-2" title="Scarso">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>

                            <input type="radio" name="ristorazione" id="ris-1" value="1">
                            <label for="ris-1" title="Pessimo">
                                <img src="../src/icons/icons8-calcio-2-30.png" alt="icona_pallone">
                            </label>
                        </div>
                        <div class="contenitore_testo_valutazione">
                            <p id="testo_valutazione_ristorazione" class="testo_valutazione"></p>
                        </div>
                    </div>
                    
                </form>
                <div>
                    <h3>La tua esperienza dagli spalti</h3>
                    <p>Raccontaci di più. Hai qualche consiglio che vuoi dare ai prossimi visitatori dello stadio? Vuoi aggiungere altre informazioni alla recensione?</p>
                    <textarea name="descrizione" id="descrizione" required placeholder="Consiglio a chi dovesse frequentare lo stadio d'inverno di coprirsi bene la testa, sopratutto per i settori più in alto!"></textarea>
                </div>
            </div>
            <div class="contenitore_bottoni_evento_recensione">
                <button type="submit" id="bottone_submit" disabled>Salva recensione</button>
                <button id = "back_home">Torna alla home</button>
            </div>
        </div>
        <footer>
            <small>
                Progetto di Progettazione Web | Professore: Alessio Vecchio - Studente: Francesco Lombardo | Università di Pisa
            </small>
        </footer>
    </body>
</html>