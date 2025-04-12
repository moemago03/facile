<?php
// Dati (definizioni $regioni_hp, $dimensioni_hp, $map_data, $map_data_json come prima)
$regioni_hp = ["Abruzzo", "Basilicata", "Calabria", "Campania", "Emilia-Romagna", "Friuli-Venezia Giulia", "Lazio", "Liguria", "Lombardia", "Marche", "Molise", "Piemonte", "Puglia", "Sardegna", "Sicilia", "Toscana", "Trentino-Alto Adige", "Umbria", "Valle d'Aosta", "Veneto"];
$dimensioni_hp = [ '' => ['label' => 'Dimensione Impresa (UE)', 'details' => 'Seleziona la dimensione della tua impresa'], 'Micro' => ['label' => 'Micro Impresa', 'details' => '<10 dipendenti e ≤ 2M€ fatturato/bilancio annuo'], 'Piccola' => ['label' => 'Piccola Impresa', 'details' => '<50 dipendenti e ≤ 10M€ fatturato/bilancio annuo'], 'Media' => ['label' => 'Media Impresa', 'details' => '<250 dipendenti e ≤ 50M€ fatturato o ≤ 43M€ bilancio annuo'], 'Grande' => ['label' => 'Grande Impresa', 'details' => 'Supera i limiti della Media Impresa'] ];
$map_data = [ 'Lombardia' => ['lat' => 45.4642, 'lng' => 9.1900, 'status' => 'green', 'label' => 'Alta Disponibilità'], 'Lazio' => ['lat' => 41.9028, 'lng' => 12.4964, 'status' => 'green', 'label' => 'Alta Disponibilità'], 'Campania' => ['lat' => 40.8518, 'lng' => 14.2681, 'status' => 'yellow', 'label' => 'Media Disponibilità'], 'Sicilia' => ['lat' => 38.1157, 'lng' => 13.3613, 'status' => 'yellow', 'label' => 'Media Disponibilità'], 'Veneto' => ['lat' => 45.4384, 'lng' => 12.3271, 'status' => 'green', 'label' => 'Alta Disponibilità'], 'Piemonte' => ['lat' => 45.0703, 'lng' => 7.6869, 'status' => 'yellow', 'label' => 'Media Disponibilità'], 'Emilia-Romagna' => ['lat' => 44.4949, 'lng' => 11.3426, 'status' => 'green', 'label' => 'Alta Disponibilità'], 'Toscana' => ['lat' => 43.7696, 'lng' => 11.2558, 'status' => 'yellow', 'label' => 'Media Disponibilità'], 'Puglia' => ['lat' => 41.1257, 'lng' => 16.8621, 'status' => 'red', 'label' => 'Bassa Disponibilità'], 'Calabria' => ['lat' => 38.9052, 'lng' => 16.5878, 'status' => 'red', 'label' => 'Bassa Disponibilità'], 'Liguria' => ['lat' => 44.4056, 'lng' => 8.9463, 'status' => 'yellow', 'label' => 'Media Disponibilità'], 'Marche' => ['lat' => 43.6158, 'lng' => 13.5189, 'status' => 'yellow', 'label' => 'Media Disponibilità'], 'Abruzzo' => ['lat' => 42.3590, 'lng' => 13.3997, 'status' => 'red', 'label' => 'Bassa Disponibilità'], 'Sardegna' => ['lat' => 39.2238, 'lng' => 9.1217, 'status' => 'yellow', 'label' => 'Media Disponibilità'], 'Friuli-Venezia Giulia' => ['lat' => 45.6495, 'lng' => 13.7768, 'status' => 'green', 'label' => 'Alta Disponibilità'], 'Trentino-Alto Adige' => ['lat' => 46.0667, 'lng' => 11.1167, 'status' => 'green', 'label' => 'Alta Disponibilità'], 'Umbria' => ['lat' => 43.1122, 'lng' => 12.3889, 'status' => 'yellow', 'label' => 'Media Disponibilità'], 'Basilicata' => ['lat' => 40.6667, 'lng' => 15.8000, 'status' => 'red', 'label' => 'Bassa Disponibilità'], 'Molise' => ['lat' => 41.5576, 'lng' => 14.6661, 'status' => 'red', 'label' => 'Bassa Disponibilità'], 'Valle d\'Aosta' => ['lat' => 45.7372, 'lng' => 7.3204, 'status' => 'yellow', 'label' => 'Media Disponibilità'] ];
$map_data_json = json_encode($map_data);
$body_class = 'homepage'; // Definisci la classe per l'header (opzionale se usi body class)
$page_title = "Facile Agevolazioni: Trova Agevolazioni, Bandi e Finanziamenti PMI | Facile Agevolazioni"; // Titolo SEO Homepage
$page_description = "Cerca e trova bandi, finanziamenti PNRR e agevolazioni per la tua PMI in Italia con Facile Agevolazioni. Inizia la ricerca gratuita e ottieni supporto esperto.";

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">

        <!-- ================== Favicon Links ================== -->
    <!-- Sostituisci img/favicon/ con il percorso corretto -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#007bff"> <!-- Sostituisci colore -->
    <link rel="shortcut icon" href="img/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff"> <!-- Sostituisci colore -->
    <meta name="msapplication-config" content="img/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff"> <!-- Sostituisci colore -->

    <!-- Libs CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <!-- CSS incorporato -->
    <link rel="stylesheet" href="css/style.css">

