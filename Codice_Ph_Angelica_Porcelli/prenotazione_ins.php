<?php
session_start();

$conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
if (!$conn) {
    echo "<html><head><title>Errore di connessione</title></head><body>";
    echo 'Connessione al database fallita.';
    echo "</body></html>";
    exit();
}

//recupero i dati dalla pagina precedente
$data = isset($_POST['dataesame']) ? ($_POST['dataesame']) : NULL;
$ora = isset($_POST['oraesame']) ? ($_POST['oraesame']) : NULL;
$priv = isset($_POST['privato']) ? ($_POST['privato']) : NULL;
$urg = isset($_POST['urgenza']) ? ($_POST['urgenza']) : NULL;
$cf = isset($_POST['cfpaziente']) ? ($_POST['cfpaziente']) : NULL;
$cod = isset($_POST['codesame']) ? ($_POST['codesame']) : NULL;


// Gestione del campo matricolamedico che può essere null
$med = isset($_POST['matricolamedico']) && $_POST['matricolamedico'] !== 'NULL' ? pg_escape_string($_POST['matricolamedico']) : NULL;

$query = "INSERT INTO prenotazione (dataesame, oraesame, dataprenotazione, privato, urgenza, cfpaziente, codesame, matricolamedico) 
VALUES ('$data', '$ora', CURRENT_DATE, '$priv', '$urg', '$cf', '$cod'";
//uso la data corrente perchè sta prenotando in quel momento

//aggiungo  $med che recupera la matricola nel medico nel caso ci fosse, altrmenti mette null anche nell'inserimento
if ($med === NULL) {
    $query .= ",NULL";
} else {
    $query .= ",'$med' ";
}

$query .= ")";
$result = pg_query($conn, $query);
if (!$result) {
    echo "<html><head><title>Errore</title></head><body>";
    echo "Si è verificato un errore durante l'inserimento della prenotazione.<br>";
    echo pg_last_error($conn);
    echo "<br><a href='prenotazione.php'>Torna indietro</a>";
    echo "</body></html>";
    exit();
}

pg_close($conn);

echo "<html><head><title>Successo</title></head><body>";
echo "Prenotazione inserita con successo.<br>";
echo "<a href='pazienti.php'>Torna alla pagina iniziale</a>";
echo "</body></html>";
?>
