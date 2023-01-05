jQuery(document).ready(function($) {
    $('body').on('change', '.filtro:not(.no-select)', function() {
        getNextSelect($(this));
    });
    $('body').on('change', '.filtro', function() {
        getMateriais();
    });
});

function getNextSelect($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, v: $this.val() },
        success: function(data) {
            $('body').removeClass('load');
            $('.' + $this.data('next')).html(data);
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function getMateriais($this) {
    $.ajax({
        url: routes.sistema.ajax.materiais,
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, c: $('.curso').val(), m: $('.modulo').val(), a: $('.aula').val() },
        success: function(data) {
            $('body').removeClass('load');
            $('.resultados').html(data);
            var count = (data.match(/btn-material/g) || []).length;
            $('.enc').html(count);
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}