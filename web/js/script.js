$('#fos_user_registration_form_profesion').change(function () {
    // Mostrar campos adicionales si la opción "Médico" es seleccionada, ocultarlos en caso contrario.
    var medicoSelected = ($(this).val() == 1);
    $('#registration-medico-fields').toggle(medicoSelected);
});
