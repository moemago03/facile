<?php
// --- START File Header ---
/**
 * File: includes/funzioni_filtro.php
 * Contiene le funzioni per il filtro delle agevolazioni:
 * - _checkRule: Helper interno per valutare una singola regola.
 * - trovaAgevolazioniPreliminari: Filtro iniziale basato su Regione e Dimensione.
 * - trovaAgevolazioniCompatibili: Filtro completo basato su tutti i criteri utente.
 */
// --- END File Header ---

// --- START Helper Function _checkRule ---
/**
 * Funzione helper interna per verificare una singola regola di confronto.
 * (Codice _checkRule come nella versione precedente - è già robusto)
 */
function _checkRule($valore_utente, string $tipo_condizione, string $valore_criterio_regola): bool
{
    // ... (Codice completo della funzione _checkRule come fornito prima) ...
    if ($valore_utente === null || $valore_utente === '') {
        if (!in_array($tipo_condizione, ['NOT_EQUALS', 'NOT_IN_LIST'])) { }
    }
    $regola_soddisfatta = false;
    $valore_utente_str = is_scalar($valore_utente) ? trim((string)$valore_utente) : $valore_utente;
    $valore_criterio_regola_trimmed = trim($valore_criterio_regola);
    if (strcasecmp($valore_criterio_regola_trimmed, 'Tutte') == 0 || strcasecmp($valore_criterio_regola_trimmed, 'Qualsiasi') == 0) {
        return true;
    }
    switch (strtoupper($tipo_condizione)) {
        case 'EQUALS':
            $regola_soddisfatta = (strcasecmp((string)$valore_utente_str, $valore_criterio_regola_trimmed) == 0);
            break;
        case 'NOT_EQUALS':
            $regola_soddisfatta = (strcasecmp((string)$valore_utente_str, $valore_criterio_regola_trimmed) != 0);
            break;
        case 'GREATER_THAN':
            $regola_soddisfatta = is_numeric($valore_utente) && is_numeric($valore_criterio_regola) && (float)$valore_utente > (float)$valore_criterio_regola;
            break;
        case 'GREATER_THAN_OR_EQUAL':
             $regola_soddisfatta = is_numeric($valore_utente) && is_numeric($valore_criterio_regola) && (float)$valore_utente >= (float)$valore_criterio_regola;
            break;
        case 'LESS_THAN':
            $regola_soddisfatta = is_numeric($valore_utente) && is_numeric($valore_criterio_regola) && (float)$valore_utente < (float)$valore_criterio_regola;
            break;
        case 'LESS_THAN_OR_EQUAL':
            $regola_soddisfatta = is_numeric($valore_utente) && is_numeric($valore_criterio_regola) && (float)$valore_utente <= (float)$valore_criterio_regola;
            break;
        case 'IN_LIST':
            $lista_valori = array_map('trim', explode(',', $valore_criterio_regola_trimmed));
            $lista_valori_lower = array_map('strtolower', $lista_valori);
            $regola_soddisfatta = in_array(strtolower((string)$valore_utente_str), $lista_valori_lower, true);
            break;
        case 'NOT_IN_LIST':
            $lista_valori = array_map('trim', explode(',', $valore_criterio_regola_trimmed));
            $lista_valori_lower = array_map('strtolower', $lista_valori);
            $regola_soddisfatta = !in_array(strtolower((string)$valore_utente_str), $lista_valori_lower, true);
            break;
        case 'IS_TRUE':
            $regola_soddisfatta = filter_var($valore_utente, FILTER_VALIDATE_BOOLEAN);
            break;
        case 'IS_FALSE':
            $regola_soddisfatta = !filter_var($valore_utente, FILTER_VALIDATE_BOOLEAN);
            break;
        case 'CONTAINS':
            $regola_soddisfatta = is_string($valore_utente_str) && $valore_criterio_regola_trimmed !== '' && stripos($valore_utente_str, $valore_criterio_regola_trimmed) !== false;
            break;
        case 'STARTS_WITH':
            $regola_soddisfatta = is_string($valore_utente_str) && $valore_criterio_regola_trimmed !== '' && stripos($valore_utente_str, $valore_criterio_regola_trimmed) === 0;
            break;
         case 'REGEX_MATCH':
             $match_result = @preg_match($valore_criterio_regola, (string)$valore_utente);
             if ($match_result === false) {
                 error_log("(_checkRule) Errore nella REGEX: " . $valore_criterio_regola . " - Errore: " . preg_last_error_msg());
                 $regola_soddisfatta = false;
             } else { $regola_soddisfatta = ($match_result === 1); }
            break;
        default:
            $regola_soddisfatta = false;
            error_log("(_checkRule) Tipo condizione non riconosciuto: " . $tipo_condizione);
            break;
    }
    return $regola_soddisfatta;
}
// --- END Helper Function _checkRule ---


