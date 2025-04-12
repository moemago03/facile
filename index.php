<?php
// index.php

// --- Configurazione SEO e Titolo Pagina ---
$pageTitle = "Facile Agevolazioni | Trova Bandi e Finanziamenti per la Tua PMI";
$pageDescription = "Scopri bandi, finanziamenti agevolati e contributi a fondo perduto per la tua Micro, Piccola o Media Impresa in Italia. Inizia la ricerca gratuita.";
// Assicurati che l'URL canonico sia corretto per la tua installazione
$canonicalUrl = "https://www.facileagevolazioni.it/"; // Esempio

// --- Inclusione Header ---
// Presuppone che header.php contenga: <!DOCTYPE>, <html>, <head> (con <title>, meta description, canonical, link a Bootstrap CSS, TomSelect CSS, style.css, Google Fonts), <body>, Navbar
include 'includes/header.php';
?><head>
    <link rel="stylesheet" href="css/style.css">
</head>
<!-- ============================================= -->
<!-- =========     HERO SECTION START      ========= -->
<!-- ============================================= -->
<section class="hero-section text-center">
    <div class="container">
        <!-- Titolo Principale (H1) -->
        <h1>Trova i Fondi Giusti per Far Crescere la Tua Impresa</h1>

        <!-- Sottotitolo / Descrizione Breve -->
        <p class="sub-headline lead px-md-5">
            Accedi a bandi regionali, nazionali ed europei, finanziamenti agevolati e contributi a fondo perduto per le PMI italiane.
            <br> Inizia la tua ricerca gratuita in pochi secondi.
        </p>

        <!-- Form di Ricerca Iniziale -->
        <div class="search-form-container mt-4 mx-auto">
            <form action="tool.php" method="get" id="home-search-form" class="needs-validation" novalidate>
                <!-- Campo nascosto per passare allo step 1 del tool -->
                <input type="hidden" name="step" value="1">

                <div class="row g-3 justify-content-center align-items-center">
                    <!-- Input Regione -->
                    <div class="col-md-5">
                        <label for="regione" class="form-label visually-hidden">Regione</label>
                        <select id="regione" name="regione" placeholder="Seleziona la tua Regione..." required>
                            <option value="">Seleziona la tua Regione...</option>
                            <option value="Abruzzo">Abruzzo</option>
                            <option value="Basilicata">Basilicata</option>
                            <option value="Calabria">Calabria</option>
                            <option value="Campania">Campania</option>
                            <option value="Emilia-Romagna">Emilia-Romagna</option>
                            <option value="Friuli-Venezia Giulia">Friuli-Venezia Giulia</option>
                            <option value="Lazio">Lazio</option>
                            <option value="Liguria">Liguria</option>
                            <option value="Lombardia">Lombardia</option>
                            <option value="Marche">Marche</option>
                            <option value="Molise">Molise</option>
                            <option value="Piemonte">Piemonte</option>
                            <option value="Puglia">Puglia</option>
                            <option value="Sardegna">Sardegna</option>
                            <option value="Sicilia">Sicilia</option>
                            <option value="Toscana">Toscana</option>
                            <option value="Trentino-Alto Adige">Trentino-Alto Adige</option>
                            <option value="Umbria">Umbria</option>
                            <option value="Valle d'Aosta">Valle d'Aosta</option>
                            <option value="Veneto">Veneto</option>
                        </select>
                        <div class="invalid-feedback">Per favore, seleziona una regione.</div>
                    </div>

                    <!-- Input Dimensione PMI -->
                    <div class="col-md-5">
                        <label for="dimensione_pmi" class="form-label visually-hidden">Dimensione PMI</label>
                        <select id="dimensione_pmi" name="dimensione_pmi" placeholder="Seleziona la Dimensione..." required>
                            <option value="">Seleziona la Dimensione...</option>
                            <option value="Micro Impresa (meno di 10 dipendenti e fatturato/bilancio <= €2M)">Micro Impresa</option>
                            <option value="Piccola Impresa (meno di 50 dipendenti e fatturato/bilancio <= €10M)">Piccola Impresa</option>
                            <option value="Media Impresa (meno di 250 dipendenti e fatturato <= €50M o bilancio <= €43M)">Media Impresa</option>
                            <!-- <option value="Non sono una PMI">Non sono una PMI</option> -->
                             <!-- Nota: Valutare se gestire il caso "Non sono una PMI" o rimuoverlo se il target è solo PMI -->
                        </select>
                         <div class="invalid-feedback">Per favore, seleziona la dimensione della tua impresa.</div>
                    </div>

                    <!-- Bottone Submit -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Cerca</button> <!-- Modificato testo e aggiunto w-100 per consistenza -->
                    </div>
                </div>

                <!-- Micro-testo sotto il form -->
                 <p class="form-microcopy mt-3"><small>Dati necessari per filtrare le opportunità iniziali.</small></p>
            </form>
        </div>
         <!-- Fine search-form-container -->

    </div> <!-- Fine container -->
</section>
<!-- ============================================= -->
<!-- =========      HERO SECTION END       ========= -->
<!-- ============================================= -->


