jQuery(document).ready(function($) {

    $('body').find('[data-toggle="tooltip"]').tooltip();
    if ($('.select2').length > 0) {
        $('.select2').select2({
            placeholder: "Selecione uma opção",
            allowClear: true,
        });
    }

    var is_touch_device = ("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch;
    $('body').find('[data-toggle="popover"]').popover({
        trigger: is_touch_device ? "focus" : "hover"
    });

    $('.header .header-baixo .lista-categorias > li > .subs').each(function() {
        $lista = $('.todas').offset().top + 45;
        $sub = $(this).parents('li').offset().top;
        $(this).css('top', ($sub - $lista) * -1 + 'px');
        $(this).css('min-height', ($('.header .header-baixo .lista-categorias').height() + 5) + 'px');
    });

    $('.header .header-baixo .lista-categorias').css('transform', 'scaleY(0)');

    if ($(document).width() > 768) {
        $(document).scroll(function() {
            if ($(document).scrollTop() > 5) {
                $('section.header').addClass('scroll');
            } else {
                $('section.header').removeClass('scroll');
            }
        });
    }

    $('.hamburguer').on('touchstart', function() {
        $('.menu-mobile').toggleClass('show');
    });

    $('.fechar').on('touchstart', function() {
        $('.menu-mobile').toggleClass('show');
    });

    if ($('.cidade').length > 0) {
        makeSelect2($('.cidade'));
    }

    if ($('.avaliacao').length > 0) {
        $('.avaliacao').rating({
            displayOnly: true,
            step: 0.5,
            theme: 'krajee-fas',
            showClear: false,
            size: 'xs',
            clearCaption: '-',
            starCaptions: { 1: 'Péssimo', 2: 'Ruim', 3: 'Bom', 4: 'Muito bom', 5: 'Excelente' },
            starCaptionClasses: { 1: 'badge badge-danger text-12-pt', 2: 'badge badge-warning text-12-pt', 3: 'badge badge-info text-12-pt', 4: 'badge badge-primary text-12-pt', 5: 'badge badge-success text-12-pt' },
        });
    }

    $('.form-normal').on('submit', function() {
        submitForm($(this));
        return false;
    });

    $('.form-normal-data').on('submit', function() {
        submitFormData($(this));
        return false;
    });

    $('.submit-url').on('click', function() {
        confirma($(this));
        return false;
    });

    $('.submit-post').on('submit', function() {
        confirmaPost($(this));
        return false;
    });

    $('body').on('click', '.submit-single-post', function() {
        confirmaPost($(this), true);
        return false;
    });

    $('body').on('click', '.submit-simple-url', function() {
        submitSimpleUrl($(this));
        return false;
    });

    $('body').on('click', '.submit-simple-url-load', function() {
        submitSimpleUrlLoad($(this));
        return false;
    });

    $('body').on('click', '.btn-alterar', function() {
        alterar($(this));
        $(this).parents('table').find('tr').each(function() {
            $(this).removeAttr('style', '');
            $(this).find('td').removeAttr('style', '');
            $(this).find('td').find('a').removeAttr('style', '');
        });
        $(this).parents('tr').css('background-color', '#dc3545');
        $(this).parents('tr').find('td').css('color', '#ffffff !important');
        $(this).parents('tr').find('td').find('a').css('color', '#ffffff !important');
        return false;
    });

    $('body').on('click', '.btn-copy', function() {
        copy($(this).prev().attr('id'));
    });

    if ($('.editor-min').length > 0) {
        makeEditorMin($('.editor-min'));
    }
    if ($('.img-editor').length > 0) {
        $('.img-editor').each(function() {
            makeImgEditor($(this));
        });
    }

    $('.estados').on('change', function() {
        getCidades($(this));
    });

    $('.marcas').on('change', function() {
        getModelos($(this));
    });

    $('img.img-editor').on('froalaEditor.image.replaced', function(e, editor, $img, response) {
        $(this).parent().find('.url-imagem').val($img.attr('src'));
    });

    /** CART */

    $('.radio-plano').on('click', function() {
        $('.resume_product_header p').html($(this).data('titulo'));
        $('.resume_product_header span').html($(this).data('descricao'));
        $('.resume_product_price').html($(this).data('valor'));
        $('.resume_total p').html($(this).data('valor'));
        $('.plano_paypal').val($(this).data('paypal'));
        $('.plano_id').val($(this).data('id'));
        $('.nav-link.cadastro').removeClass('disabled');
        $('.nav-link.cadastro').trigger('click');
        if ($(this).data('gratuito') == '1') {
            // $('.nav-link.pagamento').addClass('disabled');
            $('.btn-cadastro').html('realizar cadastro');
        } else {
            // $('.nav-link.pagamento').removeClass('disabled');
            $('.btn-cadastro').html('pronto, realizar pagamento');
        }
    })

    $('a[href="#package"]').on('show.bs.tab', function(event) {
        $('.nav-link.cadastro').addClass('disabled');
    });

    $('a[href="#register"]').on('show.bs.tab', function(event) {
        $('.pais').val(0);
    });


    $('.radio-plano-internacional').on('click', function() {
        $('.resume_product_header p', window.parent.document).html($(this).data('titulo'));
        $('.resume_product_header span', window.parent.document).html($(this).data('descricao'));
        $('.resume_product_price', window.parent.document).html($(this).data('valor'));
        $('.resume_total p', window.parent.document).html($(this).data('valor'));
        $('.plano_id', window.parent.document).val($(this).data('id'));
        $('.plano_paypal', window.parent.document).val($(this).data('paypal'));
        $('.nav-link.cadastro', window.parent.document).removeClass('disabled');
        $('.nav-link.cadastro', window.parent.document).trigger('click');
        if ($(this).data('gratuito') == '1') {
            // $('.nav-link.pagamento').addClass('disabled');
            $('.btn-cadastro', window.parent.document).html('realizar cadastro');
        } else {
            // $('.nav-link.pagamento').removeClass('disabled');
            $('.btn-cadastro', window.parent.document).html('pronto, realizar pagamento');
        }
        parent.jQuery.fancybox.getInstance().close();
    })


})


function submitForm($this, $formdata = false) {
    $('body').addClass('load');
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
            if (data.response == 9) {
                new swal({
                    title: 'Tudo certo',
                    html: data.message,
                    icon: 'question',
                    confirmButtonText: "Sim",
                    showCancelButton: true,
                    cancelButtonText: "Não",
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (!result.value) {
                        window.location.href = data.url2;
                    } else {
                        window.location.reload();
                    }
                });
            }
            if (data.response == 1) {
                new swal({
                    title: 'Tudo certo',
                    html: data.message,
                    icon: 'success'
                }).then((result) => {
                    if (result.value) {
                        if (data.redirect == '1') {
                            window.location.href = data.url;
                        }
                        if (data.redirect == '2') {
                            window.location.reload();
                        }
                        if (data.redirect == '3') {
                            parent.window.location.reload();
                        }
                        if (data.redirect == '4') {
                            if ($('body').find('.modal').length > 1) {
                                $('body').find('.modal').each(function() {
                                    $(this).modal('hide');
                                })
                            }
                        }
                    }
                });
            }
            if (data.response == 2) {
                new swal({
                    title: 'Oops...',
                    html: data.message,
                    icon: 'error'
                }).then((result) => {
                    if (result.value) {
                        // if(data.url != '0' ){
                        //   window.location.href = data.url;
                        // }
                    }
                });
            }
        },
        beforeSend: function() {
            limpaValidacao($this);
            $('.loading').addClass('show');
        },
        error: function(data) {
            $('body').removeClass('load');
            if (data.status == 422) {
                validaForm($this, data);
            }
            if (data.status == 500) {
                new swal({
                    title: 'Oops...',
                    html: 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde',
                    icon: 'error'
                });
            }
        },
        complete: function() {}
    });
}

