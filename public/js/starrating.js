/*
 * starrating.js
 *
 * Requires: jQuery (tested with v 1.11)
 *
 * jQuery plug-in that adds to a web-page the customised rating widget
*/

jQuery.fn.addStarRating = function(options){
	var defaults = {
		width: null, 								// container max width
		img_filled: "/img/star-filled-48.png",		// path to filled image
		img_empty: "/img/star-empty-48.png",		// path to empty image
		input_id: "",								// input's ID where rating value will be stored
		max: 10										// amount of 'stars'
	};
	
	var options = $.extend({}, defaults, options),
		$destElement = $(this),
		star_filled = new Image(),
		star_empty = new Image(),
		star_style = { 								// styles for images (stars)
			margin: '0px',
			width: (options.width) ? Math.floor(options.width / options.max) : 'auto',
			cursor: 'pointer',
		},
		rating = 0;
		
	$destElement.css('display', 'inline').css('white-space', 'nowrap'); // styles for container
		
	star_filled.src = options.img_filled;
	star_empty.src = options.img_empty;
	
	for (var i=0; i<options.max; i++){
		// creates every 'star' and add it to container
		var $new_star = $(star_empty).clone();
		
		$destElement.append($new_star);
		
		$new_star
			.css(star_style)
			.addClass('rating_star')
			.data('id', i+1)
			.on('mouseover', function(event){
				var index = parseInt($(this).data("id"), 10);
				
				// makes all 'stars' filled within current container ($destElement) that are placed before (and under) cursor 
				$(".rating_star:lt(" + (index) + ")", $destElement).attr("src", options.img_filled);
				
				// makes all 'stars' emptied within current container ($destElement) that are placed after cursor 
				$(".rating_star:gt(" + (index-1) + ")", $destElement).attr("src", options.img_empty);

			})
			.on('mouseleave', function(event){
				if (rating == 0){
					// if rating is not set yet then make all 'stars' emptied
					$(".rating_star", $destElement).attr("src", options.img_empty);
				} else {
					// set widget's 'stars' accordingly to rating value
					$(".rating_star:lt(" + (rating) + ")", $destElement).attr("src", options.img_filled);
					$(".rating_star:gt(" + (rating-1) + ")", $destElement).attr("src", options.img_empty);
				}
			})
			.on('click', function(event){
				rating = parseInt($(this).data("id"), 10); // sets raating variable
				$("#" + options.input_id).val(rating); // stores rating into input box
			});
		
		
	}
	
	return $destElement;

};