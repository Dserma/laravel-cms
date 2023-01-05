jQuery(document).ready(function($){

    jQuery('.lista-cursos-ead').slick({
        prevArrow:"<button type='button' class='slick-prev pull-left'><i class='fas fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next pull-right'><i class='fas fa-chevron-right'></i></button>",
        arrows:true,
        autoplay:false,
        slidesToShow:5,
        responsive: [
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 3,
            }
          },
          {
            breakpoint: 780,
            settings: {
              slidesToShow: 2,
            }
          },
          {
            breakpoint: 608,
            settings: {
              slidesToShow: 1,
            }
          }
        ]
      });


      var maskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
      },
      options = {onKeyPress: function(val, e, field, options) {
              field.mask(maskBehavior.apply({}, arguments), options);
          }
      };

    jQuery('.telefone input[type="tel"]').on('focus',function(){

      jQuery('.telefone input[type="tel"]').mask(maskBehavior, options);

    });

    jQuery('.telefone input[type="text"]').on('focus',function(){

        jQuery('.telefone input[type="text"]').mask(maskBehavior, options);

      });


    jQuery('.cep input[type="text"]').on('focus',function(){

      jQuery('.cep input[type="text"]').mask('00000-000');

     });


});