function submitFormData($this, ) {
    $.ajax({
        url: $this.data('action'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        cache: false,
        contentType: false,
        processData: false,
        async: true,
        method: 'POST',
        data: new FormData($this[0]),
        success: function(data) {
            $('body').removeClass('load');
            if (data.response == 1) {
                swal({
                    title: 'Tudo certo',
                    html: data.message,
                    type: 'success'
                }).then((result) => {
                    if (result.value) {
                        if (data.redirect == '1') {
                            window.location.href = data.url;
                        }
                        if (data.redirect == '2') {
                            window.location.reload();
                        }
                        if (data.redirect == '3') {
                            parent.window.location.reload();
                        }
                    }
                });
            } else {
                swal({
                    title: 'Oops...',
                    html: data.message,
                    type: 'error'
                });
            }
        },
        beforeSend: function() {
            limpaValidacao($this);
            $('body').addClass('load');
        },
        error: function(data) {
            validaForm($this, data);
        },
        complete: function() {}
    });
}

function submitUrl($this) {
    $('body').addClass('load');
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random },
        success: function(data) {
            $('body').removeClass('load');
            if (data.response == 1) {
                swal({
                    title: 'Tudo certo',
                    html: data.message,
                    type: 'success'
                }).then((result) => {
                    if (result.value) {
                        if (data.redirect == '1') {
                            window.location.href = data.url;
                        }
                        if (data.redirect == '2') {
                            window.location.reload();
                        }
                        if (data.redirect == '3') {
                            parent.window.location.reload();
                        }
                    }
                });
            } else {
                swal({
                    title: 'Oops...',
                    html: data.message,
                    type: 'error'
                }).then((result) => {
                    if (result.value) {
                        console.log(data.url);
                        // if(data.url != '0' ){
                        //   window.location.href = data.url;
                        // }
                    }
                });
            }
        },
        beforeSend: function() {
            limpaValidacao($this);
            $('.loading').addClass('show');
        },
        error: function(data) {
            validaForm($this, data);
        },
        complete: function() {}
    });
}

