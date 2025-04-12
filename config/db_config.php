<?php
/*
 * File di Configurazione del Database
 */

// --- MODIFICA QUESTE VARIABILI ---
define('DB_HOST', 'localhost');       // Host del database (spesso 'localhost')
define('DB_USER', 'root');            // Nome utente del database (es. 'root' in locale)
define('DB_PASS', '');                // Password del database (vuota per XAMPP/MAMP di default)
define('DB_NAME', 'facileagevolazioni'); // Nome del database che hai creato
// ----------------------------------

// Tentativo di connessione usando MySQLi (Object-Oriented)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica della connessione
if ($conn->connect_error) {
    // In un'applicazione reale, logga l'errore invece di mostrarlo a schermo
    error_log("Errore di connessione al database: " . $conn->connect_error);
    die("Errore di connessione al database. Si prega di riprovare più tardi."); // Messaggio generico per l'utente
}

// Imposta il set di caratteri a utf8mb4 per supportare tutti i caratteri
if (!$conn->set_charset("utf8mb4")) {
    error_log("Errore nel caricamento del set di caratteri utf8mb4: " . $conn->error);
    // Non è necessario interrompere l'esecuzione, ma è bene saperlo
}

// Ora hai la variabile $conn disponibile per le tue query negli script che includono questo file.
// Non chiudere la connessione qui, verrà chiusa alla fine dello script principale.
// Esempio di chiusura (da fare alla fine dello script che usa $conn): $conn->close();

?>