<?php
function ic_agenda_render_event_list($months = [], $years = []) {
    $meta_query = ['relation' => 'AND'];

    // Controleer of "Alle Maanden" geselecteerd is
    $all_months_selected = in_array('all', $months) || empty($months);
    if (!$all_months_selected) {
        // Alleen toevoegen als een specifieke maand is geselecteerd
        $meta_query[] = [
            'key'     => 'event_month',
            'value'   => $months,
            'compare' => 'IN',
        ];
    }

    // Controleer of "Alle Jaren" geselecteerd is
    $all_years_selected = in_array('all', $years) || empty($years);
    if (!$all_years_selected) {
        // Alleen toevoegen als een specifiek jaar is geselecteerd
        $meta_query[] = [
            'key'     => 'event_year',
            'value'   => $years,
            'compare' => 'IN',
        ];
    }

    // Query voor het ophalen van evenementen
    $query_args = [
        'post_type'      => 'events',
        'posts_per_page' => -1,
        'meta_query'     => $meta_query,
        'orderby'        => 'meta_value', // Voeg dit toe als je sorteert op een specifieke meta_key
        'order'          => 'ASC',
    ];

    // Zorg ervoor dat je ook op de juiste meta_key sorteert, bijvoorbeeld 'event_date'
    if (!$all_months_selected || !$all_years_selected) {
        $query_args['meta_key'] = 'event_date'; // Zorg ervoor dat 'event_date' goed ingesteld is
    }

    $query = new WP_Query($query_args);

    if ($query->have_posts()) {
        echo '<div class="events-grid">';
        while ($query->have_posts()) {
            $query->the_post();
            include plugin_dir_path(__FILE__) . 'event-item.php';
        }
        echo '</div>';
    } else {
        // Melding wanneer er geen evenementen zijn
        echo '<p class="no-events-message">Geen evenementen gevonden voor de opgegeven filters.</p>';
    }

    wp_reset_postdata();
}

?>