// --- START Function trovaAgevolazioniPreliminari ---
/**
 * Trova le agevolazioni preliminari basate solo su Regione e Dimensione PMI.
 * Restituisce un array di bandi con i dettagli base per le card preliminari.
 */
function trovaAgevolazioniPreliminari(string $regione, string $dimensione_pmi, mysqli $conn): array
{
    $risultati_preliminari = [];

    // ***** MODIFICA SQL *****
    // Aggiungi la colonna stato_bando (ASSICURATI CHE ESISTA!) e tipologia_agevolazione
    $sql_agevolazioni = "SELECT id, nome_bando, descrizione_breve, ente_erogatore, ambito_geografico,
                                stato_bando, tipologia_agevolazione  -- << Aggiunto stato_bando qui
                         FROM agevolazioni
                         WHERE attivo = 1";
    // ***********************

    $result_agevolazioni = $conn->query($sql_agevolazioni);
    if (!$result_agevolazioni) { /* Gestione errore query */ return []; }

    $sql_criteri_agevolazione = "SELECT nome_criterio, tipo_condizione, valore_criterio FROM agevolazione_criteri WHERE agevolazione_id = ?";
    $stmt_criteri = $conn->prepare($sql_criteri_agevolazione);
    if (!$stmt_criteri) { /* Gestione errore prepare */ $result_agevolazioni->free(); return []; }

    while ($agevolazione = $result_agevolazioni->fetch_assoc()) {
        $agevolazione_id = $agevolazione['id'];
        $regola_regione_soddisfatta = true;
        $regola_dimensione_soddisfatta = true;

        // Bind, Execute, Get Result per criteri (come prima)
        if (!$stmt_criteri->bind_param("i", $agevolazione_id)) { continue; }
        if (!$stmt_criteri->execute()) { continue; }
        $result_criteri = $stmt_criteri->get_result();
        if (!$result_criteri) { continue; }

        // Loop e verifica criteri Regione/Dimensione (come prima)
        if ($result_criteri->num_rows > 0) {
            while ($regola = $result_criteri->fetch_assoc()) {
                $nome_criterio_regola = $regola['nome_criterio'];
                if ($nome_criterio_regola === 'regione') {
                    $regola_regione_soddisfatta = _checkRule($regione, $regola['tipo_condizione'], $regola['valore_criterio']);
                } elseif ($nome_criterio_regola === 'dimensione_pmi') {
                    $regola_dimensione_soddisfatta = _checkRule($dimensione_pmi, $regola['tipo_condizione'], $regola['valore_criterio']);
                }
                if (!$regola_regione_soddisfatta || !$regola_dimensione_soddisfatta) { break; }
            }
            $result_criteri->free();
        }

        // Aggiungi ai risultati se le regole sono soddisfatte
        if ($regola_regione_soddisfatta && $regola_dimensione_soddisfatta) {
             // ***** MODIFICA ARRAY RISULTATO *****
             // Aggiungi 'stato' e 'tipologia' dall'array $agevolazione
            $risultati_preliminari[] = [
                'id' => $agevolazione['id'],
                'nome' => $agevolazione['nome_bando'] ?? 'N/D',
                'descrizione_breve' => $agevolazione['descrizione_breve'] ?? null,
                'ente' => $agevolazione['ente_erogatore'] ?? 'N/D',
                'ambito_geografico' => $agevolazione['ambito_geografico'] ?? 'Nazionale',
                'stato' => $agevolazione['stato_bando'] ?? null,      // <-- AGGIUNTO (usa nome colonna DB)
                'tipologia' => $agevolazione['tipologia_agevolazione'] ?? null // <-- AGGIUNTO (usa nome colonna DB)
            ];
            // ***********************************
        }
    }
    $stmt_criteri->close();
    $result_agevolazioni->free();
    return $risultati_preliminari;
}
// --- END Function trovaAgevolazioniPreliminari ---