function submitSimpleUrl($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random },
        success: function(data) {
            if (data.redirect == '1') {
                window.location.href = data.url;
            }
            if (data.redirect == '2') {
                window.location.reload();
            }
            if (data.redirect == '3') {
                parent.window.location.reload();
            }
        },
        beforeSend: function() {},
        error: function(data) {},
        complete: function() {}
    });
}

function submitSimpleUrlLoad($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, id: $this.data('id') },
        success: function(data) {
            $('body').removeClass('load');
            if (data.response == 1) {
                new swal({
                    title: 'Tudo certo',
                    html: data.message,
                    icon: 'success'
                }).then((result) => {
                    if (result.value) {
                        if (data.redirect == '1') {
                            window.location.href = data.url;
                        }
                        if (data.redirect == '2') {
                            window.location.reload();
                        }
                        if (data.redirect == '3') {
                            parent.window.location.reload();
                        }
                    }
                });
            }
            if (data.response == 3) {
                window.open(data.url);
            }
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {
            $('body').removeClass('load');
            if (data.responseJSON.response == 0) {
                new swal({
                    title: 'Oops!',
                    html: data.responseJSON.message,
                    icon: 'error'
                }).then((result) => {
                    if (result.value) {
                        if (data.responseJSON.redirect == '1') {
                            window.location.href = data.responseJSON.url;
                        }
                        if (data.responseJSON.redirect == '2') {
                            window.location.reload();
                        }
                        if (data.responseJSON.redirect == '3') {
                            parent.window.location.reload();
                        }
                    }
                });
            }
        },
        complete: function() {}
    });
}

