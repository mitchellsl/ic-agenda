<?php
// Shortcode voor het combineren van filters en evenementenlijst
function ic_agenda_combined_shortcode($atts) {
    ob_start();
    $filter_data = ic_agenda_generate_filter_options();
    $months = $filter_data['months'];
    $years = $filter_data['years'];

    // Huidige maand en jaar ophalen
    $current_month = date('m');
    $current_year = date('Y');

    // Sorteer de maanden oplopend
    sort($months);

    include plugin_dir_path(__FILE__) . '../render/event-filter-form.php';

    echo '<div id="ic-agenda-events-list">';
    ic_agenda_render_event_list([$current_month], [$current_year]);
    echo '</div>';
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
add_shortcode('ic_agenda', 'ic_agenda_combined_shortcode');
