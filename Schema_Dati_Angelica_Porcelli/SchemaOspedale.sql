CREATE TYPE FasciaUrgenza AS ENUM ('Rosso', 'Giallo', 'Verde');

-- Table: OSPEDALE 
CREATE TABLE OSPEDALE (
    CodOspedale VARCHAR(5) PRIMARY KEY,
    NomeOspedale VARCHAR(30) NOT NULL,
    IndirizzoOspedale VARCHAR(50) NOT NULL
);

-- Table: PRONTO_SOCCORSO
CREATE TABLE PRONTO_SOCCORSO (
    CodOspedale VARCHAR(5) PRIMARY KEY,
    FOREIGN KEY (CodOspedale) REFERENCES OSPEDALE(CodOspedale)
);

-- Table: REPARTO
CREATE TABLE REPARTO (
    CodReparto VARCHAR(5) PRIMARY KEY,
    NomeReparto VARCHAR(30) NOT NULL,
    NrTelefono VARCHAR(10) UNIQUE,
    OrarioInizioVisite TIME NOT NULL,
    OrarioFineVisite TIME NOT NULL,
    CodOspedale VARCHAR(5) NOT NULL,
    UNIQUE (NomeReparto, CodOspedale),
    FOREIGN KEY (CodOspedale) REFERENCES OSPEDALE(CodOspedale)
);


-- Table: SALA_OPERATORIA
CREATE TABLE SALA_OPERATORIA (
    CodReparto VARCHAR(5),
    NomeSala VARCHAR(30) NOT NULL,
    FOREIGN KEY (CodReparto) REFERENCES REPARTO(CodReparto),
    PRIMARY KEY(CodReparto, NomeSala)
);


-- Table: STANZA
CREATE TABLE STANZA (
    NrStanza VARCHAR(5) NOT NULL,
    CodReparto VARCHAR(5) NOT NULL,
    FOREIGN KEY (CodReparto) REFERENCES REPARTO(CodReparto),
    PRIMARY KEY (NrStanza, CodReparto)
);

-- Table: LETTO
CREATE TABLE LETTO (
    CodLetto VARCHAR(5) PRIMARY KEY, --il fatto che sia occupato, posso controllarlo con data inizio e fine ricovero
    NrStanza VARCHAR(5) NOT NULL,
    CodReparto VARCHAR(5) NOT NULL,
    FOREIGN KEY (NrStanza, CodReparto) REFERENCES STANZA(NrStanza, CodReparto)
);

-- Table: AMBULATORI
CREATE TABLE AMBULATORIO_LABORATORIO (
    CodAmbulatorio VARCHAR(5) PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL
);

-- Table: AMBULATORI_OSPEDALI
CREATE TABLE AMBULATORI_OSPEDALI (
    CodAmbulatorio VARCHAR(5) NOT NULL,
    CodOspedale VARCHAR(5) NOT NULL,
    FOREIGN KEY (CodAmbulatorio) REFERENCES AMBULATORIO_LABORATORIO(CodAmbulatorio),
    FOREIGN KEY (CodOspedale) REFERENCES OSPEDALE(CodOspedale),
    PRIMARY KEY (CodAmbulatorio, CodOspedale)
);

-- Table: AMBULATORIO_LABORATORIO_INTERNO
CREATE TABLE AMBULATORIO_LABORATORIO_INTERNO (
    CodAmbulatorio VARCHAR(5) PRIMARY KEY, 
    Piano INT NOT NULL,
    NrStanza VARCHAR(5) NOT NULL,
    CodReparto VARCHAR(5) NOT NULL,
    FOREIGN KEY (NrStanza, CodReparto) REFERENCES STANZA(NrStanza, CodReparto),
    FOREIGN KEY (CodAmbulatorio) REFERENCES AMBULATORIO_LABORATORIO(CodAmbulatorio)
);

-- Table: AMBULATORIO_LABORATORIO_ESTERNO
CREATE TABLE AMBULATORIO_LABORATORIO_ESTERNO (
    CodAmbulatorio VARCHAR(5) PRIMARY KEY,
    Indirizzo VARCHAR(50) NOT NULL,
    NrTelAmbulatorio VARCHAR(10) UNIQUE NOT NULL,
    OrarioApertura TIME NOT NULL,
    OrarioChiusura TIME NOT NULL,
    CHECK (OrarioChiusura > OrarioApertura),
    FOREIGN KEY (CodAmbulatorio) REFERENCES AMBULATORIO_LABORATORIO(CodAmbulatorio)
);

