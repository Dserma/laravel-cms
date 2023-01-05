jQuery(document).ready(function($) {
    $('.filtro').each(function() {
        $(this).on('change', function() {
            filtra($(this));
        });
    });
});

function filtra($this) {
    $chain = Array();
    $('.filtro').each(function() {
        $el = $(this).attr('name');
        if ($('.' + $el).val() != '') {
            $chain.push('[data-' + $el + '="' + $('.' + $el).val() + '"]');
        }
    });
    $lista = $('.lista-cursos');
    $items = $lista.find('.item-curso');
    if ($chain.length > 0) {
        $hide = $items.not($chain.join(''));
        $show = $lista.find($chain.join(''));
    } else {
        $show = $items;
    }
    $hide.fadeOut();
    $show.fadeIn();
}