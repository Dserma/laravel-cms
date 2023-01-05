$(document).ready(function() {
    $('.cep').keyup(function() {
        $this = $(this);
        if ($this.val().length > 8) {
            $('body').addClass('load');
            $.ajax({
                url: 'https://viacep.com.br/ws/' + $this.val().replace('-', '') + '/json/unicode/',
                async: true,
                dataType: "jsonp",
                method: 'POST',
                success: function(data) {
                    $('body').removeClass('load');
                    if (data.erro != true) {
                        Object.keys(data).forEach(function(k) {
                            if ($this.parents('.endereco').find('.' + k).length > 0) {
                                $this.parents('.endereco').find('.' + k).val(data[k]);
                                $this.parents('.endereco').find('.' + k).addClass('disabled');
                                $this.parents('.endereco').find('.numero').removeClass('disabled');
                                $this.parents('.endereco').find('.numero').focus();
                                $this.parents('.endereco').find('.complemento').removeClass('disabled');
                                $this.parents('.endereco').find('.telefone').removeClass('disabled');
                                $this.parents('.endereco').find('.celular').removeClass('disabled');
                            }
                            if ($this.parents('.endereco').find('.' + k).hasClass('select2')) {
                                $this.parents('.endereco').find('.' + k).trigger('change');
                                // $this.parents('.endereco').find('.'+k).prop("disabled", false);
                            }
                        });
                        $this.parents('.endereco').find('.uf.get').trigger('change');
                        $this.parents('.endereco').find('.localidade').val(data.ibge).trigger('change');
                    } else {
                        $this.parents('.endereco').find('input').each(function() {
                            $(this).removeClass('disabled');
                        });
                        $this.parents('.endereco').find('.uf').removeClass('disabled');
                        $this.parents('.endereco').find('.logradouro').focus();
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-bottom-full-width",
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
                            'O CEP não foi encontrado!',
                            'Oops...'
                        )
                    }
                }
            })
        }
    });
});