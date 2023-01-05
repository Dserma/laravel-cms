$(document).ready(function() {
    preferidos($('.tipo'));
    $('.tipo').on('change', function() {
        preferidos($(this));
    });
});

function preferidos($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, tipo: $this.val() },
        success: function(data) {
            $('body').removeClass('load');
            $('.resultados').html(data);
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}