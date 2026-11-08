<!--basic_ins.php-->
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
//print_R($_POST);
if (isset($_POST['toinsert'])) {//sono stati passati correttamente i dati
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
  }
  else {
    //echo "Connessione riuscita."."<br/>";

    //codesame    descrizione     costopubblico  costoprivato codambulatorio
    $cod = isset($_POST['codesame']) ? $_POST['codesame'] : NULL;
    $d = isset($_POST['descrizione']) ? $_POST['descrizione'] : NULL;
    $cpu = isset($_POST['costopubblico']) ? $_POST['costopubblico'] : NULL;
    $cpr = isset($_POST['costoprivato']) ? $_POST['costoprivato'] : NULL;
    $amb = isset($_POST['codambulatorio']) ? $_POST['codambulatorio'] : NULL;

    // Gestione del campo matricolamedico che può essere null

    $query = "INSERT INTO Esame  (codesame, descrizione, costopubblico, costoprivato, codambulatorio) VALUES ('$cod','$d','$cpu','$cpr','$amb')";
    //$result = pg_query($conn, $query);
    
      if($cod!='not valid'){
        $result = pg_query($conn, $query);
        //echo $query;
        if (!$result) {
          echo "Si è verificato un errore.<br/>";
          echo pg_last_error($conn);
          exit();
        }
        else {
          //$cmdtuples = pg_affected_rows($result);
          echo "Inserimento avvenuto con successo<br><a href='select_esame.php'>ritorna</a>";
        };
      } else {
        echo "I dati passati non sono conformi alle richieste.<br>";
        echo "Se vuoi puoi <a href='select_esame.php'>riprovare</a>";
      };
    };

    //se fossero inserite le avvertenze allora esame specialistico, va fatta una insert
    if (isset($_POST['avvertenze'])) {
        $avv= isset($_POST['avvertenze']) ? $_POST['avvertenze'] : NULL;
        $query_spec = "INSERT INTO Esame_specialistico (codesamespecialistico, avvertenze) VALUES ('$cod','$avv')";
        $resultspec = pg_query($conn, $query_spec);
        if (!$resultspec) {
            echo "<html><head><title>Errore</title></head><body>";
            echo "Si è verificato un errore durante l'inserimento dell'esame specialistico'.<br>";
            echo pg_last_error($conn);
            echo "<br><a href='select_esame.php'>Torna indietro</a>";
            echo "</body></html>";
            exit();
        }
    }  
  
}
else {//non sono stati passati correttamente i dati
  print ($htmlint);
  echo "Non risultano dati passati<br>";
  echo "Se vuoi puoi <a href='select_esame.php'>riprovare</a>";
}
?>
</BODY>
</HTML>