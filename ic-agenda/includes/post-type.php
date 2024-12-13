<?php

function ic_agenda_register_post_type() {
    register_post_type('events', [
        'labels' => [
            'name' => __('Evenementen'),
            'singular_name' => __('Evenement'),
        ],
        'public' => true,
        'has_archive' => true,
        'supports'           => ['title', 'thumbnail', 'excerpt', 'custom-fields'],
    ]);
}
add_action('init', 'ic_agenda_register_post_type');
