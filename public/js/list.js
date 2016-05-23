function renumberRows($dest, colNum){ // func takes a number of column with a counter
    $("tr td:nth-child(" + colNum + "):visible", $dest).each(function(index, elem){
        $(this).text(index + 1);
    });
}

function generate_genre_filter_list(){
	$("#filter_list_genre, #filter_list_year").html("");
	
    var genres = {};
	$("td.genre_cell:visible").each(function(index, elem){
	    elem.innerText.split(",").forEach(function(e){
	       if (e in genres)
    	       genres[e]++; 
    	   else
    	       genres[e] = 1;
	    }); 
	});
	
	var keys = Object.keys(genres);
	keys.sort()
	for (var i=0; i<keys.length; i++){
		var genre = keys[i];
		$("<a>", {href: "#"})
			.text(genre + " (" + genres[genre] + ")")
			.on("click", {'genre': genre}, function(e){
				$("tbody tr:not(:has(td.genre_cell:contains('" + e.data.genre + "')))").hide();
				e.preventDefault();
				generate_genre_filter_list();
				generate_year_filter_list();
				renumberRows($("#dest"), 1);
			})
			.appendTo("#filter_list_genre")
			.after((i==keys.length-1) ? "" : " &sdot; ");
	}
}

function generate_year_filter_list(){
	var years = {};
	$("td.date_cell:visible").each(function(index, elem){
	    var year = (new Date(elem.innerText)).getFullYear();
        if (year in years)
           years[year]++; 
        else
           years[year] = 1;
	});
	
	var keys = Object.keys(years);
	keys.sort()
	for (var i=0; i<keys.length; i++){
		var year = keys[i];
		$("<a>", {href: "#"})
			.text(year + " (" + years[year] + ")")
			.on("click", {'year': year}, function(e){
				$("tbody tr:not(:has(td.date_cell:contains('" + e.data.year + "')))").hide();
				e.preventDefault();
				generate_genre_filter_list();
				generate_year_filter_list();
				renumberRows($("#dest"), 1);
			})
			.appendTo("#filter_list_year")
			.after((i==keys.length-1) ? "" : " &sdot; ");
	}
}
    
$(function()
{
    $("#dest").addSortWidget({
		img_asc: "../img/asc_sort.gif",	
        img_desc: "../img/desc_sort.gif",	
		img_nosort: "../img/no_sort.gif",		
	});
	
	$("[data-toggle='tooltip']").tooltip();
	
	$(".reset_filters").on("click", function(e){
		e.preventDefault();	
		
		$("tbody tr").show();
		
		generate_genre_filter_list();
		generate_year_filter_list();
		renumberRows($("#dest"), 1);
	});
	
	generate_genre_filter_list();
	generate_year_filter_list();
});