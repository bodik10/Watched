$(function(){
    $(".list-group-item:not(.disabled)").on("click", function(e){
        var type = $(this).text();
        $("#statistic_header").text(type);
        $(".list-group-item").removeClass("active");
        $(this).addClass("active");
        
        $("#result, #advanced_info").html("");
        $("#info").html("Loading...");
        
        // get statistic information
        $.getJSON("load-statistic.php", {type: type})
        .done(function(data, textStatus, jqXHR) {
            $("#result").html(data.result);
            $("#info").html(data.info);
            $("#advanced_info").html(data.advanced_info);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown.toString());
        })
        
        e.preventDefault();
    });
});