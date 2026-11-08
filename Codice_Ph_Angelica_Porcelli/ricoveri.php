<?php
session_start();

$conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
if (!$conn) {
    echo "<html><head><title>Errore di connessione</title></head><body>";
    echo 'Connessione al database fallita.';
    echo "</body></html>";
    exit();
}

// Recupera la lista dei pazienti
$query_paz = "SELECT cf, nome, cognome FROM paziente";
$query_osp = "SELECT codospedale, nomeospedale FROM ospedale";

$result_paz = pg_query($conn, $query_paz);
if (!$result_paz) {
    echo "Errore nella query dei pazienti.";
    exit();
}

$result_osp = pg_query($conn, $query_osp);
if (!$result_osp) {
    echo "Errore nella query dei pazienti.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Storico Ricoveri</title>
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
    <h1>Seleziona un paziente</h1>

    <!--form per scegliere e mandare l'informazione del paziente del quale si vuole vedere il ricovero--> 
    <form method="POST" action="">
        <label for="paziente">Paziente:</label>
        <select name="paziente" id="paziente">
            <?php
            //mi restituisce tutti i pazienti esistenti
            while ($row = pg_fetch_assoc($result_paz)) {
                echo "<option value='" . $row['cf'] . "'>" .$row['cf'] ."</option>";
            }
            ?>
        </select>
        <label for="ospedale">Ospedale:</label>
        <select name="ospedale" id="ospedale">
            <?php
            //mi restituisce tutti i pazienti esistenti
            while ($row = pg_fetch_assoc($result_osp)) {
                echo "<option value='" . $row['codospedale'] . "'>" .$row['nomeospedale'] ."</option>";
            }
            ?>
        </select>
        <input type="submit" name="submit" value="Visualizza Storico Ricovero">
    </form>

    <?php
    if (isset($_POST['submit']) && isset($_POST['paziente'])&& isset($_POST['ospedale'])) {
        $paziente = $_POST['paziente'];
        $osp = $_POST['ospedale'];

        // Recupera lo storico dei ricoveri per il paziente selezionato
        $query_paziente = "
            SELECT  r.cfpaziente, p.nome, p.cognome, r.codricovero, r.dataricovero, r.datadimissione, r.codletto, re.codreparto, o.codospedale
            FROM RICOVERO r JOIN LETTO l on r.codletto = l.codletto 
            JOIN REPARTO re ON re.codreparto = l.codreparto 
            JOIN OSPEDALE o on re.codospedale = o.codospedale JOIN PAZIENTE p on p.cf = r.cfpaziente
            WHERE p.cf = '$paziente' and o.codospedale = '$osp'
            ORDER BY r.dataricovero
        ";
        $result_paziente = pg_query($conn, $query_paziente);
        if (!$result_paziente) {
            echo "Errore nella query dello storico dei ricoveri.";
            exit();
        }

        echo "<h2>Storico Paziente</h2>";
        echo "<table border='1'>
                <tr>
                    <th>CF</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>CodRicovero</th>
                    <th>Data Ricovero</th>
                    <th>Data Dimissione</th>
                    <th>Letto</th>
                    <th>Reparto</th>
                    <th>Ospedale</th>
                </tr>";

        while ($row = pg_fetch_assoc($result_paziente)) {
            echo "<tr>
                    <td>" . $row['cfpaziente'] . "</td>
                    <td>" . $row['nome'] . "</td>
                    <td>" . $row['cognome'] . "</td>
                    <td>" . $row['codricovero'] . "</td>
                    <td>" . $row['dataricovero'] . "</td>
                    <td>" . $row['datadimissione'] . "</td>
                    <td>" . $row['codletto'] . "</td>
                    <td>" . $row['codreparto'] . "</td>
                    <td>" . $row['codospedale'] . "</td>
                </tr>";
        }

        echo "</table>";
    }

    pg_close($conn);
    ?>
    <a href="pazienti.php" class="button">Torna all'area pazienti</a>
</body>
</html>
