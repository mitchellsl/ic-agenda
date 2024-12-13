jQuery(document).ready(function ($) {
    // Maandnamen voor volledige weergave
    const monthNames = {
        '01': 'Januari', '02': 'Februari', '03': 'Maart', '04': 'April',
        '05': 'Mei', '06': 'Juni', '07': 'Juli', '08': 'Augustus',
        '09': 'September', '10': 'Oktober', '11': 'November', '12': 'December'
    };

    // Functie om maandselecties te beheren
    $('#ic-agenda-filters input[name="filter_months[]"]').on('change', function () {
        let allMonthsCheckbox = $('#ic-agenda-filters input[name="filter_months[]"][value="all"]');

        if ($(this).val() === 'all') {
            if ($(this).is(':checked')) {
                $('#ic-agenda-filters input[name="filter_months[]"]').not(this).prop('checked', false)
                    .closest('.ic-agenda-filter-label').removeClass('checked').addClass('unchecked');
                $(this).closest('.ic-agenda-filter-label').addClass('checked').removeClass('unchecked');
            }
        } else {
            if ($(this).is(':checked')) {
                allMonthsCheckbox.prop('checked', false)
                    .closest('.ic-agenda-filter-label').removeClass('checked').addClass('unchecked');
                $(this).closest('.ic-agenda-filter-label').addClass('checked').removeClass('unchecked');
            } else {
                $(this).closest('.ic-agenda-filter-label').removeClass('checked').addClass('unchecked');
            }
        }
    });

    // Functie om jaarselecties te beheren
    $('#ic-agenda-filters input[name="filter_years[]"]').on('change', function () {
        let allYearsCheckbox = $('#ic-agenda-filters input[name="filter_years[]"][value="all"]');

        if ($(this).val() === 'all') {
            if ($(this).is(':checked')) {
                $('#ic-agenda-filters input[name="filter_years[]"]').not(this).prop('checked', false)
                    .closest('.ic-agenda-filter-label').removeClass('checked').addClass('unchecked');
                $(this).closest('.ic-agenda-filter-label').addClass('checked').removeClass('unchecked');
            }
        } else {
            if ($(this).is(':checked')) {
                allYearsCheckbox.prop('checked', false)
                    .closest('.ic-agenda-filter-label').removeClass('checked').addClass('unchecked');
                $(this).closest('.ic-agenda-filter-label').addClass('checked').removeClass('unchecked');
            } else {
                $(this).closest('.ic-agenda-filter-label').removeClass('checked').addClass('unchecked');
            }
        }
    });

    // Voeg 'checked' of 'unchecked' class toe bij initialisatie
    $('#ic-agenda-filters input[type="checkbox"]').each(function () {
        if ($(this).is(':checked')) {
            $(this).closest('.ic-agenda-filter-label').addClass('checked').removeClass('unchecked');
        } else {
            $(this).closest('.ic-agenda-filter-label').addClass('unchecked').removeClass('checked');
        }
    });

    // Functie om AJAX-filtering uit te voeren
    function filterEvents() {
        let selectedMonths = [];
        let selectedYears = [];

        $('#ic-agenda-filters input[name="filter_months[]"]:checked').each(function () {
            selectedMonths.push($(this).val());
        });

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

    // Event listener voor filtering
    $('#ic-agenda-filters input[type="checkbox"]').on('change', filterEvents);

    // Functie om de modal event listeners opnieuw in te stellen
    function initModalListeners() {
        // Voeg de event listeners voor de nieuwe evenementitems
        $('.event-item, .event-item-card').on('click', function () {
            const modal = $('#ic-agenda-modal');
            const modalTitle = $('#ic-agenda-modal-title');
            const modalDetails = $('#ic-agenda-modal-details');
            const modalImage = $('#ic-agenda-modal-image');
            const modalDate = $('#ic-agenda-modal-date');
            const modalTime = $('#ic-agenda-modal-time');
            const modalPDFLink = $('#ic-agenda-pdf-link');
            const openFormButton = $('#ic-agenda-open-form');
            const hiddenForm = $('#ic-agenda-hidden-form');

            modalTitle.text($(this).data('title'));
            modalDetails.html($(this).data('details'));  // HTML inhoud wordt hier correct weergegeven
            modalDate.text($(this).data('date')).show();
            modalTime.text($(this).data('time')).show();

            var imageUrl = $(this).data('image');
            if (imageUrl) {
                modalImage.attr('src', imageUrl).show();
            } else {
                modalImage.hide();
            }

            var pdfUrl = $(this).data('knop-url');
            if (pdfUrl) {
                modalPDFLink.attr('href', pdfUrl).show();
            } else {
                modalPDFLink.hide();
            }

            // Maak de 'Open Formulier' knop zichtbaar
            openFormButton.show();

            modal.fadeIn(); // Toon de modal
        });
    }
});
