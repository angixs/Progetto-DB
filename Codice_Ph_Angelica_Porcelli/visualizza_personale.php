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
    $query_ospedali = "SELECT codospedale, nomeospedale FROM ospedale";
    $result_ospedali = pg_query($conn, $query_ospedali);

    if (!$result_ospedali) {
        echo "Errore nella query degli ospedali.";
        exit();
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Visualizza Personale per Ospedale</title>
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
    <h1>Seleziona un Ospedale</h1>  
    <div class="container">

    <!-- Form per selezionare il dato, per visualizzare le sue info-->
    <form method="POST" action="">
        <label for="ospedale">Ospedale:</label>
        <select name="ospedale" id="ospedale">

        <!-- Chiamata alla query per visualizzare effettivamente i dati nel db, per selezionarne poi uno -->
            <?php
            while ($row = pg_fetch_assoc($result_ospedali)) {
                echo "<option value='" . $row['codospedale'] . "'>" . $row['nomeospedale'] . "</option>";
            }
            ?>
        </select>

        <!-- Submit per mandare le info richieste -->
        <input type="submit" name="submit" value="Visualizza Personale">
        <input type="submit" name="submit" value="Visualizza Medici">
        <input type="submit" name="submit" value="Visualizza Infermieri">
        <input type="submit" name="submit" value="Visualizza personale amministrativo">
    </form>
</div>

    <?php

//se è stato selezionato e mandato in submit, un codice di un ospedale ed effettivamente c'è allora

    if (isset($_POST['submit']) && isset($_POST['ospedale'])) {
        
        $ospedale_selezionato = $_POST['ospedale'];
        $query_personale = "";
        $submit_value = $_POST['submit'];

        switch ($submit_value) {
            case 'Visualizza Personale':
        
        // Recupera il personale per l'ospedale selezionato, tramite una query che poi uso
        $query_personale = "
            SELECT p.matricola, p.nome, p.cognome, p.nrcell, r.codreparto, r.nomereparto
            FROM personale p
            JOIN reparto r ON p.codreparto = r.codreparto
            WHERE r.codospedale = '$ospedale_selezionato'
            ORDER BY p.codreparto, p.matricola
        ";
        break;
        case 'Visualizza Medici':
            $query_personale = "
                SELECT p.matricola, p.nome, p.cognome, p.nrcell, r.codreparto, r.nomereparto
                FROM personale p
                JOIN reparto r ON p.codreparto = r.codreparto
                JOIN medico m ON p.matricola = m.matricolamedico
                WHERE r.codospedale = '$ospedale_selezionato'
                ORDER BY p.codreparto, p.matricola
            ";
        
        case 'Visualizza Infermieri':
                $query_personale = "
                    SELECT p.matricola, p.nome, p.cognome, p.nrcell, r.codreparto, r.nomereparto
                    FROM personale p
                    JOIN reparto r ON p.codreparto = r.codreparto
                    JOIN infermiere i ON p.matricola = i.matricolainfermiere
                    WHERE r.codospedale = '$ospedale_selezionato'
                    ORDER BY p.codreparto, p.matricola
                ";
        
        case 'Visualizza personale amministrativo':
                    $query_personale = "
                        SELECT p.matricola, p.nome, p.cognome, p.nrcell, r.codreparto, r.nomereparto
                        FROM personale p
                        JOIN reparto r ON p.codreparto = r.codreparto
                        JOIN amministrativo a ON p.matricola = a.matricolaamministrativo
                        WHERE r.codospedale = '$ospedale_selezionato'
                        ORDER BY p.codreparto, p.matricola
                    ";
            break;
        
        default:
            echo "Azione non valida.";
            exit();
        }
        //testo la connessione con la query
        $result_personale = pg_query($conn, $query_personale);
        if (!$result_personale) {
            echo "Errore nella query del personale.";
            exit();
        }

        //creazione di una tabella per visualizzare l'effettivo personale, indicando il codice dell'ospedale
        echo "<h2>Personale dell'ospedale '$ospedale_selezionato'</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Matricola</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Numero di Cellulare</th>
                    <th>Cod</th>
                    <th>Reparto</th>
                </tr>";

    //ciclo while che prende e mette nelle colonne le informazioni prese dalla query $result_
        while ($row = pg_fetch_assoc($result_personale)) {
            echo "<tr>
                    <td>" . $row['matricola'] . "</td>
                    <td>" . $row['nome'] . "</td>
                    <td>" . $row['cognome'] . "</td>
                    <td>" . $row['nrcell'] . "</td>
                    <td>" . $row['codreparto'] . "</td>
                    <td>" . $row['nomereparto'] . "</td>
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
