document.addEventListener('DOMContentLoaded', function() {
    const progressBarFill = document.getElementById('progress-bar-fill');

    if (progressBarFill) {
        // Leggi la percentuale target finale dall'attributo data-progress
        const targetProgress = parseFloat(progressBarFill.getAttribute('data-progress') || '0');

        // --- Animazione Riempimento ---

        // 1. Imposta VISIVAMENTE la larghezza a 0% all'inizio dello script
        //    (sovrascrive temporaneamente lo stile inline di PHP)
        progressBarFill.style.width = '0%';

        // 2. Forza il browser a registrare lo 0%
        progressBarFill.offsetHeight; // Forza reflow

        // 3. Applica la larghezza target dopo un istante
        //    La transizione CSS sulla proprietà 'width' farà l'animazione.
        requestAnimationFrame(() => {
            progressBarFill.style.width = targetProgress + '%';
        });

        // Gestione colore (rimane come prima, basato sulla classe 'has-progress' impostata da PHP)
        // Se vuoi animare anche il colore da grigio a verde all'avanzamento:
        //progressBarFill.classList.remove('has-progress');
        //progressBarFill.offsetHeight; // Altro reflow
        //if (targetProgress > 0) {
        //    requestAnimationFrame(() => {
        //         progressBarFill.classList.add('has-progress');
        //    });
        //}

    }

    // --- Altre funzionalità JS ---
});