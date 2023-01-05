$(document).ready(function() {
    makeEditor($('.editor'));
    $('.form-conteudo').on('submit', function() {
        gravaConteudo($(this));
        return false;
    })
});

function gravaConteudo($this) {
    $valida = true;
    if ($valida) {
        $.ajax({
            url: $this.data('url'),
            headers: {
                'X-CSRF-Token': $('meta[name=_token]').attr('content')
            },
            async: true,
            method: 'POST',
            data: $this.serialize(),
            success: function(data) {
                toastr.clear();
                $this.find('.box').find('.overlay').remove();
                toastr.success(
                    'Item salvo com sucesso!',
                    'Tudo certo!', {
                        timeOut: 2000,
                        showEasing: 'linear',
                        showMethod: 'slideDown',
                        closeMethod: 'fadeOut',
                        closeDuration: 300,
                        closeEasing: 'swing',
                        closeButton: false,
                        progressBar: true,
                        onHidden: function() {}
                    }
                );
            },
            error: function(data) {
                toastr.clear();
                $this.find('.box').find('.overlay').remove();
                Object.keys(data.responseJSON.errors).forEach(function(k) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "preventDuplicates": false,
                        "showDuration": "1000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    toastr.error(
                        data.responseJSON.errors[k],
                        'Oops....'
                    )
                });
            },
            beforeSend: function() {
                $this.find('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                toastr.info(
                    'Estamos salvando suas alterações...',
                    'Aguarde!', {
                        showEasing: 'linear',
                        showMethod: 'slideDown',
                        closeMethod: 'fadeOut',
                        closeDuration: 300,
                        closeEasing: 'swing',
                        closeButton: false,
                        progressBar: true,
                    }
                );
            },
            complete: function() {}
        });
    }
}

function makeEditor($this) {
    $this.froalaEditor({
        heightMin: 400,
        language: 'pt_br',
        imageEditButtons: ['imageReplace', 'imageAlign', 'imageCaption', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize', 'aviary'],
        imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL', 'imageManager', 'aviary'],
        imageUploadURL: routes.backend.ajax.upload,
        aviaryKey: 'fda9ef816ef748a3b315c542bd2692f5',
        aviaryOptions: {
            displayImageSize: true,
            theme: 'dark'
        },
        imageManagerDeleteMethod: 'DELETE',
        imageManagerDeleteURL: routes.backend.ajax.delete,
        imageManagerLoadMethod: 'POST',
        imageManagerLoadURL: routes.backend.ajax.load,
        imageManagerPageSize: 20,
        imageManagerScrollOffset: 10,
        imageDefaultWidth: 0,
    });
}