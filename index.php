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
        const regionData = <?php echo $map_data_json; ?>; // Assicurati che questa variabile PHP sia definita e contenga JSON valido

        // --- Mappa Leaflet ---
        var mapElement = document.getElementById('italy-map-fullscreen');
        if (mapElement) {
            try {
                map = L.map(mapElement, {
                    center: [42.5, 12.5],
                    zoom: 0,
                    scrollWheelZoom: false,
                    zoomControl: false
                });
                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OSM</a> © <a href="https://carto.com/attributions">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 12,
                    minZoom: 5
                }).addTo(map);

                function createColoredIcon(color) {
                    return L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style='background-color:${color};width:14px;height:14px;border-radius:50%; border: 2px solid rgba(255,255,255,0.7); box-shadow: 0 1px 3px rgba(0,0,0,0.4);'></div>`,
                        iconSize: [14, 14],
                        iconAnchor: [7, 7]
                    });
                }
                var greenIcon = createColoredIcon('#28a745'),
                    yellowIcon = createColoredIcon('#ffc107'),
                    redIcon = createColoredIcon('#dc3545');

                for (var regionName in regionData) {
                    if (regionData.hasOwnProperty(regionName)) {
                        var data = regionData[regionName],
                            icon, statusClass;
                        switch (data.status) {
                            case 'green': icon = greenIcon; statusClass = 'green'; break;
                            case 'yellow': icon = yellowIcon; statusClass = 'yellow'; break;
                            case 'red': icon = redIcon; statusClass = 'red'; break;
                            default: icon = L.divIcon(); statusClass = '';
                        }
                        if (data.lat && data.lng) {
                            var marker = L.marker([data.lat, data.lng], { icon: icon }).addTo(map);
                            var popupContent = `<strong>${regionName}</strong><br>Stato Fondi: `;
                            if (statusClass) {
                                popupContent += `<span class='status-label ${statusClass}'>${data.label || 'Disponibile'}</span>`; // Aggiunto fallback label
                            } else {
                                popupContent += "N/D";
                            }
                            marker.bindPopup(popupContent);
                        }
                    }
                }
                // Invalidate map size dopo un breve ritardo per assicurare il rendering corretto
                setTimeout(() => { if (map) map.invalidateSize(); }, 200);
            } catch (e) {
                console.error("Mappa Errore:", e);
                if (mapElement) mapElement.innerHTML = "<p>Errore nel caricamento della mappa.</p>"; // Feedback utente
            }
        } else {
             console.log("Elemento #italy-map-fullscreen non trovato.");
        }

        // --- Tom Select ---

        // Funzione helper per renderizzare le opzioni con icona info (se presente data-details)
        function renderTomSelectOption(data, escape, includeIcon = false) {
            let details = '';
            // Correggi il modo di accedere all'elemento originale e all'opzione
            const tsInstance = this; // 'this' è l'istanza di TomSelect
            if (tsInstance && tsInstance.settings && tsInstance.settings.originalElement && data.value) {
                const originalSelect = tsInstance.settings.originalElement;
                const originalOption = originalSelect.querySelector(`option[value="${escape(data.value)}"]`);
                if (originalOption) {
                    details = originalOption.getAttribute('data-details') || '';
                }
            }

            let iconHtml = '';
            if (includeIcon && details) {
                // Usa l'escape corretto per l'attributo title
                iconHtml = `<i class="fa-regular fa-circle-info info-icon" title="${escape(details)}"></i>`;
            }
            // Usa l'escape corretto per il testo dell'opzione
            return `<div class="ts-option"><span class="ts-option-text">${escape(data.text)}</span>${iconHtml}</div>`;
        }

        // Inizializzazione TomSelect per REGIONE
        var regioneSelect = document.getElementById('regione_hp');
        if (regioneSelect) {
            try {
                new TomSelect(regioneSelect, {
                    create: false,
                    sortField: { field: null }, // Mantieni l'ordine originale se necessario
                    render: {
                        option: function(data, escape) { return renderTomSelectOption.call(this, data, escape, false); }, // Passa 'this' e escape
                        item: function(data, escape) { return `<div>${escape(data.text)}</div>`; } // Escape anche qui
                    },
                    onChange: function(value) {
                        if (map && value && regionData[value]) {
                            const r = regionData[value];
                            if (r.lat && r.lng) map.flyTo([r.lat, r.lng], 8, { animate: true, duration: 1.0 });
                        } else if (map && !value) {
                            // Torna alla vista iniziale se nessuna regione è selezionata
                            map.flyTo([42.5, 12.5], 5.5, { animate: true, duration: 1.0 });
                        }
                    },
                    // *** AGGIUNTA CHIAVE QUI ***
                    dropdownParent: 'body'
                    // **************************
                });
                console.log("TomSelect per Regione HP inizializzato.");
            } catch (e) {
                console.error("TS Regione Errore:", e);
            }
        } else {
             console.log("Elemento #regione_hp non trovato.");
        }

        // Inizializzazione TomSelect per DIMENSIONE PMI
        var dimensioneSelect = document.getElementById('dimensione_pmi_hp');
        if (dimensioneSelect) {
            try {
                new TomSelect(dimensioneSelect, {
                    create: false,
                    sortField: { field: null }, // Mantieni l'ordine originale
                    allowEmptyOption: false, // Impedisce la deselezione se non c'è opzione vuota
                    render: {
                       option: function(data, escape) { return renderTomSelectOption.call(this, data, escape, true); }, // Passa 'this' e escape, abilita icona
                       item: function(data, escape) { return `<div>${escape(data.text)}</div>`; } // Escape anche qui
                    },
                    // *** AGGIUNTA CHIAVE QUI ***
                    dropdownParent: 'body'
                    // **************************
                });
                 console.log("TomSelect per Dimensione PMI HP inizializzato.");
            } catch (e) {
                console.error("TS Dimensione Errore:", e);
            }
        } else {
             console.log("Elemento #dimensione_pmi_hp non trovato.");
        }
      });
    </script>

</body>
</html>