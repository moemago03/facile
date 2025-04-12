<?php
// --- START Session & Configuration ---
session_start();
require_once 'config/db_config.php';
require_once 'includes/funzioni_filtro.php';
// --- END Session & Configuration ---

// --- START Reset Handling ---
if (isset($_GET['reset']) && $_GET['reset'] == '1') {
    session_destroy();
    header("Location: index.php");
    exit;
}
// --- END Reset Handling ---

// --- START Variable/Data Initialization (Global Scope) ---
$errors = [];
$fatal_error = $_SESSION['fatal_error'] ?? null;
if ($fatal_error) {
    unset($_SESSION['fatal_error']);
    $errors['fatal'] = $fatal_error;
}

$current_step = 0;
$total_steps = 4;

$all_invest_flags_keys = [
    'invest_macchinari_attrezzature', 'invest_software_digitale', 'invest_formazione_competenze', 'invest_innovazione_rs',
    'invest_efficienza_energetica', 'invest_fotovoltaico_rinnovabili', 'invest_sicurezza_lavoro', 'invest_internazionalizzazione',
    'invest_certificazioni', 'invest_proprieta_intellettuale', 'invest_consulenze', 'invest_immobiliari_ristrutturazioni',
    'invest_materie_riciclate', 'invest_startup_avvio', 'invest_barriere_architettoniche', 'invest_adeguamento_sismico'
];

$investimenti_options = [
    'invest_software_digitale' => 'Software e Tecnologie Digitali (Industria 4.0, AI, Cloud, Ecommerce)',
    'invest_macchinari_attrezzature' => 'Macchinari, Impianti e Attrezzature Produttive',
    'invest_innovazione_rs' => 'Ricerca, Sviluppo e Innovazione di Prodotto/Processo',
    'invest_formazione_competenze' => 'Formazione e Aggiornamento Competenze Personale (4.0 e altre)',
    'invest_efficienza_energetica' => 'Efficienza Energetica e Riduzione Consumi',
    'invest_fotovoltaico_rinnovabili' => 'Fotovoltaico e Fonti Rinnovabili',
    'invest_internazionalizzazione' => 'Export, Fiere e Internazionalizzazione Mercati',
    'invest_certificazioni' => 'Certificazioni di Qualità, Ambientali, Sicurezza, ecc.',
    'invest_immobiliari_ristrutturazioni' => 'Acquisto Immobili Strumentali o Ristrutturazioni Edilizie',
];
// --- END Variable/Data Initialization (Global Scope) ---


// --- START Helper Function Definitions ---
function get_value($field_name, $default = '') {
    return htmlspecialchars($_POST[$field_name] ?? $_SESSION['criteria_data'][$field_name] ?? $default, ENT_QUOTES, 'UTF-8');
}

function is_invest_checked($flag_name) {
    if (isset($_POST['investimenti_previsti']) && is_array($_POST['investimenti_previsti']) && in_array($flag_name, $_POST['investimenti_previsti'])) {
        return 'checked';
    }
    if (isset($_SESSION['criteria_data'][$flag_name]) && $_SESSION['criteria_data'][$flag_name]) {
         return 'checked';
    }
    return '';
}

function display_errors($errors) {
    if (!empty($errors)) {
        $output = '<div class="error-summary">';
        $output .= '<strong><i class="fas fa-exclamation-triangle"></i> Attenzione:</strong><ul>';
        foreach ($errors as $key => $error) {
            $output .= '<li>' . ($key === 'sessione' || $key === 'database' || $key === 'fatal' ? $error : htmlspecialchars($error)) . '</li>';
        }
        $output .= '</ul></div>';
        return $output;
    } return '';
}
// --- END Helper Function Definitions ---


// --- START Back Navigation Handling (goto_step) ---
if (isset($_GET['goto_step'])) {
    $target_step = (int)$_GET['goto_step'];
    $current_step_before_change = $_SESSION['current_step'] ?? 2;
    if ($target_step >= 2 && $target_step < $current_step_before_change && $target_step <= $total_steps + 1) {
        $_SESSION['current_step'] = $target_step;
        header("Location: tool.php");
        exit;
    } elseif ($target_step == $current_step_before_change) {
        header("Location: tool.php");
        exit;
    }
}
// --- END Back Navigation Handling (goto_step) ---


