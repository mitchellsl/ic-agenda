<?php

// Voeg actie toe voor het verwerken van meta velden en categorieën bij het opslaan van een evenement
add_action('save_post_events', 'process_event_meta_and_category', 99, 3);

function process_event_meta_and_category($post_id, $post, $update) {
    // Controleer of de gebruiker gemachtigd is om de post op te slaan
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Controleer of het bericht al in de database staat en niet een revisie of autosave is
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        error_log("Post ID $post_id is een revisie of autosave, functie afgebroken.");
        return;
    }

    // Controleer of de aangepaste velden beschikbaar zijn
    if (!isset($_POST['date-time-picker']) || empty($_POST['date-time-picker'])) {
        error_log("Geen datumwaarde gevonden in POST voor post ID $post_id, functie afgebroken.");
        return;
    }

    // Haal de waarde van de datum op uit het aangepaste veld
    $date_value = sanitize_text_field($_POST['date-time-picker']);
    error_log("Datumwaarde opgehaald voor post ID $post_id: " . print_r($date_value, true));

    if (!empty($date_value)) {
        try {
            // Controleer of de waarde een Unix timestamp is en maak een DateTime-object
            if (is_numeric($date_value)) {
                $date = new DateTime();
                $date->setTimestamp((int)$date_value);
            } else {
                $date = new DateTime($date_value);
            }
        } catch (Exception $e) {
            error_log("Fout bij het maken van DateTime object: " . $e->getMessage());
            return;
        }

        // Vertaal de maand naar het Nederlands
        $dutch_months = [
            'January' => 'januari', 'February' => 'februari', 'March' => 'maart',
            'April' => 'april', 'May' => 'mei', 'June' => 'juni',
            'July' => 'juli', 'August' => 'augustus', 'September' => 'september',
            'October' => 'oktober', 'November' => 'november', 'December' => 'december'
        ];

        $year = $date->format('Y');
        $month_english = $date->format('F');
        $month_number = $date->format('m'); // Maand als getal (01, 02, etc.)
        $month_name = $dutch_months[$month_english] ?? $month_english; // Vertaal maand
        $day = $date->format('d');

        // Formatteer de datum als "11 December 2024"
        $formatted_date = "$day " . ucfirst($month_name) . " $year";

        // Sla de meta velden op
        update_post_meta($post_id, 'event_year', $year);
        update_post_meta($post_id, 'event_month', $month_number);
        update_post_meta($post_id, 'event_day', $day);
        update_post_meta($post_id, 'formatted_event_date', $formatted_date);

        error_log("Meta velden opgeslagen voor post ID $post_id: Jaar - $year, Maand - $month_number, Dag - $day, Geformatteerde Datum - $formatted_date");

        // Koppel de maandnaam en het jaartal aan categorieën
        assign_categories_to_post($post_id, [
            ['term_name' => ucfirst($month_name), 'taxonomy' => 'event_category', 'type' => 'Maand'],
            ['term_name' => $year, 'taxonomy' => 'event_category', 'type' => 'Jaar'],
        ]);

        // Stel de postdatum gelijk aan de waarde van het aangepaste veld
        $post_date = $date->format('Y-m-d H:i:s');
        remove_action('save_post_events', 'process_event_meta_and_category', 99);
        $post_data = [
            'ID' => $post_id,
            'post_date' => $post_date,
            'post_date_gmt' => get_gmt_from_date($post_date),
            'post_status' => 'publish',
        ];

        wp_update_post($post_data);
        add_action('save_post_events', 'process_event_meta_and_category', 99, 3);
    } else {
        error_log("Geen datumwaarde gevonden voor post ID $post_id, functie afgebroken.");
    }
}

/**
 * Algemene functie om categorieën toe te wijzen aan een post zonder duplicaten
 */
function assign_categories_to_post($post_id, $terms_data) {
    foreach ($terms_data as $term_data) {
        $term_name = $term_data['term_name'];
        $taxonomy = $term_data['taxonomy'];
        $type = $term_data['type'];

        // Haal de bestaande termen van het bericht op
        $existing_terms = wp_get_post_terms($post_id, $taxonomy, ['fields' => 'names']);

        // Controleer of de term al is gekoppeld aan de post
        if (in_array($term_name, $existing_terms)) {
            error_log("Term '$term_name' bestaat al voor post ID $post_id, overslaan.");
            continue;
        }

        // Haal de term op of maak deze aan als deze niet bestaat
        $term = get_term_by('name', $term_name, $taxonomy);

        if (!$term) {
            // Voeg de term toe als deze niet bestaat
            $new_term = wp_insert_term($term_name, $taxonomy);
            if (!is_wp_error($new_term)) {
                $term_id = $new_term['term_id'];
                error_log("Nieuwe $type term aangemaakt: $term_name met term ID $term_id voor post ID $post_id");
            } else {
                error_log("Fout bij het aanmaken van $type term $term_name: " . $new_term->get_error_message());
                continue;
            }
        } else {
            $term_id = $term->term_id;
            error_log("Bestaande $type term gevonden: $term_name met term ID $term_id voor post ID $post_id");
        }

        // Koppel de term aan de post
        if (!empty($term_id)) {
            wp_set_post_terms($post_id, [$term_id], $taxonomy, true);
            error_log("$type Term ID $term_id gekoppeld aan post ID $post_id");
        }
    }
}
