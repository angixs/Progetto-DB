<!--basic_updt2.php-->
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
//print_R($_POST);        && isset($_SESSION['tbl'])
if (isset($_POST['toupdate2'])) {//sono stati passati correttamente i dati
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
  }
  else {
    //echo "Connessione riuscita."."<br/>";
    $cod = isset($_POST['codesame']) ? $_POST['codesame'] : NULL;
    //testo anche la composizione

    $de = isset($_POST['descrizione']) ? $_POST['descrizione'] : NULL;
    $cp = isset($_POST['costopubblico']) ? $_POST['costopubblico'] : '';
    $cpr = isset($_POST['costoprivato']) ? $_POST['costoprivato'] : NULL;
    $amb = isset($_POST['codambulatorio']) ? $_POST['codambulatorio'] : '';
    $avv = (isset($_POST['avvertenze']))? $_POST['avvertenze'] : NULL;

    //" . $_SESSION['tbl'] . "
    //query per l'aggiornamento
    $query = "UPDATE Esame  set  descrizione ='$de', costopubblico ='$cp', costoprivato ='$cpr', 
    codambulatorio ='$amb' where codesame ='$cod'";

    //se ho le avvertenze aggiorno gli esami specialistici
    if (isset($_POST['avvertenze'])) {
      $avv= isset($_POST['avvertenze']) ? $_POST['avvertenze'] : NULL;
      $query_spec = "UPDATE Esame_specialistico set avvertenze = '$avv' 
      where codesamespecialistico = '$cod'";
      
      $resultspec = pg_query($conn, $query_spec);
      if (!$resultspec) {
          echo "<html><head><title>Errore</title></head><body>";
          echo "Si è verificato un errore durante l'inserimento dell'esame specialistico'.<br>";
          echo pg_last_error($conn);
          echo "<br><a href='select_esame.php'>Torna indietro</a>";
          echo "</body></html>";
          exit();
      }
    };

    $result = pg_query($conn, $query);

    //echo $query;
    if($cod!='not valid'){
      $result = pg_query($conn, $query);
      if (!$result) {
        echo "Si è verificato un errore.<br/>";
        echo pg_last_error($conn);
        exit();
      }
      else {
        //$cmdtuples = pg_affected_rows($result);
        echo "Aggiornamento avvenuto con successo<br><a href='select_esame.php'>ritorna</a>";
      };
    }
    else {
      echo "I dati passati non sono conformi alle richieste.<br>";
      echo "Se vuoi puoi <a href='select_basic.php'>riprovare</a>";
    };
  };
}
else {//non sono stati passati correttamente i dati
  print ($htmlint);
  echo "Non risultano dati passati<br>";
  echo "Se vuoi puoi <a href='select_esame.php'>riprovare</a>";
}
?>
</BODY>
</HTML>
