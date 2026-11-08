<!--strutture_upd.php-->
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
if (isset($_POST['toupdate']) && isset($_SESSION['tbl'])) {//sono stati passati correttamente i dati
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
  }
  else {
    //echo "Connessione riuscita."."<br/>";

    
    $tbl = $_SESSION['tbl'];
    switch ($tbl) {

      //OSPEDALE
        case 'ospedale':
        $query = "SELECT * FROM " . $_SESSION['tbl'] . " WHERE codospedale='" . $_POST['toupdate'] . "';";
        //echo $query;
        $result = pg_query($conn, $query);
        if (!$result) {
          echo "Si è verificato un errore.<br/>";
          echo pg_last_error($conn);
          exit();
        }
        else {
          //$cmdtuples = pg_affected_rows($result);
          $array = pg_fetch_array($result);
          print ($htmlint);
          echo "<h2>Aggiornamento ospedale</h2>";
          print ("<table>");
          print ("<form action=\"strutture_upd2.php\" method=\"POST\">");
          //una volta raccolte le modifiche, passo i dati al file preposto all'applicazione delle stesse
          //si noti che la chiave non deve essere modificabile
          print ("<tr><th>Codice</th><td><input type=\"text\" name=\"codospedale\" value='" . $array['codospedale'] . "'  required readonly></td></tr>");
          print ("<tr><th>Nome</th><td><input type=\"text\" name=\"nomeospedale\" value='" . $array['nomeospedale'] . "' required></td</tr>");
          print ("<tr><th>Indirizzo</th><td><input type=\"text\" name=\"indirizzoospedale\" value='" . $array['indirizzoospedale'] . "' required></td></tr>");
          print ("<tr><td><input type=\"submit\" name=\"toupdate2\" value=\"Send\"></td></tr>");
          print ("</form>");
          print ("</table>");
          echo ("<br>");
          echo "Torna <a href='select_strutture.php'>indietro</a>";
        };
        break;

        //PERSONALE
        case 'personale':
          $query = "SELECT * FROM " . $_SESSION['tbl'] . " WHERE matricola='" . $_POST['toupdate'] . "';";
          //echo $query;
          $result = pg_query($conn, $query);
          if (!$result) {
            echo "Si è verificato un errore.<br/>";
            echo pg_last_error($conn);
            exit();
          }
          else {
            //$cmdtuples = pg_affected_rows($result);
            $array = pg_fetch_array($result);
            print ($htmlint);

            echo "<h2>Aggiornamento personale</h2>";

            print ("<table>");
            print ("<form action=\"strutture_upd2.php\" method=\"POST\">");
            //una volta raccolte le modifiche, passo i dati al file preposto all'applicazione delle stesse
            //si noti che la chiave non deve essere modificabile
            print ("<tr><th>Matricola</th><td><input type=\"text\" name=\"matricola\" value='" . $array['matricola'] . "'  required readonly></td></tr>");
            print ("<tr><th>Nome</th><td><input type=\"text\" name=\"nome\" value='" . $array['nome'] . "' required></td</tr>");
            print ("<tr><th>Cognome</th><td><input type=\"text\" name=\"cognome\" value='" . $array['cognome'] . "' required></td></tr>");
            print ("<tr><th>Nr Cellulare</th><td><input type=\"text\" name=\"nrcell\" value='" . $array['nrcell'] . "' required></td</tr>");
            print ("<tr><th>Reparto</th><td><input type=\"text\" name=\"codreparto\" value='" . $array['codreparto'] . "' required></td></tr>");
            
            print ("<tr><td><input type=\"submit\" name=\"toupdate2\" value=\"Send\"></td></tr>");
            print ("</form>");
            print ("</table>");
            echo ("<br>");

            echo "Torna <a href='select_strutture.php'>indietro</a>";
          };
          break;
          case 'reparto':
            $query = "SELECT * FROM " . $_SESSION['tbl'] . " WHERE codreparto='" . $_POST['toupdate'] . "';";
            //echo $query;
            $result = pg_query($conn, $query);
            if (!$result) {
              echo "Si è verificato un errore.<br/>";
              echo pg_last_error($conn);
              exit();
            }
            else {
              //$cmdtuples = pg_affected_rows($result);
              $array = pg_fetch_array($result);
              print ($htmlint);
              
              echo "<h2>Aggiornamento reparto</h2>";
              print ("<table>");
              print ("<form action=\"strutture_upd2.php\" method=\"POST\">");
              //una volta raccolte le modifiche, passo i dati al file preposto all'applicazione delle stesse
              //si noti che la chiave non deve essere modificabile
              print ("<tr><th>Codice</th><td><input type=\"text\" name=\"codreparto\" value='" . $array['codreparto'] . "'  required readonly></td></tr>");
              print ("<tr><th>Nome</th><td><input type=\"text\" name=\"nomereparto\" value='" . $array['nomereparto'] . "' required></td</tr>");
              print ("<tr><th>Nr Telefono</th><td><input type=\"text\" name=\"nrtelefono\" value='" . $array['nrtelefono'] . "' required></td></tr>");
              print ("<tr><th>Inizio Visite</th><td><input type=\"time\" name=\"orarioiniziovisite\" value='" . $array['orarioiniziovisite'] . "' required></td</tr>");
              print ("<tr><th>Fine Visite</th><td><input type=\"time\" name=\"orariofinevisite\" value='" . $array['orariofinevisite'] . "' required></td></tr>");
              print ("<tr><th>Ospedale</th><td><input type=\"text\" name=\"codospedale\" value='" . $array['codospedale'] . "' required></td></tr>");
              
              print ("<tr><td><input type=\"submit\" name=\"toupdate2\" value=\"Send\"></td></tr>");
              print ("</form>");
              print ("</table>");
              echo ("<br>");

            echo "Torna <a href='select_strutture.php'>indietro</a>";
          
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