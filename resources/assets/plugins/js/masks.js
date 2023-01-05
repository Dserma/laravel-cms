$(document).ready(function() {
    var SPMaskBehavior = function(val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('.telefone-input-mask').mask(SPMaskBehavior, spOptions);
    //$('.data-input-mask').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.ano-input-mask').mask("0000");
    $('.ddi-input-mask').mask("+0000");
    $('.data-input-mask').mask("00/00/0000");
    $('.validade-input-mask').mask("00/0000");
    $('.validade-input-mask-2').mask("00/00");
    $('.cvv-input-mask').mask("0000");
    $('.hora-input-mask').mask('00:00:00');
    $('.hora-curta-input-mask').mask('00:00');
    $('.data-hora-input-mask').mask('00/00/0000 00:00:00');
    $('.cep-input-mask').mask('00000-000');
    $('.cpf-input-mask').mask('000.000.000-00', { reverse: true });
    $('.cnpj-input-mask').mask('00.000.000/0000-00', { reverse: true });
    $(document).on('keypress', '.dinheiro-input-mask', function() {
        $(this).mask('#.##0,00', { reverse: true });
    });
    $('.credit-input-mask').mask("0000.0000.0000.0000");

    // $( ".input-calendar" ).datepicker({
    //   autoclose: true,
    //   format: 'dd/mm/yyyy',
    //   language: 'pt-BR',
    // });
});

function validaCPF(cpf) {
    if (cpf != '') {
        cpf = cpf.replace(/[^\d]+/g, '');
        var Soma;
        var Resto;
        Soma = 0;
        if (cpf == "00000000000") return false;

        for (i = 1; i <= 9; i++) Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(cpf.substring(9, 10))) return false;

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(cpf.substring(10, 11))) return false;
        return true;
    } else {
        return true;
    }
}

function validaCNPJ(cnpj) {
    if (cnpj != '') {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if (cnpj == '') return false;
        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;
    } else {
        return true;
    }

}