Plotly.d3.json('assets/data/map_papers.json', function(rows){

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
        autocolorscale: true
    }];

    var layout = {
      title: 'Articoli per paese',
      geo: {
          projection: {
              type: 'robinson'
          }
      }
    };

    Plotly.newPlot("myDiv", data, layout, {showLink: false});

});
