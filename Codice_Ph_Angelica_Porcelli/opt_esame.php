<!--opt_basic.php-->
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
if (isset($_POST['operazione'])) {//sono stati passati correttamente i dati
  //$tbl = $_POST['tabella'];
  $op = $_POST['operazione'];
  //$_SESSION['tbl'] = $tbl;
  //$_SESSION['op'] = $op;
  $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
  if (!$conn) {//caso connessione fallita
    echo 'Connessione al database fallita.';
    exit();
  }
  else {//caso connessione riuscita
    //echo "Connessione riuscita."."<br/>";
    switch ($op) {//stabilisco cosa fare in base all'operazione selezionata
      case 'select':
      //la selezione richiede la visualizzazione del resultset in forma tabellare
        //switch ($tbl) {//stabilisco cosa fare in base alla tabella selezionata
        //devo gestire tutte le combinazioni possibili operazione-tabella
          //case 'esame':

            $query = "SELECT e.codesame, e.descrizione, e.costopubblico, e.costoprivato, 
            e.codambulatorio, s.avvertenze
            FROM ESAME as e LEFT JOIN ESAME_SPECIALISTICO as s on e.codesame = s.codesamespecialistico ";
            $result = pg_query($conn, $query);
            if (!$result) {//la query ha generato errori
              echo "Si è verificato un errore.<br/>";
              echo pg_last_error($conn);
              exit();
            }
            else {//la query non ha generato errori
              print ($htmlint);
              //costruisco una tabella per visualizzare i dati

              //codesame    descrizione     costopubblico  costoprivato codambulatorio
              echo ' <h2> Elenco esami:</h2>
                <table>
                <tr>
                <th>Codice Esame</th>
                <th>Descrizione </td>
                <th>Costo Pubblico</th>
                <th>Costo Privato</th>
                <th>Codice Ambulatorio</th>
                <th>Avvertenze</th>
                </tr>';

                //popolo con i dati per visualizzare 
                    while ($row = pg_fetch_array($result)) {
                        echo '<tr>
                    <td>' . $row['codesame'] . '</td>
                    <td>' . $row['descrizione'] . '</td>
                    <td>' . $row['costopubblico'] . '</td>
                    <td>' . $row['costoprivato'] . '</td>          
                    <td>' . $row['codambulatorio'] . '</td>
                     <td>' . $row['avvertenze'] . '</td>                 
                </tr>';
                    };
                    echo '</table><br>';
                    echo "Torna agli  <a href='select_esame.php'> esami</a>";
                    };
                //break;
                //};
                break;
        
    //cancellazione
      case 'delete':
        //la cancellazione richiede la selezione preliminare della tupla da cancellare
        //switch ($tbl) {
          //case '...':
            // la query di cancellazione gestisce solo i dati eliminabili
            $query = "SELECT e.codesame, e.descrizione, e.costopubblico, e.costoprivato, e.codambulatorio, s.avvertenze
                FROM ESAME as e LEFT JOIN ESAME_SPECIALISTICO as s on e.codesame = s.codesamespecialistico 
                EXCEPT
                SELECT e.codesame, e.descrizione, e.costopubblico, e.costoprivato, e.codambulatorio, s.avvertenze
                FROM ESAME as e LEFT JOIN ESAME_SPECIALISTICO as s on e.codesame = s.codesamespecialistico JOIN prenotazione as p on e.codesame = p.codesame
                ";
          
            $result = pg_query($conn, $query);
            if (!$result) {
              echo "Si è verificato un errore.<br/>";
              echo pg_last_error($conn);
              exit();
            }
            else {
              print ($htmlint);
              echo "Torna agli  <a href='select_esame.php'> esami</a>";
              echo '<h2> Esami cancellabili:</h2>
                <table>
                <tr>
                <th>Codice Esame</th>
                <th>Descrizione </td>
                <th>Costo Pubblico</th>
                <th>Costo Privato</th>
                <th>Codice Ambulatorio</th>
                <th>Avvertenze</th>
                </tr>';

              print ("<form action=\"esame_del.php\" method=\"POST\">");
              //passo le informazioni della tupla selezionata da cancellare
              while ($row = pg_fetch_array($result)) {
                echo '<tr>
                    <td>' . $row['codesame'] . '</td>
                    <td>' . $row['descrizione'] . '</td>
                    <td>' . $row['costopubblico'] . '</td>
                    <td>' . $row['costoprivato'] . '</td>          
                    <td>' . $row['codambulatorio'] . '</td>
                    <td>' . $row['avvertenze'] . '</td>
                    <td><input type="radio" name="todelete" value=' . $row['codesame'] . ' required></td>                 
                </tr>';
              };

              
              echo '</table><br>';
             
              echo "<input type=\"submit\" name=\"delete\" value=\"Delete\">";

              echo "</form>"; 
              echo '<br>';

             
            //};
          //break;
        };
      break;
        //
        
      case 'insert':
        //l'inserimento richiede l'operazione preliminare di raccolta dei dati da inserire
        //switch ($tbl) {
          //case 'cliente':
            print ($htmlint);
            echo '<h2> Inserimento esami</h2>';

            
            echo '<br><table>';
            print ("<form action=\"esame_ins.php\" method=\"POST\">");
            //passo le informazioni oggetto dell'inserimento

            //ESAME(codesame    descrizione     costopubblico  costoprivato codambulatorio)
            print ("<tr><th>Codice</th><td><input type=\"text\" name=\"codesame\" required></td></tr>");
            print ("<tr><th>Descrizione</th><td><input type=\"text\" name=\"descrizione\" required></td</tr>");
            print ("<tr><th>Costo Pubblico</th><td><input type=\"number\" name=\"costopubblico\" required></td></tr>");
            print ("<tr><th>Costo Privato</th><td><input type=\"number\" name=\"costoprivato\" required></td></tr>");
             
               // Recupera i dati per gli elenchi a discesa
               $query_ambulatori = "SELECT codambulatorio, nome FROM AMBULATORIO_LABORATORIO";
               $result_ambulatori = pg_query($conn, $query_ambulatori);  

               echo '<tr><th>Ambulatorio</th><td><select name="codambulatorio" required>';
               while ($row = pg_fetch_assoc($result_ambulatori)) {
                   echo '<option value="' . $row['codambulatorio'] . '">' . $row['nome'] . '</option>';
               }
             // Radio button per Privato
             print ("<tr><th>Avvertenze </th><td><input type=\"text\" name=\"avvertenze\" ></td></tr>");
             
                    
            print ("<tr><td><input type=\"submit\" name=\"toinsert\" value=\"Insert\"></td></tr>");
            print ("</form>");
            print ("</table>");
            echo "Torna agli  <a href='select_esame.php'> esami</a> ";
          //break;
        //};
      break;
        
      //aggiornamento  
      case 'update':
        //l'operazione di aggiornamento richiede la scelta preliminare della tupla da aggiornare
        //switch ($tbl) {
          //case 'tab1':
            $query = "SELECT e.codesame, e.descrizione, e.costopubblico, e.costoprivato, 
            e.codambulatorio, s.avvertenze
            FROM ESAME as e LEFT JOIN ESAME_SPECIALISTICO as s ON e.codesame = s.codesamespecialistico
            ";

            $result = pg_query($conn, $query);
            if (!$result) {
              echo "Si è verificato un errore.<br/>";
              echo pg_last_error($conn);
              exit();
            }
            else {
              print ($htmlint);
              echo "<br>Torna alla pagina di selezione degli <a href='select_esame.php'>esami</a> <br>";
              
                  //ESAME(codesame    descrizione     costopubblico  costoprivato codambulatorio)
              echo '<br><table>
              
              <tr>
                <th>Codice Esame</th>
                <th>Descrizione</td>
                <th>Costo pubblico</th>
                <th>Costo privato</th>
                <th>Ambulatorio</th>
                <th>Avvertenze</th>
              </tr>';

              print ("<form action=\"esame_upd.php\" method=\"POST\">");
             
              //passo le informazioni della tupla selezionata da aggiornare
              while ($row = pg_fetch_array($result)) {
                echo '<tr>
            <td>' . $row['codesame'] . '</td>
            <td>' . $row['descrizione'] . '</td>
            <td>' . $row['costopubblico'] . '</td>
            <td>' . $row['costoprivato'] . '</td>          
            <td>' . $row['codambulatorio'] . '</td>
            <td>' . $row['avvertenze'] . '</td>             
            <td><input type="radio" name="toupdate" value=' . $row['codesame'] . ' required></td>
          </tr>';
              };
              echo '</table>';
              echo "<input type=\"submit\" name=\"update\" value=\"Update\">";
              echo "</form>";
            };
          break;
       // };
     // break;
    };
  };
}
else {//non sono stati passati correttamente i dati
  print ($htmlint);
  echo "Non risultano dati passati<br>";
  echo "Se vuoi puoi <a href='select_basic.php'>riprovare</a>";
}
?>
</BODY>
</HTML>