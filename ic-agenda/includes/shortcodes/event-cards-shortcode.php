<?php
function ic_agenda_event_card_shortcode($atts) {
    ob_start();

    $current_date = date('Y-m-d');

    $query = new WP_Query([
        'post_type'      => 'events',
        'posts_per_page' => 2,
        'meta_query'     => [
            [
                'key'     => 'event_date',
                'value'   => $current_date,
                'compare' => '>=',
                'type'    => 'DATE',
            ],
        ],
        'orderby'        => 'meta_value',
        'meta_key'       => 'event_date',
        'order'          => 'ASC',
    ]);

    // Pad naar event-cards-list.php
    $file_path = plugin_dir_path(__FILE__) . '../render/event-cards-list.php';
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo '<p>Event cards template niet gevonden.</p>';
    }

    // Voeg de modal toe na de lijst van evenementen
    ?>
   <!-- Modal voor het weergeven van evenementdetails -->
        <div id="ic-agenda-modal" class="ic-agenda-modal" style="display:none;">
            <div class="ic-agenda-modal-content">
                <div class="ic-agenda-modal-header">
                    <h2 id="ic-agenda-modal-title"></h2>
                    <span class="ic-agenda-modal-close">&times;</span>
                </div>
                <div class="modalWrapper">
                    <div class="ic-agenda-modal-left">
                        <div id="ic-agenda-modal-details"></div>
                    </div>
                    <div class="ic-agenda-modal-right">
                        <img id="ic-agenda-modal-image" src="" alt="Featured Image" style="display:none;">
                        <p class="modalDate">Datum evenement</p>
                        <p id="ic-agenda-modal-date" style="display:none;"></p>
                        <p class="modalTime">Tijd evenement</p>
                        <p id="ic-agenda-modal-time" style="display:none;"></p>

                        <div class="modalButtonWrapper">
                            <a id="ic-agenda-pdf-link" href="#" target="_blank" class="ic-agenda-button" style="display:none;">Open PDF</a>
                            <button id="ic-agenda-open-form" class="ic-agenda-button" style="display:none;">Inschrijven</button>
                            <div id="ic-agenda-hidden-form" style="display:none;">
                                [gravityform id="1" title="false"]
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
    <?php

    return ob_get_clean();
}
add_shortcode('ic_agenda_event_cards', 'ic_agenda_event_card_shortcode');