// --- START Function trovaAgevolazioniCompatibili ---
/**
 * Trova le agevolazioni compatibili con TUTTI i criteri forniti dall'utente.
 * Restituisce un array di bandi con i dettagli necessari per le card dello Step 3.
 */
function trovaAgevolazioniCompatibili(array $dati_utente, mysqli $conn): array
{
    $agevolazioni_compatibili = [];

    // ***** MODIFICA SQL *****
    // Aggiungi stato_bando, tipologia_agevolazione. Usa 'descrizione' se disponibile, altrimenti 'descrizione_breve'.
    $sql_agevolazioni = "SELECT id, nome_bando, ente_erogatore, data_scadenza, link_fonte_ufficiale,
                                descrizione, descrizione_breve, stato_bando, tipologia_agevolazione -- << Aggiunto stato_bando
                         FROM agevolazioni
                         WHERE attivo = 1";
    // ***********************

    $result_agevolazioni = $conn->query($sql_agevolazioni);
    if (!$result_agevolazioni) { /* Gestione errore query */ return []; }

    $sql_criteri_agevolazione = "SELECT nome_criterio, tipo_condizione, valore_criterio FROM agevolazione_criteri WHERE agevolazione_id = ?";
    $stmt_criteri = $conn->prepare($sql_criteri_agevolazione);
    if (!$stmt_criteri) { /* Gestione errore prepare */ $result_agevolazioni->free(); return []; }

    while ($agevolazione = $result_agevolazioni->fetch_assoc()) {
        $agevolazione_id = $agevolazione['id'];
        $agevolazione_corrisponde = true;

        // Bind, Execute, Get Result per criteri (come prima)
        if (!$stmt_criteri->bind_param("i", $agevolazione_id)) { continue; }
        if (!$stmt_criteri->execute()) { continue; }
        $result_criteri = $stmt_criteri->get_result();
        if (!$result_criteri) { continue; }

        // Loop e verifica TUTTI i criteri (come prima)
        if ($result_criteri->num_rows > 0) {
            while ($regola = $result_criteri->fetch_assoc()) {
                $nome_criterio_db = $regola['nome_criterio'];
                $valore_utente = $dati_utente[$nome_criterio_db] ?? null;
                if (!_checkRule($valore_utente, $regola['tipo_condizione'], $regola['valore_criterio'])) {
                    $agevolazione_corrisponde = false;
                    break;
                }
            }
            $result_criteri->free();
        }

        // Aggiungi ai risultati se tutti i criteri corrispondono
        if ($agevolazione_corrisponde) {
            // ***** MODIFICA ARRAY RISULTATO *****
            // Aggiungi 'stato', 'tipologia' e scegli la descrizione migliore
             $agevolazioni_compatibili[] = [
                'id' => $agevolazione['id'],
                'nome' => $agevolazione['nome_bando'] ?? 'N/D',
                'ente' => $agevolazione['ente_erogatore'] ?? 'N/D',
                'scadenza' => $agevolazione['data_scadenza'] ?? null,
                'link' => $agevolazione['link_fonte_ufficiale'] ?? null,
                'descrizione' => $agevolazione['descrizione'] ?: ($agevolazione['descrizione_breve'] ?? null), // Usa descrizione completa se c'è, altrimenti la breve
                'stato' => $agevolazione['stato_bando'] ?? null,           // <-- AGGIUNTO (usa nome colonna DB)
                'tipologia' => $agevolazione['tipologia_agevolazione'] ?? null // <-- AGGIUNTO (usa nome colonna DB)
            ];
            // ***********************************
        }
    }
    $stmt_criteri->close();
    $result_agevolazioni->free();
    return $agevolazioni_compatibili;
}
// --- END Function trovaAgevolazioniCompatibili ---

?>a