// --- START Request Handling (POST and GET) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- START POST Request Handling ---
    $current_step_on_post = $_SESSION['current_step'] ?? 0; // Define before checking source

    if (!$conn && !$fatal_error) {
         $_SESSION['fatal_error'] = "Errore di connessione al database durante l'elaborazione.";
         header("Location: tool.php");
         exit;
    }

    if (!$fatal_error) {
        $source = $_POST['source'] ?? 'tool';

        if ($source === 'homepage') {
            // --- START POST from Homepage (Step 1 Logic) ---
            $regione = trim($_POST['regione'] ?? '');
            $dimensione_pmi = trim($_POST['dimensione_pmi'] ?? '');
            if (empty($regione)) $errors['regione'] = 'Regione obbligatoria.';
            if (empty($dimensione_pmi)) $errors['dimensione_pmi'] = 'Dimensione PMI obbligatoria.';

            if (empty($errors)) {
                $_SESSION['criteria_data'] = [
                    'regione' => $regione, 'dimensione_pmi' => $dimensione_pmi, 'numero_dipendenti' => null,
                    'meno_60_mesi' => null, 'settore_attivita' => null,
                    'invest_macchinari_attrezzature' => false, 'invest_software_digitale' => false, 'invest_formazione_competenze' => false, 'invest_innovazione_rs' => false,
                    'invest_efficienza_energetica' => false, 'invest_fotovoltaico_rinnovabili' => false, 'invest_sicurezza_lavoro' => false, 'invest_internazionalizzazione' => false,
                    'invest_certificazioni' => false, 'invest_proprieta_intellettuale' => false, 'invest_consulenze' => false, 'invest_immobiliari_ristrutturazioni' => false,
                    'invest_materie_riciclate' => false, 'invest_startup_avvio' => false, 'invest_barriere_architettoniche' => false, 'invest_adeguamento_sismico' => false,
                    'invest_altro_descrizione' => null, 'aderisce_fondi_interprof' => 'NonSo', 'modello_231_interesse' => 'No', 'parita_genere_interesse' => 'No'
                ];
                unset($_SESSION['results_data']);
                unset($_SESSION['preliminary_results']);

                try {
                    // Assicurati che trovaAgevolazioniPreliminari ritorni 'ambito_geografico'
                    $_SESSION['preliminary_results'] = trovaAgevolazioniPreliminari($regione, $dimensione_pmi, $conn);
                } catch (Exception $e) {
                    error_log("Errore trovaAgevolazioniPreliminari: " . $e->getMessage());
                    $errors['filtro'] = "Errore ricerca preliminare.";
                    $_SESSION['preliminary_results'] = [];
                }

                if (!isset($errors['filtro'])) {
                    $_SESSION['current_step'] = 2;
                    header("Location: tool.php");
                    exit;
                }
                // Se errore filtro, la pagina si ricarica dopo mostrando l'errore
            } else {
                 $_SESSION['homepage_errors'] = $errors;
                 $_SESSION['homepage_data'] = $_POST;
                 header("Location: index.php");
                 exit;
            }
            // --- END POST from Homepage (Step 1 Logic) ---
        } else {
            // --- START POST from Tool Steps ---
            $submitted_step = (int)($_POST['step'] ?? 0);

            switch ($submitted_step) {
                case 2:
                    // --- START POST Step 2 (Investments/Employees) ---
                    if ($current_step_on_post === 2) {
                        $numero_dipendenti_input = trim($_POST['numero_dipendenti'] ?? '');
                        $numero_dipendenti = ($numero_dipendenti_input !== '' && is_numeric($numero_dipendenti_input) && $numero_dipendenti_input >= 0) ? (int)$numero_dipendenti_input : null;
                        $investimenti_selezionati = $_POST['investimenti_previsti'] ?? [];

                        if (empty($errors)) {
                            if (empty($_SESSION['criteria_data']['regione'])) {
                                $errors['sessione'] = "Errore: Dati sessione mancanti. <a href='tool.php?reset=1'>Ricominciare</a>.";
                            } else {
                                $_SESSION['criteria_data']['numero_dipendenti'] = $numero_dipendenti;
                                foreach ($all_invest_flags_keys as $flag_key) {
                                    $_SESSION['criteria_data'][$flag_key] = in_array($flag_key, $investimenti_selezionati);
                                }
                                unset($_SESSION['results_data']);

                                $agevolazioni_filtrate = [];
                                $credito_innovazione_calc = 0;
                                try {
                                    $agevolazioni_filtrate = trovaAgevolazioniCompatibili($_SESSION['criteria_data'], $conn);
                                    if ($numero_dipendenti !== null && $numero_dipendenti > 4) {
                                        $credito_innovazione_calc = $numero_dipendenti * 5000;
                                    }
                                    $_SESSION['results_data'] = [
                                        'agevolazioni' => $agevolazioni_filtrate,
                                        'credito_innovazione' => $credito_innovazione_calc,
                                        'dipendenti' => $numero_dipendenti
                                    ];
                                } catch (Exception $e) {
                                    error_log("Errore filtro/calcolo Step 2 POST: " . $e->getMessage());
                                    $errors['filtro'] = "Errore durante la ricerca dettagliata.";
                                    $_SESSION['results_data'] = ['agevolazioni' => [], 'credito_innovazione' => 0, 'dipendenti' => $numero_dipendenti];
                                }

                                if (!isset($errors['filtro'])) {
                                    $_SESSION['current_step'] = 3;
                                    header("Location: tool.php");
                                    exit;
                                }
                            }
                        } // fine if(empty($errors))
                    } else { $errors['step_mismatch'] = "Invio dati dallo step errato."; }
                    // --- END POST Step 2 ---
                    break;

                case 3:
                    // --- START POST Step 3 (Contact/Save) ---
                     if ($current_step_on_post === 3) {
                         $nome_azienda = trim($_POST['nome_azienda'] ?? '');
                         $email = trim($_POST['email'] ?? '');
                         $telefono = trim($_POST['telefono'] ?? '');
                         if (empty($nome_azienda)) $errors['nome_azienda'] = 'Nome azienda obbligatorio.';
                         if (empty($email)) { $errors['email'] = 'Email obbligatoria.'; }
                         elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Formato Email non valido.'; }

                         if (empty($errors)) {
                             if (empty($_SESSION['criteria_data']['regione'])) { $errors['sessione'] = "Dati criteri mancanti. <a href='tool.php?reset=1'>Ricominciare</a>."; }
                             else {
                                 $conn->begin_transaction();
                                 try {
                                     // 1. INSERT leads
                                     $sql_lead = "INSERT INTO leads (nome_azienda, email, telefono, stato_lead, data_inserimento) VALUES (?, ?, ?, 'Nuovo', NOW())";
                                     $stmt_lead = $conn->prepare($sql_lead);
                                     if (!$stmt_lead) throw new Exception("Errore prepare leads: " . $conn->error);
                                     $stmt_lead->bind_param("sss", $nome_azienda, $email, $telefono);
                                     if (!$stmt_lead->execute()) { if ($conn->errno == 1062) { throw new Exception("Email '$email' già registrata."); } throw new Exception("Errore execute leads: " . $stmt_lead->error); }
                                     $lead_id = $conn->insert_id;
                                     $stmt_lead->close();

                                     // 2. INSERT azienda_criteri
                                     $sql_criteri = "INSERT INTO azienda_criteri (lead_id, regione, dimensione_pmi, numero_dipendenti, meno_60_mesi, settore_attivita, invest_macchinari_attrezzature, invest_software_digitale, invest_formazione_competenze, invest_innovazione_rs, invest_efficienza_energetica, invest_fotovoltaico_rinnovabili, invest_sicurezza_lavoro, invest_internazionalizzazione, invest_certificazioni, invest_proprieta_intellettuale, invest_consulenze, invest_immobiliari_ristrutturazioni, invest_materie_riciclate, invest_startup_avvio, invest_barriere_architettoniche, invest_adeguamento_sismico, invest_altro_descrizione, aderisce_fondi_interprof, modello_231_interesse, parita_genere_interesse) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                     $stmt_criteri = $conn->prepare($sql_criteri);
                                     if (!$stmt_criteri) throw new Exception("Errore prepare criteri: " . $conn->error);
                                     $c = $_SESSION['criteria_data'];
                                     $params = [ $lead_id, $c['regione'] ?? null, $c['dimensione_pmi'] ?? null, $c['numero_dipendenti'] ?? null, (int)($c['meno_60_mesi'] ?? 0), $c['settore_attivita'] ?? null, (int)($c['invest_macchinari_attrezzature'] ?? 0), (int)($c['invest_software_digitale'] ?? 0), (int)($c['invest_formazione_competenze'] ?? 0), (int)($c['invest_innovazione_rs'] ?? 0), (int)($c['invest_efficienza_energetica'] ?? 0), (int)($c['invest_fotovoltaico_rinnovabili'] ?? 0), (int)($c['invest_sicurezza_lavoro'] ?? 0), (int)($c['invest_internazionalizzazione'] ?? 0), (int)($c['invest_certificazioni'] ?? 0), (int)($c['invest_proprieta_intellettuale'] ?? 0), (int)($c['invest_consulenze'] ?? 0), (int)($c['invest_immobiliari_ristrutturazioni'] ?? 0), (int)($c['invest_materie_riciclate'] ?? 0), (int)($c['invest_startup_avvio'] ?? 0), (int)($c['invest_barriere_architettoniche'] ?? 0), (int)($c['invest_adeguamento_sismico'] ?? 0), $c['invest_altro_descrizione'] ?? null, $c['aderisce_fondi_interprof'] ?? 'NonSo', $c['modello_231_interesse'] ?? 'No', $c['parita_genere_interesse'] ?? 'No' ];
                                     $types = "isssisiiiiiiiiiiiiiiiiisss";
                                     if (strlen($types) !== count($params)) { throw new Exception("Errore tipi bind_param."); }
                                     $stmt_criteri->bind_param($types, ...$params);
                                     if (!$stmt_criteri->execute()) throw new Exception("Errore execute criteri: " . $stmt_criteri->error);
                                     $stmt_criteri->close();
                                     $conn->commit();

                                     // Send Email Notification
                                     $notify_to = "tua_email@tuodominio.com"; // CAMBIA
                                     $notify_subject = "Nuovo Lead Generato - Facile Agevolazioni";
                                     $notify_body = "Nuovo lead:\n\nAzienda: $nome_azienda\nEmail: $email\nTel: " . ($telefono ?: 'N/D') . "\n";
                                     // Add more details if needed
                                     $notify_headers = "From: noreply@tuodominio.com"; // CAMBIA/CONFIGURA
                                     if (!@mail($notify_to, $notify_subject, $notify_body, $notify_headers)) {
                                         error_log("Errore invio email notifica: " . $email);
                                     }

                                     // Prepare confirmation data
                                     $conf_invest_keys = []; foreach ($all_invest_flags_keys as $flag) { if (!empty($c[$flag])) $conf_invest_keys[] = $flag; }
                                     $conf_invest_nomi = []; foreach($conf_invest_keys as $k) { if (isset($investimenti_options[$k])) { $parts = explode('(',$investimenti_options[$k]); $conf_invest_nomi[] = trim($parts[0]); } }
                                     $conf_invest_str = !empty($conf_invest_nomi) ? implode(', ', $conf_invest_nomi) : 'N/D';
                                     $_SESSION['confirmation_data'] = [ 'regione' => $c['regione'] ?? 'N/D', 'dimensione' => $c['dimensione_pmi'] ?? 'N/D', 'dipendenti' => $c['numero_dipendenti'] ?? null, 'investimenti_str' => $conf_invest_str ];

                                     // Set confirmation message and step, clean up session
                                     $_SESSION['confirmation_message'] = "Grazie, " . htmlspecialchars($nome_azienda) . "! Richiesta inviata. Sarai ricontattato a " . htmlspecialchars($email) . ".";
                                     $_SESSION['current_step'] = 4;
                                     unset($_SESSION['criteria_data']); unset($_SESSION['results_data']); unset($_SESSION['preliminary_results']);
                                     header("Location: tool.php");
                                     exit;

                                 } catch (Exception $e) {
                                     $conn->rollback();
                                     $errors['database'] = "Errore salvataggio: " . $e->getMessage();
                                     error_log("Errore salvataggio DB: " . $e->getMessage());
                                 }
                             }
                         } // fine if(empty($errors))
                    } else { $errors['step_mismatch'] = "Invio dati dallo step errato."; }
                    // --- END POST Step 3 ---
                    break;

                default:
                     $errors['step_invalid'] = "Step di invio non valido.";
            } // fine switch
            // --- END POST from Tool Steps ---
        } // fine else (POST interno)
    } // fine else (no fatal error)

    // Determine step to display after failed POST
    if (empty($errors['step_mismatch']) && empty($errors['step_invalid']) && !$fatal_error) {
       $current_step = $current_step_on_post;
    } else {
       $current_step = $_SESSION['current_step'] ?? 2;
       if ($current_step < 2) $current_step = 2;
    }
    // --- END POST Request Handling ---

} else {
    // --- START GET Request Handling ---
    if (!(isset($_GET['reset']) && $_GET['reset'] == '1') && !$fatal_error) {
         if (!isset($_SESSION['criteria_data']['regione']) || !isset($_SESSION['criteria_data']['dimensione_pmi'])) {
              header("Location: index.php?error=session_missing");
              exit;
         }
         $current_step = $_SESSION['current_step'] ?? 2;
    } elseif ($fatal_error) {
        $current_step = 0;
    } else { /* Reset in corso */ }
    // --- END GET Request Handling ---
}
// --- END Request Handling (POST and GET) ---

