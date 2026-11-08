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
  } else {
    //echo "Connessione riuscita."."<br/>"; $_SESSION['tbl'] 
    $query = "SELECT * FROM Prenotazione WHERE cfpaziente='" . $_POST['toupdate'] . "';";
    //echo $query;
    $result = pg_query($conn, $query);
    if (!$result) {
      echo "Si è verificato un errore.<br/>";
      echo pg_last_error($conn);
      exit();
    } else {
      $array = pg_fetch_array($result);
      print($htmlint);
      print(" <h2> Modifica la prenotazione</h2> ");
      print("<table>");
      print("<form action=\"prenotazione_upd2.php\" method=\"POST\">");
      
      
      print("<tr><th>Data Esame</th><td><input type=\"date\" name=\"dataesame\" value='" . $array['dataesame'] . "' required></td></tr>");
      print("<tr><th>Ora Esame</th><td><input type=\"time\" name=\"oraesame\" value='" . $array['oraesame'] . "' required></td></tr>");
    
      //radio button per scegliere se privato o no, partendo da quella memorizzata checked
      print("<tr><th>Privato</th><td>
              <input type='radio' name='privato' value='true' " . ($array['privato'] == 't' ? 'checked' : '') . " required> Sì 
              <input type='radio' name='privato' value='false' " . ($array['privato'] == 'f' ? 'checked' : '') . " required> No
            </td></tr>");

    //radio button per poter scegliere il tipo di urgenza, partendo da quella memorizzata checked
    print("<tr><th>Urgenza</th><td>
            <input type='radio' name='urgenza' value='Rosso' " . ($array['urgenza'] == 'Rosso' ? 'checked' : '') . " required> Rosso
            <input type='radio' name='urgenza' value='Giallo' " . ($array['urgenza'] == 'Giallo' ? 'checked' : '') . " required> Giallo
            <input type='radio' name='urgenza' value='Verde' " . ($array['urgenza'] == 'Verde' ? 'checked' : '') . " required> Verde
          
            </td></tr>");
        
      //  print("<tr><th>Urgenza</th><td><input type=\"text\" name=\"urgenza\" value='" . $array['urgenza'] . "' required></td></tr>");
      //  print("<tr><th>Matricola Medico</th><td><input type=\"text\" name=\"matricolamedico\" value='" . $array['matricolamedico'] . "' ></td></tr>");

      // Recupera i medici dal database
      $query_medici = "SELECT MatricolaMedico FROM MEDICO";
      $result_medici = pg_query($conn, $query_medici);
      
      if (!$result_medici) {
        echo "Si è verificato un errore nel recupero dei medici.<br/>";
        echo pg_last_error($conn);
        exit();
      } else {
        // Elenco a discesa per Matricola Medico, che li recupera dalla tabella MEDICO
        print("<tr><th>Matricola Medico</th><td><select name='matricolamedico'>");
        while ($row_medico = pg_fetch_assoc($result_medici)) {
          $selected = ($array['matricolamedico'] == $row_medico['matricolamedico']) ? "selected" : "";
          print("<option value='" . $row_medico['matricolamedico'] . "' $selected>" . $row_medico['matricolamedico'] . "</option>");
        }
        print("</select></td></tr>");
      }

      print("<tr><td><input type=\"hidden\" name=\"cfpaziente\" value='" . $array['cfpaziente'] . "'></td></tr>");
      print("<tr><td><input type=\"submit\" name=\"toupdate2\" value=\"Send\"></td></tr>");
      print("</form>");
      print("</table>");
      echo 'Torna all area di modifica delle <a href="prenota_modifica.php" class="button"> prenotazioni</a>';
    }
  }
} else { // non sono stati passati correttamente i dati
  print($htmlint);
  echo "Non risultano dati passati<br>";
  echo "Se vuoi puoi <a href='prenota_modifica.php'>riprovare</a>";
}
?>
</BODY>
</HTML>
