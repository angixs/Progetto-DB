<?php
session_start();
$htmlint = <<<NOW
<HTML>
  <HEAD>
    <style>
      table, th, td {
        text-align: left;
        border: 1px solid;
      }
    </style>
  </HEAD>
<BODY> 
NOW;

if (isset($_POST['toupdate2'])) { // sono stati passati correttamente i dati
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
  } else {
    // Recupera i valori dal form
    $cod = isset($_POST['cfpaziente']) ? $_POST['cfpaziente'] : NULL;
    $de = isset($_POST['dataesame']) ? $_POST['dataesame'] : NULL;
    $h = isset($_POST['oraesame']) ? $_POST['oraesame'] : '';
    $pr = isset($_POST['privato']) ? $_POST['privato'] : NULL;
    $u = isset($_POST['urgenza']) ? $_POST['urgenza'] : '';
    $m = isset($_POST['matricolamedico']) ? $_POST['matricolamedico'] : NULL;

    // Prepara la query di aggiornamento
    $query = "UPDATE prenotazione SET dataesame = '$de', oraesame = '$h', privato = '$pr', urgenza = '$u', matricolamedico = '$m' WHERE cfpaziente = '$cod'";

    // Esegui la query
    $result = pg_query($conn, $query);

    if (!$result) {
      echo "Si è verificato un errore.<br/>";
      echo pg_last_error($conn);
      exit();
    } else {
      echo "Aggiornamento avvenuto con successo<br><a href='modifica_prenotazione.php'>ritorna</a>";
    }
  }
} else { // non sono stati passati correttamente i dati
  print($htmlint);
  echo "Non risultano dati passati<br>";
  echo "Se vuoi puoi <a href='select_esame.php'>riprovare</a>";
}
?>
</BODY>
</HTML>
