<!--strutture_updt2.php-->
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
if (isset($_POST['toupdate2']) && isset($_SESSION['tbl'])) {//sono stati passati correttamente i dati
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
  }
  else {
    
    $tbl = $_SESSION['tbl'];
      switch ($tbl) {
        case 'ospedale':
          //echo "Connessione riuscita."."<br/>";
          $cod = isset($_POST['codospedale']) ? $_POST['codospedale'] : NULL;
          $nome = isset($_POST['nomeospedale']) ? $_POST['nomeospedale'] : NULL;
          $ind = isset($_POST['indirizzoospedale']) ? $_POST['indirizzoospedale'] : '';
          $query = "UPDATE " . $_SESSION['tbl'] . " set  nomeospedale='$nome', indirizzoospedale='$ind' where codospedale='$cod'";
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
              echo "Aggiornamento avvenuto con successo<br><a href='select_strutture.php'>ritorna</a>";
            };
          }
          else {
            echo "I dati passati non sono conformi alle richieste.<br>";
            echo "Se vuoi puoi <a href='select_strutture.php'>riprovare</a>";
          };
          break;

          //PERSONALE
          case 'personale':
            //echo "Connessione riuscita."."<br/>";
            $cod = isset($_POST['matricola']) ? $_POST['matricola'] : NULL;
            $nome = isset($_POST['nome']) ? $_POST['nome'] : NULL;
            $cognome = isset($_POST['cognome']) ? $_POST['cognome'] : NULL;
            $nr= isset($_POST['nrcell']) ? $_POST['nrcell'] : NULL;
            $rep = isset($_POST['codreparto']) ? $_POST['codreparto'] : '';
            $query = "UPDATE " . $_SESSION['tbl'] . " set  nome ='$nome',cognome ='$cognome',nrcell ='$nr', codreparto ='$rep' where matricola='$cod'";
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
                echo "Aggiornamento avvenuto con successo<br><a href='select_strutture.php'>ritorna</a>";
              };
            }
            else {
              echo "I dati passati non sono conformi alle richieste.<br>";
              echo "Se vuoi puoi <a href='select_strutture.php'>riprovare</a>";
            };
            break;
            case 'reparto':
              //echo "Connessione riuscita."."<br/>";
              $cod = isset($_POST['codreparto']) ? $_POST['codreparto'] : NULL;
              $nome = isset($_POST['nomereparto']) ? $_POST['nomereparto'] : NULL;
              $nr = isset($_POST['nrtelefono']) ? $_POST['nrtelefono'] : NULL;
              $in = isset($_POST['orarioiniziovisite']) ? $_POST['orarioiniziovisite'] : NULL;
              $fi = isset($_POST['orariofinevisite']) ? $_POST['orariofinevisite'] : NULL;
              $os = isset($_POST['codospedale']) ? $_POST['codospedale'] : NULL;
              $query = "UPDATE " . $_SESSION['tbl'] . " set  nomereparto='$nome', nrtelefono='$nr', orarioiniziovisite='$in', orariofinevisite='$fi', codospedale='$os' where codospedale='$cod'";
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
                  echo "Aggiornamento avvenuto con successo<br><a href='select_strutture.php'>ritorna</a>";
                };
              }
              else {
                echo "I dati passati non sono conformi alle richieste.<br>";
                echo "Se vuoi puoi <a href='select_strutture.php'>riprovare</a>";
              };
              break;
    };
  }
}
else {//non sono stati passati correttamente i dati
  print ($htmlint);
  echo "Non risultano dati passati<br>";
  echo "Se vuoi puoi <a href='select_strutture.php'>riprovare</a>";
}
?>
</BODY>
</HTML>