<style>
    

</style>

</head>
<body class="homepage">

<?php include 'includes/header.php'; // Includi l'header globale ?>

    <div class="split-layout-wrapper" style="position: relative;">
        <section class="hp-hero-top-split">
            <div class="hero-content">
                <h1>Trova gli incentivi giusti.<br>Fai crescere la tua impresa.</h1>
                <p class="subtitle">Scopri bandi, finanziamenti e agevolazioni per la tua PMI in Italia.</p>
            </div>
            <div class="search-form-container">
                <!-- Form punta a tool.php -->
                <form action="tool.php" method="POST" class="search-bar" id="homepage-search-form">
                    <input type="hidden" name="source" value="homepage">
                    <div class="form-field-wrapper">
                        <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 11.5A2.5 2.5 0 0 1 9.5 9A2.5 2.5 0 0 1 12 6.5A2.5 2.5 0 0 1 14.5 9a2.5 2.5 0 0 1-2.5 2.5M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Z"></path></svg>
                        <select id="regione_hp" name="regione" required placeholder="Regione Sede Operativa">
                            <option value="">Regione Sede Operativa</option>
                            <?php foreach ($regioni_hp as $r): ?><option value="<?php echo htmlspecialchars($r); ?>"><?php echo htmlspecialchars($r); ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-field-wrapper">
                         <svg class="field-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M19 21h-2v-7h-2v7h-2v-9h-2v9H9v-7H7v7H5v-9H3V5h18v16ZM5 7v2h2V7H5Zm4 0v2h2V7H9Zm4 0v2h2V7h-2Zm4 0v2h2V7h-2Z"></path></svg>
                        <select id="dimensione_pmi_hp" name="dimensione_pmi" required placeholder="Dimensione Impresa (UE)">
                            <option value="" disabled selected>Dimensione Impresa (UE)</option>
                            <?php foreach ($dimensioni_hp as $val => $data): ?>
                                <?php if ($val === '') continue; ?>
                                <option value="<?php echo htmlspecialchars($val); ?>" data-details="<?php echo htmlspecialchars($data['details']); ?>">
                                    <?php echo htmlspecialchars($data['label']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit"> Scopri Agevolazioni <i class="fas fa-arrow-right"></i> </button>
                </form>
            </div>
        </section>
        <section class="hp-map-bottom-split">
            <div id="italy-map-fullscreen"></div>
        </section>
    </div>

    <!-- Footer Ripristinato -->
    <footer class="hp-footer">
         <p> <a href="/privacy-policy.html" target="_blank">Privacy</a> | <a href="/cookie-policy.html" target="_blank">Cookie</a> | <a href="/contatti.html">Contatti</a> </p>
         <p>© <?php echo date("Y"); ?> NomeServizio | P.IVA XXXXXXX | Strumento informativo, non sostituisce consulenza professionale.</p>
         <p><small>Le informazioni sui bandi potrebbero subire variazioni. Verifica sempre le fonti ufficiali.</small></p>
    </footer>

    <!-- JS (Leaflet, Tom Select - senza logica modale) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    let map;
    // Assicurati che questa variabile PHP sia definita correttamente sopra questo script
    // e contenga un oggetto JSON valido con i dati delle regioni (lat, lng, status, label). Esempio:
    // const regionData = {"Lombardia": {"lat": 45.4642, "lng": 9.1900, "status": "green", "label": "Attivo"}, ...};
    const regionData = <?php echo isset($map_data_json) && json_decode($map_data_json) !== null ? $map_data_json : '{}'; ?>;
    let regionMarkers = {}; // Oggetto per memorizzare i marker Leaflet per regione

    // --- Mappa Leaflet ---
    var mapElement = document.getElementById('italy-map-fullscreen');
    if (mapElement) {
        try {
            map = L.map(mapElement, {
                center: [42.5, 12.5], // Centro Italia
                zoom: 5.5,           // Zoom iniziale
                scrollWheelZoom: false,// Disabilita zoom con rotellina
                zoomControl: false    // Nasconde i controlli +/- dello zoom
            });

            // Aggiunge il Tile Layer SCURO da CartoDB
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OSM</a> © <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 12,
                    minZoom: 5
                }).addTo(map);

            // Funzione per creare icone colorate personalizzate
            function createColoredIcon(color) {
                return L.divIcon({
                    className: 'custom-div-icon', // Puoi usare questa classe per stili CSS aggiuntivi se vuoi
                    html: `<div style='background-color:${color};width:14px;height:14px;border-radius:50%; border: 2px solid rgba(255,255,255,0.7); box-shadow: 0 1px 3px rgba(0,0,0,0.4);'></div>`,
                    iconSize: [14, 14], // Dimensioni dell'icona
                    iconAnchor: [7, 7]   // Punto di ancoraggio (centro)
                });
            }
            // Crea le istanze delle icone
            var greenIcon = createColoredIcon('#28a745'), // Verde
                yellowIcon = createColoredIcon('#ffc107'), // Giallo
                redIcon = createColoredIcon('#dc3545');   // Rosso

            // Ciclo per creare i marker sulla mappa
            for (var regionName in regionData) {
                if (regionData.hasOwnProperty(regionName)) {
                    var data = regionData[regionName];
                    var icon, statusClass = ''; // Inizializza statusClass

                    // Determina l'icona e la classe CSS in base allo status
                    switch (data.status) {
                        case 'green':
                            icon = greenIcon;
                            statusClass = 'green';
                            break;
                        case 'yellow':
                            icon = yellowIcon;
                            statusClass = 'yellow';
                            break;
                        case 'red':
                            icon = redIcon;
                            statusClass = 'red';
                            break;
                        default: // Fallback se status non è definito o non corrisponde
                           // Usa un'icona di default o nessuna icona visibile
                           icon = L.divIcon({iconSize: [0,0]}); // Icona invisibile
                           console.warn(`Status non valido o mancante per ${regionName}:`, data.status);
                    }

                    // Crea il marker solo se abbiamo latitudine e longitudine
                    if (data.lat && data.lng) {
                        var marker = L.marker([data.lat, data.lng], { icon: icon }).addTo(map);

                        // Crea il contenuto del popup
                        var popupContent = `<strong>${regionName}</strong><br>Stato Fondi: `;
                        if (statusClass) {
                            // Usa l'etichetta 'label' se disponibile, altrimenti un testo generico
                            popupContent += `<span class='status-label ${statusClass}'>${data.label || data.status.charAt(0).toUpperCase() + data.status.slice(1)}</span>`;
                        } else {
                            popupContent += "N/D"; // Non disponibile
                        }
                        marker.bindPopup(popupContent);

                        // Memorizza il marker nell'oggetto `regionMarkers`
                        regionMarkers[regionName] = marker;
                    } else {
                        console.warn(`Lat/Lng mancanti per ${regionName}. Marker non creato.`);
                    }
                }
            }

            // Invalida la dimensione della mappa dopo un breve ritardo per assicurare il rendering corretto
            setTimeout(() => { if (map) map.invalidateSize(); }, 200);
            console.log("Mappa Leaflet inizializzata con successo.");

        } catch (e) {
            console.error("Errore durante l'inizializzazione della mappa Leaflet:", e);
            // Mostra un messaggio di errore all'utente nel contenitore della mappa
            if (mapElement) mapElement.innerHTML = "<p style='color:#ccc; text-align:center; padding-top: 50px;'>Impossibile caricare la mappa interattiva.</p>";
        }
    } else {
         console.log("Elemento contenitore della mappa (#italy-map-fullscreen) non trovato nel DOM.");
    }
    // --- Fine Mappa Leaflet ---


    // --- Tom Select con Larghezza Dinamica e Apertura Popup ---

    // Funzione helper per renderizzare le opzioni di TomSelect (con/senza icona info)
    function renderTomSelectOption(data, escape, includeIcon = false) {
        let details = '';
        const tsInstance = this; // 'this' è l'istanza di TomSelect
        // Accedi all'elemento select originale dall'istanza TomSelect
        if (tsInstance && tsInstance.settings && tsInstance.settings.originalElement && data.value) {
            const originalSelect = tsInstance.settings.originalElement;
             // Usa try-catch per sicurezza con querySelector e valori potenzialmente problematici
            try {
                 // Assicurati che il valore sia valido per un selettore CSS
                 const escapedValue = CSS.escape ? CSS.escape(data.value) : escape(data.value); // Usa CSS.escape se disponibile
                 const originalOption = originalSelect.querySelector(`option[value="${escapedValue}"]`);
                if (originalOption) {
                    details = originalOption.getAttribute('data-details') || '';
                }
            } catch(e) {
                console.warn(`Errore nel trovare l'opzione originale per il valore: ${data.value}`, e);
            }
        }

        let iconHtml = '';
        // Mostra l'icona solo se includeIcon è true E ci sono dettagli
        if (includeIcon && details) {
            // Usa escape sulla stringa dei dettagli per sicurezza nell'attributo title
            iconHtml = `<i class="fa-regular fa-circle-info info-icon" title="${escape(details)}"></i>`;
        }
        // Usa escape sul testo dell'opzione per sicurezza
        return `<div class="ts-option"><span class="ts-option-text">${escape(data.text)}</span>${iconHtml}</div>`;
    }

    // Funzione Helper per inizializzare TomSelect e gestire la larghezza del dropdown
    function initializeTomSelectWithDynamicWidth(selectorId, userOptions = {}) {
        const element = document.getElementById(selectorId);
        if (!element) {
            console.warn(`Elemento #${selectorId} non trovato per TomSelect.`);
            return; // Esce se l'elemento non esiste
        }

        try {
            // Opzioni di default che verranno applicate a tutti i TomSelect inizializzati con questa funzione
            const defaultOptions = {
                create: false,         // Non permette all'utente di creare nuove opzioni
                dropdownParent: 'body',// Appende il dropdown al body per evitare problemi di clipping/styling
                render: {              // Render di default per item e option (può essere sovrascritto)
                    item: function(data, escape) { return `<div>${escape(data.text)}</div>`; },
                    option: function(data, escape) { return renderTomSelectOption.call(this, data, escape, false); } // Usa il render helper di default
                },
                onInitialize: function() {
                    // Codice eseguito una volta che TomSelect è inizializzato
                    // 'this' qui è l'istanza di TomSelect
                    console.log(`TomSelect per #${selectorId} inizializzato.`);
                     // Potresti aggiungere una classe per indicare che JS ha funzionato
                    // this.wrapper.classList.add('tomselect-initialized');
                },
                onDropdownOpen: function(dropdown) {
                    // Codice eseguito ogni volta che il dropdown si apre
                    // 'this' è l'istanza TomSelect, 'dropdown' è l'elemento DOM del dropdown
                    const wrapper = this.wrapper; // Il div .ts-wrapper creato da TomSelect
                    if (wrapper && dropdown) {
                        const wrapperWidth = wrapper.offsetWidth; // Larghezza del campo di input visibile
                        if (wrapperWidth > 0) {
                             // Imposta la larghezza MINIMA del dropdown uguale a quella del wrapper
                             // Permette al dropdown di espandersi se un'opzione è più lunga,
                             // ma non sarà mai più stretto del campo.
                            dropdown.style.minWidth = wrapperWidth + 'px';

                            // Se vuoi forzare la larghezza ESATTA (rischio di tagliare opzioni lunghe):
                            // dropdown.style.width = wrapperWidth + 'px';
                        } else {
                             console.warn(`Dropdown #${selectorId}: Impossibile ottenere larghezza valida dal wrapper.`);
                        }
                    }
                }
                // Aggiungi altri eventi di default se necessario (es. onFocus, onBlur, etc.)
            };

            // Unisci le opzioni di default con quelle specifiche passate per questo select
            // Le opzioni in userOptions sovrascrivono quelle in defaultOptions se hanno lo stesso nome
            const finalOptions = { ...defaultOptions, ...userOptions };
            // Gestione speciale per l'oggetto 'render', per unire le sue proprietà invece di sovrascrivere l'intero oggetto
            if (userOptions.render) {
                finalOptions.render = { ...defaultOptions.render, ...userOptions.render };
            }
            // Assicurati che funzioni come onChange vengano correttamente assegnate se presenti in userOptions
             if (userOptions.onChange) {
                 finalOptions.onChange = userOptions.onChange;
             }


            // Inizializza TomSelect sull'elemento con le opzioni finali
            new TomSelect(element, finalOptions);

        } catch (e) {
            console.error(`Errore durante l'inizializzazione di TomSelect per #${selectorId}:`, e);
        }
    }

    // --- Inizializzazione Specifica per i Select della Homepage ---

    // Opzioni specifiche per il select della Regione (#regione_hp)
    const regioneHpOptions = {
        sortField: { field: null }, // Mantiene l'ordine originale delle opzioni nell'HTML
        // Non serve 'render' qui perché vogliamo quello di default (senza icona info)

        // Funzione eseguita quando il valore del select cambia
        onChange: function(value) {
            if (map) { // Controlla se la mappa è stata inizializzata
                if (value && regionData[value]) {
                    // È stata selezionata una regione valida
                    const regionInfo = regionData[value]; // Dati della regione selezionata

                    if (regionInfo.lat && regionInfo.lng) {
                        // Vola sulla mappa alle coordinate della regione
                        map.flyTo([regionInfo.lat, regionInfo.lng], 8, { // Zoom 8 sulla regione
                            animate: true,
                            duration: 1.0 // Durata animazione in secondi
                        });

                        // Cerca il marker corrispondente nell'oggetto che abbiamo popolato
                        const targetMarker = regionMarkers[value];
                        if (targetMarker) {
                            // Apri il popup del marker trovato
                            // Usa setTimeout per dare tempo a flyTo di iniziare l'animazione
                            setTimeout(() => {
                                targetMarker.openPopup();
                                console.log("Popup aperto per:", value);
                            }, 400); // Ritardo in millisecondi (prova ad aggiustarlo se serve)
                        } else {
                            console.warn("Marker non trovato per la regione selezionata:", value);
                            map.closePopup(); // Chiudi eventuali popup aperti se non c'è marker
                        }
                    } else {
                         console.warn(`Lat/Lng mancanti per la regione selezionata: ${value}`);
                         map.closePopup(); // Chiudi popup se mancano coordinate
                    }
                } else {
                    // Nessuna regione selezionata (valore vuoto) o regione non trovata nei dati
                    // Riporta la mappa alla vista iniziale
                    map.flyTo([42.5, 12.5], 5.5, { // Coordinate e zoom iniziali
                        animate: true,
                        duration: 1.0
                    });
                    // Chiudi qualsiasi popup eventualmente aperto
                    map.closePopup();
                }
            } else {
                console.warn("La mappa non è inizializzata, impossibile interagire con onChange della regione.");
            }
        }
    };
    // Inizializza TomSelect per la regione usando la funzione helper
    initializeTomSelectWithDynamicWidth('regione_hp', regioneHpOptions);

    // Opzioni specifiche per il select della Dimensione PMI (#dimensione_pmi_hp)
    const dimensioneHpOptions = {
        sortField: { field: null }, // Mantiene l'ordine originale
        allowEmptyOption: false,   // Non permette di deselezionare (a meno che non ci sia un'option vuota)
        render: { // Sovrascrivi il render di default per includere l'icona info
           option: function(data, escape) { return renderTomSelectOption.call(this, data, escape, true); }, // Passa 'true' per l'icona
           // item: function(data, escape) { return `<div>${escape(data.text)}</div>`; } // item rimane standard
        }
        // Nessun onChange specifico necessario per questo select al momento
    };
     // Inizializza TomSelect per la dimensione PMI usando la funzione helper
    initializeTomSelectWithDynamicWidth('dimensione_pmi_hp', dimensioneHpOptions);

    // --- Fine Tom Select ---

     console.log("Script DOMContentLoaded eseguito completamente.");
  });
</script>

</body>
</html>