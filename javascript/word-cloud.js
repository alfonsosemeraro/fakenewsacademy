$(document).ready(function() {
    //Funzione necessaria per la creazione della word-cloud a 
    //partire dal un file json
    $.getJSON( "../assets/data/top_keywords.json", function(data) {
        var result = [];
        var myLabels = [];
        var myData = [];
        var d = [];

        for(var i in data) {
            result.push([i, data [i]]);
        }
        for (var j=0; j<result.length; j++) {
            myLabels.push(result[j][0]);
        }
        for (var k=0; k<result.length; k++) {
            myData.push(result[k][1]);
        }
        for (var l=0; l<result.length; l++) {
            d.push({"text": myLabels[l], "weight": myData[l], "link": 'results.php?title='+myLabels[l]});
        }

        $("#container").jQCloud(d, {
            fontSize: {
                from: 0.05,
                to: 0.02
            },
            autoResize: true
        });
    });
        
} );