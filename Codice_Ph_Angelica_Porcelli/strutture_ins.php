<?php
session_start();

if (!isset($_POST['toinsert']) || !isset($_SESSION['tbl'])) {
    // Gestione del caso in cui non siano stati passati correttamente i dati
    echo "<html><head><title>Errore</title></head><body>";
    echo "Non sono stati passati correttamente i dati.<br>";
    echo "Torna alla pagina iniziale: <a href='select_strutture.php'>vai</a>";
    echo "</body></html>";
    exit();
}

$conn = pg_connect("host=localhost port=5432 dbname=Ospedale user=postgres password=unimi");
if (!$conn) {
    echo "<html><head><title>Errore di connessione</title></head><body>";
    echo 'Connessione al database fallita.';
    echo "</body></html>";
    exit();
}

$tbl = $_SESSION['tbl'];

switch ($tbl) {
    case 'ospedale':
        //recupero i dati dal form nel file opt_strutture
        $cod = isset($_POST['codospedale']) ? $_POST['codospedale'] : NULL;
        $nome = isset($_POST['nomeospedale']) ? $_POST['nomeospedale'] : NULL;
        $ind = isset($_POST['indirizzoospedale']) ? $_POST['indirizzoospedale'] : NULL;
        $query = "INSERT INTO ospedale (codospedale, nomeospedale, indirizzoospedale) VALUES ('$cod', '$nome', '$ind')";
        $result = pg_query($conn, $query);
        if (!$result) {
            echo "<html><head><title>Errore</title></head><body>";
            echo "Si è verificato un errore durante l'inserimento dell'ospedale.<br>";
            echo pg_last_error($conn);
            echo "<br><a href='select_strutture.php'>Torna indietro</a>";
            echo "</body></html>";
            exit();
        }

        echo "<html><head><title>Inserimento avvenuto con successo</title></head><body>";
        echo "Inserimento dell'ospedale avvenuto con successo.<br>";
        echo "<a href='select_strutture.php'>Torna indietro</a>";
        echo "</body></html>";
        break;

    case 'personale':
        $matricola = isset($_POST['matricola']) ? $_POST['matricola'] : NULL;
        $nome = isset($_POST['nome']) ? $_POST['nome'] : NULL;
        $cognome = isset($_POST['cognome']) ? $_POST['cognome'] : NULL;
        $nrCell = isset($_POST['nrcell']) ? $_POST['nrcell'] : NULL;
        $codReparto = isset($_POST['codreparto']) ? $_POST['codreparto'] : NULL;

        // Inserimento nella tabella Personale
        $query = "INSERT INTO personale (matricola, nome, cognome, nrcell, codreparto) VALUES ('$matricola', '$nome', '$cognome', '$nrCell', '$codReparto')";
        $result = pg_query($conn, $query);

        if (!$result) {
            echo "<html><head><title>Errore</title></head><body>";
            echo "Si è verificato un errore durante l'inserimento nel personale.<br>";
            echo pg_last_error($conn);
            echo "<br><a href='select_strutture.php'>Torna indietro</a>";
            echo "</body></html>";
            exit();
        }

        // Verifica se è stato selezionato il tipo di personale (infermiere, medico, amministrativo)
        if (isset($_POST['tipo_personale'])) {
            $tipoPersonale = $_POST['tipo_personale'];
            foreach ($tipoPersonale as $tipo) {

                //gestisco l'inserimento del personale, specificando se infermiere, medico o amministrativo
                switch ($tipo) {
                    case 'infermiere':
                        // Inserimento nella tabella Infermiere
                        $queryInfermiere = "INSERT INTO infermiere (matricolainfermiere) VALUES ('$matricola')";
                        $resultInfermiere = pg_query($conn, $queryInfermiere);
                        if (!$resultInfermiere) {
                            echo "<html><head><title>Errore</title></head><body>";
                            echo "Si è verificato un errore durante l'inserimento dell'infermiere.<br>";
                            echo pg_last_error($conn);
                            echo "<br><a href='select_strutture.php'>Torna indietro</a>";
                            echo "</body></html>";
                            exit();
                        }
                        break;
                    // Aggiungi qui casi per altri tipi di personale se necessario
                    case 'medico':
                      // Inserimento nella tabella Medico
                      $queryMedico = "INSERT INTO medico (matricolamedico, dataassunzione) VALUES ('$matricola', CURRENT_DATE)";
                      $resultMedico = pg_query($conn, $queryMedico);
                      if (!$resultMedico) {
                          echo "<html><head><title>Errore</title></head><body>";
                          echo "Si è verificato un errore durante l'inserimento dell'infermiere.<br>";
                          echo pg_last_error($conn);
                          echo "<br><a href='select_strutture.php'>Torna indietro</a>";
                          echo "</body></html>";
                          exit();
                      }
                      break;
                      case 'amministrativo':
                        // Inserimento nella tabella Amministrativo
                        $queryAmministrativo = "INSERT INTO medico (matricolaamministrativo) VALUES ('$matricola')";
                        $resultAmministrativo = pg_query($conn, $queryAmministrativo);
                        if (!$resultAmministrativo) {
                            echo "<html><head><title>Errore</title></head><body>";
                            echo "Si è verificato un errore durante l'inserimento dell'infermiere.<br>";
                            echo pg_last_error($conn);
                            echo "<br><a href='select_strutture.php'>Torna indietro</a>";
                            echo "</body></html>";
                            exit();
                        }
                        break;
                    
                }
            }   
        }


        echo "<html><head><title>Inserimento avvenuto con successo</title></head><body>";
        echo "Inserimento avvenuto con successo.<br>";
        echo "<a href='select_strutture.php'>Torna indietro</a>";
        echo "</body></html>";
        break;

        case 'reparto':
            $cod = isset($_POST['codreparto']) ? $_POST['codreparto'] : NULL;
            $nome = isset($_POST['nomereparto']) ? $_POST['nomereparto'] : NULL;
            $nr = isset($_POST['nrtelefono']) ? $_POST['nrtelefono'] : NULL;
            $in = isset($_POST['orarioiniziovisite']) ? $_POST['orarioiniziovisite'] : NULL;
            $fi = isset($_POST['orariofinevisite']) ? $_POST['orariofinevisite'] : NULL;
            $os = isset($_POST['codospedale']) ? $_POST['codospedale'] : NULL;

            $query = "INSERT INTO reparto (codreparto, nomereparto, nrtelefono, orarioiniziovisite, orariofinevisite, codospedale) VALUES ('$cod', '$nome','$nr','$in', '$fi', '$os')";
            $result = pg_query($conn, $query);
            if (!$result) {
                echo "<html><head><title>Errore</title></head><body>";
                echo "Si è verificato un errore durante l'inserimento dell'ospedale.<br>";
                echo pg_last_error($conn);
                echo "<br><a href='select_strutture.php'>Torna indietro</a>";
                echo "</body></html>";
                exit();
            }
    
            echo "<html><head><title>Inserimento avvenuto con successo</title></head><body>";
            echo "Inserimento dell'ospedale avvenuto con successo.<br>";
            echo "<a href='select_strutture.php'>Torna indietro</a>";
            echo "</body></html>";
            break;

    default:
        echo "<html><head><title>Errore</title></head><body>";
        echo "Tabella non valida per l'inserimento.";
        echo "</body></html>";
        exit();
}

pg_close($conn);
?>