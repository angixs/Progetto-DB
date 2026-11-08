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

//file per gestire Ospedale, Reparto, Personale
if (isset($_POST['tabella']) && isset($_POST['operazione'])) {
    $tbl = $_POST['tabella']; 
    $op = $_POST['operazione'];
    $_SESSION['tbl'] = $tbl;

    $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
    if (!$conn) {
        echo 'Connessione al database fallita.';
        exit();
    } else {
        switch ($op) {
            case 'select':
                switch ($tbl) {
                    case 'ospedale':
                        $query = "SELECT * FROM Ospedale";
                        $result = pg_query($conn, $query);
                        if (!$result) {
                            echo "Si è verificato un errore.<br/>";
                            echo pg_last_error($conn);
                            exit();
                        } else {
                            print ($htmlint);
                            echo '
                            <h2> Ospedali della regione </h2>
                            <br><table>
                            <tr>
                              <th>Codice</th>
                              <th>Nome</th>
                              <th>Indirizzo</th>
                            </tr>';
                            while ($row = pg_fetch_array($result)) {
                                echo '<tr>
                                <td>' . $row['codospedale'] . '</td>
                                <td>' . $row['nomeospedale'] . '</td>
                                <td>' . $row['indirizzoospedale'] . '</td>       
                                </tr>';
                            }
                            echo '</table><br>';
                            echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                        }
                        break;

                    case 'personale':
                        $query = "SELECT * FROM Personale";
                        $result = pg_query($conn, $query);
                        if (!$result) {
                            echo "Si è verificato un errore.<br/>";
                            echo pg_last_error($conn);
                            exit();
                        } else {
                            print ($htmlint);
                            echo '
                           <h2> Personale della regione </h2>
                            <br><table>
                            <tr>
                              <th>Matricola</th>
                              <th>Nome</th>
                              <th>Cognome</th>
                              <th>Nr Cellulare</th>
                              <th>Reparto</th>
                            </tr>';
                            while ($row = pg_fetch_array($result)) {
                                echo '<tr>
                                <td>' . $row['matricola'] . '</td>
                                <td>' . $row['nome'] . '</td>
                                <td>' . $row['cognome'] . '</td>
                                <td>' . $row['nrcell'] . '</td>
                                <td>' . $row['codreparto'] . '</td>
                                </tr>';
                            }
                            echo '</table><br>';
                            echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                        }
                        break;
                        case 'reparto':
                            $query = "SELECT * FROM Reparto ORDER BY codospedale";
                            $result = pg_query($conn, $query);
                            if (!$result) {
                                echo "Si è verificato un errore.<br/>";
                                echo pg_last_error($conn);
                                exit();
                            } else {
                                print ($htmlint);
                                echo '
                                <h2> Reparti della regione </h2>
                                <br><table>
                                <tr>
                                  <th>Codice Reparto</th>
                                  <th>Nome</th>
                                  <th>Nr Telefono</th>
                                  <th>Inizio visite</th>
                                  <th>Fine visite</th>
                                  <th>Ospedale</th>
                                </tr>';
                                while ($row = pg_fetch_array($result)) {
                                    echo '<tr>
                                    <td>' . $row['codreparto'] . '</td>   
                                    <td>' . $row['nomereparto'] . '</td>   
                                    <td>' . $row['nrtelefono'] . '</td>
                                    <td>' . $row['orarioiniziovisite'] . '</td>
                                    <td>' . $row['orariofinevisite'] . '</td>    
                                    <td>' . $row['codospedale'] . '</td>   
                                    </tr>';
                                }
                                echo '</table><br>';
                                echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                            }
                            break;

                    default:
                        echo "Tabella non valida.";
                        break;
                }
                break;

            case 'delete':
                switch ($tbl) {
                    case 'ospedale':
                        //$query = "SELECT * FROM Ospedale";
                        
                        //posso eliminare solo gli ospedali vuoti
                        $query = "SELECT codospedale, nomeospedale, indirizzoospedale
                        FROM OSPEDALE
                        EXCEPT
                        SELECT o.codospedale, o.nomeospedale, o.indirizzoospedale
                        FROM OSPEDALE as o JOIN REPARTO as r ON o.codospedale = r.codospedale 
                        ";

                        $result = pg_query($conn, $query);
                        
                        if (!$result) {
                            echo "Si è verificato un errore.<br/>";
                            echo pg_last_error($conn);
                            exit();
                        } else {
                            print ($htmlint);
                            echo '
                            <h2> Ospedali eliminabili </h2>
                            <br><table>
                            <tr>
                                <th>Codice</th>
                                <th>Nome</th>
                                <th>Indirizzo</th>
                            </tr>';
                            
                            print ("<form action=\"strutture_del.php\" method=\"POST\">");
                            while ($row = pg_fetch_array($result)) {
                                echo '<tr>
                                <td>' . $row['codospedale'] . '</td>
                                <td>' . $row['nomeospedale'] . '</td>
                                <td>' . $row['indirizzoospedale'] . '</td>
                                <td><input type="radio" name="todelete" value=' . $row['codospedale'] . ' required></td>
                                </tr>';
                            }
                            echo '</table>';
                            echo "<input type=\"submit\" name=\"delete\" value=\"Delete\">";
                            echo "</form>";
                            echo "<br>";
                            echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                        }
                        break;
                      
                        case 'personale':
                          $query = "SELECT * FROM Personale";
                          $result = pg_query($conn, $query);
                          if (!$result) {
                              echo "Si è verificato un errore.<br/>";
                              echo pg_last_error($conn);
                              exit();
                          } else {
                              print ($htmlint);
                              echo '
                              <h2> Elimina personale </h2>
                              <br> <table>
                              <tr>
                                  <th>Matricola</th>
                                  <th>Nome</th>
                                  <th>Cognome</th>
                                  <th>Nr Cellulare</th>
                                  <th>Reparto</th>
                              </tr>';
                              print ("<form action=\"strutture_del.php\" method=\"POST\">");
                              while ($row = pg_fetch_array($result)) {
                                  echo '<tr>
                                    <td>' . $row['matricola'] . '</td>
                                    <td>' . $row['nome'] . '</td>
                                    <td>' . $row['cognome'] . '</td>
                                    <td>' . $row['nrcell'] . '</td>
                                    <td>' . $row['codreparto'] . '</td>
                                  <td><input type="radio" name="todelete" value=' . $row['matricola'] . ' required></td>
                                  </tr>';
                              }
                              echo '</table>';
                              echo "<input type=\"submit\" name=\"delete\" value=\"Delete\">";
                              echo "</form>";
                              echo "<br>";
                              echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                          }
                          break;
                          case 'reparto':
                            //$query = "SELECT * FROM Ospedale";
                            
                            //posso eliminare solo gli ospedali vuoti
                            $query = "SELECT codreparto, nomereparto,codospedale
                                    FROM REPARTO
                                    EXCEPT 
                                    SELECT r.codreparto, r.nomereparto, r.codospedale
                                    FROM REPARTO as r JOIN PERSONALE as p on r.codreparto = p.codreparto 
                                    JOIN STANZA as s ON r.codreparto = s.codreparto JOIN
                                    SALA_OPERATORIA as so ON r.codreparto = so.codreparto";
    
                            $result = pg_query($conn, $query);
                            
                            if (!$result) {
                                echo "Si è verificato un errore.<br/>";
                                echo pg_last_error($conn);
                                exit();
                            } else {
                                print ($htmlint);
                                echo '
                                <h2> Reparti eliminabili </h2>
                                <br><table>
                                <tr>
                                    <th>Codice</th>
                                    <th>Nome</th>
                                    <th>Ospedale</th>
                                </tr>';
                                
                                print ("<form action=\"strutture_del.php\" method=\"POST\">");
                                while ($row = pg_fetch_array($result)) {
                                    echo '<tr>
                                    <td>' . $row['codreparto'] . '</td>
                                    <td>' . $row['nomereparto'] . '</td>
                                    <td>' . $row['codospedale'] . '</td>
                                    <td><input type="radio" name="todelete" value=' . $row['codreparto'] . ' required></td>
                                    </tr>';
                                }
                                echo '</table>';
                                echo "<input type=\"submit\" name=\"delete\" value=\"Delete\">";
                                echo "</form>";
                                echo "<br>";
                                echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                            }
                            break;

                    default:
                        echo "Operazione non valida per questa tabella.";
                        break;
                }
                break;

            case 'insert':
                switch ($tbl) {
                    case 'ospedale':
                        print ($htmlint);
                        echo '
                        <h2> Inserimento di ospedali  </h2>
                        <br><table>';
                        print ("<form action=\"strutture_ins.php\" method=\"POST\">");
                        print ("<tr><th>Codice</th><td><input type=\"text\" name=\"codospedale\" required></td></tr>");
                        print ("<tr><th>Nome</th><td><input type=\"text\" name=\"nomeospedale\" required></td></tr>");
                        print ("<tr><th>Indirizzo</th><td><input type=\"text\" name=\"indirizzoospedale\" required></td></tr>");
                        print ("<tr><td><input type=\"submit\" name=\"toinsert\" value=\"Insert\"></td></tr>");
                        print ("</form>");
                        print ("</table>");
                        echo "<br>";
                        echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                        break;

                    case 'personale':
                         // Recupera i reparti esistenti
                         $query_reparti = "SELECT codreparto, nomereparto, codospedale FROM Reparto";
                         $result_reparti = pg_query($conn, $query_reparti);
                         if (!$result_reparti) {
                             echo "Si è verificato un errore nel recupero dei reparti.<br/>";
                             echo pg_last_error($conn);
                             exit();
                         }
                         
                        print ($htmlint);
                        echo '
                        <h2> Inserimento di personale  </h2>
                        <br><table>';
                        print ("<form action=\"strutture_ins.php\" method=\"POST\">");
                        print ("<tr><th>Matricola</th><td><input type=\"text\" name=\"matricola\" required></td></tr>");
                        print ("<tr><th>Nome</th><td><input type=\"text\" name=\"nome\" required></td></tr>");
                        print ("<tr><th>Cognome</th><td><input type=\"text\" name=\"cognome\" required></td></tr>");
                        print ("<tr><th>Nr Cellulare</th><td><input type=\"text\" name=\"nrcell\" required></td></tr>");
                        
                        //print ("<tr><th>Cod Reparto</th><td><input type=\"text\" name=\"codreparto\" required></td></tr>");
                         // Dropdown per selezionare il reparto
                         print ("<tr><th>Reparto</th><td><select name=\"codreparto\" required>");
                         while ($row = pg_fetch_assoc($result_reparti)) {
                             print ("<option value=\"" . $row['codreparto'] . "\">" . $row['codospedale'] .' '. $row['nomereparto'] . "</option>");
                         }
                         print ("</select></td></tr>");

                        // Checkbox per selezionare il tipo di personale
                        print ("<tr><th>Tipo Personale</th><td>");
                        print ("<input type=\"radio\" name=\"tipo_personale[]\" value=\"infermiere\"> Infermiere ");
                        print ("<input type=\"radio\" name=\"tipo_personale[]\" value=\"medico\"> Medico ");
                        print ("<input type=\"radio\" name=\"tipo_personale[]\" value=\"amministrativo\"> Amministrativo ");
                        print ("</td></tr>");
                        
                        print ("<tr><td><input type=\"submit\" name=\"toinsert\" value=\"Insert\"></td></tr>");
                        print ("</form>");
                        print ("</table>");
                        echo "<br>";
                        echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                        break;


                        case 'reparto':
                            // Recupera i reparti esistenti
                            $query_osp = "SELECT * FROM Ospedale";
                            $result_osp = pg_query($conn, $query_osp);
                            if (!$result_osp) {
                                echo "Si è verificato un errore nel recupero dei reparti.<br/>";
                                echo pg_last_error($conn);
                                exit();
                            }
                            
                           print ($htmlint);
                           echo '
                           <h2> Inserimento dei reparti  </h2>
                           <br><table>';
                           print ("<form action=\"strutture_ins.php\" method=\"POST\">");
                           print ("<tr><th>Codice Reparto</th><td><input type=\"text\" name=\"codreparto\" required></td></tr>");
                           print ("<tr><th>Nome</th><td><input type=\"text\" name=\"nomereparto\" required></td></tr>");
                           print ("<tr><th>Telefono</th><td><input type=\"text\" name=\"nrtelefono\" required></td></tr>");
                           print ("<tr><th>Inizio viste</th><td><input type=\"time\" name=\"orarioiniziovisite\" required></td></tr>");
                           print ("<tr><th>Fine visite</th><td><input type=\"time\" name=\"orariofinevisite\" required></td></tr>");
                           
                            // Dropdown per selezionare il reparto
                            print ("<tr><th>Ospedale</th><td><select name=\"codospedale\" required>");
                            while ($row = pg_fetch_assoc($result_osp)) {
                                print ("<option value=\"" . $row['codospedale'] . "\">" .' '. $row['codospedale'] . "</option>");
                            }
                            print ("</select></td></tr>");
   
                           // Checkbox per selezionare il tipo di personale  
                           print ("<tr><td><input type=\"submit\" name=\"toinsert\" value=\"Insert\"></td></tr>");
                           print ("</form>");
                           print ("</table>");
                           echo "<br>";
                           echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                           break;
                        
                    default:
                        echo "Inserimento non valido per questa tabella.";
                        break;
                }
                break;

            case 'update':
                switch ($tbl) {
                  //OSPEDALE
                    case 'ospedale':
                        $query = "SELECT * FROM Ospedale";
                        $result = pg_query($conn, $query);
                        if (!$result) {
                            echo "Si è verificato un errore.<br/>";
                            echo pg_last_error($conn);
                            exit();
                        } else {
                            print ($htmlint);
                            echo '
                            <h2> Aggiornamento di ospedali  </h2>
                            <br><table>
                            <tr>
                                <th>Codice</th>
                                <th>Nome</th>
                                <th>Indirizzo</th>
                            </tr>';
                            print ("<form action=\"strutture_upd.php\" method=\"POST\">");
                            while ($row = pg_fetch_array($result)) {
                                echo '<tr>
                                <td>' . $row['codospedale'] . '</td>
                                <td>' . $row['nomeospedale'] . '</td>
                                <td>' . $row['indirizzoospedale'] . '</td>
                                <td><input type="radio" name="toupdate" value=' . $row['codospedale'] . ' required></td>
                                </tr>';
                            }
                            echo '</table>';
                            echo "<input type=\"submit\" name=\"update\" value=\"Update\">";
                            echo "</form>";
                            echo "<br>";
                            echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                        }
                        break;

                      //PERSONALE
                      case 'personale':

                        $query = "SELECT * FROM Personale";
                        $result = pg_query($conn, $query);
                        if (!$result) {
                            echo "Si è verificato un errore.<br/>";
                            echo pg_last_error($conn);
                            exit();
                        } else {
                            print ($htmlint);
                            echo '
                                <h2> Aggiornamento del personale </h2>
                            <br><table>
                            <tr>
                                <th>Matricola</th>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Nr Cellulare</th>
                                <th>Reparto</th>
                            </tr>';
                            print ("<form action=\"strutture_upd.php\" method=\"POST\">");
                            while ($row = pg_fetch_array($result)) {
                                echo '<tr>
                                  <td>' . $row['matricola'] . '</td>
                                  <td>' . $row['nome'] . '</td>
                                  <td>' . $row['cognome'] . '</td>
                                  <td>' . $row['nrcell'] . '</td>
                                  <td>' . $row['codreparto'] . '</td>
                                <td><input type="radio" name="toupdate" value=' . $row['matricola'] . ' required></td>
                                </tr>';
                            }
                            echo '</table>';
                            echo "<input type=\"submit\" name=\"update\" value=\"Update\">";
                            echo "</form>";
                            echo "<br>";
                            echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                        }
                        break;

                        case 'reparto':
                            $query = "SELECT * FROM Reparto";
                            $result = pg_query($conn, $query);
                            if (!$result) {
                                echo "Si è verificato un errore.<br/>";
                                echo pg_last_error($conn);
                                exit();
                            } else {
                                print ($htmlint);
                                echo '
                                <h2> Aggiornamento di reparti  </h2>
                                <br><table>
                                <tr>
                                    <th>Codice</th>
                                    <th>Nome</th>
                                    <th>Telefono</th>
                                    <th>Inizio Visite</th>
                                    <th>Fine Visite</th>
                                    <th>Ospedale</th>
                                </tr>';
                                print ("<form action=\"strutture_upd.php\" method=\"POST\">");
                                while ($row = pg_fetch_array($result)) {
                                    echo '<tr>
                                    <td>' . $row['codreparto'] . '</td>
                                    <td>' . $row['nomereparto'] . '</td>
                                    <td>' . $row['nrtelefono'] . '</td>
                                    <td>' . $row['orarioiniziovisite'] . '</td>
                                    <td>' . $row['orariofinevisite'] . '</td>
                                    <td>' . $row['codospedale'] . '</td>
                                    <td><input type="radio" name="toupdate" value=' . $row['codreparto'] . ' required></td>
                                    </tr>';
                                }
                                echo '</table>';
                                echo "<input type=\"submit\" name=\"update\" value=\"Update\">";
                                echo "</form>";
                                echo "<br>";
                                echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
                            }
                            break;

                    default:
                        echo "Aggiornamento non valido per questa tabella.";
                        break;
                }
                break;

            default:
                echo "Operazione non valida.";
                break;
        }
    }
} else {
    print ($htmlint);
    echo "Non sono stati passati correttamente i dati.<br>";
    echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
}
?>
</BODY>
</HTML>