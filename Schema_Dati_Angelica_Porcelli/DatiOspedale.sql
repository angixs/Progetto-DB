-- Inserimento dati nella tabella OSPEDALE
INSERT INTO OSPEDALE (CodOspedale, NomeOspedale, IndirizzoOspedale) VALUES
('OSP01', 'Ospedale San Raffaele', 'Via Olgettina 60, Milano'),
('OSP02', 'Ospedale Niguarda', 'Piazza Ospedale Maggiore 3, Milano'),
('OSP03', 'Ospedale Luigi Sacco', 'Via G.B. Grassi 74, Milano'),
('OSP04', 'Ospedale San Gerardo', 'Via Pergolesi 33, Monza');

-- Inserimento dati nella tabella PRONTO_SOCCORSO
INSERT INTO PRONTO_SOCCORSO (CodOspedale) VALUES
('OSP01'),
('OSP02');

-- Inserimento dati nella tabella REPARTO
INSERT INTO REPARTO (CodReparto, NomeReparto, NrTelefono, OrarioInizioVisite, OrarioFineVisite, CodOspedale) VALUES
('REP01', 'Cardiologia', '0123456789', '09:00:00', '12:00:00', 'OSP01'),
('REP02', 'Neurologia', '0123456790', '10:00:00', '13:00:00', 'OSP01'),
('REP03', 'Ortopedia', '0123456791', '14:00:00', '17:00:00', 'OSP01'),
('REP04', 'Pediatria', '0123456792', '15:00:00', '18:00:00', 'OSP02'),
('REP05', 'Ginecologia', '0123456793', '08:00:00', '11:00:00', 'OSP02'),
('REP06', 'Chirurgia Generale', '0123456794', '09:00:00', '12:00:00', 'OSP02'),
('REP07', 'Oncologia', '0123456795', '10:00:00', '13:00:00', 'OSP03'),
('REP08', 'Urologia', '0123456796', '11:00:00', '14:00:00', 'OSP03'),
('REP09', 'Dermatologia', '0123456797', '13:00:00', '16:00:00', 'OSP04'),
('REP10', 'Oculistica', '0123456798', '12:00:00', '15:00:00', 'OSP04');

-- Inserimento dati nella tabella SALA_OPERATORIA
INSERT INTO SALA_OPERATORIA (CodReparto, NomeSala) VALUES
('REP01', 'Sala A'),
('REP01', 'Sala B'),
('REP02', 'Sala C'),
('REP03', 'Sala D'),
('REP03', 'Sala E'),
('REP04', 'Sala F'),
('REP08', 'Sala J');


-- Inserimento dati nella tabella STANZA
INSERT INTO STANZA (NrStanza, CodReparto) VALUES
('S01', 'REP01'),
('S02', 'REP01'),
('S03', 'REP02'),
('S04', 'REP02'),
('S05', 'REP03'),
('S06', 'REP03'),
('S07', 'REP04'),
('S08', 'REP04'),
('S09', 'REP05'),
('S10', 'REP05'),
('S11', 'REP06');


-- Inserimento dati nella tabella LETTO
INSERT INTO LETTO (CodLetto, NrStanza, CodReparto) VALUES
('L01', 'S01', 'REP01'),
('L02', 'S01', 'REP01'),
('L03', 'S02', 'REP01'),
('L04', 'S02', 'REP01'),
('L05', 'S03', 'REP02'),
('L06', 'S03', 'REP02'),
('L07', 'S04', 'REP02'),
('L08', 'S04', 'REP02'),
('L09', 'S05', 'REP03'),
('L10', 'S05', 'REP03');


-- Inserimento dati nella tabella AMBULATORIO_LABORATORIO
INSERT INTO AMBULATORIO_LABORATORIO (CodAmbulatorio, Nome) VALUES
('AMB01', 'Laboratorio Analisi'),
('AMB02', 'Ambulatorio Cardiologico'),
('AMB03', 'Laboratorio Radiologia'),
('AMB04', 'Ambulatorio Ortopedico'),
('AMB05', 'Laboratorio Patologia'),
('AMB06', 'Ambulatorio Gastroenterologia'),
('AMB07', 'Ambulatorio Urologia'),
('AMB08', 'Ambulatorio Pediatria');