-- Table: PAZIENTE
CREATE TABLE PAZIENTE (
    CF CHAR(16) PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    DataDiNascita DATE NOT NULL,
    Indirizzo VARCHAR(30) NOT NULL
);


-- Table: ESAME
CREATE TABLE ESAME (
    CodEsame VARCHAR(5) PRIMARY KEY,
    Descrizione VARCHAR(50) NOT NULL,
    CostoPubblico DECIMAL(10, 2) NOT NULL,
    CostoPrivato DECIMAL(10, 2) NOT NULL,
    CodAmbulatorio VARCHAR(5) NOT NULL,
    FOREIGN KEY (CodAmbulatorio) REFERENCES AMBULATORIO_LABORATORIO(CodAmbulatorio)
);

-- Table: ESAME_SPECIALISTICO
CREATE TABLE ESAME_SPECIALISTICO (
    CodEsameSpecialistico VARCHAR(5) PRIMARY KEY,
    Avvertenze VARCHAR(100) NOT NULL,
    FOREIGN KEY (CodEsameSpecialistico) REFERENCES ESAME(CodEsame) ON DELETE CASCADE
);

-- Table: RICOVERO
CREATE TABLE RICOVERO (
    CodRicovero VARCHAR(5) PRIMARY KEY,
    DataRicovero DATE NOT NULL,
    DataDimissione DATE,
    CFPaziente CHAR(16) NOT NULL, 
    CodLetto VARCHAR(5) NOT NULL,
    FOREIGN KEY (CFPaziente) REFERENCES PAZIENTE(CF),
    FOREIGN KEY (CodLetto) REFERENCES LETTO(CodLetto),
    CHECK (DataDimissione IS NULL OR DataDimissione > DataRicovero) 
);

-- Table: PATOLOGIA
CREATE TABLE PATOLOGIA (
    NomePatologia VARCHAR(50) PRIMARY KEY,
    Descrizione VARCHAR(250) NOT NULL
);



-- Table: RICOVERO_PATOLOGIE
CREATE TABLE RICOVERO_PATOLOGIE (
    CodRicovero VARCHAR(5),
    NomePatologia VARCHAR(30),
    FOREIGN KEY (CodRicovero) REFERENCES RICOVERO(CodRicovero),
    FOREIGN KEY (NomePatologia) REFERENCES PATOLOGIA(NomePatologia),
    PRIMARY KEY(CodRicovero, NomePatologia)
);

-- Table: PERSONALE
CREATE TABLE PERSONALE (
    Matricola VARCHAR(6) PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    NrCell VARCHAR(10) NOT NULL UNIQUE,
    CodReparto VARCHAR(5) NOT NULL,
    FOREIGN KEY (CodReparto) REFERENCES REPARTO(CodReparto)
);

-- Table: MEDICO
CREATE TABLE MEDICO (
    MatricolaMedico VARCHAR(6) PRIMARY KEY,
    DataAssunzione DATE NOT NULL,
    FOREIGN KEY (MatricolaMedico) REFERENCES PERSONALE(Matricola)
);

-- Table: VICE_PRIMARIO
CREATE TABLE VICE_PRIMARIO (
    MatricolaVicePrimario VARCHAR(6) PRIMARY KEY,
    DataPromozione DATE NOT NULL,
    FOREIGN KEY (MatricolaVicePrimario) REFERENCES MEDICO(MatricolaMedico)
);

-- Table: PRIMARIO
CREATE TABLE PRIMARIO (
    MatricolaPrimario VARCHAR(6) PRIMARY KEY,
    CodReparto VARCHAR(5) NOT NULL UNIQUE,
    FOREIGN KEY (MatricolaPrimario) REFERENCES MEDICO(MatricolaMedico),
    FOREIGN KEY (CodReparto) REFERENCES REPARTO(CodReparto)
);


