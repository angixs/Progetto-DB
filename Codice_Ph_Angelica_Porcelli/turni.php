<!--visualizzare i medici e gli infermieri, selezionato un turno specifico -->

<?php
    session_start();

    //connessione
    $conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
    if (!$conn) {
        echo "<html><head><title>Errore di connessione</title></head><body>";
        echo 'Connessione al database fallita.';
        echo "</body></html>";
        exit();
    }

    // Recupera la lista degli ospedali esistenti nel db
    $query = "SELECT codturno FROM TURNO";
    $result = pg_query($conn, $query);

    if (!$result) {
        echo "Errore nella query degli ospedali.";
        exit();
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Visualizza Turni</title>
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
</head>
<body>
    <h1>Seleziona un Turno</h1>  
    <div class="container">

    <!-- Form per selezionare il dato, per visualizzare le sue info-->
    <form method="POST" action="">
        <label for="turno">Turno:</label>
        <select name="turno" id="turno">

        <!-- Chiamata alla query per visualizzare effettivamente i dati nel db, per selezionarne poi uno -->
            <?php
            while ($row = pg_fetch_assoc($result)) {
                echo "<option value='" . $row['codturno'] . "'>" . $row['codturno'] . $row['dataorainizio'] . "</option>";
            }
            ?>
        </select>

        <!-- Submit per mandare le info richieste -->
        <input type="submit" name="submit" value="Turno">
    </form>
</div>

    <?php

//se è stato selezionato e mandato in submit, un codice di un ospedale ed effettivamente c'è allora

    if (isset($_POST['submit']) && isset($_POST['turno'])) {
        
        $turno_selezionato = $_POST['turno'];
        $query_turno = "";
        $submit_value = $_POST['submit'];

        switch ($submit_value) {
            case 'Turno':
        
        // Recupera il personale per l'ospedale selezionato, tramite una query che poi uso
        $query_turno = "SELECT t.codturno, t.dataorainizio, t.dataorafine, i.matricolainfermiere,  
            m.matricolamedico, t.codospedaleps
            FROM TURNO as t JOIN TURNO_INFERMIERE as i on t.codturno = i.codturno 
            JOIN TURNO_MEDICO as m ON t.codturno = m.codturno 
            WHERE t.codturno = '$turno_selezionato'
        ";
        break;
        
        default:
            echo "Azione non valida.";
            exit();
        }
        //testo la connessione con la query
        $result_turno = pg_query($conn, $query_turno);
        if (!$result_turno) {
            echo "Errore nella query del personale.";
            exit();
        }

        //creazione di una tabella per visualizzare l'effettivo personale, indicando il codice dell'ospedale
        echo "<h2>Informazioni sul turno'$turno_selezionato'</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Codice</th>
                    <th>Data e ora di inizio</th>
                    <th>Data e ora di fine</th>
                    <th>Infermiere</th>
                    <th>Medico</th>
                    <th>Pronto Soccorso</th>
                </tr>";

    //ciclo while che prende e mette nelle colonne le informazioni prese dalla query $result_
        while ($row = pg_fetch_assoc($result_turno)) {
            echo "<tr>
                    <td>" . $row['codturno'] . "</td>
                    <td>" . $row['dataorainizio'] . "</td>
                    <td>" . $row['dataorafine'] . "</td>
                    <td>" . $row['matricolainfermiere'] . "</td>
                    <td>" . $row['matricolamedico'] . "</td>
                    <td>" . $row['codospedaleps'] . "</td>
                </tr>";
        }

        echo "</table>";
    }


    pg_close($conn);
    ?>
    <br>
    <br>
    <a href="strutture_personale.php" class="button">Torna indietro  </a>
</body>
</html>