-- Inserimento dati nella tabella AMBULATORI_OSPEDALI
INSERT INTO AMBULATORI_OSPEDALI (CodAmbulatorio, CodOspedale) VALUES
('AMB01', 'OSP01'),
('AMB02', 'OSP01'),
('AMB03', 'OSP01'),
('AMB04', 'OSP02'),
('AMB05', 'OSP02'),
('AMB01', 'OSP04'),
('AMB02', 'OSP02'),
('AMB03', 'OSP04'),
('AMB04', 'OSP03'),
('AMB05', 'OSP01');

-- Inserimento dati nella tabella AMBULATORIO_LABORATORIO_INTERNO
INSERT INTO AMBULATORIO_LABORATORIO_INTERNO (CodAmbulatorio, Piano, NrStanza, CodReparto) VALUES
('AMB01', 1, 'S01', 'REP01'),
('AMB02', 2, 'S03', 'REP02'),
('AMB03', 3, 'S05', 'REP03'),
('AMB04', 1, 'S07', 'REP04'),
('AMB05', 2, 'S09', 'REP05');

-- Inserimento dati nella tabella AMBULATORIO_LABORATORIO_ESTERNO
INSERT INTO AMBULATORIO_LABORATORIO_ESTERNO (CodAmbulatorio, Indirizzo, NrTelAmbulatorio, OrarioApertura, OrarioChiusura) VALUES
('AMB01', 'Via Olgettina 60, Milano', '0123456001', '08:00:00', '18:00:00'), --dal 1 per l'osp 4
('AMB02', 'Via Olgettina 60, Milano', '0123456002', '09:00:00', '19:00:00'), --dal 1 per l'osp 2
('AMB03', 'Via Olgettina 60, Milano', '0123456003', '07:30:00', '18:00:00'), -- dal 1 per l'osp 4
('AMB04', 'Piazza Ospedale Maggiore 3, Milano', '0123456004', '08:30:00', '18:00:00'), -- dal 2 per l'osp 3
('AMB05', 'Piazza Ospedale Maggiore 3, Milano', '0123456005', '07:00:00', '17:00:00'); -- dal 2 per l'osp 1

-- Inserimento dati nella tabella PAZIENTE
INSERT INTO PAZIENTE (CF, Nome, Cognome, DataDiNascita, Indirizzo) VALUES
('ABC1234567890123', 'Mario', 'Villa', '1980-05-15', 'Via Verdi 10, Milano'),
('DEF2345678901234', 'Arianna', 'DelGiaccio', '2002-03-27', 'Via Roma 5, Anzio'),
('GHI3456789012345', 'Luca', 'Govoni', '1976-12-10', 'Corso Italia 15, Brescia'),
('MNO4567890123456', 'Giulia', 'Matera', '1988-04-03', 'Via Manzoni 8, Milano'),
('PQR5678901234567', 'Laura', 'Natale', '1990-09-20', 'Corso Mazzini 22, Milano'),
('STU6789012345678', 'Paolo', 'Colombo', '1985-06-28', 'Viale Italo 12, Bergamo'),
('VWX7890123456789', 'Marta', 'Moro', '1992-03-17', 'Via XX Settembre 4, Sondrio'),
('YZA8901234567890', 'Alessandro', 'Calcagno', '1982-11-30', 'Via Elvetica 18, Bollate'),
('BCD9012345678901', 'Eleonora', 'Santoro', '1998-07-07', 'Piazza Duomo 1, Milano'),
('EFG0123456789012', 'Luca', 'Piana', '1987-02-14', 'Via Roma 3, San Donato');

-- Inserimento dati nella tabella ESAME
INSERT INTO ESAME (CodEsame, Descrizione, CostoPubblico, CostoPrivato, CodAmbulatorio) VALUES
('E01', 'Elettrocardiogramma', 50.00, 80.00, 'AMB02'),
('E02', 'Ecografia addominale', 100.00, 150.00, 'AMB03'),
('E03', 'Esame del sangue completo', 30.00, 50.00, 'AMB01'),
('E04', 'Risonanza magnetica', 300.00, 400.00, 'AMB04'),
('E05', 'Endoscopia digestiva', 150.00, 200.00, 'AMB02'),
('E06', 'Radiografia toracica', 80.00, 120.00, 'AMB03'),
('E07', 'Colonscopia', 200.00, 250.00, 'AMB01'),
('E08', 'Test allergologici', 60.00, 90.00, 'AMB05'),
('E09', 'Visita oculistica', 40.00, 60.00, 'AMB05'),
('E10', 'Mammografia', 100.00, 150.00, 'AMB04'),
('E11', 'Analisi delle urine', 25.00, 40.00, 'AMB01'),
('E12', 'Test glicemico', 20.00, 35.00, 'AMB01'),
('E13', 'Spirometria', 50.00, 75.00, 'AMB02'),
('E14', 'Elettroencefalogramma', 150.00, 200.00, 'AMB03'),
('E15', 'Esame delle feci', 30.00, 45.00, 'AMB01'),
('E16', 'Ecocardiogramma', 100.00, 130.00, 'AMB02'),
('E17', 'Test del respiro', 80.00, 110.00, 'AMB05'),
('E18', 'Audiometria', 60.00, 90.00, 'AMB04'),
('E19', 'Holter cardiaco', 120.00, 160.00, 'AMB02'),
('E20', 'Test di funzionalità epatica', 70.00, 100.00, 'AMB03');

