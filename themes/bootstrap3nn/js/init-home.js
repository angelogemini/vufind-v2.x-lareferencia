//toggle partner's images
$(document).ready(function() {
/*	
$('#partners').flexslider({
    animation: "slide",
    easing: "swing",
    animationLoop: true,
    itemWidth: 1,
    itemMargin:30,
    minItems: 2,
    maxItems: 8,
    controlNav: false,
    directionNav: false,
    move: 2
});*/
		
$(".pick-nodes a").hover(function(e) {	
	e.preventDefault();
    $(this).find('img').toggle();
});

$(".partners a").hover(function(e) {	
	e.preventDefault();
    $(this).find('img').toggle();
});


$('#partns-viewport').carousel(5000); 
$('#nodes-viewport').carousel(5000);


});