<!-- ============================================= -->
<!-- ========= HOW IT WORKS SECTION START  ========= -->
<!-- ============================================= -->
<section class="how-it-works-section section-padding">
    <div class="container">
        <h2 class="section-title text-center">Come Trovare Agevolazioni in 3 Semplici Passi</h2>
        <div class="row g-4 justify-content-center text-center">
            <!-- Step 1 Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="step-card w-100">
                     <div class="step-icon mb-3">
                         <img src="assets/icons/step-location.svg" alt="Icona Mappa Regione" style="width: 50px; height: auto;"> <!-- Esempio Icona SVG -->
                     </div>
                    <h3 class="step-title h5">1. Indica Regione e Dimensione</h3>
                    <p class="step-description">Seleziona dove opera la tua impresa e la sua classificazione (Micro, Piccola, Media). Ottieni subito una lista preliminare.</p>
                </div>
            </div>
            <!-- Step 2 Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="step-card w-100">
                     <div class="step-icon mb-3">
                        <img src="assets/icons/step-filter.svg" alt="Icona Filtri Progetto" style="width: 50px; height: auto;"> <!-- Esempio Icona SVG -->
                     </div>
                    <h3 class="step-title h5">2. Specifica i Tuoi Progetti</h3>
                    <p class="step-description">Aggiungi dettagli come il tipo di investimento (software, macchinari, energia, consulenze) per affinare la ricerca.</p>
                </div>
            </div>
            <!-- Step 3 Card -->
            <div class="col-md-6 col-lg-4 d-flex">
                <div class="step-card w-100">
                     <div class="step-icon mb-3">
                        <img src="assets/icons/step-contact.svg" alt="Icona Documento e Contatto" style="width: 50px; height: auto;"> <!-- Esempio Icona SVG -->
                     </div>
                    <h3 class="step-title h5">3. Ricevi Risultati e Consulenza</h3>
                    <p class="step-description">Visualizza i bandi più adatti e, se vuoi, richiedi una consulenza gratuita e senza impegno con un nostro esperto partner.</p>
                </div>
            </div>
        </div> <!-- Fine row -->
    </div> <!-- Fine container -->
</section>
<!-- ============================================= -->
<!-- =========  HOW IT WORKS SECTION END   ========= -->
<!-- ============================================= -->


<!-- ============================================= -->
<!-- =========   BENEFITS SECTION START    ========= -->
<!-- ============================================= -->
<section class="benefits-section section-padding bg-light">
    <div class="container">
        <h2 class="section-title text-center">Perché Affidarsi a Facile Agevolazioni?</h2>
        <div class="row g-4">
            <!-- Benefit Card 1 -->
            <div class="col-md-6 col-lg-3 d-flex">
                <div class="benefit-card text-center w-100">
                    <div class="benefit-icon mb-3">
                        <img src="assets/icons/benefit-time.svg" alt="Icona Orologio" style="width: 45px; height: auto;"> <!-- Esempio Icona SVG -->
                    </div>
                    <h3 class="benefit-title h6">Risparmia Tempo Prezioso</h3>
                    <p class="benefit-description">Basta ricerche infinite. Centralizziamo le informazioni aggiornate sui bandi attivi per te.</p>
                </div>
            </div>
            <!-- Benefit Card 2 -->
            <div class="col-md-6 col-lg-3 d-flex">
                <div class="benefit-card text-center w-100">
                     <div class="benefit-icon mb-3">
                         <img src="assets/icons/benefit-target.svg" alt="Icona Bersaglio" style="width: 45px; height: auto;"> <!-- Esempio Icona SVG -->
                    </div>
                    <h3 class="benefit-title h6">Informazioni Mirate</h3>
                    <p class="benefit-description">Filtri intelligenti ti mostrano solo le agevolazioni realmente accessibili per la tua specifica situazione.</p>
                </div>
            </div>
            <!-- Benefit Card 3 -->
            <div class="col-md-6 col-lg-3 d-flex">
                <div class="benefit-card text-center w-100">
                     <div class="benefit-icon mb-3">
                        <img src="assets/icons/benefit-expert.svg" alt="Icona Consulente" style="width: 45px; height: auto;"> <!-- Esempio Icona SVG -->
                    </div>
                    <h3 class="benefit-title h6">Supporto Esperto Gratuito</h3>
                    <p class="benefit-description">Entra in contatto con consulenti specializzati in finanza agevolata, pronti a guidarti senza impegno.</p>
                </div>
            </div>
            <!-- Benefit Card 4 -->
            <div class="col-md-6 col-lg-3 d-flex">
                <div class="benefit-card text-center w-100">
                    <div class="benefit-icon mb-3">
                        <img src="assets/icons/benefit-growth.svg" alt="Icona Grafico Crescita" style="width: 45px; height: auto;"> <!-- Esempio Icona SVG -->
                    </div>
                    <h3 class="benefit-title h6">Accelera la Tua Crescita</h3>
                    <p class="benefit-description">Sblocca le risorse finanziarie necessarie per investire in innovazione, macchinari, personale e sostenibilità.</p>
                </div>
            </div>
        </div> <!-- Fine row -->
    </div> <!-- Fine container -->
</section>
<!-- ============================================= -->
<!-- =========    BENEFITS SECTION END     ========= -->
<!-- ============================================= -->


<!-- ============================================= -->
<!-- =========      CTA SECTION START      ========= -->
<!-- ============================================= -->
<section class="cta-section section-padding">
    <div class="container text-center">
        <h2 class="section-title">Non Rimandare la Crescita della Tua Impresa</h2>
        <p class="lead mb-4">Scopri subito le agevolazioni a cui puoi accedere. La ricerca è semplice e gratuita.</p>
        <!-- Bottone che riporta al form in cima e mette il focus sul primo campo -->
        <a href="#home-search-form" class="btn btn-primary btn-lg" onclick="document.getElementById('regione').focus(); return false;">
            Inizia Ora la Tua Ricerca
        </a>
    </div> <!-- Fine container -->
</section>
<!-- ============================================= -->
<!-- =========       CTA SECTION END       ========= -->
<!-- ============================================= -->


<?php
// --- Inclusione Footer ---
// Presuppone che footer.php contenga: Contenuto del footer (copyright, link privacy, ecc.), link a JS (Bootstrap Bundle, TomSelect, choices-init.js, altri script custom), </body>, </html>
include 'includes/footer.php';
?>