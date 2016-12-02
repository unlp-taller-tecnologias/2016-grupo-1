if ($('#fos_user_registration_form_profesion').val() == 'médico') {
    $('#registration-medico-fields').show();
}

$('#fos_user_registration_form_profesion, #fos_user_profile_form_profesion').change(function () {
    // Mostrar campos adicionales si la opción "Médico" es seleccionada, ocultarlos en caso contrario.
    var medicoSelected = ($(this).val() == "médico");
    $('#registration-medico-fields').toggle(medicoSelected);
});

// Crear automáticamente los datepicker
$(document).ready(function () {
    $('.input-datepicker').datepicker({
        language: 'es',
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#input-daterange-reporte').datepicker({
        format: "mm/yyyy",
        minViewMode: 1,
        maxViewMode: 2,
        endDate: "0d",
        autoclose: true,
        language: 'es'
    })
});

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

(function ($) {
    // Handling the modal confirmation message.
    $(document).on('submit', 'form[data-confirmation]', function (event) {
        var $form = $(this),
            $confirm = $('#confirmationModal');

        if ($confirm.data('result') !== 'yes') {
            //cancel submit event
            event.preventDefault();

            $confirm
                .off('click', '#btnYes')
                .on('click', '#btnYes', function () {
                    $confirm.data('result', 'yes');
                    $form.find('input[type="submit"]').attr('disabled', 'disabled');
                    $form.submit();
                })
                .modal('show');
        }
    });
})(window.jQuery);


// Menu Toggle Script
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});

// Clean search URL's
$('.clean-url').submit(function() {
    $(':input', this).each(function() {
        this.disabled = !($(this).val());
    });
});
