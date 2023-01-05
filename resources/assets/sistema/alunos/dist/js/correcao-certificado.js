jQuery(document).ready(function($) {
    $('.balao_1').addClass('show');
    $('.show-balao').click(function() {
        $('.balao').each(function() {
            $(this).removeClass('show');
        });
        $target = $('.balao_' + $(this).data('target'));
        $target.addClass('show');
    })
})