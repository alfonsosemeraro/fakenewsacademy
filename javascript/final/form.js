$(document).ready(function() {
    //Restituisce gli articoli degli stessi autori e gli articoli simili
    var aut = $("#authors").text();
    var v = $("#paper").text();
    $("h5").hide();
    $("h4").hide();
    $.ajax({
        type: "POST",
        url: "authors.php",
        data: "author=" + aut + "&paper=" + v,
        dataType: "json",
        success: function(msg) {
            if (msg.length == 0) {
                $("#art-art").hide();
            }
            $.each(msg, function(i, riga) {
                var txt = $("<li></li>");
                var txt1 = $("<a></a>").attr("href", "final.php?paper="+riga.paper_id).text(riga.title+ "; ");
                txt.append(txt1, riga.author+"; "+riga.year);
                
                $('#eqaut').append(txt);
            });
        },
        error: function() {
            $('#eqaut').text("Errore");
        }
    });

    $.ajax({
        type: "POST",
        url: "similar.php",
        data: "paper=" + v,
        dataType: "json",
        success: function(msg) {
            if (msg.length == 0) {
                $("#sim-sim").hide();
            }
            $.each(msg, function(i, riga) {
                var txt = $("<li></li>");
                var txt1 = $("<a></a>").attr("href", "final.php?paper="+riga.paper_id).text(riga.title + "; ");
                txt.append(txt1, riga.author + "; "+riga.year);
                
                $('#simart').append(txt);
            });
        },
        error: function() {
            $('#simart').text("Errore");
        }
    });
});   