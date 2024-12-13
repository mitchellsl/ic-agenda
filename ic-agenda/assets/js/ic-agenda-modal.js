jQuery(document).ready(function ($) {
    const modal = $('#ic-agenda-modal');
    const modalClose = $('.ic-agenda-modal-close');
    const modalTitle = $('#ic-agenda-modal-title');
    const modalDetails = $('#ic-agenda-modal-details');
    const modalImage = $('#ic-agenda-modal-image');
    const modalDate = $('#ic-agenda-modal-date');
    const modalTime = $('#ic-agenda-modal-time');
    const modalPDFLink = $('#ic-agenda-pdf-link');
    const openFormButton = $('#ic-agenda-open-form');
    const hiddenForm = $('#ic-agenda-hidden-form');
    const closeFormButton = $('#ic-agenda-close-form');

    // Controleer of de modal-elementen aanwezig zijn
    if (!modal.length || !modalClose.length || !modalTitle.length || !modalDetails.length || !modalImage.length || !modalDate.length || !modalTime.length || !modalPDFLink.length || !openFormButton.length || !hiddenForm.length) {
        console.error('Een of meerdere modal-elementen zijn niet gevonden in het DOM.');
        return;
    }

    // Functie voor het openen van de modal
    function openModal(item) {
        modalTitle.text(item.dataset.title || '');
        modalDetails.html(item.dataset.details || ''); // Gebruik innerHTML om HTML-inhoud weer te geven
        modalDate.text(item.dataset.date || '');
        modalDate.show();
        modalTime.text(item.dataset.time || '');
        modalTime.show();

        var imageUrl = item.dataset.image;
        if (imageUrl) {
            modalImage.attr('src', imageUrl).show();  // Stel de afbeelding in als de URL beschikbaar is
        } else {
            modalImage.hide();
        }

        var pdfUrl = item.dataset.knopUrl;
        if (pdfUrl) {
            modalPDFLink.attr('href', pdfUrl).show();
        } else {
            modalPDFLink.hide();
        }

        // Maak de 'Open Formulier' knop zichtbaar
        openFormButton.show();
        modal.fadeIn();
    }

    // Functie voor het initialiseren van event listeners voor de evenementenitems
    function initModalListeners() {
        // Voeg de event listeners voor de nieuwe evenementitems
        $('.event-item, .event-item-card').on('click', function () {
            openModal(this);
        });
    }

    // Sluit de modal wanneer de close knop wordt geklikt
    modalClose.on('click', function () {
        modal.fadeOut(); // Verberg de modal
        hiddenForm.hide(); // Verberg het formulier
    });

    // Sluit de modal wanneer je buiten de modal klikt
    $(document).on('click', function (e) {
        if ($(e.target).is(modal)) {
            modal.fadeOut(); // Verberg de modal
            hiddenForm.hide(); // Verberg het formulier
        }
    });

    // Event listener voor het filteren van evenementen
    function filterEvents() {
        let selectedMonths = [];
        let selectedYears = [];

        // Verzamel geselecteerde maanden
        $('#ic-agenda-filters input[name="filter_months[]"]:checked').each(function () {
            selectedMonths.push($(this).val());
        });

        // Verzamel geselecteerde jaren
        $('#ic-agenda-filters input[name="filter_years[]"]:checked').each(function () {
            selectedYears.push($(this).val());
        });

        $.ajax({
            url: ic_agenda.ajax_url,
            type: 'POST',
            data: {
                action: 'ic_agenda_filter_events',
                months: selectedMonths,
                years: selectedYears,
            },
            success: function (response) {
                $('#ic-agenda-events-list').html(response); // Laad de gefilterde evenementen
                initModalListeners(); // Herinitialiseer de modal event listeners na filtering
            },
        });
    }

    // Event listener voor filtering bij wijziging van de checkboxen
    $('#ic-agenda-filters input[type="checkbox"]').on('change', filterEvents);

    // Functie voor het openen van het formulier wanneer de knop wordt geklikt
    openFormButton.on('click', function () {
        hiddenForm.show(); // Toon het formulier
        openFormButton.hide(); // Verberg de knop
    });

    // Event listener voor het sluiten van het formulier
    closeFormButton.on('click', function () {
        hiddenForm.hide(); // Verberg het formulier
        openFormButton.show(); // Maak de Open Formulier knop weer zichtbaar
    });

    // Initialiseer event listeners bij het laden van de pagina
    initModalListeners();

    // Herinitialiseer event listeners na AJAX-filtering
    document.addEventListener('ajaxComplete', function () {
        initModalListeners();
    });
});
