<!--paziente_updt2.php-->
<?php
session_start();
$htmlint = <<<NOW
<HTML>
  <HEAD>
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
  </HEAD>
<BODY> 
NOW;
//print_R($_POST);
if (isset($_POST['toupdate2'])) {//sono stati passati correttamente i dati
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
  }
  else {
    
//solo paziente

          //echo "Connessione riuscita."."<br/>";
          $cf = isset($_POST['cf']) ? $_POST['cf'] : NULL;
          $nome = isset($_POST['nome']) ? $_POST['nome'] : NULL;
          $cognome = isset($_POST['cognome']) ? $_POST['cognome'] : NULL;
          $data = isset($_POST['datadinascita']) ? $_POST['datadinascita'] : NULL;
          $ind = isset($_POST['indirizzo']) ? $_POST['indirizzo'] : '';
          $query = "UPDATE " . 'paziente' . " set  nome ='$nome', cognome ='$cognome', datadinascita ='$data', indirizzo ='$ind' where cf ='$cf'";
          //echo $query;
          if($cf!='not valid'){
            $result = pg_query($conn, $query);
            if (!$result) {
              echo "Si è verificato un errore.<br/>";
              echo pg_last_error($conn);
              exit();
            }
            else {
              //$cmdtuples = pg_affected_rows($result);
              echo "Aggiornamento avvenuto con successo<br><a href='select_paziente.php'>ritorna</a>";
            };
          }
          else {
            echo "I dati passati non sono conformi alle richieste.<br>";
            echo "Se vuoi puoi <a href='select_paziente.php'>riprovare</a>";
          };
  }
}
else {//non sono stati passati correttamente i dati
  print ($htmlint);
  echo "Non risultano dati passati<br>";
  echo "Se vuoi puoi <a href='select_paziente.php'>riprovare</a>";
}
?>
</BODY>
</HTML>
