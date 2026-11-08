<!-- select_strutture.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Operazioni</title>
</head>
<body>
    <h1>Area delle strutture e del personale</h1>

    <form action="opt_strutture.php" method="POST">
        <!-- Selezione della tabella da gestire -->
        <label for="tabella">Seleziona la tabella:</label>
        <select id="tabella" name="tabella">
            <option value="ospedale">Ospedale</option>
            <option value="personale">Personale</option>
            <option value="reparto">Reparto</option>
            
           <!-- <option value="paziente">Paziente</option> -->   
        </select>
        <br><br>

        <!-- Selezione dell'operazione da eseguire -->
        <label for="operazione">Seleziona l'operazione:</label>
        <select id="operazione" name="operazione">
            <option value="select">Visualizza</option>
            <option value="insert">Inserisci</option>
            <option value="update">Aggiorna</option>
            <option value="delete">Elimina</option>
        </select>
        <br><br>

        <input type="submit" value="Procedi">
    </form>
    <br>
    <br>
    <a href="strutture_personale.php" class="button">Torna indietro  </a>
</body>
</html>
