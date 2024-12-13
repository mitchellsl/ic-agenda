<?php
// AJAX-handler voor het filteren van evenementen
function ic_agenda_ajax_filter_events() {
    // Haal de geselecteerde maanden en jaren op uit het POST-verzoek
    $months = isset($_POST['months']) ? $_POST['months'] : ['all'];
    $years = isset($_POST['years']) ? $_POST['years'] : ['all'];

    // Roep de functie aan om de gefilterde evenementenlijst te genereren
    ic_agenda_render_event_list($months, $years);

    // Stop de uitvoering van het script
    wp_die();
}

// Registreer de AJAX-acties voor ingelogde en niet-ingelogde gebruikers
add_action('wp_ajax_ic_agenda_filter_events', 'ic_agenda_ajax_filter_events');
add_action('wp_ajax_nopriv_ic_agenda_filter_events', 'ic_agenda_ajax_filter_events');
