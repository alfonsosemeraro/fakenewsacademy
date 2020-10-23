$(document).ready(function(){
    var id = $("#paper").text();    
    $.ajax({
        type: "POST",
        url: "cit.php",
        data: "paper=" + id,
        dataType: "json",
        success: function(msg){
            console.log(msg);
        }, 
        error: function(){
            alert("errore");
        }
    });
});