// --- START Final Step Determination & View Data Preparation ---

// Determina lo step corrente finale da visualizzare
if ($fatal_error) {
    $current_step = 0; // Stato errore
} elseif (!isset($current_step) || ($current_step < 2 && $current_step !== 0) ) {
    // Se $current_step non è stato impostato o è invalido, forza allo step 2 se la sessione base esiste
     $current_step = $_SESSION['current_step'] ?? 2;
     if ($current_step < 2) $current_step = 2;
}

// Inizializza tutte le variabili usate nella view con valori di default
$regione_corrente = 'N/A';
$dimensione_corrente = 'N/A';
$dipendenti_corrente = null;
$investimenti_riepilogo_str = 'Nessuno specificato';
$preliminary_results_all = [];
$preliminary_results_locali = []; // Array per risultati locali
$preliminary_results_nazionali = []; // Array per risultati nazionali
$agevolazioni_finali = [];
$credito_innovazione = 0;
$dipendenti_per_credito = null;
$conf_data_view = null;
$messaggio_conferma = $_SESSION['confirmation_message'] ?? '';

// Popola le variabili della view se lo step è valido e i dati di sessione esistono
if ($current_step >= 2 && isset($_SESSION['criteria_data'])) {
    // Carica criteri base dalla sessione
    $regione_corrente = $_SESSION['criteria_data']['regione'] ?? 'N/D';
    $dimensione_corrente = $_SESSION['criteria_data']['dimensione_pmi'] ?? 'N/D';
    $dipendenti_corrente = $_SESSION['criteria_data']['numero_dipendenti'] ?? null;

    // Crea stringa riepilogo investimenti selezionati
    $invest_keys = [];
    if(isset($all_invest_flags_keys)){
        foreach ($all_invest_flags_keys as $flag) {
            // Controlla esplicitamente se il flag è true o 1 in sessione
            if (isset($_SESSION['criteria_data'][$flag]) && $_SESSION['criteria_data'][$flag]) {
                 $invest_keys[] = $flag;
            }
        }
    }
    $invest_nomi = [];
    if(isset($investimenti_options)){
        foreach($invest_keys as $k) {
            if (isset($investimenti_options[$k])) {
                $parts = explode('(',$investimenti_options[$k]);
                $invest_nomi[] = trim($parts[0]);
            }
        }
    }
    $investimenti_riepilogo_str = !empty($invest_nomi) ? implode(', ', $invest_nomi) : 'Nessuno specificato';

    // Carica e dividi risultati preliminari
    $preliminary_results_all = $_SESSION['preliminary_results'] ?? [];
    if (!empty($preliminary_results_all)) {
        foreach ($preliminary_results_all as $bando) {
            // Recupera l'ambito geografico dal risultato del bando
            // Assicurati che 'trovaAgevolazioniPreliminari' restituisca questo campo!
            $ambito = $bando['ambito_geografico'] ?? 'Nazionale'; // Default a Nazionale

            // Logica di divisione: considera locale se l'ambito NON è 'Nazionale' (case-insensitive)
            // e potenzialmente verifica se la regione corrisponde (se hai il dato)
            $is_locale = false;
            if (isset($ambito) && strcasecmp($ambito, 'Nazionale') != 0) {
                // È locale se non è 'Nazionale'.
                // Potresti aggiungere un controllo più specifico se 'ambito' contiene la regione
                // o se hai un campo 'regione_target' nel risultato $bando.
                // Esempio: if(stripos($ambito, $regione_corrente) !== false) $is_locale = true;
                $is_locale = true; // Logica semplificata: non-Nazionale = Locale
            }

            if ($is_locale) {
                $preliminary_results_locali[] = $bando;
            } else {
                $preliminary_results_nazionali[] = $bando;
            }
        }
    }

    // Carica risultati finali (necessari per Step 3+)
    if ($current_step >= 3 && isset($_SESSION['results_data'])) {
        $results_data_session = $_SESSION['results_data'];
        // Assicurati che trovaAgevolazioniCompatibili restituisca i campi necessari
        $agevolazioni_finali = $results_data_session['agevolazioni'] ?? [];
        $credito_innovazione = $results_data_session['credito_innovazione'] ?? 0;
        $dipendenti_per_credito = $results_data_session['dipendenti'] ?? null;
    }
}

