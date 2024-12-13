<?php

function ic_agenda_generate_filter_options() {
    global $wpdb;

    $months = $wpdb->get_col("
        SELECT DISTINCT meta_value 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = 'event_month'
    ");

    $years = $wpdb->get_col("
        SELECT DISTINCT meta_value 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = 'event_year'
    ");

    // Sorteer de maanden oplopend
    sort($months);

    // Sorteer de jaren oplopend
    sort($years);

    return [
        'months' => $months,
        'years' => $years,
    ];
}
