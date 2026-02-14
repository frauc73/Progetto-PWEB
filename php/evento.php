<?php
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Crea Evento</title>
  <link rel="stylesheet" href="../css/shared.css">
  <link rel="stylesheet" href="../css/evento.css">
  <link rel="icon" href="../src/images/logo_sito.png" type="image/ico">
  <script src="../js/evento.js"></script>
</head>
<body>
  <img src="../src/images/logo_sito.png" alt="logo_sito" id="logo_sito" class="bordered">
  <div id="form_container">
    <h2 class="testo_centrale">Crea un nuovo evento</h2>
    <form id="eventoForm" enctype="multipart/form-data">
      <div id ="contenitore_partita">
        <h3>Inserisci la partita</h3>
        <select name="paese" id="paese" required>
                <option value="">-- Seleziona una Nazione --</option>
                <option value="Francia">Francia</option>
                <option value="Germania">Germania</option>
                <option value="Inghilterra">Inghilterra</option>
                <option value="Italia">Italia</option>
                <option value="Spagna">Spagna</option>
        </select>
        <table id="table_evento" class="hidden">
          <tr>
            <td></td>
            <td>
              <p id="competizione" class="testo_centrale"></p>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <div class="squadra">
                <p class="testo_centrale">Squadra di casa</p>
                <img id="logo_casa" class="logo hidden" src="../src/posts/Default.png" alt="Logo della squadra di casa">
                <select id="squadra_casa" name="squadra_casa" required>
                  <option value="">-- Seleziona una squadra --</option>
                </select>
              </div>
            </td>
            <td>
              <div id="score_container">
                <input type="number" class="punteggio bordered testo_centrale" name="punteggio_casa" id="punteggio_casa" required>
                <input type="number" class="punteggio bordered testo_centrale" name="punteggio_ospite" id="punteggio_ospite" required>
              </div>
            </td>
            <td>
              <div class="squadra">
                <p class="testo_centrale">Squadra ospite</p>
                <img id="logo_ospite" class="logo hidden" src="../src/posts/Default.png" alt="Logo della squadra ospite">
                <select id="squadra_ospite" name="squadra_ospite" required>
                  <option value="">-- Seleziona una squadra --</option>
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td></td>
            <td><p id="stadio" class="testo_centrale"></p></td>
            <td></td>
          </tr>
        </table>
        <label for="data_partita">Data</label>
        <input type="date" name="data_partita" id="data_partita" required>
      </div>
      <div id="contenitore_foto" class="staccato">
        <h3>Scegli una foto ricordo</h3>
        <p>Facoltativo</p>
        <input type="file" name="foto" id="select_foto" accept=".jpg,.jpeg,.png,.gif">
        <img src="../src/posts/Default.png" alt="Anteprima foto" class="hidden" id="foto_ricordo">
        <small>Formati accettati : jpg, jpeg, png, gif</small>
      </div>
      <div class="staccato">
        <h3>Scrivi un pensiero</h3>
        <textarea name="caption" id="caption" placeholder="Partita entusiasmante della squadra..." required></textarea>
      </div>
      <div class="staccato contenitore_bottoni_evento_recensione">
        <button type="submit" class="bordered" id="submit_button" disabled>Salva evento</button>
        <button id = "back_home">Torna alla home</button>
      </div>
    </form>
  </div>
    <footer>
      <small>
        Progetto di Progettazione Web | Professore: Alessio Vecchio - Studente: Francesco Lombardo | Università di Pisa
      </small>
    </footer>
</body>
</html>