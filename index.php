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
    <?php // Chiusura del tuo tag .hp-footer esistente ?>

</div> <?php // Questa è la chiusura del .content-wrapper se lo usi ?>

<!-- Pulsante WhatsApp Flottante -->
<a href="https://wa.me/39XXXXXXXXXX?text=Buongiorno%2C%20avrei%20una%20domanda%20sul%20servizio%20Facile%20Agevolazioni."
   class="whatsapp-button"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Contattaci su WhatsApp">
    <i class="fab fa-whatsapp"></i> <?php // Assicurati di usare il prefisso corretto per FontAwesome (fab per Brands) ?>
</a>
<!-- Fine Pulsante WhatsApp Flottante -->

<?php // Eventuali script JS caricati alla fine del body ?> 
    <!-- JS (Leaflet, Tom Select - senza logica modale) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>



    <script>
  document.addEventListener('DOMContentLoaded', function() {
    let map;
    // Assicurati che $map_data_json sia definito e valido JSON in PHP prima di questo script
    const regionData = <?php echo isset($map_data_json) && json_decode($map_data_json) !== null ? $map_data_json : '{}'; ?>;
    let regionMarkers = {}; // Oggetto per memorizzare i marker L.Marker per regione
    let geojsonLayer = null; // Layer Leaflet per i confini regionali
    let highlightedRegionLayer = null; // Layer della regione attualmente evidenziata all'interno del geojsonLayer
    let geojsonLayerLookup = {}; // Oggetto per mappare: nome regione -> layer specifico della regione

    // --- Stili per il Layer GeoJSON (Adatti per Mappa Chiara) ---
    const defaultRegionStyle = {
        weight: 0.2,
        opacity: 0.7,
        color: '#555555', // Grigio scuro per bordo
        fillOpacity: 0.05,
        fillColor: '#AAAAAA' // Grigio per riempimento leggero
    };
    const highlightRegionStyle = {
        weight: 0.6,
        opacity: 1,
        color: '#007bff', // Blu primario per bordo evidenziato
        fillOpacity: 0.2,
        fillColor: '#007bff' // Blu primario per riempimento evidenziato
    };
    // --- Fine Stili GeoJSON ---

    // --- Mappa Leaflet ---
    var mapElement = document.getElementById('italy-map-fullscreen');
    if (mapElement) {
        try {
            // Inizializza la mappa Leaflet
            map = L.map(mapElement, {
                center: [42.5, 12.5], // Centro Italia
                zoom: 2,           // Zoom iniziale
                scrollWheelZoom: false,// Disabilita zoom con rotellina
                zoomControl: false,    // Nasconde i controlli +/- dello zoom
                // --- OPZIONE DA TESTARE per performance (decommenta se necessario) ---
                // preferCanvas: true
                // --------------------------------------------------------------------
            });

            // <<< 1. CREA UN PANNELLO PERSONALIZZATO PER I MARKER >>>
            // Questo assicura che i marker siano disegnati sopra altri layer come il GeoJSON.
            map.createPane('customMarkerPane');
            map.getPane('customMarkerPane').style.zIndex = 650; // Z-index > overlayPane (400), < popupPane (700)
            // Permette ai click di passare attraverso il pannello se non colpiscono il marker
            map.getPane('customMarkerPane').style.pointerEvents = 'none';

            // Aggiunge il Tile Layer CHIARO (Standard) da CartoDB
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OSM</a> © <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 10,
                minZoom: 5
            }).addTo(map);

            // --- Funzione per creare le icone colorate dei marker ---
            function createColoredIcon(color) {
                return L.divIcon({
                    className: 'custom-div-icon', // Utile per CSS aggiuntivo se serve
                    // Bordo scuro per visibilità su mappa chiara
                    html: `<div style='background-color:${color};width:14px;height:14px;border-radius:50%; border: 2px solid rgba(50,50,50,0.6); box-shadow: 0 1px 3px rgba(0,0,0,0.4);'></div>`,
                    iconSize: [14, 14], // Dimensioni icona
                    iconAnchor: [7, 7]   // Punto centrale come ancoraggio
                });
            }
            // Crea le istanze delle icone
            var greenIcon = createColoredIcon('#28a745'),
                yellowIcon = createColoredIcon('#ffc107'),
                redIcon = createColoredIcon('#dc3545');

            // --- Ciclo per creare e aggiungere i Marker alla mappa ---
            for (var regionName in regionData) {
                if (regionData.hasOwnProperty(regionName)) {
                    var data = regionData[regionName];
                    var icon, statusClass = '';
                    // Determina icona e classe CSS in base allo status
                    switch (data.status) {
                        case 'green': icon = greenIcon; statusClass = 'green'; break;
                        case 'yellow': icon = yellowIcon; statusClass = 'yellow'; break;
                        case 'red': icon = redIcon; statusClass = 'red'; break;
                        default: icon = L.divIcon({iconSize: [0,0]}); // Fallback: icona invisibile
                    }
                    // Crea il marker solo se ci sono coordinate valide
                    if (data.lat && data.lng) {
                        // <<< 2. ASSEGNA IL MARKER AL PANNELLO PERSONALIZZATO >>>
                        var marker = L.marker([data.lat, data.lng], {
                             icon: icon,                 // Usa l'icona colorata creata
                             pane: 'customMarkerPane'    // Importante: disegna sul nostro pannello personalizzato
                        }).addTo(map); // Aggiunge il marker alla mappa

                        // Crea il contenuto del popup
                        var popupContent = `<strong>${regionName}</strong><br>Stato Fondi: `;
                        if (statusClass) {
                            popupContent += `<span class='status-label ${statusClass}'>${data.label || data.status.charAt(0).toUpperCase() + data.status.slice(1)}</span>`;
                        } else {
                            popupContent += "N/D"; // Non disponibile
                        }
                        marker.bindPopup(popupContent); // Associa il popup al marker

                        // Memorizza il riferimento all'oggetto marker Leaflet
                        regionMarkers[regionName] = marker;
                    }
                }
            }
            // --- Fine Creazione Marker ---

            // --- Carica e Aggiungi il Layer GeoJSON dei Confini Regionali ---
            // <<< MODIFICA QUESTO PERCORSO SE IL TUO FILE È ALTROVE >>>
            fetch('assets/data/georef-italy-regione.geojson')
                .then(response => {
                    // Controlla se la richiesta HTTP ha avuto successo
                    if (!response.ok) { throw new Error(`Errore HTTP ${response.status} nel caricare il GeoJSON`); }
                    // Parsa la risposta come JSON
                    return response.json();
                })
                .then(geojsonData => {
                    // Crea il layer GeoJSON
                    geojsonLayer = L.geoJSON(geojsonData, {
                        style: defaultRegionStyle, // Applica lo stile di default
                        interactive: false,        // Impedisce interazioni dirette con i poligoni (es. click)
                        // --- OPZIONE DA TESTARE (se hai messo preferCanvas sulla mappa) ---
                        // preferCanvas: true
                        // -----------------------------------------------------------------
                        // Funzione eseguita per ogni feature (regione) nel GeoJSON
                        onEachFeature: function (feature, layer) {
                            // Popola l'oggetto lookup per accesso rapido
                            const featurePropertyName = 'reg_name'; // <<< Nome proprietà nel tuo GeoJSON
                            // Controlla che la proprietà esista prima di aggiungerla al lookup
                            if (feature?.properties?.[featurePropertyName]) {
                                const regionNameValue = feature.properties[featurePropertyName];
                                geojsonLayerLookup[regionNameValue] = layer; // Mappa: "Nome Regione" -> Oggetto Layer Leaflet
                            } else {
                                console.warn("Proprietà regione mancante o non trovata in una feature GeoJSON:", feature?.properties);
                            }
                        }
                    }).addTo(map); // Aggiunge il layer GeoJSON alla mappa

                    console.log("Layer GeoJSON delle regioni caricato e lookup creato.");

                    // <<< LA RIGA marker.bringToFront() È STATA RIMOSSA >>>
                    // L'ordine è ora gestito dai pannelli ('customMarkerPane').

                })
                .catch(error => {
                    // Cattura errori di rete o di parsing JSON
                    console.error('>>> ERRORE REALE Caricamento/Parsing GeoJSON:', error);
                    // Mostra un messaggio di errore visivo solo se il layer non è stato caricato
                    if (mapElement) {
                         const existingErrorMsg = document.getElementById('geojson-error-msg');
                         if (!existingErrorMsg && !geojsonLayer) { // Mostra solo se non c'è già e il layer è ancora null
                             mapElement.insertAdjacentHTML('beforeend', '<p id="geojson-error-msg" style="color:red;position:absolute;top:10px;left:10px;z-index:1000;background:rgba(255,255,255,0.7);padding:5px;border-radius:3px;">Errore caricamento confini.</p>');
                         }
                    }
                });
            // --- Fine Caricamento GeoJSON ---

            // Forza il ricalcolo delle dimensioni della mappa dopo un breve delay
            setTimeout(() => { if (map) map.invalidateSize(); }, 200);
            console.log("Mappa Leaflet inizializzata.");

        } catch (e) {
             console.error("Errore grave durante l'inizializzazione della mappa Leaflet:", e);
             if (mapElement) mapElement.innerHTML = "<p style='color:#555; text-align:center; padding-top: 50px;'>Impossibile caricare la mappa interattiva.</p>";
        }
    } else {
         console.log("Elemento contenitore della mappa (#italy-map-fullscreen) non trovato.");
    }
    // --- Fine Mappa Leaflet ---


    // --- Tom Select (Funzioni Helper e Inizializzazione) ---

    // Funzione per renderizzare le opzioni nel dropdown TomSelect
    function renderTomSelectOption(data, escape, includeIcon = false) {
        let details = '';
        const tsInstance = this;
        if (tsInstance?.settings?.originalElement && data.value) {
            const originalSelect = tsInstance.settings.originalElement;
            try {
                const escapedValue = CSS.escape ? CSS.escape(data.value) : escape(data.value);
                const originalOption = originalSelect.querySelector(`option[value="${escapedValue}"]`);
                if (originalOption) { details = originalOption.getAttribute('data-details') || ''; }
            } catch(e) { console.warn(`Errore querySelector opzione: ${data.value}`, e); }
        }
        let iconHtml = '';
        if (includeIcon && details) { iconHtml = `<i class="fa-regular fa-circle-info info-icon" title="${escape(details)}"></i>`; }
        return `<div class="ts-option"><span class="ts-option-text">${escape(data.text)}</span>${iconHtml}</div>`;
    }

    // Funzione Helper per inizializzare TomSelect e gestire la larghezza dinamica del dropdown
    function initializeTomSelectWithDynamicWidth(selectorId, userOptions = {}) {
        const element = document.getElementById(selectorId);
        if (!element) { console.warn(`Elemento #${selectorId} non trovato.`); return; }
        try {
            const defaultOptions = {
                create: false, dropdownParent: 'body',
                render: {
                    item: (data, escape) => `<div>${escape(data.text)}</div>`,
                    option: (data, escape) => renderTomSelectOption.call(this, data, escape, false)
                },
                onInitialize: function() { console.log(`TomSelect #${selectorId} inizializzato.`); },
                onDropdownOpen: function(dropdown) {
                    const wrapper = this.wrapper;
                    if (wrapper && dropdown) {
                        const wrapperWidth = wrapper.offsetWidth;
                        if (wrapperWidth > 0) { dropdown.style.minWidth = wrapperWidth + 'px'; }
                    }
                }
            };
            const finalOptions = { ...defaultOptions, ...userOptions };
            if (userOptions.render) { finalOptions.render = { ...defaultOptions.render, ...userOptions.render }; }
            if (userOptions.onChange) { finalOptions.onChange = userOptions.onChange; }
            new TomSelect(element, finalOptions);
        } catch (e) { console.error(`Errore TomSelect per #${selectorId}:`, e); }
    }

    // --- Inizializzazione Specifica dei Select ---

    // Opzioni per il select della Regione (#regione_hp)
    const regioneHpOptions = {
        sortField: { field: null }, // Mantiene l'ordine HTML

        // Funzione chiamata quando l'utente seleziona/deseleziona una regione
        onChange: function(value) { // 'value' è il nome della regione (es. "Lombardia") o null/""

            // 1. Resetta Subito lo Stile della Regione Precedentemente Evidenziata
            if (highlightedRegionLayer && geojsonLayer) {
                try { geojsonLayer.resetStyle(highlightedRegionLayer); }
                catch (e) { console.warn("Errore nel resettare lo stile:", e); }
                highlightedRegionLayer = null; // Rimuovi riferimento
            }

            // Chiudi subito eventuali popup dei marker aperti
            if (map) { map.closePopup(); }

            // 2. Gestisci la Nuova Selezione (o deselezione)
            if (map && value && regionData[value]) {
                // --- È stata selezionata una regione valida ---
                const regionInfo = regionData[value];

                if (regionInfo.lat && regionInfo.lng) {
                    // Definisci cosa fare DOPO che l'animazione flyTo è completata
                    const onFlyToEnd = function() {
                        console.log("Animazione flyTo terminata per:", value);

                        // 3. Evidenzia il Confine della Regione (usando il lookup)
                        if (geojsonLayer && geojsonLayerLookup[value]) {
                            const targetRegionLayer = geojsonLayerLookup[value];
                            targetRegionLayer.setStyle(highlightRegionStyle); // Applica stile highlight
                            highlightedRegionLayer = targetRegionLayer; // Memorizza riferimento
                            console.log(`Regione ${value} evidenziata dopo flyTo.`);
                        } else {
                            console.warn(`Layer GeoJSON o regione "${value}" non trovati nel lookup dopo flyTo.`);
                        }

                        // 4. Apri il Popup del Marker corrispondente
                        const targetMarker = regionMarkers[value];
                        if (targetMarker) {
                            targetMarker.openPopup();
                            console.log("Popup aperto dopo flyTo per:", value);
                        } else {
                             console.warn(`Marker non trovato per ${value} dopo flyTo.`);
                        }

                        // Rimuovi questo listener per evitare che si attivi di nuovo
                        map.off('moveend', onFlyToEnd);
                    };

                    // Registra il listener per l'evento 'moveend' (UNA SOLA volta)
                    map.once('moveend', onFlyToEnd);

                    // Avvia l'animazione flyTo
                    map.flyTo([regionInfo.lat, regionInfo.lng], 8, {
                        animate: true,
                        duration: 0.8 // Durata animazione (prova a variare)
                    });

                } else {
                     console.warn(`Lat/Lng mancanti per ${value}, impossibile eseguire flyTo.`);
                     // Reset stile e popup già fatti all'inizio
                }
            } else if (map) {
                // --- Nessuna Regione Selezionata o Valore Non Valido ---
                // Riporta la mappa alla vista generale
                map.flyTo([42.5, 12.5], 5.5, {
                    animate: true,
                    duration: 0.8
                });
                // Stile e popup già resettati/chiusi all'inizio
            }
        } // Fine onChange
    };
    // Inizializza TomSelect per la regione
    initializeTomSelectWithDynamicWidth('regione_hp', regioneHpOptions);

    // Opzioni per il select della Dimensione PMI (#dimensione_pmi_hp)
    const dimensioneHpOptions = {
        sortField: { field: null },
        allowEmptyOption: false,
        render: { // Mostra icona info
           option: function(data, escape) { return renderTomSelectOption.call(this, data, escape, true); }
        }
    };
     // Inizializza TomSelect per la dimensione PMI
    initializeTomSelectWithDynamicWidth('dimensione_pmi_hp', dimensioneHpOptions);
    // --- Fine Tom Select ---

    console.log("Script principale (DOMContentLoaded) eseguito completamente.");
  }); // Fine DOMContentLoaded
</script>

</body>
</html>