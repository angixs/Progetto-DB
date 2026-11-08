

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <title>Selezione Query</title>
</head>
<body>
    <h1>Seleziona il tipo di query</h1>
    <form method="post">
        <label for="query_type">Scegli una query:</label>
        <select id="query_type" name="query_type" required>
            <option value="a">Vice primari che hanno sostituito esattamente una volta il proprio primario</option>
            <option value="b"> Vice primari che hanno sostituito almeno due volte il proprio primario</option>
            <option value="c"> Vice primari che non hanno mai sostituito il proprio primario</option>
        </select><br><br>
        <input type="submit" value="Esegui Query">
    </form>

    <br>


    <a href="strutture_personale.php" class="button">Torna indietro  </a>
    <br>
    <br>
    <br>
</body>
</html>
<?php

// Connessione al database
$conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");

if (!$conn) {
    die("Connessione al database fallita: " . pg_last_error());
}

// Funzione per eseguire la query e visualizzare i risultati

// Gestione della richiesta
if (isset($_POST['query_type'])) {
    $query_type = $_POST['query_type'];
    switch ($query_type) {
        case 'a':
            $query = "SELECT MatricolaVicePrimario
                      FROM SOSTITUZIONE
                      GROUP BY MatricolaVicePrimario
                      HAVING COUNT(*) = 1";
            break;
        case 'b':
            $query = "SELECT MatricolaVicePrimario
                      FROM SOSTITUZIONE
                      GROUP BY MatricolaVicePrimario
                      HAVING COUNT(*) > 1";
            break;
        case 'c':
            $query = "SELECT MatricolaVicePrimario
                      FROM VICE_PRIMARIO
                      EXCEPT
                      SELECT MatricolaVicePrimario
                      FROM SOSTITUZIONE";
            break;
        default:
            echo "Tipo di query non valido.";
            exit;
    }

    $result = pg_query($conn, $query);

    if (!$result) {
        echo "Errore nell'esecuzione della query: " . pg_last_error();
        return;
    }

    echo "<br><br><table border='1'>";
    echo "<tr><th>Matricola Vice Primario</th></tr>";
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr><td>{$row['matricolaviceprimario']}</td></tr>";
    }
    echo "</table>";

    pg_free_result($result);

    $query_visual = "SELECT * FROM personale WHERE matricola in ($query)";
    $result2 = pg_query($conn, $query_visual);
  


    echo "Dati dei Vice-Primari";
    echo "<table border='1'>
    <tr>
        <th>Matricola</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Reparto</th>
    </tr>
      <br>
    ";
  

    while ($row = pg_fetch_assoc($result2)) {
        echo "<tr>";
        echo"<td>{$row['matricola']}</td>";
        echo "<td>{$row['nome']}</td>";
        echo "<td>{$row['cognome']}</td>";
        echo "<td>{$row['codreparto']}</td>
        </tr>";      
    }
    echo "</table>";
}

pg_close($conn);
?>