var fields = ['imdb-id', 'date', 'released', 'rating-imdb', 'poster', 'plot', 'genre', 'runtime'];

$(function()
{
    
    $("#addbutton").prop("disabled", true);
    
    $("#rating-container").addStarRating({
        img_filled: "/img/star-filled-48.png",	
		img_empty: "/img/star-empty-48.png",	
		input_id: "rating",							
		max: 5, 
		width: 140
    });
    
    // Prevent Users from submitting form by hitting enter
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });
    
    $("#movie")
    .on("keydown", function(event){
        clear_fields();
    })
    .autocomplete({
        minLength: 2,
        source: "search.php",
        select: function(event, ui){
            $("#imdb-id").val(ui.item.id);
            
            load_info(ui.item.id);
            
            check_form();
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        var title_description = item.title_description.split(",");
        return $( "<li>" )
            .append( item.title + " (" + title_description[0].trim() + ")" )
            .appendTo( ul );
    };
    
    $("#date").on("change", check_form);
});

function clear_fields(){
    $("div.description img").attr('src', '');
    $("div.description h3").text("No movie has been selected");
    $("div.description p").text("");
    $("span.imdbRatingPlugin a").attr('href', '').text('');
    
    for (var i=0; i<fields.length; i++){
        $("#" + fields[i]).val("");
    }
    check_form();
}

function check_form(){
    for (var i=0; i<fields.length; i++){
        if (!$("#" + fields[i]).val()){
            $("#addbutton").prop("disabled", true);
            return;
        }
    }
    $("#addbutton").prop("disabled", false);
}

function load_info(imdb_id)
{
    $("div.description img").attr('src', 'img/loading_spinner.gif');
    $("div.description h3").text("Loading...");
    
    // get places matching query (asynchronously)
    var parameters = {
        imdb_id: imdb_id,
    };
    $.getJSON("load-info.php", parameters)
    .done(function(data, textStatus, jqXHR) {
        $("#released").val(data["year"]);
        $("#plot").val(data["plot"]);
        $("#rating-imdb").val(data["imdb-rating"]);
        $("#runtime").val(data["runtime"]);
        $("#poster").val(data["poster"]);
        $("#genre").val(data["genre"]);
        
        show_info(data, imdb_id);
        
        check_form();
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        clear_fields();
        // log error to browser's console
        console.log(errorThrown.toString());
    });
}

function show_info(data, imdb_id){
    $("div.description img").attr('src', data["poster"]);
    $("div.description h3").text( $("#movie").val() + ' (' + data['year'] + ')' );
    $("div.description p.movie_info").text( data['genre'] + ' | ' + data['runtime'] );
    $("div.description p.movie_description").text( data['plot'] );
    
    $("span.imdbRatingPlugin a").attr('href', 'http://www.imdb.com/title/' + imdb_id + '/').text( 'IMDb Rating: ' + data['imdb-rating'] );
}