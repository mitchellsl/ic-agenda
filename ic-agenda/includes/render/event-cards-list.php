<?php
if (isset($query) && $query->have_posts()) {
    echo '<div class="ic-agenda-event-cards">';

    while ($query->have_posts()) {
        $query->the_post();
        $event_id = get_the_ID();
        $day = get_post_meta($event_id, 'event_day', true);
        $month_number = get_post_meta($event_id, 'event_month', true);
        $year = get_post_meta($event_id, 'event_year', true);
        $event_details = get_post_meta($event_id, 'evenement_details', true);
        $start_time = get_post_meta($event_id, 'begintijd_', true);
        $end_time = get_post_meta($event_id, 'eindtijd', true);
        $image_url = get_the_post_thumbnail_url($event_id, 'full');
        $knop_url = get_post_meta($event_id, 'knop_url', true);

        // Maandnamen in hoofdletters
        $month_names = [
            '01' => 'JAN', '02' => 'FEB', '03' => 'MAR', '04' => 'APR',
            '05' => 'MEI', '06' => 'JUN', '07' => 'JUL', '08' => 'AUG',
            '09' => 'SEP', '10' => 'OKT', '11' => 'NOV', '12' => 'DEC'
        ];
        $formatted_month = $month_names[$month_number];

        echo '<div class="event-item-card" 
                  data-title="' . esc_attr(get_the_title()) . '"
                  data-details="' . esc_attr($event_details) . '"
                  data-date="' . esc_attr("$day $formatted_month $year") . '"
                  data-time="' . esc_attr($start_time . ' - ' . $end_time) . '"
                  data-image="' . esc_url($image_url) . '"
                  data-knop-url="' . esc_url($knop_url) . '">';

        if ($image_url) {
            echo '<div class="event-image-container">';
            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
            echo '</div>';
        }

        echo '<div class="event-date-short">';
        echo '<span class="event-day-short">' . esc_html($day) . '</span>';
        echo '<span class="event-month-short">' . esc_html($formatted_month) . '</span>';
        echo '</div>';

        echo '<h3 class="event-title">' . get_the_title() . '</h3>';
        echo '</div>';
    }

    echo '</div>';
} else {
    echo '<p>Geen toekomstige evenementen gevonden.</p>';
}

wp_reset_postdata();