-- Inserimento dati nella tabella ESAME_SPECIALISTICO
INSERT INTO ESAME_SPECIALISTICO (CodEsameSpecialistico, Avvertenze) VALUES
('E01', 'Non mangiare nelle 8 ore precedenti'),
('E02', 'Bere molta acqua'),
('E04', 'Rimuovere tutti i gioielli'),
('E05', 'Assumere un lassativo la sera prima'),
('E06', 'Indossare abiti comodi'),
('E07', 'Non assumere cibo solido per 12 ore'),
('E08', 'Evitare farmaci antistaminici'),
('E09', 'Portare lenti correttive se necessario'),
('E10', 'Evitare deodoranti');

-- Inserimento dati nella tabella RICOVERO
INSERT INTO RICOVERO (CodRicovero, DataRicovero, DataDimissione, CFPaziente, CodLetto) VALUES
('R01', '2024-01-10', '2024-01-20', 'ABC1234567890123', 'L01'),
('R02', '2024-02-05', '2024-02-15', 'DEF2345678901234', 'L02'),
('R03', '2024-03-01', '2024-03-10', 'GHI3456789012345', 'L03'),
('R04', '2024-04-12', '2024-04-20', 'MNO4567890123456', 'L04'),
('R05', '2024-05-03', '2024-05-13', 'PQR5678901234567', 'L05'),
('R06', '2024-06-18', '2024-06-25', 'STU6789012345678', 'L06'),
('R07', '2024-07-22', NULL, 'VWX7890123456789', 'L07'),
('R08', '2024-08-05', '2024-08-14', 'YZA8901234567890', 'L08'),
('R09', '2024-09-10', NULL, 'BCD9012345678901', 'L09'),
('R10', '2024-10-11', NULL, 'EFG0123456789012', 'L10');

-- Inserimento dati nella tabella PATOLOGIA
INSERT INTO PATOLOGIA (NomePatologia, Descrizione) VALUES
('Ipertensione', 'Aumento persistente della pressione arteriosa'),
('Diabete Mellito', 'Malattia cronica caratterizzata da iperglicemia'),
('Insufficienza Cardiaca', 'Condizione in cui il cuore non pompa sangue a sufficienza'),
('Polmonite', 'Infezione polmonare causata da batteri o virus'),
('Frattura', 'Interruzione della continuità di un osso'),
('Emicrania', 'Disturbo neurologico caratterizzato da forti mal di testa'),
('Artrosi', 'Malattia degenerativa delle articolazioni'),
('Asma', 'Malattia cronica delle vie respiratorie'),
('Gastrite', 'Infiammazione della mucosa gastrica'),
('Anemia', 'Riduzione del numero di globuli rossi nel sangue');

-- Inserimento dati nella tabella RICOVERO_PATOLOGIE
INSERT INTO RICOVERO_PATOLOGIE (CodRicovero, NomePatologia) VALUES
('R01', 'Ipertensione'),
('R01', 'Diabete Mellito'),
('R02', 'Polmonite'),
('R03', 'Frattura'),
('R03', 'Anemia'),
('R04', 'Emicrania'),
('R05', 'Artrosi'),
('R06', 'Asma'),
('R07', 'Gastrite'),
('R08', 'Anemia'),
('R09', 'Insufficienza Cardiaca'),
('R10', 'Ipertensione');

