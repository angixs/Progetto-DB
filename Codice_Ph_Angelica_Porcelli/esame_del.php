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
if (isset($_POST['todelete'])) {
    $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
    if (!$conn) {
        echo 'Connessione al database fallita.';
        exit();
    } else {
        // Quale tabella è stata selezionata per l'eliminazione
        //switch ($_SESSION['tbl']) {
           //case '...':
                // Prepara la query di eliminazione per l'...
                $query = "DELETE FROM Esame WHERE codesame='" . $_POST['todelete'] . "'";
                print ("</select></td></tr>");           
             //   break;
        }
        
        $result = pg_query($conn, $query);
        if (!$result) {
            echo "Si è verificato un errore durante l'eliminazione.<br/>";
            echo pg_last_error($conn);
            exit();
        } else {
            echo "Cancellazione avvenuta con successo<br><a href='select_esame.php'>Torna alla selezione esame</a>";
        }
} else {
    print ($htmlint);
    echo "Non risultano dati passati<br>";
    echo "Tornare agli puoi <a href='select_esame.php'>esami</a>";
}
?>
</BODY>
</HTML>
