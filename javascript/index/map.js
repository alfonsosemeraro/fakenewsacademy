Plotly.d3.json('../assets/data/map_papers.json', function(rows){
    //Funzione necessaria per la costruzione della choropleth map
    // a partire da un file json
    var result = [];
    var myLabels = [];
    var myData = [];

    for(var i in rows) {
        result.push([i, rows [i]]);
    }
    for (var j=0; j<result.length; j++) {
        myLabels.push(result[j][0]);
    }
    for (var k=0; k<result.length; k++) {
        myData.push(result[k][1]);
    }

    var data = [{
        type: 'choropleth',
        locationmode: 'country names',
        locations: myLabels,
        z: myData,
        text: myLabels,
        colorscale: [
            [0,'#096E75'],[0.35,'#208f96'],
            [0.5,'#4caab0'], [0.6,'#06C2A9'],
            [0.7,'#07d9bd'],[1,'rgb(220, 220, 220)']
        ],
        autocolorscale: false,
        reversescale: true,
        marker: {
            line: {
                color: 'rgb(180,180,180)',
                width: 0.5
            }
        }
    }];

    var layout = {
      title: 'Articles by country',
      geo: {
        projection: {
            type: 'robinson'
        }
      },
      dragmode: false,
      autosize: false,
      width: 520,
      height: 350
    };

    var config = {responsive: true}

    Plotly.newPlot("myDiv", data, layout, config, {showLink: false});

});