-- Inserimento dati nella tabella PERSONALE
INSERT INTO PERSONALE (Matricola, Nome, Cognome, NrCell, CodReparto) VALUES
('P001', 'Mario', 'Rossi', '3331234567', 'REP01'), --prim
('P002', 'Lucia', 'Bianchi', '3331234568', 'REP01'), --vice
('P003', 'Giovanni', 'Greco', '3331234569', 'REP03'),--prim
('P004', 'Anna', 'Barbieri', '3331234570', 'REP03'), --vice
('P005', 'Marco', 'Serra', '3331234571', 'REP05'),--prim
('P006', 'Paolo', 'Martinelli', '3331234572', 'REP06'),
('P007', 'Laura', 'Rosa', '3331234573', 'REP07'),--prim
('P008', 'Chiara', 'Lombardi', '3331234574', 'REP07'), --vice
('P009', 'Fabio', 'Rizzo', '3331234575', 'REP09'),--prim
('P010', 'Elisa', 'Longo', '3331234576', 'REP10'),
('P011', 'Franco', 'Leone', '3331234577', 'REP01'), --inf
('P012', 'Marta', 'Rizzi', '3331234578', 'REP02'), --inf
('P013', 'Luigi', 'Mazza', '3331234579', 'REP03'), --inf
('P014', 'Giulia', 'Gentile', '3331234580', 'REP02'), --inf
('P015', 'Lorenzo', 'Ricci', '3331234581', 'REP01'), --inf
('P016', 'Carla', 'Damiani', '3331234582', 'REP05'), --inf
('P017', 'Stefano', 'Moretti', '3331234583', 'REP05'), --inf
('P018', 'Alessia', 'Ferri', '3331234584', 'REP05'),--inf
('P019', 'Daniele', 'Testa', '3331234585', 'REP06'),--inf
('P020', 'Federica', 'Grassi', '3331234586', 'REP06'), --inf
('P021', 'Francesca', 'Ferrari', '3331234588', 'REP01'),
('P022', 'Sofia', 'Russo', '3331234587', 'REP02'),
('P023', 'Sara', 'Gallo', '3331234589', 'REP03'),
('P024', 'Gianluca', 'Romano', '3331234596', 'REP04'),
('P025', 'Gianmarco', 'Costa', '3321234576', 'REP05');

-- Inserimento dati nella tabella MEDICO
INSERT INTO MEDICO (MatricolaMedico, DataAssunzione) VALUES
('P001', '2010-05-01'),
('P002', '2012-08-15'),
('P003', '2015-01-10'),
('P004', '2017-04-22'),
('P005', '2019-07-30'),
('P006', '2020-10-11'),
('P007', '2021-02-28'),
('P008', '2018-03-05'),
('P009', '2016-06-17'),
('P010', '2022-09-25');

-- Inserimento dati nella tabella VICE_PRIMARIO
INSERT INTO VICE_PRIMARIO (MatricolaVicePrimario, DataPromozione) VALUES
('P002', '2021-11-01'),
('P004', '2022-12-15'),
('P008', '2020-07-10');

-- Inserimento dati nella tabella PRIMARIO
INSERT INTO PRIMARIO (MatricolaPrimario, CodReparto) VALUES
('P001', 'REP01'),
('P003', 'REP03'),
('P005', 'REP05'),
('P007', 'REP07'),
('P009', 'REP09');


-- Inserimento dati nella tabella SOSTITUIZIONE
INSERT INTO SOSTITUZIONE (MatricolaPrimario, MatricolaVicePrimario, DataInizio, DataFine) VALUES
('P001', 'P002', '2023-01-01', '2023-01-31'),
('P003', 'P004', '2023-02-01', '2023-02-28'),
('P001', 'P002', '2023-03-01', NULL);

-- Inserimento dati nella tabella SPECIALIZZAZIONE
INSERT INTO SPECIALIZZAZIONE (NomeSpecializzazione) VALUES
('Cardiologia'),
('Neurologia'),
('Ortopedia'),
('Pediatria'),
('Ginecologia'),
('Chirurgia'),
('Oncologia'),
('Urologia'),
('Dermatologia'),
('Cardiochirurgia'),
('Fisiatria'),
('Chirurgia vascolare'),
('Oculistica');

-- Inserimento dati nella tabella SPECIALIZZAZIONE_PRIMARI
INSERT INTO SPECIALIZZAZIONE_PRIMARI (MatricolaPrimario, Specializzazione) VALUES
('P001', 'Cardiologia'),
('P001', 'Cardiochirurgia'),
('P001', 'Chirurgia vascolare'),
('P003', 'Ortopedia'),
('P003', 'Fisiatria'),
('P003', 'Cardiologia'),
('P005', 'Ginecologia'),
('P007', 'Chirurgia'),
('P009', 'Dermatologia');

