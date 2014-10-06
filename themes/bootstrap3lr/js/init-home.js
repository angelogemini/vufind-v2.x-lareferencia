//toggle partner's images
$(document).ready(function() {
	
$(".partner a").hover(function(e) {	
	e.preventDefault();
    $(this).find('img').toggle();
});

});