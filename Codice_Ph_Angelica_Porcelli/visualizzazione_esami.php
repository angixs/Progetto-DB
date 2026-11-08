<?php
session_start();

$conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
if (!$conn) {
    echo "<html><head><title>Errore di connessione</title></head><body>";
    echo 'Connessione al database fallita.';
    echo "</body></html>";
    exit();
}

// Recupera la lista degli ospedali
$query_pazienti = "SELECT cf, nome, cognome FROM paziente";
$result_pazienti = pg_query($conn, $query_pazienti);
if (!$result_pazienti) {
    echo "Errore nella query degli ospedali.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Esami di pazienti</title>
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
</head>
<body>
    <h1>Seleziona un paziente per visualizzare le sue prenotazioni</h1>
    <form method="POST" action="">
        <label for="paziente">Pazienti:</label>
        <select name="paziente" id="paziente">

            <?php
            while ($row = pg_fetch_assoc($result_pazienti)) {
                echo "<option value='" . $row['cf'] . "'>" . $row['cf'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" name="submit" value="Visualizza prenotazioni">
    </form>

    <?php
     if (isset($_POST['submit']) && isset($_POST['paziente'])) {
        $paziente_sel = $_POST['paziente'];

        // Recupera il personale per l'ospedale selezionato
       /* $query_prenotazione = "  
           SELECT p.cf, p.nome, p.cognome, pr.dataesame, pr.oraesame, e.descrizione, e.codambulatorio
            FROM PAZIENTE as p JOIN PRENOTAZIONE as pr ON p.cf = pr.cfpaziente 
            JOIN ESAME as e ON pr.codesame = e.codesame
            WHERE p.cf ='$paziente_sel'
            ORDER BY pr.dataesame
        ";*/

        $query_prenotazione =" SELECT p.cfpaziente, p.dataesame, p.oraesame, e.codambulatorio, e.descrizione, a.indirizzo, o.codospedale
                FROM PRENOTAZIONE p JOIN ESAME e ON p.codesame = e.codesame 
                JOIN  AMBULATORIO_LABORATORIO_ESTERNO a ON a.codambulatorio = e.codambulatorio 
                JOIN AMBULATORI_OSPEDALI o ON o.codambulatorio = a.codambulatorio JOIN OSPEDALE os on o.codospedale = os.codospedale
                WHERE a.indirizzo= os.indirizzoospedale AND p.cfpaziente ='$paziente_sel'
                ";
        
        $result_pren = pg_query($conn, $query_prenotazione);
        if (!$result_pren) {
            echo "Errore nella query del personale.";
            exit();
        }

        echo "<h2>Esami Prenotati di '$paziente_sel'</h2>";
        echo "<table border='1'>
                <tr>
                    <th>CF</th>
                    <th>Data Esame</th>
                    <th>Ora </th>
                    <th>Esame</th>
                    <th>Ambulatorio</th>
                    <th>Indirizzo</th>
                    <th>Ospedale</th>
                </tr>";

        while ($row = pg_fetch_assoc($result_pren)) {
            echo "<tr>
                    <td>" . $row['cfpaziente'] . "</td>
                    <td>" . $row['dataesame'] . "</td>
                    <td>" . $row['oraesame'] . "</td>
                    <td>" . $row['descrizione'] . "</td>
                    <td>" . $row['codambulatorio'] . "</td>
                    <td>" . $row['indirizzo'] . "</td>
                    <td>" . $row['codospedale'] . "</td>
                </tr>";
        }

        echo "</table>";
    }
    pg_close($conn);
    ?>
   Torna <a href="pazienti.php" class="button">indietro</a>
</body>
</html>