-- Inserimento dati nella tabella INFERMIERE
INSERT INTO INFERMIERE (MatricolaInfermiere) VALUES
('P011'),
('P012'),
('P013'),
('P014'),
('P015'),
('P016'),
('P017'),
('P018'),
('P019'),
('P020');

-- Inserimento dati nella tabella AMMINISTRATIVO
INSERT INTO AMMINISTRATIVO (MatricolaAmministrativo) VALUES
('P021'),
('P022'),
('P023'),
('P024'),
('P025');

-- Inserimento dati nella tabella TURNO
INSERT INTO TURNO (CodTurno, DataOraInizio, DataOraFine, CodOspedalePS) VALUES
('T001', '2024-07-01 08:00:00', '2024-07-01 16:00:00', 'OSP01'),
('T002', '2024-07-01 16:00:00', '2024-07-02 00:00:00', 'OSP01'),
('T003', '2024-07-02 00:00:00', '2024-07-02 08:00:00', 'OSP01'),
('T004', '2024-07-01 08:00:00', '2024-07-01 16:00:00', 'OSP01'),
('T005', '2024-07-01 16:00:00', '2024-07-02 00:00:00', 'OSP01'),
('T006', '2024-07-02 00:00:00', '2024-07-02 08:00:00', 'OSP02'),
('T007', '2024-07-01 08:00:00', '2024-07-01 16:00:00', 'OSP02'),
('T008', '2024-07-01 16:00:00', '2024-07-02 00:00:00', 'OSP02'),
('T009', '2024-07-02 00:00:00', '2024-07-02 08:00:00', 'OSP02'),
('T010', '2024-07-01 08:00:00', '2024-07-01 16:00:00', 'OSP02');

-- Inserimento dati nella tabella TURNO_INFERMIERE
INSERT INTO TURNO_INFERMIERE (CodTurno, MatricolaInfermiere) VALUES
('T001', 'P011'),
('T002', 'P012'),
('T003', 'P013'),
('T004', 'P014'),
('T005', 'P015'),
('T006', 'P016'),
('T007', 'P017'),
('T008', 'P018'),
('T009', 'P019'),
('T010', 'P020');

-- Inserimento dati nella tabella TURNO_MEDICO
INSERT INTO TURNO_MEDICO (CodTurno, MatricolaMedico) VALUES
('T001', 'P001'),
('T002', 'P002'),
('T003', 'P004'),
('T004', 'P005'),
('T005', 'P006'),
('T006', 'P002'),
('T007', 'P002'),
('T008', 'P003'),
('T009', 'P001'),
('T010', 'P003');

-- Inserimento dati nella tabella PRENOTAZIONE
INSERT INTO PRENOTAZIONE (DataEsame, OraEsame, DataPrenotazione, Privato, Urgenza, CFPaziente, CodEsame, MatricolaMedico) VALUES
('2024-07-10', '09:00:00','2024-06-10', FALSE, 'Rosso', 'ABC1234567890123', 'E01', 'P001'),
('2024-07-11', '10:00:00','2024-06-12',TRUE, 'Giallo', 'DEF2345678901234', 'E02', 'P002'),
('2024-07-12', '11:00:00','2024-06-12', FALSE, 'Verde', 'ABC1234567890123', 'E03', NULL),
('2024-07-13', '14:00:00', '2024-05-13', TRUE, 'Rosso', 'ABC1234567890123', 'E04', 'P004'),
('2024-07-14', '15:00:00', '2024-05-14', FALSE, 'Giallo', 'PQR5678901234567', 'E05', 'P005'),
('2024-07-15', '08:00:00', '2024-04-18', TRUE, 'Verde', 'STU6789012345678', 'E03', NULL),
('2024-07-16', '09:00:00', '2024-03-14', FALSE, 'Rosso', 'VWX7890123456789', 'E07', 'P007'),
('2024-07-17', '10:00:00', '2024-04-15', TRUE, 'Giallo', 'YZA8901234567890', 'E08', 'P008'),
('2024-07-18', '11:00:00', '2024-05-11', FALSE, 'Verde', 'BCD9012345678901', 'E03', NULL),
('2024-07-19', '14:00:00', '2024-04-11', TRUE, 'Rosso', 'EFG0123456789012', 'E04', 'P004');