function alterar($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, token: $('.token').val() },
        success: function(data) {
            $('body').removeClass('load');
            Object.keys(data).forEach(function(k) {
                $el = $('.form-normal .' + k);
                if ($el.length < 1) {
                    $el = $('[name="' + k + '"]');
                }
                if ($el.length > 0) {
                    $el.addClass('edit');
                    $el.attr('disabled', false);
                    if ($el.is('textarea')) {
                        $el.html(data[k]);
                        $el.val(data[k]);
                        if ($el.hasClass('editor')) {
                            makeEditor($el);
                        }
                        if ($el.hasClass('editor-video')) {
                            makeEditorVideo($el);
                        }
                        // makeEditorMin($el);
                    }
                    if ($el.is('select')) {
                        if ($el.attr('multiple') != 'multiple') {
                            $el.val(data[k]);
                        } else {
                            // $el.val(data[k]);
                            $el.val('').change();
                            initSelect('#' + k, data[k]);
                            select2_sortable($('#' + k));
                        }
                        $el.trigger('change');
                    }
                    if ($el.not('[type="radio"]').not('[type="file"]').is('input')) {
                        $el.val(data[k]);
                        if ($el.hasClass('data-input-mask')) {
                            console.log(data[k]);
                            $old = data[k].split('-');
                            $old.reverse();
                            $el.val($old.join('/'));
                            // var d = new Date(data[k] + 'EDT');
                            // let options = { year: 'numeric', month: '2-digit', day: '2-digit' };
                            // $el.val(d.toLocaleString('pt-BR', options));
                        }
                        if ($el.hasClass('hora-curta-input-mask')) {
                            $el.trigger('blur');
                        }
                        $r = $el.attr('data-relation');
                        if (typeof $r != 'undefined') {
                            var at = $el.attr('data-relation');
                            value = data[k];
                            $el.val(at.split('.').reduce((o, i) => o[i], value));
                        }
                    }
                    if ($el.is(':radio')) {
                        $el.each(function() {
                            if ($(this).attr('id') == k + '_' + data[k]) {
                                $(this).iCheck('check');
                            }
                        })
                    }
                    if ($el.hasClass('check-group')) {
                        $el.find('input').each(function() {
                            $(this).attr('checked', false);
                        })
                        $a = data[k].split(',');
                        $a.forEach(e => {
                            $e = $('#' + k.slice(0, -1) + '_' + e);
                            $e.attr('checked', 'checked');
                        });
                    }
                    if ($el.hasClass('url-imagem')) {
                        if (data[k] != '') {
                            $el.parent().find('.img-editor').attr('src', data[k]);
                        } else {
                            $el.parent().find('.img-editor').attr('src', '../../../../resources/assets/backend/images/sem-imagem.png');
                        }
                        if (!$el.parent().find('.img-editor').data('froala.editor')) {
                            makeImgEditor($el.parent().find('.img-editor'));
                        }
                    }
                } else {
                    if (k == 'tipo') {
                        $('.modal-spa #tipo_' + data[k]).iCheck('check');
                    }
                }
            });

        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}


