# Progetto Database: Gestione Aziende Ospedaliere 🏥

Progetto accademico per il corso di **Basi di Dati e Web** (A.A. 2023-2024).  
Il sistema modella e gestisce l'intero flusso operativo di una rete di presidi ospedalieri: dall'organizzazione interna (reparti, stanze, letti, turni e gerarchia del personale) ai servizi rivolti all'utenza (prenotazione esami, ricoveri e ambulatori).

---

## 📌 Panoramica del Progetto

Il progetto copre l'intero ciclo di vita di un sistema informativo:
1. **Analisi e Progettazione Concettuale:** Modellazione del dominio tramite diagramma Entità-Relazione (ER) completo di vincoli di integrità e cardinalità.
2. **Progettazione Logica e Ristrutturazione:** Traduzione dello schema ER nel modello relazionale (normalizzazione, gestione delle generalizzazioni e chiavi).
3. **Database Relazionale:** Implementazione fisica su **PostgreSQL** con script DDL, vincoli di dominio/referenziali e popolamento dati di test.
4. **Interrogazioni SQL Avanzate:** Query analitiche complesse (es. monitoraggio storico sostituzioni primari/vice-primari con raggruppamenti e operatori insiemistici).
5. **Applicazione Web:** Portale gestionale dinamico sviluppato in **PHP** strutturato per la navigazione e le operazioni CRUD su strutture e pazienti.

---

## 🏛️ Architettura del Dominio

* **Presidi e Strutture:** Gestione di ospedali, reparti con sale operatorie, stanze, letti e pronto soccorso.
* **Ambulatori e Laboratori:** Modellazione di ambulatori interni (associati a stanze/reparti) ed esterni con orari e recapiti.
* **Personale Sanitario:** Gerarchia strutturata (Personale generico, Medici, Infermieri, Personale Amministrativo), gestione cariche (Primari, Vice-Primari e relative sostituzioni temporanee) e pianificazione turni al PS.
* **Pazienti e Ricoveri:** Tracciamento ricoveri associati a specifici posti letto con storico patologie.
* **Prestazioni Sanitarie:** Catalogo esami (ordinari e specialistici), con gestione differenziata dei costi (regime pubblico vs privato), ricette mediche e sistema di prenotazioni con priorità di urgenza.

---

## 💻 Moduli dell'Applicazione Web

L'interfaccia web (accessibile via server locale/Apache) è suddivisa in due aree principali:
* **Area Strutture:**
  * Gestione e censimento di ospedali, reparti e personale.
  * Configurazione esami e prestazioni specialistiche.
  * Gestione sostituzioni gerarchiche e visualizzazione dei turni.
* **Area Pazienti:**
  * Anagrafica e registrazione nuovi pazienti.
  * Inserimento, aggiornamento e annullamento delle prenotazioni esami.
  * Storico dei ricoveri e consultazione per Codice Fiscale.

---

## 🛠️ Stack Tecnologico

* **DBMS:** PostgreSQL
* **Backend:** PHP
* **Web Server:** Apache (es. XAMPP)
* **Modellazione:** Draw.io
* **Linguaggi:** SQL, PHP, HTML/CSS

---

## 📂 Struttura del Repository

```text
├── Codice_Ph_Angelica_Porcelli/   # Sorgenti PHP dell'applicazione web
├── Schema_Dati_Angelica_Porcelli/ # Script SQL (DDL creazione schema e DML popolamento)
├── SchemaER_Angelica_Porcelli/    # Diagrammi concettuali e logici (Draw.io / immagini)
└── Documentazione/                # Relazione tecnica di progetto (PDF/Word)
