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
if (isset($_POST['toupdate'])) {//sono stati passati correttamente i dati
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
  }
  else {
    //echo "Connessione riuscita."."<br/>";

   //solo paziente
        $query = "SELECT * FROM " . 'paziente' . " WHERE cf ='" . $_POST['toupdate'] . "';";
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
          echo "<h2> Aggiornamento cf paziente '" . $_POST['toupdate'] . "' </h2>";
          print ("<table>");
          print ("<form action=\"paziente_upd2.php\" method=\"POST\">");

          //una volta raccolte le modifiche, passo i dati al file preposto all'applicazione delle stesse
          //si noti che la chiave non deve essere modificabile
          print ("<tr><th>Codice</th><td><input type=\"text\" name=\"cf\" value='" . $array['cf'] . "'  required readonly></td></tr>");
          print ("<tr><th>Nome</th><td><input type=\"text\" name=\"nome\" value='" . $array['nome'] . "' required></td</tr>");
          print ("<tr><th>Nome</th><td><input type=\"text\" name=\"cognome\" value='" . $array['cognome'] . "' required></td</tr>");
          print ("<tr><th>Data di nascita</th><td><input type=\"text\" name=\"datadinascita\" value='" . $array['datadinascita'] . "' required></td</tr>");
          print ("<tr><th>Indirizzo</th><td><input type=\"text\" name=\"indirizzo\" value='" . $array['indirizzo'] . "' required></td></tr>");
          print ("<tr><td><input type=\"submit\" name=\"toupdate2\" value=\"Send\"></td></tr>");
          print ("</form>");
          print ("</table>");
          echo "<br> Torna alla pagina  <a href='select_paziente.php'> pazienti</a>";
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