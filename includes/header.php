<?php
// File: includes/header.php
// Questo file contiene l'HTML per l'header globale.
// La pagina chiamante (index.php o tool.php) può definire
// la classe del body per differenziare lo stile (es. homepage).

// Determina il percorso base se necessario (opzionale, utile se gli include sono in sottocartelle)
// $base_path = '/'; // Adatta se il sito non è nella root del dominio

// Recupera la classe del body definita nella pagina chiamante (se definita)
// Non è strettamente necessario qui, ma utile per debug o logica futura.
global $body_class; // Usa global se definisci $body_class prima dell'include
$current_body_class = $body_class ?? ''; // Fallback a stringa vuota

?>
<header class="tool-header <?php echo ($current_body_class === 'homepage') ? 'initially-transparent' : 'initially-solid'; ?>">
    <div class="header-container main-container">
         <div class="logo">
             <!-- Usa UN solo logo, preferibilmente scuro o SVG. CSS gestirà il colore. -->
             <a href="/"><img src="img/logo_dark.png" alt="Facile Agevolazioni" class="logo"></a>
             <!-- Se usi SVG: -->
             <!-- <a href="/"><img src="/img/logo.svg" alt="Logo NomeServizio" class="logo-svg"></a> -->
         </div>
         <div class="header-actions">
             <a href="/assistenza" title="Assistenza Clienti" aria-label="Assistenza Clienti"><i class="fas fa-headset"></i></a>
             <a href="/login" title="Area Riservata" aria-label="Area Riservata / Login"><i class="fas fa-user-circle"></i></a>
         </div>
    </div>
</header>
<style>
.logo {
    max-width:60px;
}
</style>