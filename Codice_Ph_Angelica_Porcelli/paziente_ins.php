<?php
<?php
session_start();

if (!isset($_POST['toinsert']) || !isset($_SESSION['tbl'])) {
    // Gestione del caso in cui non siano stati passati correttamente i dati
    echo "<html><head><title>Errore</title></head><body>";
    echo "Non sono stati passati correttamente i dati.<br>";
    echo "Torna alla pagina dei pazienti: <a href='opt_pazienti.php'>vai</a>";
    echo "</body></html>";
    exit();
}

$conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
if (!$conn) {
    echo "<html><head><title>Errore di connessione</title></head><body>";
    echo 'Connessione al database fallita.';
    echo "</body></html>";
    exit();
}
//cf nome cognome datadinascita indirizzo

    $cf = isset($_POST['cf']) ? $_POST['cf'] : NULL;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : NULL;
    $cognome = isset($_POST['cognome']) ? $_POST['cognome'] : NULL;
    $dn= isset($_POST['datadinascita']) ? $_POST['datadinascita'] : NULL;
    $ind = isset($_POST['indirizzo']) ? $_POST['indirizzo'] : NULL;

    $query = "INSERT INTO paziente (cf, nome, cognome, datadinascita, indirizzo) VALUES ('$cf', '$nome', '$cognome', '$dn','$ind')";
    $result = pg_query($conn, $query);

    if (!$result) {
        echo "<html><head><title>Errore</title></head><body>";
        echo "Si è verificato un errore durante l'inserimento del paziente.<br>";
        echo pg_last_error($conn);
        echo "<br><a href='pazienti.php'>Torna indietro</a>";
        echo "</body></html>";
        exit();
    }

    echo "<html><head><title>Inserimento avvenuto con successo</title></head><body>";
    echo "Inserimento dell'ospedale avvenuto con successo.<br>";
    echo "<a href='select_strutture.php'>Torna indietro</a>";
    echo "</body></html>";
    
pg_close($conn);
?>


