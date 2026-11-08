<?php
session_start();

$htmlint = <<<NOW
<!DOCTYPE html>
<html lang="it">
<head>  
    <meta charset="UTF-8">
    <title>Gestione Pazienti</title>
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

// Verifica se sono stati inviati i dati dal form
if (isset($_POST['operazione'])) {
    //gestisco solo le operazioni del paziente
    $op = $_POST['operazione'];
    $_SESSION['operazione'] = $op;

    $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
    if (!$conn) {
        echo 'Connessione al database fallita.';
        exit();
    } else {

        //switch case solo per le operazioni
        switch ($op) {
            case 'select':
                $query = "SELECT * FROM Paziente";
                $result = pg_query($conn, $query);
                if (!$result) {
                    echo "Si è verificato un errore.<br/>";
                    echo pg_last_error($conn);
                    exit();
                } else {
                    echo $htmlint;
                    echo '<h1>Visualizza Pazienti</h1>';
                    echo '<br><table>
                        <tr>
                            <th>Codice Fiscale</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Data Di Nascita</th>
                            <th>Indirizzo</th>
                        </tr>';
                    while ($row = pg_fetch_assoc($result)) {
                        echo '<tr>
                            <td>' . $row['cf'] . '</td>
                            <td>' . $row['nome'] . '</td>
                            <td>' . $row['cognome'] . '</td>
                            <td>' . $row['datadinascita'] . '</td>
                            <td>' . $row['indirizzo'] . '</td>       
                        </tr>';
                    }
                    echo '</table><br>';
                    echo "Torna alla pagina iniziale: <a href='select_paziente.php'>vai</a>";
                }
                break;

            case 'insert':
                echo $htmlint;
                echo '<h2>Inserisci Nuovo Paziente</h2>';
                echo '<form action="paziente_ins.php" method="POST">';
                echo '<table>
                    <tr><th>Codice Fiscale:</th><td><input type="text" name="cf" required></td></tr>
                    <tr><th>Nome:</th><td><input type="text" name="nome" required></td></tr>
                    <tr><th>Cognome:</th><td><input type="text" name="cognome" required></td></tr>
                    <tr><th>Data di Nascita:</th><td><input type="date" name="datadinascita" required></td></tr>
                    <tr><th>Indirizzo:</th><td><input type="text" name="indirizzo" required></td></tr>
                </table>';
                echo '<input type="submit" name="toinsert" value="Inserisci">';
                echo '</form>';
                echo "<br> Torna alla pagina  <a href='select_paziente.php'> pazienti</a>";
                break;

            case 'update':
                $query = "SELECT * FROM Paziente";
                $result = pg_query($conn, $query);
                if (!$result) {
                    echo "Si è verificato un errore.<br/>";
                    echo pg_last_error($conn);
                    exit();
                } else {
                    echo $htmlint;
                    echo '<h2>Aggiorna Paziente</h2>';
                    echo '<form action="paziente_upd.php" method="POST">';
                    echo '<table>
                        <tr>
                            <th>Codice Fiscale</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Data Di Nascita</th>
                            <th>Indirizzo</th>
                            <th>Seleziona</th>
                        </tr>';
                    while ($row = pg_fetch_assoc($result)) {
                        echo '<tr>
                            <td>' . $row['cf'] . '</td>
                            <td>' . $row['nome'] . '</td>
                            <td>' . $row['cognome'] . '</td>
                            <td>' . $row['datadinascita'] . '</td>
                            <td>' . $row['indirizzo'] . '</td>  
                            <td><input type="radio" name="toupdate" value="' . $row['cf'] . '" required></td>
                        </tr>';
                    }
                    echo '</table>';
                    echo '<input type="submit" name="update" value="Aggiorna">';
                    echo '</form>';
                    echo "Torna alla pagina  <a href='select_paziente.php'> pazienti</a>";
                }
                break;

            default:
                echo $htmlint;
                echo "Operazione non valida.<br>";
                echo "Torna alla pagina iniziale: <a href='pazienti.php'>vai</a>";
                break;
        }
    }
} else {
    echo $htmlint;
    echo "Dati non passati correttamente.<br>";
    echo "Torna alla pagina iniziale: <a href='pazienti.php'>vai</a>";
}
?>
</body>
</html>
