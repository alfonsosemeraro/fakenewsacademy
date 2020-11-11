$(document).ready(function() {
    //Restituisce gli articoli nelle pagine successive
    //e nelle pagine precedenti quando viene premuto prev
    var page = 1;
    var text = $("h2").text();
    $("h2").hide();
    var maxBet = $("h6").text();
    $("h6").hide();
    var maxInd = $("h5").text();
    console.log(maxInd);
    $("h5").hide();
    $("#prev-page").hide();
    $("#pag-ord").hide();
    $("#pag-cit").hide();
    $("#pag-bet").hide();
    $("#pag-ind").hide();
    $("#pag-clust").hide();
    $("#pag-rank").hide();

    $("#next-page").click(function() {
        page++;
        loadData(text, page, maxBet, maxInd);
        $("#prev-page").show();
        $('body,html').animate({scrollTop:0},800);
    });

    $("#prev-page").click(function() {
        page--;
        loadData(text, page, maxBet, maxInd);
        if (page == 1) {
            $("#prev-page").hide();
        }
        $("#next-page").show();
        $('body,html').animate({scrollTop:0},800);
    });
});  

function loadData(text, page, maxBet, maxInd) {
    $.ajax({
        type: "POST",
        url: "res.php",
        data: text + "&page=" + page,
        dataType: "json",
        success: function(msg) {
            $("#all-papers #papers").hide();
            if (msg.length < 10) {
                $("#next-page").hide();
            }
            if (msg.length > 0) {
                $.each(msg, function(i, riga) {
                    var txt = $("<div></div>").attr("id", "papers");
                    var h = $("<h3></h3>");
                    var a = $("<a></a>").attr("href", "../final/final.php?paper="+riga.paper_id).attr("class", "tooltip").text(riga.title);
                    var span = $("<span></span>").attr("class", "tooltiptext");
                    span.append("<h3>"+riga.title+"</h3>", "<p>"+riga.author+"</p>", "<p>"+riga.year+"</p>", "<p>"+riga.abstract+"</p>");
                    a.append(span);
                    h.append(a);
                    var txt1 = $("<div></div>").attr("id", "year-aut");
                    txt1.append("<p>"+riga.author+"</p>", "<p>"+riga.year+"</p>");
                    if (riga.abstract.length > 500) {
                     var txt2 = $("<div></div>").attr("id", "abstr").text(riga.abstract.substring(0, 500)+"...");
                    } else {
                     var txt2 = $("<div></div>").attr("id", "abstr").text(riga.abstract);
                    }
                    var txt3 = $("<div></div>").attr("id", "paperInfo");
                    if (riga.betweenness<=maxBet/5) {
                        var bet = $("<p></p>").text("Betweenness: \u2193");
                    } else if (riga.betweenness>maxBet/5 && riga.betweenness<=maxBet/5*2) {
                        var bet = $("<p></p>").text("Betweenness: \u2198");
                    } else if (riga.betweenness>maxBet/5*2 && riga.betweenness<=maxBet/5*3) {
                        var bet = $("<p></p>").text("Betweenness: \u2192");
                    } else if (riga.betweenness>maxBet/5*3 && riga.betweenness<=maxBet/5*4) {
                        var bet = $("<p></p>").text("Betweenness: \u2197");
                    } else {
                        var bet = $("<p></p>").text("Betweenness: \u2191");
                    }
                    if (riga.indegree<=maxInd/5) {
                        var ind = $("<p></p>").text("Indegree: \u2193");
                    } else if (riga.indegree>maxInd/5 && riga.indegree<=maxInd/5*2) {
                        var ind = $("<p></p>").text("Indegree: \u2198");
                    } else if (riga.indegree>maxInd/5*2 && riga.indegree<=maxInd/5*3) {
                        var ind = $("<p></p>").text("Indegree: \u2192");
                    } else if (riga.indegree>maxInd/5*3 && riga.indegree<=maxInd/5*4) {
                        var ind = $("<p></p>").text("Indegree: \u2197");
                    } else {
                        var ind = $("<p></p>").text("Indegree: \u2191");
                    }
                    if (riga.clustering>=0 && riga.clustering<=0.2) {
                        var clust = $("<p></p>").text("Clustering: \u2193");
                    } else if (riga.clustering>0.2 && riga.clustering<=0.4) {
                        var clust = $("<p></p>").text("Clustering: \u2198");
                    } else if (riga.clustering>0.4 && riga.clustering<=0.6) {
                        var clust = $("<p></p>").text("Clustering: \u2192");
                    } else if (riga.clustering>0.6 && riga.clustering<0.8) {
                        var clust = $("<p></p>").text("Clustering: \u2197");
                    } else {
                        var clust = $("<p></p>").text("Clustering: \u2191");
                    }
                    if (riga.pagerank>=0 && riga.pagerank<=0.2) {
                        var pagerank = $("<p></p>").text("Pagerank: \u2193");
                    } else if (riga.pagerank>0.2 && riga.pagerank<=0.4) {
                        var pagerank = $("<p></p>").text("Pagerank: \u2198");
                    } else if (riga.pagerank>0.4 && riga.pagerank<=0.6) {
                        var pagerank = $("<p></p>").text("Pagerank: \u2192");
                    } else if (riga.pagerank>0.6 && riga.pagerank<0.8) {
                        var pagerank = $("<p></p>").text("Pagerank: \u2197");
                    } else {
                        var pagerank = $("<p></p>").text("Pagerank: \u2191");
                    }
                    txt3.append("<p>"+"cit: "+riga.cit+",</p>", bet, ind, clust, pagerank);
                    txt.append(h, txt1, txt2, txt3);
                    $("#all-papers").append(txt);
                });
            } else {
                $("#pag").hide();
                $("#ord").hide();
                $("#ord-cit").hide();
                $("#ord-ind").hide();
                $("#ord-bet").hide();
                $("#ord-rank").hide();
                $("#ord-clust").hide();
            }
        },
        error: function() {
            $("#all-papers").text("Errore");
            $("#pag").hide();
            $("#ord").hide();
            $("#ord-cit").hide();
            $("#ord-ind").hide();
            $("#ord-bet").hide();
            $("#ord-rank").hide();
            $("#ord-clust").hide();
        }
    });
}