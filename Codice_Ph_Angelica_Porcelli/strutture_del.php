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
if (isset($_POST['todelete']) && isset($_SESSION['tbl'])) {
    $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
    if (!$conn) {
        echo 'Connessione al database fallita.';
        exit();
    } else {

        // Verifica quale tabella è stata selezionata per l'eliminazione
        switch ($_SESSION['tbl']) {
            case 'ospedale':
                // Prepara la query di eliminazione per l'ospedale
                $query = "DELETE FROM Ospedale WHERE codospedale='" . $_POST['todelete'] . "'";
                print ("</select></td></tr>");           

                break;
                
            case 'personale':
                // Prepara la query di eliminazione per il personale
                $query = "DELETE FROM Personale WHERE matricola='" . $_POST['todelete'] . "'";
                break;
            
            case 'reparto':
                    // Prepara la query di eliminazione per il personale
                    $query = "DELETE FROM Reparto WHERE codreparto ='" . $_POST['todelete'] . "'";
                    break;
            
                    
            default:
                echo "Tabella non valida per l'eliminazione.";
                exit();
        }
        
        $result = pg_query($conn, $query);
        if (!$result) {
            echo "Si è verificato un errore durante l'eliminazione.<br/>";
            echo pg_last_error($conn);
            exit();
        } else {
            echo "Cancellazione avvenuta con successo<br><a href='select_strutture.php'>Ritorna</a>";
        }
    }
} else {
    print ($htmlint);
    echo "Non risultano dati passati<br>";
    echo "Se vuoi puoi <a href='select_strutture.php'>riprovare</a>";
}
?>
</BODY>
</HTML>