// Carica e pulisce i dati per la pagina di conferma (Step 4)
if ($current_step == 4 && isset($_SESSION['confirmation_data'])) {
    $conf_data_view = $_SESSION['confirmation_data'];
    unset($_SESSION['confirmation_data']);
    if(!empty($messaggio_conferma)) unset($_SESSION['confirmation_message']);
}
// Pulisci messaggio se l'utente ricarica la pagina di conferma
elseif ($current_step == 4 && empty($conf_data_view)) {
     $messaggio_conferma = '';
}

// --- END Final Step Determination & View Data Preparation ---

// --- START Set Page Title ---
$brand_name = "Facile Agevolazioni";
$step_titles = [ 2 => "Step 1/4: Definisci Ricerca", 3 => "Step 2/4: Risultati", 4 => "Step 3/4: Contatto", 5 => "Step 4/4: Conferma" ];
$current_logical_step_for_title = ($current_step == 4) ? 5 : $current_step;
$step_title_part = $step_titles[$current_logical_step_for_title] ?? "Ricerca Agevolazioni";
$page_title = $step_title_part . " | " . $brand_name;
$page_description = "Utilizza lo strumento di Facile Agevolazioni per identificare opportunità di finanziamento per la tua PMI.";
// --- END Set Page Title ---

$body_class = 'tool-page';

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <!-- <meta name="robots" content="noindex, follow"> -->
    <!-- Favicon Links -->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#007bff">
    <link rel="shortcut icon" href="/img/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="/img/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- Libs CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="<?php echo $body_class ?? ''; ?>">

    <?php // --- START Header Include ---
        include 'includes/header.php';
    // --- END Header Include --- ?>

    <div class="container">
        <?php // --- START Fatal Error Display ---
        if ($current_step === 0): ?>
             <div class="fatal-error-display">
                 <i class="fas fa-times-circle"></i>
                 <p><?php echo htmlspecialchars($errors['fatal'] ?? 'Errore imprevisto.'); ?></p>
                 <p><a href="index.php">Homepage</a></p>
             </div>
        <?php // --- END Fatal Error Display ---
        else: ?>
            <?php // --- START Step Indicator --- ?>
            <div class="step-indicator">
                 <?php
                    $steps_info = [ 2 => ['icon' => 'far fa-building', 'text' => 'Azienda'], 3 => ['icon' => 'fas fa-clipboard-list', 'text' => 'Risultati'], 4 => ['icon' => 'far fa-address-card', 'text' => 'Contatto'], 5 => ['icon' => 'far fa-check-circle', 'text' => 'Conferma'] ];
                    $visual_step_map = [ 2 => 1, 3 => 2, 4 => 3, 5 => 4];
                    $current_logical_step_for_display = ($current_step == 4) ? 5 : $current_step;
                    $current_visual_step = $visual_step_map[$current_logical_step_for_display] ?? 0;
                    for ($i = 1; $i <= $total_steps; $i++) {
                        $step_key = array_search($i, $visual_step_map);
                        $step_data = $steps_info[$step_key] ?? ['icon' => 'fa-question', 'text' => 'Step ' . $i];
                        $is_active = ($i == $current_visual_step); $is_completed = ($i < $current_visual_step);
                        $step_class = ''; if ($is_active) $step_class .= ' active'; if ($is_completed) $step_class .= ' completed';
                        $icon_class = $step_data['icon']; $step_text = $step_data['text'];
                        $link_enabled = ($is_completed && $step_key >= 2); $tag = $link_enabled ? 'a' : 'div';
                        $href = $link_enabled ? 'href="tool.php?goto_step=' . $step_key . '"' : ''; $link_class = $link_enabled ? 'enabled-link' : '';
                ?>
                    <<?php echo $tag; ?> class="step-item <?php echo trim($step_class); ?> <?php echo $link_class; ?>" <?php echo $href; ?>>
                         <div class="icon-wrapper"><i class="<?php echo $icon_class; ?>"></i></div><span><?php echo $step_text; ?></span>
                    </<?php echo $tag; ?>>
                <?php } ?>
            </div>
            <?php // --- END Step Indicator --- ?>

            <?php // --- START Step Content --- ?>
            <div class="step-content">
                <?php echo display_errors($errors); ?>

                <?php // --- START Step 2 Content --- ?>
                <div class="step-section <?php echo ($current_step === 2) ? 'active' : ''; ?>">
                    <h1>La Tua Ricerca Attuale</h1>
                    <div class="current-choices-summary">
                        <div class="summary-row">
                            <div class="choice-badge"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($regione_corrente); ?></div>
                            <div class="choice-badge"><i class="fas fa-building"></i> <?php echo htmlspecialchars($dimensione_corrente); ?></div>
                        </div>
                    </div>
                    <div class="preliminary-results">
                        <h4><i class="fas fa-map-marker-alt"></i> Opportunità Specifiche per <?php echo htmlspecialchars($regione_corrente); ?></h4>
                        <?php if (!empty($preliminary_results_locali)): ?>
                            <div class="results-grid local-results">
                                 <?php foreach ($preliminary_results_locali as $bando): ?>
                                     <div class="result-card">
                                         <div class="card-header"><i class="fas fa-award card-icon"></i><h5><?php echo htmlspecialchars($bando['nome'] ?? 'N/D'); ?></h5></div>
                                         <div class="card-content"><p><?php echo htmlspecialchars($bando['descrizione_breve'] ?? 'N/D'); ?></p></div>
                                         <div class="card-footer"><small><i class="fas fa-university"></i> Ente: <?php echo htmlspecialchars($bando['ente'] ?? 'N/D'); ?></small></div>
                                     </div>
                                 <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="nessun-risultato mini">Nessuna opportunità specifica locale trovata.</p>
                        <?php endif; ?>
                        <h4 style="margin-top: 40px;"><i class="fas fa-globe-europe"></i> Opportunità Nazionali Potenziali</h4>
                        <?php if (!empty($preliminary_results_nazionali)): ?>
                            <div class="results-grid national-results">
                                 <?php foreach ($preliminary_results_nazionali as $bando): ?>
                                     <div class="result-card">
                                          <div class="card-header"><i class="fas fa-award card-icon"></i><h5><?php echo htmlspecialchars($bando['nome'] ?? 'N/D'); ?></h5></div>
                                          <div class="card-content"><p><?php echo htmlspecialchars($bando['descrizione_breve'] ?? 'N/D'); ?></p></div>
                                          <div class="card-footer"><small><i class="fas fa-university"></i> Ente: <?php echo htmlspecialchars($bando['ente'] ?? 'N/D'); ?></small></div>
                                     </div>
                                 <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                             <p class="nessun-risultato mini">Nessuna opportunità nazionale generica trovata.</p>
                        <?php endif; ?>
                        <hr class="section-divider">
                    </div>
                    <form action="tool.php" method="POST" id="form-step-2">
                        <input type="hidden" name="step" value="2">
                        <fieldset>
                            <legend>Tipi di Investimento in Programma?</legend>
                            <div class="checkbox-group">
                                <?php foreach ($investimenti_options as $key => $label): ?>
                                    <label><input type="checkbox" name="investimenti_previsti[]" value="<?php echo $key; ?>" <?php echo is_invest_checked($key); ?>><span><?php echo htmlspecialchars($label); ?></span></label>
                                <?php endforeach; ?>
                            </div>
                             <?php if(isset($errors['investimenti_previsti'])): ?><p class="error-message"><?php echo htmlspecialchars($errors['investimenti_previsti']); ?></p><?php endif; ?>
                        </fieldset>
                        <fieldset>
                             <legend>Informazioni Aggiuntive (Opzionale)</legend>
                             <label for="numero_dipendenti">Numero Dipendenti</label>
                             <input type="number" id="numero_dipendenti" name="numero_dipendenti" min="0" step="1" value="<?php echo get_value('numero_dipendenti', ''); ?>" placeholder="Es. 15" class="<?php if(isset($errors['numero_dipendenti'])) echo 'error'; ?>">
                              <?php if(isset($errors['numero_dipendenti'])): ?><p class="error-message"><?php echo htmlspecialchars($errors['numero_dipendenti']); ?></p><?php endif; ?>
                        </fieldset>
                        <div class="form-actions">
                             <a href="tool.php?reset=1" class="back-link"><i class="fas fa-redo"></i> Ricomincia</a>
                             <button type="submit" class="button-primary">Vedi Risultati <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
                <?php // --- END Step 2 Content --- ?>

                <?php // --- START Step 3 Content --- ?>
                <div class="step-section <?php echo ($current_step === 3) ? 'active' : ''; ?>">
                     <h1>Risultati Dettagliati e Contatto</h1>
                     <div class="current-choices-summary">
                         <div class="summary-row">
                             <div class="choice-badge"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($regione_corrente); ?></div>
                             <div class="choice-badge"><i class="fas fa-building"></i> <?php echo htmlspecialchars($dimensione_corrente); ?></div>
                             <?php if ($dipendenti_corrente !== null): ?><div class="choice-badge"><i class="fas fa-users"></i> <?php echo htmlspecialchars($dipendenti_corrente); ?> Dip.</div><?php endif; ?>
                         </div>
                         <div class="summary-row investments">
                             <span class="summary-label"><i class="fas fa-cogs"></i> Investimenti:</span>
                             <span class="summary-text"><?php echo htmlspecialchars($investimenti_riepilogo_str); ?></span>
                         </div>
                     </div>
                    <div class="final-results">
                        <?php if ($credito_innovazione > 0): ?>
                            <div class="highlight-credito-imposta"><h4><i class="fas fa-calculator"></i> Stima Credito Imposta</h4><p>Con <strong><?php echo htmlspecialchars($dipendenti_per_credito ?? 'N/D'); ?> dip.</strong>, stima: <strong><?php echo number_format($credito_innovazione, 0, ',', '.'); ?> €</strong>.</p><small><i>Nota: Stima preliminare.</i></small></div>
                         <?php endif; ?>
                        <?php if (!empty($agevolazioni_finali)): ?>
                            <h4 style="margin-top: <?php echo $credito_innovazione > 0 ? '30px' : '0'; ?>;"><i class="fas fa-clipboard-check"></i> Agevolazioni Compatibili:</h4>
                            <div class="results-grid detailed-results">
                                <?php foreach ($agevolazioni_finali as $bando): ?>
                                    <div class="result-card final-card">
                                        <div class="card-header"><i class="fas fa-award card-icon"></i><h5><?php echo htmlspecialchars($bando['nome'] ?? 'N/D'); ?></h5></div>
                                        <div class="card-content">
                                            <?php if (!empty($bando['descrizione'])): ?><p><?php echo htmlspecialchars($bando['descrizione']); ?></p><?php endif; ?>
                                            <ul class="bando-details-list">
                                                <?php if (!empty($bando['ente'])): ?><li><i class="fas fa-university fa-fw"></i> <strong>Ente:</strong> <?php echo htmlspecialchars($bando['ente']); ?></li><?php endif; ?>
                                                <?php if (!empty($bando['scadenza'])): ?><li><i class="fas fa-calendar-times fa-fw"></i> <strong>Scadenza:</strong> <?php echo date("d/m/Y", strtotime($bando['scadenza'])); ?></li><?php else: ?><li><i class="fas fa-calendar-check fa-fw"></i> <strong>Scadenza:</strong> A sportello o N/D</li><?php endif; ?>
                                            </ul>
                                        </div>
                                        <?php if (!empty($bando['link'])): ?><div class="card-footer"><a href="<?php echo htmlspecialchars($bando['link']); ?>" target="_blank" rel="noopener noreferrer" class="button-link-bando"><i class="fas fa-external-link-alt"></i> Fonte Ufficiale</a></div><?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php elseif ($credito_innovazione <= 0): ?>
                             <p class="nessun-risultato">Nessuna agevolazione specifica trovata.</p>
                        <?php endif; ?>
                        <hr class="section-divider">
                        <h3 class="form-section-title">Richiedi Consulenza Gratuita</h3>
                        <p class="form-section-intro">Lascia i tuoi dati per essere ricontattato.</p>
                        <form action="tool.php" method="POST" id="form-step-3">
                            <input type="hidden" name="step" value="3">
                            <label for="nome_azienda_contatto">Nome Azienda: *</label>
                            <input type="text" id="nome_azienda_contatto" name="nome_azienda" required value="<?php echo get_value('nome_azienda'); ?>" placeholder="Ragione Sociale" class="<?php echo isset($errors['nome_azienda']) ? 'error' : ''; ?>">
                            <?php if(isset($errors['nome_azienda'])): ?><p class="error-message"><?php echo htmlspecialchars($errors['nome_azienda']); ?></p><?php endif; ?>
                            <label for="email_contatto">Email Aziendale: *</label>
                            <input type="email" id="email_contatto" name="email" required value="<?php echo get_value('email'); ?>" placeholder="info@tuaazienda.it" class="<?php echo isset($errors['email']) ? 'error' : ''; ?>">
                            <?php if(isset($errors['email'])): ?><p class="error-message"><?php echo htmlspecialchars($errors['email']); ?></p><?php endif; ?>
                            <label for="telefono_contatto">Telefono (Opzionale):</label>
                            <input type="tel" id="telefono_contatto" name="telefono" value="<?php echo get_value('telefono'); ?>" placeholder="012 3456789" class="<?php echo isset($errors['telefono']) ? 'error' : ''; ?>">
                            <?php if(isset($errors['telefono'])): ?><p class="error-message"><?php echo htmlspecialchars($errors['telefono']); ?></p><?php endif; ?>
                             <p class="form-notes"><small>Cliccando, accetti la <a href="/privacy-policy.html" target="_blank">Privacy Policy</a>.</small></p>
                             <div class="form-actions">
                                 <a href="tool.php?goto_step=2" class="back-link"><i class="fas fa-arrow-left"></i> Indietro</a>
                                 <button type="submit" class="button-primary">Invia Richiesta <i class="fas fa-paper-plane"></i></button>
                             </div>
                         </form>
                    </div>
                </div>
                 <?php // --- END Step 3 Content --- ?>

                 <?php // --- START Step 4 Content (Confirmation) --- ?>
                <div class="step-section <?php echo ($current_step === 4) ? 'active' : ''; ?>">
                     <div class="confirmation-box">
                        <i class="far fa-check-circle icon-conferma"></i>
                        <h1>Richiesta Inviata!</h1>
                        <?php if (!empty($messaggio_conferma)): ?><p><?php echo $messaggio_conferma; ?></p><?php else: ?><p>Ti contatteremo presto.</p><?php endif; ?>
                        <?php if ($conf_data_view): ?>
                            <div class="summary-on-confirmation">
                                <strong>Riepilogo Richiesta:</strong>
                                <ul>
                                    <li><i class="fas fa-map-marker-alt fa-fw"></i> <strong>Regione:</strong> <?php echo htmlspecialchars($conf_data_view['regione'] ?? 'N/D'); ?></li>
                                    <li><i class="fas fa-building fa-fw"></i> <strong>Dimensione:</strong> <?php echo htmlspecialchars($conf_data_view['dimensione'] ?? 'N/D'); ?></li>
                                    <?php if (isset($conf_data_view['dipendenti']) && $conf_data_view['dipendenti'] !== null): ?><li><i class="fas fa-users fa-fw"></i> <strong>Dipendenti:</strong> <?php echo htmlspecialchars($conf_data_view['dipendenti']); ?></li><?php endif; ?>
                                    <li><i class="fas fa-cogs fa-fw"></i> <strong>Investimenti:</strong> <?php echo htmlspecialchars($conf_data_view['investimenti_str'] ?? 'N/D'); ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <a href="tool.php?reset=1" class="nuova-ricerca button-secondary"><i class="fas fa-search"></i> Nuova Ricerca</a>
                    </div>
                </div>
                <?php // --- END Step 4 Content (Confirmation) --- ?>

            </div>
             <?php // --- END Step Content --- ?>
        <?php endif; // End check fatal_error ?>
    </div>

    <?php // --- START Footer Include ---
        include 'includes/footer.php';
    // --- END Footer Include --- ?>

    <?php // --- START Database Connection Close ---
        if (isset($conn) && $conn instanceof mysqli && $conn->thread_id) {
            $conn->close();
        }
    // --- END Database Connection Close --- ?>

    <?php // --- START Optional Tool JS --- ?>
    <?php // --- END Optional Tool JS --- ?>
</body>
</html>