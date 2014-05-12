(function($) {
  "use strict";
  
//------------------------------------- Waiting for the entire site to load ------------------------------------------------//

$(window).load(function() { 
		jQuery("#loaderInner").fadeOut(); 
		jQuery("#loader").delay(400).fadeOut("slow"); 
		$('.teaserTitle ').stop().animate({marginTop :'330px', opacity:"1"}, 1000, 'easeOutQuint');
		$('.shortcat a ').stop().animate({marginTop :'65px', opacity:"1"}, 600, 'easeOutQuint');
});



$(document).ready(function(){

//------------------------------------- Navigation setup ------------------------------------------------//


//--------- Scroll navigation ---------------//

$("#mainNav ul a, .logo a").click(function(e){


	var full_url = this.href;
	var parts = full_url.split("#");
	var trgt = parts[1];
	var target_offset = $("#"+trgt).offset();
	var target_top = target_offset.top;



	$('html,body').animate({scrollTop:target_top -70}, 800);
		return false;

});


//-------------Highlight the current section in the navigation bar------------//


	var sections = $("section");
		var navigation_links = $("#mainNav a");

		sections.waypoint({
			handler: function(event, direction) {

				var active_section;
				active_section = $(this);
				if (direction === "up") active_section = active_section.prev();

				var active_link = $('#mainNav a[href="#' + active_section.attr("id") + '"]');
				navigation_links.removeClass("active");
				active_link.addClass("active");

			},
			offset: '35%'
		});


//------------------------------------- End navigation setup ------------------------------------------------//



//--------------------------------- Mobile menu --------------------------------//


var mobileBtn = $('.mobileBtn');
	var nav = $('#mainNav ul');
	var navHeight= nav.height();

$(mobileBtn).click(function(e) {
		e.preventDefault();
		nav.slideToggle();
		$('#mainNav li a').addClass('mobile');


});

$(window).resize(function(){
		var w = $(window).width();
		if(w > 320 && nav.is(':hidden')) {
			nav.removeAttr('style');
			$('#mainNav li a').removeClass('mobile');
		}

});



$('#mainNav li a').click(function(){
	if ($(this).hasClass('mobile')) {
        nav.slideToggle();
	}

});


//--------------------------------- End mobile menu --------------------------------//




//--------------------------------- Parallax --------------------------------//

$(".splash").parallax("100%", 0.3);

//--------------------------------- End parallax --------------------------------//


//---------------------------------- Site slider-----------------------------------------//




$('.overviewSlider').flexslider({
	animation: "fade",
	slideshow: true,
	directionNav:false,
	controlNav: true,
	animationSpeed: 2000
});


$('.testiSlider').flexslider({
	animation: "slide",
	slideshow: true,
	directionNav:false,
	controlNav: true
});



$('#owl-slider').owlCarousel({
    items : 4,
    itemsDesktop : [1199,4],
    itemsDesktopSmall : [979,4],
    itemsTablet: [768,2],
    itemsTabletSmall: [550,2],
    itemsMobile : [480,2],
});


//---------------------------------- End site slider-----------------------------------------//



//---------------------------------- Gallery -----------------------------------------//

$('.gall').magnificPopup({ 
	type: 'image',
	fixedContentPos: false,
	fixedBgPos: false,
	mainClass: 'mfp-no-margins mfp-with-zoom',
	image: {
		verticalFit: true
	},
	zoom: {
		enabled: true,
		duration: 300
	}
});


//---------------------------------- End gallery-----------------------------------------//


//--------------------------------- To the top  --------------------------------//

$().UItoTop({ easingType: 'easeOutQuart' });

//--------------------------------- End to the top --------------------------------//


//---------------------------------- Newsletter form validation-----------------------------------------//
$(".subscribeForm form").validate();
//---------------------------------- End newsletter form validation-----------------------------------------//


});

})(jQuery);



