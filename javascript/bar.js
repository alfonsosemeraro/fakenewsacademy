$(document).ready(function(){ 
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = 'black';

    let ctx = $("#myCanvas").get(0);
    let ctx2 = $("#myCanvas-max").get(0);
    $.getJSON("assets/data/year_production.json", function(data) {
        var result = [];
        var myLabels = [];
        var myData = [];

        for(var i in data) {
            result.push([i, data [i]]);
        }
        for (var j=0; j<result.length; j++) {
            myLabels.push(result[j][0]);
        }
        for (var k=0; k<result.length; k++) {
            myData.push(result[k][1]);
        }

        
        var val = [];
        var valD = [];
        var data = new Date();
        for (var t=1; t<result.length; t++) {
            if ((data.getFullYear() - myLabels[t]) < 5) {
                val.push(myLabels[t]);
                valD.push(myData[t])
            }
        }
        
    
        let myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: myLabels,
                datasets: [{
                    label: "Articoli",
                    data: myData,
                    backgroundColor: "rgb(0, 202, 136)",
                    hoverBorderWidth: 3,
                    hoverBorderColor: "#000"
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Articoli pubblicati anno per anno',
                    fontSize: 25
                },
                legend: {
                    display: false
                },
                layout: {
                    padding: 50
                }
            }
        });

        let myBarChart1 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: val,
                datasets: [{
                    label: "Articoli",
                    data: valD,
                    backgroundColor: "rgb(0, 202, 136)",
                    hoverBorderWidth: 3,
                    hoverBorderColor: "#000",
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Articoli pubblicati anno per anno: ultimi 5 anni',
                    fontSize: 25
                },
                legend: {
                    display: false
                },
                layout: {
                    padding: 100
                }
            }
        });
    });

    let ctx1 = $("#canvas").get(0);
    let ctx3 = $("#canvas-max").get(0);
    $.getJSON("assets/data/year_papers.json", function(data) {
        var result = [];
        var myLabels = [];
        var myData = [];

        for(var i in data) {
            result.push([i, data [i]]);
        }
        result.pop();
        for (var j=0; j<result.length; j++) {
            myLabels.push(result[j][0]);
        }
        for (var k=0; k<result.length; k++) {
            myData.push(result[k][1]);
        }

        var val = [];
        var valD = [];
        var data = new Date();
        for (var t=1; t<result.length; t++) {
            if ((data.getFullYear() - myLabels[t]) < 5) {
                val.push(myLabels[t]);
                valD.push(myData[t])
            }
        }
        
        let myBarChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: myLabels,
                datasets: [{
                    label: "Articoli",
                    data: myData,
                    backgroundColor: "rgb(0, 202, 136)",
                    hoverBorderWidth: 3,
                    hoverBorderColor: "#000"
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Articoli pubblicati per anno',
                    fontSize: 25
                },
                legend: {
                    display: false
                },
                layout: {
                    padding: 50
                }
            }
        });

        let myBarChart1 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: val,
                datasets: [{
                    label: "Articoli",
                    data: valD,
                    backgroundColor: "rgb(0, 202, 136)",
                    hoverBorderWidth: 3,
                    hoverBorderColor: "#000"
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Articoli pubblicati per anno',
                    fontSize: 25
                },
                legend: {
                    display: false
                },
                layout: {
                    padding: 100
                }
            }
        });
    });
});