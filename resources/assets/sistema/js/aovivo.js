$(document).ready(function() {
    $('body').on('click', '.btn-iniciar', function() {
        iniciaAula($(this));
    });
})

function iniciaAula($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, i: $this.data('id') },
        success: function(data) {
            window.location.reload();
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}