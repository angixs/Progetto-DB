<!-- select_paziente.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Operazioni Pazienti</title>
</head>
<body>
    <h1>Benvenuto nell'area dei pazienti</h1>

    <form action="opt_paziente.php" method="POST">

        <!-- Selezione dell'operazione da eseguire -->
        <label for="operazione">Seleziona l'operazione:</label>
        <select id="operazione" name="operazione">
            <option value="select">Visualizza</option>
            <option value="insert">Inserisci</option>
            <option value="update">Aggiorna</option>
        </select>
        <br><br>

        <input type="submit" value="Procedi">
    </form>
    <a href="pazienti.php" class="button">Torna all'area pazienti</a>
</body>
</html>
