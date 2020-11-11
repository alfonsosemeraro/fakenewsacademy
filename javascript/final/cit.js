$(document).ready(function() {
    //Creazione del grafico delle citazioni dopo aver preso i dati con AJAX
    var v = $("#paper").text();
    var title = $("h1").text();
    $.ajax({
        type: "POST",
        url: "graph.php",
        data: "paper=" + v,
        dataType: "json",
        success: function(msg) {
            var nodes = [];
            var links = [];
            nodes.push({"id": v,"label": title});
            $.each(msg, function(i, riga) {
                nodes.push({"id": riga.paper_id, "label": riga.title, "link": "final.php?paper=" + riga.paper_id});
                if (riga.target != undefined) {
                    links.push({"source": riga.paper_id, "target": riga.target});
                } else {
                    links.push({"source": riga.source, "target": riga.paper_id});
                }
            });
            
            if (links.length == "") {
                var mar = 100;
            } else if (links.length >=1 && links.length<=20){
                var mar = 300;
            } else {
                var mar = 900;
            }
                
            var margin = {top: 10, right: 40, bottom: 30, left: 40},
            width = 1000 - margin.left - margin.right,
            height = mar - margin.top - margin.bottom;
        
        
            // append the svg object to the body of the page
            var svg = d3.select("#my_dataviz")
            .append("svg")
              .attr("width", width + margin.left + margin.right)
              .attr("height", height + margin.top + margin.bottom)
            .append("g")
              .attr("transform",
                    "translate(" + margin.left + "," + margin.top + ")");
        
            function create() {
        
                // Initialize the links
                var link = svg
                .selectAll("line")
                .data(links)
                .enter()
                .append("line")
                .style("stroke", "#aaa")
        
                // Initialize the nodes
                var node = svg
                .selectAll("circle")
                .data(nodes)
                .enter()
                .append("a")
                .attr("href", nodes => nodes.link)
                .append("circle")
                .attr("r", 15)
                .style("fill", "#096E75")
                .on("mouseover", clickNode)
                .on("mouseout", outNode);
        
        
                function clickNode(node) {
                    // load tooltip content (if it changes based on node)
                    loadTooltipContent(node); 
                    // place tooltip where cursor was
                    return tooltip.style("top", (d3.event.pageY -10) + "px").style("left", (d3.event.pageX + 10) + "px").style("visibility", "visible");
                }
        
                function outNode(node) {
                    return tooltip.style("top", (d3.event.pageY -10) + "px").style("left", (d3.event.pageX + 10) + "px").style("visibility", "hidden");
                }
        
                function loadTooltipContent(node) {
                    var htmlContent = "<div>";
                    htmlContent += "<h4>" + node.label + "<\/h4>"
                    htmlContent += "<\/div>"
                    tooltip.html(htmlContent);
                }
        
                var tooltip = d3.select("body")
                .append("div")
                .attr("class", "tooltip")
                .style("position", "absolute")
                .style("padding", "10px")
                .style("z-index", "10")
                .style("width", "300px")
                .style("height", "100px")
                .style("background-color", "rgba(230, 242, 255, 0.8)")
                .style("border-radius", "5px")
                .style("visibility", "hidden")
                .text("");
        
                // Let's list the force we wanna apply on the network
                var simulation = d3.forceSimulation(nodes)                 // Force algorithm is applied to data.nodes
                .force("link", d3.forceLink()                               // This force provides links between nodes
                        .id(function(d) { return d.id; })                     // This provide  the id of a node
                        .links(links)                                    // and this the list of links
                )
                .force("charge", d3.forceManyBody().strength(-400))         // This adds repulsion between nodes. Play with the -400 for the repulsion strength
                .force("center", d3.forceCenter(width / 2, height / 2))     // This force attracts nodes to the center of the svg area
                .on("end", ticked);
        
                // This function is run at each iteration of the force algorithm, updating the nodes position.
                function ticked() {
                    link
                        .attr("x1", function(d) { return d.source.x; })
                        .attr("y1", function(d) { return d.source.y; })
                        .attr("x2", function(d) { return d.target.x; })
                        .attr("y2", function(d) { return d.target.y; });
        
                    node
                        .attr("cx", function (d) { return d.x+6; })
                        .attr("cy", function(d) { return d.y-6; });
                }
        
        
            };
        
            create();
            
        },
        error: function() {
            alert("Errore");
        }
    });
});