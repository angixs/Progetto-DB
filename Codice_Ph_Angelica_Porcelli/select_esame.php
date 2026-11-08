<!-- select_paziente.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Operazioni Esami</title>
</head>
<body>

    <h1>Area degli esami</h1>

    <form action="opt_esame.php" method="POST">

   <!-- <label for="tabella">Seleziona la tabella:</label>
        <select id="operazione" name="operazione">
            <option value="tab1">...Visualizza</option>
            <option value="tab2">...</option>
        </select> -->

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
