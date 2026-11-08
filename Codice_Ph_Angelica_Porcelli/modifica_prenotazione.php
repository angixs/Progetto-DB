<?php
session_start();

$conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
if (!$conn) {
    echo "<html><head><title>Errore di connessione</title></head><body>";
    echo 'Connessione al database fallita.';
    echo "</body></html>";
    exit();
}

// Recupera la lista dei pazienti, tramite cf, per visualizzare le prenotazioni di qualcuno
$query_pazienti = "SELECT cf FROM paziente";
$result_pazienti = pg_query($conn, $query_pazienti);
if (!$result_pazienti) {
    echo "Errore nella query degli ospedali.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prenotazioni di pazienti</title>
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
    <h1>Seleziona un paziente per visualizzare i suoi esami</h1>
    
    <!--form che passa il parametro del cf --> 
    <form method="POST" action="">
        <label for="paziente">Pazienti:</label>
        <select name="paziente" id="paziente">

            <?php

            //ciclo while per avere un elenco selezionabile di pazienti
            while ($row = pg_fetch_assoc($result_pazienti)) {
                echo "<option value='" . $row['cf'] . "'>" . $row['cf'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" name="submit" value="Modifica prenotazioni">
    </form>

    <?php
    if (isset($_POST['submit']) && isset($_POST['paziente'])) {
        $paziente_sel = $_POST['paziente'];

        // Recupera il personale per l'ospedale selezionato
        $query_prenotazione = "  
           SELECT *
            FROM PRENOTAZIONE 
            WHERE cfpaziente ='$paziente_sel'
            ORDER BY dataesame
        ";
        
        $result_pren = pg_query($conn, $query_prenotazione);
        if (!$result_pren) {
            echo "Errore nella query del personale.";
            exit();
        }

        //tabella:
        //PRENOTAZIONE (DataEsame, OraEsame, DataPrenotazione, Privato, Urgenza, CFPaziente, CodEsame, MatricolaMedico, CodAmbulatorio) 
        
        echo "<h2>Esami Prenotati di '$paziente_sel'</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Data Esame</th>
                    <th>Ora Esame</th>
                    <th>Data Prenotazione</th>
                    <th>Privato</th>
                    <th>Urgenza</th>
                    <th>Paziente</th>
                    <th>Esame</th>
                    <th>Medico</th>
                </tr>";

        //inserisce i dati nelle label
        print ("<form action=\"prenotazione_upd.php\" method=\"POST\">");
        while ($row = pg_fetch_assoc($result_pren)) {
            echo "<tr>
                    <td>" . $row['dataesame'] . "</td>
                    <td>" . $row['oraesame'] . "</td>
                    <td>" . $row['dataprenotazione'] . "</td>
                    <td>" . $row['privato'] . "</td>
                    <td>" . $row['urgenza'] . "</td>
                    <td>" . $row['cfpaziente'] . "</td>
                    <td>" . $row['matricolamedico'] . "</td>
                    <td>" . $row['codesame'] . "</td>
                     <td><input type='radio' name='toupdate' value=" . $row['cfpaziente'] . " required></td>
                </tr>";
        }

        echo "</table>";
        echo "<input type=\"submit\" name=\"update\" value=\"Update\">";
        echo "</form>";
    }

    pg_close($conn);
    ?>
     Torna all'area <a href="prenota_modifica.php" class="button">di prenotazione</a>
</body>
</html>
