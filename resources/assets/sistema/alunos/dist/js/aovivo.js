jQuery(document).ready(function($) {

    $('.categoria-cart').on('change', function() {
        getAulas($(this));
    });

    $('body').on('click', '.duracao-aula', function() {
        $('.modal-agendar .valor').html($(this).data('valor'));
        $('.modal-agendar .quantidade').removeClass('d-none');
        $(this).parents('form').find('.btn-submit').prop('disabled', false);
    });

    $('.form-agenda').on('submit', function() {
        agendaAula($(this));
        $('.categoria-cart').val(null).trigger('change');
        $('.btn-submit').prop('disabled', true);
        return false;
    });

    $('body').on('click', '.tipo-aula', function() {
        agendaAulaCart($(this));
    });

    $('body').on('click', '.btn-quantidade', function() {
        agendaAulaCart($(this), $(this).parents('.quantidade').find('.qtd').val());
    });

    $('body').on('click', '.remover-cart', function() {
        confirma($(this));
    });

    $('body').on('click', '.btn-ver-disp', function() {
        disponibilidade($(this));
    });

    $('body').on('click', '.btn-agendar', function() {
        confirmaAgendamento($(this));
    });
})

function getAulas($this) {
    if ($this.val() == '') {
        $('.modal-agendar .radio').html('');
        $('.modal-agendar .valor').html('');
        $('.modal-agendar .valor').html('');
        $('.modal-agendar .quantidade').addClass('d-none');
        $this.parents('form').find('.btn-submit').prop('disabled', true);
        return false;
    }
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, c: $this.val() },
        success: function(data) {
            $('body').removeClass('load');
            $('.modal-agendar .radio').html(data);
            $('.modal-agendar .valor').html('Selecione uma aula');
            $('.modal-agendar .radio .duracao-aula').first().click();
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function agendaAula($this) {
    $.ajax({
        url: $this.data('action'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: $this.find('input,select,textarea').filter(function() { return !!this.value; }).serialize(),
        success: function(data) {
            $('body').removeClass('load');
            $('.modal-agendar').removeClass('show');
            $('.modal_cart').addClass('show');
            atualizaCart();
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function agendaAulaCart($this, $qtd = null) {
    $obj = $this ? $this.data('obj') : null;
    $tipo = $this ? $this.data('type') : null;
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, o: $obj, t: $tipo, qtd: $qtd },
        success: function(data) {
            $('.modal_cart_content').removeClass('load-cart');
            fbq('track', 'AddToCart');
            atualizaCart();
        },
        beforeSend: function() {
            $('.modal_cart_content').addClass('load-cart');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function confirma($this) {
    new swal({
        title: 'Opa!',
        text: $this.data('texto'),
        type: 'question',
        confirmButtonText: "Sim",
        showCancelButton: true,
        cancelButtonText: "Não",
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.value) {
            removeAulaCart($this);
        }
    });
}

function confirmaAgendamento($this) {
    new swal({
        title: 'Opa!',
        text: 'Confirma o agendamento desta aula?',
        type: 'question',
        confirmButtonText: "Sim",
        showCancelButton: true,
        cancelButtonText: "Não",
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.value) {
            agendamento($this);
        }
    });
}


function removeAulaCart($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        success: function(data) {
            $('.modal_cart_content').removeClass('load-cart');
            atualizaCart();
        },
        beforeSend: function() {
            $('.modal_cart_content').addClass('load-cart');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function atualizaCart($this = false) {
    $.ajax({
        url: routes.sistema.aovivo.atualizacart,
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        success: function(data) {
            $('.modal_cart_content').removeClass('load-cart');
            $('.modal_cart .produtos').html(data);
            var count = (data.match(/cart-item/g) || []).length;
            $('.badge-cart').html(count);
            console.log(count);
            if (count == 0) {
                $('.cart-pagar').addClass('d-none');
            } else {
                $('.cart-pagar').removeClass('d-none');
            }
            atualizaValorCart();
        },
        beforeSend: function() {
            $('.modal_cart_content').addClass('load-cart');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function atualizaValorCart() {
    $original = 0;
    $total = 0;
    $('.somar').each(function() {
        if ($(this).data('original')) {
            $original += parseFloat($(this).data('original'));
        }
        $total += parseFloat($(this).data('valor'));
    });
    $('.valor-total').html($total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
    $('.valor-original').html($original.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
    $desconto = $original - $total;
    $('.descontos').html($desconto.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
    $.ajax({
        url: routes.sistema.aovivo.atualizavalor,
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, t: $total },
    });
}

function disponibilidade($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        success: function(data) {
            $('.card-calendario').html(data);
        },
        beforeSend: function() {
            $('html, body').animate({ scrollTop: $('#calendario').offset().top }, 10);
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function preAgendamento($start, $end, $a, $ag) {
    $.ajax({
        url: routes.sistema.aovivo.preagenda,
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, s: $start, e: $end, a: $a },
        success: function(data) {
            $('body').removeClass('load');
            $('.modal-agendar .dia').html(data.date);
            $('.modal-agendar .ini').html(data.start);
            $('.modal-agendar .fim').html(data.end);
            $('.modal-agendar .categoria').html(data.c);
            $('.modal-agendar .professor').html(data.p);
            $('.modal-agendar .btn-agendar').attr('data-id', data.id);
            $('.modal-agendar .btn-agendar').attr('data-inicio', data.start);
            $('.modal-agendar .btn-agendar').attr('data-fim', data.end);
            $('.modal-agendar .btn-agendar').attr('data-dia', data.date);
            $('.modal-agendar .btn-agendar').attr('data-agenda', $ag);
            $('.btn-modal').click();
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function agendamento($this) {
    $.ajax({
        url: routes.sistema.aovivo.agendar,
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, d: $this.data('dia'), s: $this.data('inicio'), e: $this.data('fim'), a: $this.data('id'), ag: $this.data('agenda') },
        success: function(data) {
            $('body').removeClass('load');
            if (data.response == 1) {
                new swal({
                    title: 'Tudo certo',
                    html: data.message,
                    icon: 'success'
                }).then((result) => {
                    if (result.value) {
                        if (data.url != '0' && data.url != '2') {
                            window.location.href = data.url;
                        }
                        if (data.url == '0') {
                            window.location.reload();
                        }
                        if (data.url == '2') {
                            parent.window.location.reload();
                        }
                    }
                });
            }
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {
            $('body').removeClass('load');
            new swal({
                title: 'Oops...',
                html: data.responseJSON.message,
                icon: 'error'
            }).then((result) => {
                if (result.value) {}
            });
        },
        complete: function() {}
    });

}