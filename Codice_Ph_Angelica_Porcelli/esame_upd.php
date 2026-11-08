<!--basic_upd.php-->
<?php
session_start();
$htmlint = <<<NOW
<HTML>
  <HEAD>
    <style>
      table, th, td {
        text-align: left;
        border: 1px solid;
        text-align:center;
      }
    </style>
  </HEAD>
<BODY> 
NOW;
//print_R($_POST);
if (isset($_POST['toupdate']) ) {//sono stati passati correttamente i dati
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {
    echo 'Connessione al database fallita.';
    exit();
  }
  else {
    //echo "Connessione riuscita."."<br/>"; $_SESSION['tbl'] 
    $query = "SELECT e.codesame, e.descrizione, e.costopubblico, e.costoprivato, 
                      e.codambulatorio, s.avvertenze
              FROM Esame as e LEFT JOIN ESAME_SPECIALISTICO as s ON e.codesame = s.codesamespecialistico 
              WHERE e.codesame='" . $_POST['toupdate'] ."';";

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
      print("<h2> Aggiornamento esami </h2>");
      print ("<table>");
      print ("<form action=\"esame_upd2.php\" method=\"POST\">");
      //una volta raccolte le modifiche, passo i dati al file per l'applicazione delle stesse
      // la chiave non deve essere modificabile
      
      print ("<tr><th>Codice Esame</th><td><input type=\"text\" name=\"codesame\" value='" . $array['codesame'] . "'  required readonly></td></tr>"); //sola lettura
      print ("<tr><th>Descrizione</th><td><input type=\"text\" name=\"descrizione\" value='" . $array['descrizione'] . "' required></td</tr>");
      print ("<tr><th>Costo Pubblico</th><td><input type=\"number\" name=\"costopubblico\" value='" . $array['costopubblico'] . "' required></td></tr>");
      print ("<tr><th>Costo Privato</th><td><input type=\"number\" name=\"costoprivato\" value='" . $array['costoprivato'] . "' required></td></tr>");
      print ("<tr><th>Ambulatorio</th><td><input type=\"text\" name=\"codambulatorio\" value='" . $array['codambulatorio'] . "' required></td></tr>");
      print ("<tr><th>Avvertenze</th><td><input type=\"text\" name=\"avvertenze\" value='" . $array['avvertenze'] . "' ></td></tr>");

      print ("<tr><td><input type=\"submit\" name=\"toupdate2\" value=\"Send\"></td></tr>");
      print ("</form>");
      print ("</table>");
      print("<br>");
      print("Torna agli<a href='select_esame.php'> esami</a>");
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