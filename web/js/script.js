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

$(document).ready(function () {
    $("#select-localidad-modal").dialog({
        autoOpen: false,
        title: "Buscador de localidades",
        width: 'auto',
        modal: true,
        buttons: [
            {
                text: 'Aceptar',
                class: 'btn btn-primary',
                click: function () {
                    if ($("#select-localidad").val().length < 1) {
                        $("#select-localidad-error").html("Por favor, seleccione una localidad para continuar").show();
                    } else {
                        $("#paciente_localidad").val($("#select-localidad").val());
                        $("#paciente_localidad_text").val($("#select-localidad option:selected").text() + ' (' + $("#select-partido option:selected").text() + ')');
                        $(this).dialog("close");
                    }
                }
            },
            {
                text: 'Cancelar',
                click: function () {
                    $(this).dialog("close");
                },
                class: 'btn btn-danger'
            }
        ]
    });
    $("#boton-buscar-localidad").click(function () {
        reset_localidad_error();
        $("#select-localidad-modal").dialog("open");
    });
    $('#select-partido option:eq("")').prop('selected', true);
});

function fill_localidades(url) {
    $("#select-localidad").empty();
    if ($("#select-partido").val().length > 0) {
        $.ajax({
            url: url.replace(/\/id\//g, '/' + $("#select-partido").val() + '/'),
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var opt = $("<option>").val("").html(" - Seleccione una localidad - ");
                $("#select-localidad").append(opt);
                for (i = 0; i < data.length; i++) {
                    opt = $("<option>").val(data[i].id).html(data[i].localidad);
                    $("#select-localidad").append(opt);
                }
            }
        });
        $("#select-localidad").attr("disabled", false);
    } else {
        $("#select-localidad").html("<option value=''>Seleccione un partido primero</option>").attr("disabled", true);
    }
}

function reset_localidad_error() {
    $("#select-localidad-error").hide();
}

$('.clean-url').submit(function () {
    $(':input', this).each(function () {
        this.disabled = !($(this).val());
    });
});
