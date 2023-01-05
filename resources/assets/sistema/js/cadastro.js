$(document).ready(function() {
    $('.pais').on('change', function() {
        if ($(this).val() == '2' && $('.plano_paypal').val() == '') {
            $('a.modal-exterior').trigger('click');
        } else {

        }
    })
});