function valida($this) {
    let $campo = $this.attr('name');
    let $data = {};
    $data[$campo] = $this.val();
    $.ajax({
        url: $this.data('action'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: $data,
        success: function(data) {
            $this.next('.status').removeClass('checking');
            $this.next('.status').addClass('ok');
            $this.removeClass('error');
            $this.addClass('ok');
            $this.next('.status').html('<i class="fa fa-check padding-5"></i> liberado para uso.');
        },
        beforeSend: function() {
            $this.parent().find('.status').remove();
            $this.parent().append('<div class="row status"></div>');
            $this.next('.status').addClass('checking');
            $this.removeClass('error');
            $this.next('.status').html('');
        },
        error: function(data) {
            $this.next('.status').removeClass('checking');
            $this.next('.status').removeClass('ok');
            Object.keys(data.responseJSON.errors).forEach(function(k) {
                $this.addClass('error');
                $this.val('');
                $this.focus();
                $this.next('.status').addClass('error');
                $this.next('.status').html('<i class="fa fa-exclamation-triangle padding-5"></i>' + data.responseJSON.errors[k]);
            });
        },
        complete: function() {}
    });
}

function validaForm($this, data) {
    $('body').removeClass('load');
    Object.keys(data.responseJSON.errors).forEach(function(k) {
        $el = $this.find('[name="' + k + '"]:enabled');
        if ($el.length < 1 && k.includes(".")) {
            $el = $this.find('[name="' + k.split(".")[0] + '[]"]').eq(0);
        }
        if ($el.is('textarea') && ($el.hasClass('editor') || $el.hasClass('editor-min'))) {
            $el = $el.parent().find('.fr-box');
        }
        if ($el.is('input:hidden') || $el.is('input:checkbox')) {
            $el = $el.parent();
        }
        if ($el.length == 0) {
            $el = $this.find('[name="' + k + '[]"]');
        }
        if (!$el || $el.css('display') == 'none') {
            $el = $el.next('input, div');
        }
        console.log($el);
        $el.parent().find('.status').remove();
        $el.parent().append('<div class="row status"></div>');
        $el.addClass('is-invalid');
        if ($el.hasClass('select2')) {
            $el.next('.select2 ').addClass('error is-invalid');
        }
        $el.parent().find('.status').addClass('error');
        $el.parent().find('.status').html('<i class="fa fa-exclamation-triangle padding-5"></i>' + data.responseJSON.errors[k]);
    });
    $obj = $($this).find('[name=' + Object.keys(data.responseJSON.errors)[0] + ']');
    $target = $($obj).offset().top - 300;
    if ($obj.is('textarea')) {
        if ($obj.hasClass('editor-min')) {
            $target = $obj.parent().find('.fr-box').offset().top - 300;
        } else {
            $target = $obj.parent().offset().top - 300;
        }
    }
    if ($obj.is('input:hidden')) {
        $target = $obj.parent().offset().top - 300;
    }
    $('html, body').animate({ scrollTop: $target }, 800);
    $obj.focus();
}

function limpaValidacao($this) {
    $this.find('.status').each(function() {
        $(this).remove()
        $this.parents('div').find('.error').removeClass('error');
        $this.parents('div').find('.form-control').removeClass('is-invalid');
    });
    $this.find('.is-invalid').each(function() {
        $(this).removeClass('is-invalid')
    });
}

function makeEditorMin($this) {
    $this.froalaEditor({
        heightMin: 200,
        width: '100%',
        language: 'pt_br',
        toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'underline', 'strikeThrough', 'outdent', 'indent', 'clearFormatting', ],
        toolbarButtonsXS: ['undo', 'redo', '-', 'bold', 'italic', 'underline'],
        quickInsertTags: [''],
        imageDefaultWidth: 0,
    });
}


function makeImgEditor($this) {
    $.FroalaEditor.DefineIcon('imageReplace', { NAME: 'image' });
    $this.froalaEditor({
        language: 'pt_br',
        imageEditButtons: ['imageReplace', 'imageAlign', 'imageCaption', 'imageRemove'],
        imageInsertButtons: ['imageUpload'],
        imageUploadParams: {
            _token: $('meta[name=_token]').attr('content'),
        },
        imageUploadURL: routes.sistema.produto.upload,
    });
    $this.on('click', function() {
        $this.data('froala.editor').commands.exec('imageReplace');
    });
}

function getDataDados($this, $name, $target, $default = null) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, id: $this.val(), name: $name, url: $($target).find('.select2').data('url'), select: true, default: $default },
        success: function(data) {
            $('body').removeClass('load');
            $($target).html(data);
            $($target).find('.select2').each(function() {
                makeSelect2($(this));
            })
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        complete: function() {}
    });
}

function makeSelect2($this) {
    $this.select2({
        placeholder: {
            id: '-1',
            text: 'Selecione uma opção',
            width: 'resolve'
        },
        allowClear: true,
    });
}

function confirma($this) {
    swal({
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
            submitUrl($this);
        }
    });
}

