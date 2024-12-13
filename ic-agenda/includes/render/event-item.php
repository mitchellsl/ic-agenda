<?php
// Huidige datum ophalen in 'd-m-Y' formaat
$today = date('d-m-Y');

// Haal de benodigde gegevens van het evenement op
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

// Evenementdatum samenstellen in 'd-m-Y' formaat
$event_date = sprintf('%02d-%02d-%s', $day, $month_number, $year);

// Controleer of het evenement vandaag is
$is_today = ($event_date === $today) ? ' event-today' : '';
?>

<div class="event-item<?php echo esc_attr($is_today); ?>" 
     data-title="<?php echo esc_attr(get_the_title()); ?>"
     data-details="<?php echo esc_attr($event_details); ?>"
     data-date="<?php echo esc_attr("$day $formatted_month $year"); ?>"
     data-time="<?php echo esc_attr($start_time . ' - ' . $end_time); ?>"
     data-image="<?php echo esc_url($image_url); ?>"
     data-knop-url="<?php echo esc_url($knop_url); ?>">

    <?php if ($image_url): ?>
        <div class="event-image-container-large">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
        </div>
    <?php endif; ?>

    <h3><?php the_title(); ?></h3>

    <div class="event-date">
        <span class="event-day"><?php echo esc_html($day); ?></span>
        <span class="event-month"><?php echo esc_html($formatted_month); ?></span>
        <span class="event-year"><?php echo esc_html($year); ?></span>
    </div>
</div>
