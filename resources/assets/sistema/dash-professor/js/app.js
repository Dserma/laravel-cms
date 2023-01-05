$(function() {
    /*
     * VIEW HOME.PHP
     * */

    // CALENDAR

    $('.categoria-cupom').on('change', function() {
        if (!$(this).hasClass('edit')) {
            getAulasCombo($(this));
        }
    });

    // DONUT CHART
    if ($("#donut-chart").length) {
        // DONUT CHART
        var donutData = [{
                label: '',
                data: 25,
                color: '#FD414D'
            },
            {
                label: '',
                data: 75,
                color: '#C6C6C6'
            }
        ]
        $.plot('#donut-chart', donutData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0.5,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }

                }
            },
            legend: {
                show: false
            }
        });

        function labelFormatter(label, series) {
            return '<div style="font-size:14px; padding:2px; color: #fff; font-weight: 600;">' +
                label +
                Math.round(series.percent) + '%</div>'
        }
    }


    /*
     * VIEW PROFILE.PHP
     * */
    $("#kv-explorer").fileinput({
        'language': 'pt-BR',
        'uploadUrl': '#',
        showClose: false,
        overwriteInitial: true,
        initialPreviewAsData: true,
        defaultPreviewContent: '<img src="assets/img/fileinput.png" alt="Your Avatar">',
    });


    /*
     * VIEW AVAILABILITY.PHP
     * */
    //Date range picker
    $('#dateStart, #dateEnd').datetimepicker({
        format: 'DD/MM/Y',
        locale: 'pt-br'
    });

    //timepicker
    $('#timeStart, #timeEnd').datetimepicker({
        format: 'HH:mm',
        locale: 'pt-br'
    });


    /*
     * VIEW FINANCES.PHP
     * */
    $('[data-toggle="popover"]').popover();


    /*
     * VIEW PROFILE.PHP
     * */
    //select2
    $('.select2').select2();

    //summernote
    $('.summernote_featured, .summernote_more, .summernote_method, .summernote_credentials').summernote({
        height: 180
    });

    //Custom File
    bsCustomFileInput.init();


    /*
     * VIEW EVALUATION.PHP
     * */
    //summernote
    $('.summernote_testemonial').summernote({
        height: 180
    });
});

function getAulasCombo($this) {
    $.ajax({
        url: $this.data('url'),
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        async: true,
        method: 'POST',
        data: { sid: Math.random, c: $this.val(), a: $this.data('aula-id') },
        success: function(data) {
            $('body').removeClass('load');
            $('.aulas').html(data);
        },
        beforeSend: function() {
            $('body').addClass('load');
        },
        error: function(data) {},
        complete: function() {}
    });
}