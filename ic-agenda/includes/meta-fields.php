<?php
// Meta fields toevoegen
function ic_agenda_register_meta_fields() {
    register_meta('post', 'date-time-picker', [
        'type' => 'string',
        'description' => 'Datum en tijd van het evenement',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'begintijd_', [
        'type' => 'string',
        'description' => 'Begintijd van het evenement',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'eindtijd', [
        'type' => 'string',
        'description' => 'Eindtijd van het evenement',
        'single' => true,
        'show_in_rest' => true,
    ]);
    // Nieuw meta-veld voor samengestelde datum
    register_meta('post', 'event_date', [
        'type' => 'string',
        'description' => 'Gecombineerde datum voor sortering',
        'single' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'ic_agenda_register_meta_fields');

// Opsplitsen van date-time-picker en aanmaken van event_date
add_action('save_post', function($post_id) {
    if (get_post_type($post_id) !== 'events') return;

    $datetime = get_post_meta($post_id, 'date-time-picker', true);
    if ($datetime) {
        $timestamp = strtotime($datetime);
        $day = date('d', $timestamp);
        $month = date('m', $timestamp);
        $year = date('Y', $timestamp);
        $event_date = date('Y-m-d', $timestamp);

        // Meta velden bijwerken
        update_post_meta($post_id, 'event_day', $day);
        update_post_meta($post_id, 'event_month', $month);
        update_post_meta($post_id, 'event_year', $year);
        update_post_meta($post_id, 'event_date', $event_date);
    }
});