-- Table: SOSTITUIZIONE
CREATE TABLE SOSTITUZIONE (
    MatricolaPrimario VARCHAR(6),
    MatricolaVicePrimario VARCHAR(6),
    DataInizio DATE NOT NULL,
    DataFine DATE,
    FOREIGN KEY (MatricolaPrimario) REFERENCES PRIMARIO(MatricolaPrimario),
    FOREIGN KEY (MatricolaVicePrimario) REFERENCES VICE_PRIMARIO(MatricolaVicePrimario),
    PRIMARY KEY (MatricolaPrimario, MatricolaVicePrimario, DataInizio),
    CHECK (DataFine IS NULL OR DataInizio < DataFine) 
);


-- Table: SPECIALIZZAZIONE
CREATE TABLE SPECIALIZZAZIONE (
    NomeSpecializzazione VARCHAR(30) PRIMARY KEY
);

-- Table: SPECIALIZZAZIONE_PRIMARI
CREATE TABLE SPECIALIZZAZIONE_PRIMARI (
    MatricolaPrimario VARCHAR(6) NOT NULL,
    Specializzazione VARCHAR(30) NOT NULL,
    FOREIGN KEY (MatricolaPrimario) REFERENCES PRIMARIO(MatricolaPrimario),
    FOREIGN KEY (Specializzazione) REFERENCES SPECIALIZZAZIONE(NomeSpecializzazione),
    PRIMARY KEY(MatricolaPrimario, Specializzazione)
);

-- Table: INFERMIERE
CREATE TABLE INFERMIERE (
    MatricolaInfermiere VARCHAR(6) PRIMARY KEY,
    FOREIGN KEY (MatricolaInfermiere) REFERENCES PERSONALE(Matricola)
);

-- Table: AMMINISTRATIVO
CREATE TABLE AMMINISTRATIVO (
    MatricolaAmministrativo VARCHAR(6) PRIMARY KEY,
    FOREIGN KEY (MatricolaAmministrativo) REFERENCES PERSONALE(Matricola) 
);


-- Table: TURNO
CREATE TABLE TURNO (
    CodTurno VARCHAR(5) PRIMARY KEY,
    DataOraInizio TIMESTAMP,
	DataOraFine TIMESTAMP,
    CodOspedalePS VARCHAR(5) NOT NULL,
    FOREIGN KEY (CodOspedalePS) REFERENCES PRONTO_SOCCORSO(CodOspedale) 
);

-- Table: TURNO_INFERMIERE
CREATE TABLE TURNO_INFERMIERE (
    CodTurno VARCHAR(5),
    MatricolaInfermiere VARCHAR(6), 
    FOREIGN KEY (CodTurno) REFERENCES TURNO(CodTurno),
    FOREIGN KEY (MatricolaInfermiere) REFERENCES INFERMIERE(MatricolaInfermiere),
    PRIMARY KEY(CodTurno, MatricolaInfermiere) 
);

-- Table: TURNO_MEDICO
CREATE TABLE TURNO_MEDICO (
    CodTurno VARCHAR(5),
    MatricolaMedico VARCHAR(6),
    FOREIGN KEY (CodTurno) REFERENCES TURNO(CodTurno),
    FOREIGN KEY (MatricolaMedico) REFERENCES MEDICO(MatricolaMedico), 
    PRIMARY KEY(CodTurno, MatricolaMedico) 
);



-- Table: PRENOTAZIONE
CREATE TABLE PRENOTAZIONE (
    DataEsame DATE NOT NULL,
    OraEsame TIME NOT NULL,
    DataPrenotazione DATE NOT NULL,
    Privato BOOLEAN NOT NULL, -- se pubblico FALSE, se privato TRUE
    Urgenza FasciaUrgenza NOT NULL,
    CFPaziente CHAR(16) NOT NULL, 
    CodEsame VARCHAR(5) NOT NULL,
    MatricolaMedico VARCHAR(6),
    FOREIGN KEY (CFPaziente) REFERENCES PAZIENTE(CF),
    FOREIGN KEY (CodEsame) REFERENCES ESAME(CodEsame),
    FOREIGN KEY (MatricolaMedico) REFERENCES MEDICO(MatricolaMedico),
    PRIMARY KEY (CFPaziente, CodEsame, DataEsame)
);



--ALTER TABLE table_name
--ADD column_name datatype;

--DROP TABLE table_name;

--ALTER TABLE Persons
--DROP PRIMARY KEY;