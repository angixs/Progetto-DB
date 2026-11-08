<?php
session_start();

$htmlint = <<<NOW
<!DOCTYPE html>
<html>
<head>
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
NOW;

$conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cf'])) {
    $cf_paziente = $_POST['cf'];

    // Verifica se il CF del paziente esiste
    $query_paziente = "SELECT CF FROM PAZIENTE WHERE CF = '$cf_paziente'";
    $result_paziente = pg_query($conn, $query_paziente);
    if (pg_num_rows($result_paziente) === 0) {
        echo "Il CF del paziente inserito non esiste.<br>";
        echo "Torna alla pagina precedente: <a href='prenotazione.php'>vai</a>";
        exit();
    }

    // Recupera i dati dalla base di dati per gli elenchi a discesa

    //esami prenotabili
    $query_esami = "SELECT codesame, descrizione FROM ESAME";
    $result_esami = pg_query($conn, $query_esami);

    //medici selezionabili
    $query_medici = "SELECT m.matricolamedico, p.nome, p.cognome 
                    FROM MEDICO as m JOIN PERSONALE as p ON m.matricolamedico = p.matricola";
    $result_medici = pg_query($conn, $query_medici);

    echo $htmlint;
    
    echo "<h2> Prenota una visita </h2>";
    echo '<form action="prenotazione_ins.php" method="POST">';
    echo '<table>';
    echo '<tr><th>CF Paziente</th><td><input type="text" name="cfpaziente" value="' . $cf_paziente . '" readonly></td></tr>';
    
    // Elenco a discesa per CodEsame
    echo '<tr><th>Esame</th><td><select name="codesame" required>';
    while ($row = pg_fetch_assoc($result_esami)) {
        echo '<option value="' . $row['codesame'] . '">' . $row['descrizione'] . '</option>';
    }
    echo '</select></td></tr>';
    
    // Elenco a discesa per MatricolaMedico
    echo '<tr><th>Medico</th><td><select name="matricolamedico">';
    echo '<option value="NULL">Nessun medico specificato</option>'; // Opzione vuota
    while ($row = pg_fetch_assoc($result_medici)) {
        echo '<option value="' . $row['matricolamedico'] . '">' . $row['nome'] . ' ' . $row['cognome'] . '</option>';
    }
    echo '</select></td></tr>';
    
    // Campi per DataEsame e OraEsame
    echo '<tr><th>Data Esame</th><td><input type="date" name="dataesame" required></td></tr>';
    echo '<tr><th>Ora Esame</th><td><input type="time" name="oraesame" required></td></tr>';

    // Radio button per Privato
    echo '<tr><th>Privato</th><td>';
    echo '<input type="radio" name="privato" value="true" required> Sì ';
    echo '<input type="radio" name="privato" value="false" required> No';
    echo '</td></tr>';

    // Elenco a discesa per Urgenza
    echo '<tr><th>Urgenza</th><td><select name="urgenza" required>';
    echo '<option value="Rosso">Rosso</option>';
    echo '<option value="Giallo">Giallo</option>';
    echo '<option value="Verde">Verde</option>';
    echo '</select></td></tr>';

    
    echo '<tr><td colspan="2"><input type="submit" value="Prenota"></td></tr>';
    echo '</table>';
    echo '</form>';
} else {
    echo $htmlint;
    echo "<h2> Prenota una visita </h2>";
    echo '<form action="" method="POST">';
    echo '<table>';
    echo '<tr><th>CF Paziente</th><td><input type="text" name="cf" required></td></tr>';
    echo '<tr><td colspan="2"><input type="submit" value="Verifica CF e procedi"></td></tr>';
    echo '</table>';
    echo '</form>';
}
 echo 'Torna all area <a href="prenota_modifica.php" class="button">prenotazione</a>';
?>
</body>
</html>