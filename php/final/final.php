<?php
include_once("../common.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--
            Autore: Calabrese Camilla
            Contenuto: pagina contenente le informazioni di un paper
         -->
        <title>Fake News</title>
        <meta charset="utf-8" >
        <link href="../../css/index.css" type="text/css" rel="stylesheet">   
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="../../javascript/final/form.js" type="text/javascript"></script>
        <script src="https://d3js.org/d3.v4.js"></script>
        <script src="../../javascript/final/cit.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="nav">
            <ul>
                <li><a href="../index.php">Logo</a></li>
                <li><a href="../../html/project.html">Project</a></li>
                <li><a href="../../html/methods.html">Methods</a></li>
                <li style="float:right"><a href="../../html/about.html">About us</a></li>
            </ul>
        </div>
        <div><img src="../../img/wave.jpg" alt="wave"/></div>
        <?php 
        $art = $_GET["paper"];
        $db = db_connect();
        $paper = $db->quote($art);
        //Query che restituisce tutte le informazioni del paper scelto
        $rs = $db->query("SELECT * FROM papers WHERE paper_id = $paper");
        $maxBet =  $db->query("SELECT betweenness FROM papers ORDER BY betweenness DESC LIMIT 0,1");
        $maxInd =  $db->query("SELECT indegree FROM papers ORDER BY indegree DESC LIMIT 0,1");
        foreach($maxBet as $max) { ?>
            <h5><?= $max[0] ?></h5>
        <?php }
        foreach ($maxInd as $mind) { ?>
            <h4><?= $mind[0] ?></h4>
        <?php }
        if ($rs->rowCount()>0){ 
            foreach ($rs as $row) { ?>
        <div id="abstract">
            <h1><?= $row[1] ?></h1>
            <p id="authors"> <?= $row[2] ?> </p>
            <p> <?= $row[3] ?> </p>
            <p> <?= $row[5] ?> </p>
            <div id="paper-info">
                <p>Cit: <?= $row[4] ?>,</p>
                <?php if ($row[6] <= ($max[0]/5)) { ?>
                    <p>Betweenness: &#x2193;</p>
                <?php } else if ($row[6] > ($max[0]/5) && $row[6] <= ($max[0]/5*2)) { ?>
                    <p>Betweenness: &#x2198;</p>
                <?php } else if ($row[6] > ($max[0]/5*2) && $row[6] <= ($max[0]/5*3)) { ?>
                    <p>Betweenness: &#x2192;</p>
                <?php } else if ($row[6] > ($max[0]/5*3) && $row[6] <= ($max[0]/5*4)) { ?>
                    <p>Betweenness: &#x2197;</p>
                <?php } else { ?>
                    <p>Betweenness: &#x2191;</p>
                <?php } ?>
                <?php if ($row[7] <= ($mind[0]/5)) { ?>
                    <p>Indegree: &#x2193;</p>
                <?php } else if ($row[7] > ($mind[0]/5) && $row[7] <= ($mind[0]/5*2)) { ?>
                    <p>Indegree: &#x2198;</p>
                <?php } else if ($row[7] > ($mind[0]/5*2) && $row[7] <= ($mind[0]/5*3)) { ?>
                    <p>Indegree: &#x2192;</p>
                <?php } else if ($row[7] > ($mind[0]/5*3) && $row[7] <= ($mind[0]/5*4)) { ?>
                    <p>Indegree: &#x2197;</p>
                <?php } else { ?>
                    <p>Indegree: &#x2191;</p>
                <?php } ?>
                <?php if ($row[8]>=0 && $row[8]<=0.2) { ?>
                    <p>Clustering: &#x2193;</p>
                <?php } else if ($row[8]>0.2 && $row[8]<=0.4) { ?>
                    <p>Clustering: &#x2198;</p>
                <?php } else if ($row[8]>0.4 && $row[8]<=0.6) { ?>
                    <p>Clustering: &#x2192;</p>
                <?php } else if ($row[8]>0.6 && $row[8]<=0.8) { ?>
                    <p>Clustering: &#x2197;</p>
                <?php } else { ?>
                    <p>Clustering: &#x2191;</p>
                <?php } ?>
                <?php if ($row[9]>=0 && $row[9]<=0.2) { ?>
                    <p>Pagerank: &#x2193;</p>
                <?php } else if ($row[9]>0.2 && $row[9]<=0.4) { ?>
                    <p>Pagerank: &#x2198;</p>
                <?php } else if ($row[9]>0.4 && $row[9]<=0.6) { ?>
                    <p>Pagerank: &#x2192;</p>
                <?php } else if ($row[9]>0.6 && $row[9]<=0.8) { ?>
                    <p>Pagerank: &#x2197;</p>
                <?php } else { ?>
                    <p>Pagerank: &#x2191;</p>
                <?php } ?>
            </div> 
            <h6 id="paper"><?= $row[0] ?></h6>
        </div>    
        <?php }
        }
        ?>
        <div id="art">
            <h2 id="art-art">Articles by the same authors:</h2>
            <ol id="eqaut">
            </ol>  
        </div>  
        <div id="art">
            <h2 id="sim-sim">Similar articles:</h2>
            <ol id="simart">
            </ol>   
        </div> 
        <div id="my_dataviz">
            <h2>Citation graph</h2>
            <p>Articles cited and articles citing the chosen article (located in the center)</p>
        </div>    
    </body>
</html>