function confirmaPost($this, $single = false) {
    if ($this.data('cupom') == true) {
        if ($this.data('exibir') == true) {
            Swal.fire({
                title: 'Opa!',
                html: $this.data('texto'),
                icon: 'question',
                confirmButtonText: "Sim",
                showCancelButton: true,
                cancelButtonText: "Não",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    submitSimpleUrlLoad($this);
                }
            })
        } else {
            Swal.fire({
                title: 'Opa!',
                html: $this.data('texto') + '<br><br> Caso tenha um cupom de desconto, coloque-o abaixo: <br><input class="form-control cupom-alerta" name="cupom" placeholder="Cupom de desconto">',
                icon: 'question',
                confirmButtonText: "Sim",
                showCancelButton: true,
                cancelButtonText: "Não",
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                inputLabel: 'Cupom de Desconto:',
            }).then((result) => {
                if (result.isConfirmed) {
                    $cupom = $('.cupom-alerta').val();
                    if ($cupom != '' && $cupom.length > 0) {
                        checkCupom($this, $cupom);
                    } else {
                        submitSimpleUrlLoad($this);
                    }
                }
            })
        }
    } else {
        new swal({
            title: 'Opa!',
            html: $this.data('texto'),
            icon: 'question',
            confirmButtonText: "Sim",
            showCancelButton: true,
            cancelButtonText: "Não",
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.value) {
                if ($single == false) {
                    submitForm($this);
                } else {
                    submitSimpleUrlLoad($this);
                }
            }
        });
    }
}

function getCidades($this, $city = null) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, u: $this.val() },
        success: function(data) {
            $('body').removeClass('load');
            $('.cidades').html(data);
            if ($city != null) {
                $('.cidades').val($city).change();
            }
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function getModelos($this, $modelo = null) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, c: $this.data('categoria'), u: $this.val() },
        success: function(data) {
            $('body').removeClass('load');
            $('.modelos').html(data);
            if ($modelo != null) {
                $('.modelos').val($city).change();
            }
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function checkCupom($this, $cupom) {
    $.ajax({
        url: $this.data('url-cupom'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, cupom: $cupom, plano: $this.data('plano') },
        success: function(data) {
            $('body').removeClass('load');
            if (data.response == 1) {
                new swal({
                    title: 'Tudo certo',
                    html: data.message,
                    icon: 'success'
                }).then((result) => {
                    if (result.value) {
                        submitSimpleUrlLoad($this);
                    }
                });
            } else {
                new swal({
                    title: 'Oops...',
                    html: data.message,
                    icon: 'error'
                }).then((result) => {
                    if (result.value) {
                        window.location.reload();
                    }
                });
            }
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {
            let erros = '';
            $('body').removeClass('load');
            Object.keys(data.responseJSON.errors).forEach(function(k) {
                erros += data.responseJSON.errors[k];
            })
            new swal({
                title: 'Oops...',
                html: erros,
                icon: 'error'
            }).then((result) => {
                if (result.value) {
                    window.location.reload();
                }
            });
        },
        complete: function() {}
    });
}

function atualizaAssinaturaPaypal($code) {
    $.ajax({
        url: routepaypal,
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, c: $code },
        success: function(data) {
            $('body').removeClass('load');
            if (data.response == 1) {
                new swal({
                    title: 'Tudo certo',
                    html: data.message,
                    icon: 'success'
                }).then((result) => {
                    if (result.value) {
                        if (data.url != '0' && data.url != '2' && data.url != '3') {
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
            if (data.response == 3) {
                window.open(data.url);
            }
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}

function copy($target) {
    var copyText = document.getElementById($target);
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
    document.execCommand("copy");
    toastr.success(
        'Código copiado para área de transferência',
        'Tudo certo!', {
            timeOut: 2000,
            showEasing: 'linear',
            showMethod: 'slideDown',
            closeMethod: 'fadeOut',
            closeDuration: 300,
            closeEasing: 'swing',
            closeButton: false,
            progressBar: true,
            positionClass: "toast-bottom-center",
            onHidden: function() {}
        }
    );
}