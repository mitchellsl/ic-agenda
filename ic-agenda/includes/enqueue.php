<?php

function ic_agenda_enqueue_styles_scripts() {
    wp_enqueue_style('ic-agenda-styles', plugin_dir_url(__FILE__) . '../style.css');
    wp_enqueue_script('ic-agenda-filters', plugin_dir_url(__FILE__) . '../assets/js/ic-agenda-filters.js', ['jquery'], null, true);
    wp_enqueue_script('ic-agenda-modal', plugin_dir_url(__FILE__) . '../assets/js/ic-agenda-modal.js', ['jquery'], null, true);
    wp_localize_script('ic-agenda-filters', 'ic_agenda', ['ajax_url' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'ic_agenda_enqueue_styles_scripts');

