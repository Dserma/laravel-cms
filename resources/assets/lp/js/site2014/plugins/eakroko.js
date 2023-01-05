// FLAT Theme v2.0
(function( $ ){
	$.fn.retina = function(retina_part) {
		// Set default retina file part to '-2x'
		// Eg. some_image.jpg will become some_image-2x.jpg
		var settings = {'retina_part': '-2x'};
		if(retina_part) jQuery.extend(settings, { 'retina_part': retina_part });
		if(window.devicePixelRatio >= 2) {
			this.each(function(index, element) {
				if(!$(element).attr('src')) return;

				var checkForRetina = new RegExp("(.+)("+settings['retina_part']+"\\.\\w{3,4})");
				if(checkForRetina.test($(element).attr('src'))) return;

				var new_image_src = $(element).attr('src').replace(/(.+)(\.\w{3,4})$/, "$1"+ settings['retina_part'] +"$2");
				$.ajax({url: new_image_src, type: "HEAD", success: function() {
					$(element).attr('src', new_image_src);
				}});
			});
		}
		return this;
	}
})( jQuery );
function icheck(){
	if($(".icheck-me").length > 0){
		$(".icheck-me").each(function(){
			var $el = $(this);
			var skin = ($el.attr('data-skin') !== undefined) ? "_"+$el.attr('data-skin') : "",
			color = ($el.attr('data-color') !== undefined) ? "-"+$el.attr('data-color') : "";

			var opt = {
				checkboxClass: 'icheckbox' + skin + color,
				radioClass: 'iradio' + skin + color,
				increaseArea: "10%"
			}

			$el.iCheck(opt);
		});
	}
}

$(document).ready(function() {
	var mobile = false,
	tooltipOnlyForDesktop = true,
	notifyActivatedSelector = 'button-active';

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		mobile = true;
	}

	icheck();

	if($(".complexify-me").length > 0){
		$(".complexify-me").complexify(function(valid, complexity){
			if(complexity < 40){
				$(this).parent().find(".progress .bar").removeClass("bar-green").addClass("bar-red");
			} else {
				$(this).parent().find(".progress .bar").addClass("bar-green").removeClass("bar-red");
			}

			$(this).parent().find(".progress .bar").width(Math.floor(complexity)+"%").html(Math.floor(complexity)+"%");
		});
	}


	$(".retina-ready").retina("@2x");

});


$(document).ready(function() { $(".select2-me").select2(); });

jQuery("document").ready(function($){
    
    var nav = $('.nav-total');
    
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });

	$( ".click-btn-login" ).click(function() {
		$( ".login-top" ).toggle();
	});
	
	//
	$( ".dropdown-toggle" ).click(function() {
		$( ".dropdown" ).toggle();
	});
 
});

$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
