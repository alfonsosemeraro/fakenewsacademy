$(document).ready(function(){ 
    //Creazione dei 3 grafici a barre a partire da file json
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = 'black';

    let ctx = $("#myCanvas").get(0);
    let ctx2 = $("#myCanvas-max").get(0);
    $.getJSON("../assets/data/year_production.json", function(data) {
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
                    label: "Articles",
                    data: myData,
                    backgroundColor: "#06C2A9",
                    hoverBorderWidth: 3,
                    hoverBorderColor: "#000"
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Articles published year by year',
                    fontSize: 25
                },
                legend: {
                    display: false
                }
            }
        });

        let myBarChart1 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: val,
                datasets: [{
                    label: "Articles",
                    data: valD,
                    backgroundColor: "#06C2A9",
                    hoverBorderWidth: 3,
                    hoverBorderColor: "#000",
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Articles published year by year: last 5 years',
                    fontSize: 25
                },
                legend: {
                    display: false
                }
            }
        });
    });

    let ctx1 = $("#canvas").get(0);
    $.getJSON("../assets/data/year_papers.json", function(data) {
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
        
        let myBarChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: myLabels,
                datasets: [{
                    label: "Articles",
                    data: myData,
                    backgroundColor: "#06C2A9",
                    hoverBorderWidth: 3,
                    hoverBorderColor: "#000"
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Years that the articles talk about',
                    fontSize: 25
                },
                legend: {
                    display: false
                }
            }
        });
    });
});