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
 * Funzione helper interna per verificare una singola regola.
 */
function _checkRule($valore_utente, string $tipo_condizione, string $valore_criterio_regola): bool
{
    $regola_soddisfatta = false;
    // Pulisce eventuali spazi extra dai valori per confronti più robusti
    $valore_utente_trimmed = is_string($valore_utente) ? trim($valore_utente) : $valore_utente;
    $valore_criterio_regola_trimmed = trim($valore_criterio_regola);

    switch ($tipo_condizione) {
        case 'EQUALS':
            $regola_soddisfatta = (strcasecmp((string)$valore_utente_trimmed, $valore_criterio_regola_trimmed) == 0);
             if (!$regola_soddisfatta && strcasecmp($valore_criterio_regola_trimmed, 'Tutte') == 0) {
                 $regola_soddisfatta = true; // 'Tutte' matcha sempre in positivo
             }
            break;
        case 'NOT_EQUALS':
            $regola_soddisfatta = (strcasecmp((string)$valore_utente_trimmed, $valore_criterio_regola_trimmed) != 0);
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
            $regola_soddisfatta = in_array(strtolower((string)$valore_utente_trimmed), $lista_valori_lower);
             if (!$regola_soddisfatta && in_array('tutte', $lista_valori_lower)) {
                 $regola_soddisfatta = true; // 'Tutte' nella lista matcha sempre
             }
            break;
        case 'NOT_IN_LIST':
            $lista_valori = array_map('trim', explode(',', $valore_criterio_regola_trimmed));
            $lista_valori_lower = array_map('strtolower', $lista_valori);
            $regola_soddisfatta = !in_array(strtolower((string)$valore_utente_trimmed), $lista_valori_lower);
            break;
        case 'IS_TRUE':
            $regola_soddisfatta = filter_var($valore_utente, FILTER_VALIDATE_BOOLEAN);
            break;
        case 'IS_FALSE':
            $regola_soddisfatta = !filter_var($valore_utente, FILTER_VALIDATE_BOOLEAN);
            break;
        case 'CONTAINS':
            $regola_soddisfatta = is_string($valore_utente_trimmed) && $valore_criterio_regola_trimmed !== '' && stripos((string)$valore_utente_trimmed, $valore_criterio_regola_trimmed) !== false;
            break;
        case 'STARTS_WITH':
            $regola_soddisfatta = is_string($valore_utente_trimmed) && $valore_criterio_regola_trimmed !== '' && stripos((string)$valore_utente_trimmed, $valore_criterio_regola_trimmed) === 0;
            break;
         case 'REGEX_MATCH':
            $regola_soddisfatta = @preg_match($valore_criterio_regola, (string)$valore_utente) === 1; // Regex usa valore originale non trimmato? Valutare
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
 * Restituisce i dati necessari per le card preliminari, INCLUSO ambito_geografico.
 */
function trovaAgevolazioniPreliminari(string $regione, string $dimensione_pmi, mysqli $conn): array
{
    $risultati_preliminari = [];

    // Seleziona i campi necessari, inclusa la colonna 'ambito_geografico'
    $sql_agevolazioni = "SELECT id, nome_bando, descrizione_breve, ente_erogatore, ambito_geografico
                         FROM agevolazioni
                         WHERE attivo = 1";
    $result_agevolazioni = $conn->query($sql_agevolazioni);

    if (!$result_agevolazioni) {
        error_log("Errore query recupero agevolazioni (Preliminari): " . $conn->error);
        return [];
    }

    if ($result_agevolazioni->num_rows > 0) {
        $sql_criteri_agevolazione = "SELECT nome_criterio, tipo_condizione, valore_criterio
                                     FROM agevolazione_criteri WHERE agevolazione_id = ?";
        $stmt_criteri = $conn->prepare($sql_criteri_agevolazione);
        if (!$stmt_criteri) {
             error_log("Errore prepare statement criteri (Preliminari): " . $conn->error);
             $result_agevolazioni->free(); // Libera risultato precedente
             return [];
        }

        while ($agevolazione = $result_agevolazioni->fetch_assoc()) {
            $agevolazione_id = $agevolazione['id'];
            $regola_regione_soddisfatta = true;
            $regola_dimensione_soddisfatta = true;

            $stmt_criteri->bind_param("i", $agevolazione_id);
            if (!$stmt_criteri->execute()) {
                 error_log("Errore execute criteri (Preliminari) ID $agevolazione_id: " . $stmt_criteri->error);
                 continue; // Salta questo bando se l'esecuzione fallisce
            }
            $result_criteri = $stmt_criteri->get_result();
            if (!$result_criteri) {
                 error_log("Errore get_result criteri (Preliminari) ID $agevolazione_id");
                 continue;
            }

            if ($result_criteri->num_rows > 0) {
                while ($regola = $result_criteri->fetch_assoc()) {
                    $nome_criterio_regola = $regola['nome_criterio'];
                    if ($nome_criterio_regola == 'regione') {
                        $regola_regione_soddisfatta = _checkRule($regione, $regola['tipo_condizione'], $regola['valore_criterio']);
                    } elseif ($nome_criterio_regola == 'dimensione_pmi') {
                        $regola_dimensione_soddisfatta = _checkRule($dimensione_pmi, $regola['tipo_condizione'], $regola['valore_criterio']);
                    }
                    // Interrompi l'analisi dei criteri per questo bando se uno non è soddisfatto
                    if (!$regola_regione_soddisfatta || !$regola_dimensione_soddisfatta) {
                        break;
                    }
                }
                $result_criteri->free();
            }

            // Aggiungi ai risultati solo se entrambe le regole (se presenti) sono soddisfatte
            if ($regola_regione_soddisfatta && $regola_dimensione_soddisfatta) {
                $risultati_preliminari[] = [
                    'id' => $agevolazione['id'],
                    'nome' => $agevolazione['nome_bando'] ?? 'N/D',
                    'descrizione_breve' => $agevolazione['descrizione_breve'] ?? null,
                    'ente' => $agevolazione['ente_erogatore'] ?? 'N/D',
                    'ambito_geografico' => $agevolazione['ambito_geografico'] ?? 'Nazionale' // Includi l'ambito!
                ];
            }
        }
        $stmt_criteri->close();
    }
    $result_agevolazioni->free();

    // error_log("DEBUG - trovaAgevolazioniPreliminari OUTPUT: " . print_r($risultati_preliminari, true)); // Mantieni per debug se necessario
    return $risultati_preliminari;
}
// --- END Function trovaAgevolazioniPreliminari ---


// --- START Function trovaAgevolazioniCompatibili ---
/**
 * Trova le agevolazioni compatibili con TUTTI i criteri forniti dall'utente.
 * Restituisce i dettagli necessari per le card dello Step 3.
 */
function trovaAgevolazioniCompatibili(array $dati_utente, mysqli $conn): array
{
    $agevolazioni_compatibili = [];

    // Seleziona i campi necessari per le card finali (Step 3)
    // Assicurati che le colonne esistano nel tuo DB
    $sql_agevolazioni = "SELECT id, nome_bando, ente_erogatore, data_scadenza, link_fonte_ufficiale, descrizione_breve
                         FROM agevolazioni
                         WHERE attivo = 1";
    $result_agevolazioni = $conn->query($sql_agevolazioni);

    if (!$result_agevolazioni) {
        error_log("Errore query recupero agevolazioni (Completo): " . $conn->error);
        return [];
    }

    if ($result_agevolazioni->num_rows > 0) {
        $sql_criteri_agevolazione = "SELECT nome_criterio, tipo_condizione, valore_criterio
                                     FROM agevolazione_criteri WHERE agevolazione_id = ?";
        $stmt_criteri = $conn->prepare($sql_criteri_agevolazione);
        if (!$stmt_criteri) {
             error_log("Errore prepare statement criteri (Completo): " . $conn->error);
             $result_agevolazioni->free();
             return [];
        }

        while ($agevolazione = $result_agevolazioni->fetch_assoc()) {
            $agevolazione_id = $agevolazione['id'];
            $agevolazione_corrisponde = true;

            $stmt_criteri->bind_param("i", $agevolazione_id);
             if (!$stmt_criteri->execute()) {
                 error_log("Errore execute criteri (Completo) ID $agevolazione_id: " . $stmt_criteri->error);
                 continue;
            }
            $result_criteri = $stmt_criteri->get_result();
            if (!$result_criteri) {
                 error_log("Errore get_result criteri (Completo) ID $agevolazione_id");
                 continue;
            }

            if ($result_criteri->num_rows > 0) {
                while ($regola = $result_criteri->fetch_assoc()) {
                    $nome_criterio_db = $regola['nome_criterio'];
                    // Assicurati che $dati_utente contenga le chiavi corrispondenti ai criteri nel DB
                    $valore_utente = $dati_utente[$nome_criterio_db] ?? null;

                    if (!_checkRule($valore_utente, $regola['tipo_condizione'], $regola['valore_criterio'])) {
                        $agevolazione_corrisponde = false;
                        break;
                    }
                }
                $result_criteri->free();
            }

            if ($agevolazione_corrisponde) {
                // Aggiungi i dettagli necessari per lo Step 3
                 $agevolazioni_compatibili[] = [
                    'id' => $agevolazione['id'],
                    'nome' => $agevolazione['nome_bando'] ?? 'N/D',
                    'ente' => $agevolazione['ente_erogatore'] ?? 'N/D',
                    'scadenza' => $agevolazione['data_scadenza'] ?? null,
                    'link' => $agevolazione['link_fonte_ufficiale'] ?? null,
                    'descrizione' => $agevolazione['descrizione_breve'] ?? null
                ];
            }
        }
        $stmt_criteri->close();
    }
    $result_agevolazioni->free();

    return $agevolazioni_compatibili;
}
// --- END Function trovaAgevolazioniCompatibili ---

?>