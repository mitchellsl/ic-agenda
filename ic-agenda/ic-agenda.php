<?php
/**
 * Plugin Name: IT Circle Agenda Plug-in
 * Description: Een agenda plug-in om de events welke IT Circle Nederland heeft te tonen op de daarvoor bestemde pagina
 * Version: 1.1
 * Author: Mitchell Kamp
 * URI: https://sociallane.nl/
 */

// Block direct access
if (!defined('ABSPATH')) {
    exit;
}

// Inclusie van de afzonderlijke bestanden
require_once plugin_dir_path(__FILE__) . 'includes/post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-fields.php';
require_once plugin_dir_path(__FILE__) . 'includes/filters.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/enqueue.php';
require_once plugin_dir_path(__FILE__) . 'includes/post-meta.php';
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes/combined-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes/event-cards-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/render/event-list.php';


