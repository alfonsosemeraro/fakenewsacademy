<?php
include_once("../common.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--
            Autore: Calabrese Camilla
            Contenuto: pagina contenente la tabella dei papers
         -->
        <title>Fake News</title>
        <meta charset="utf-8" >
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="../../javascript/results/results.js" type="text/javascript"></script>
        <script src="../../javascript/results/ord-date.js" type="text/javascript"></script>
        <script src="../../javascript/results/ord-cit.js" type="text/javascript"></script>
        <script src="../../javascript/results/ord-bet.js" type="text/javascript"></script>
        <script src="../../javascript/results/ord-ind.js" type="text/javascript"></script>
        <script src="../../javascript/results/ord-clust.js" type="text/javascript"></script>
        <script src="../../javascript/results/ord-rank.js" type="text/javascript"></script>
        <link href="../../css/index.css" type="text/css" rel="stylesheet">  
        
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
        <div id="form">
            <form action="results.php" method="POST">
                <div class="inner-form">
                    <div class="basic-search">
                        <div class="input-field">
                            <input type="text" id="search" placeholder="Type Keywords" name="search">
                            <div class="icon-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="advance-search">
                        <span class="desc">ADVANCED SEARCH</span>
                        <div class="row">
                            <label><strong>Years:</strong></label>                           
                            <input type="text" id="year-min" placeholder="starting year" name="year-min"> -
                            <input type="text" id="year-max" placeholder="final year" name="year-max">
                        </div>
                        <div class="row">
                            <label><strong>Cit:</strong></label>
                            <input type="text" id="cit-min" placeholder="min number of cit" name="cit-min"> -
                            <input type="text" id="cit-max" placeholder="max number of cit" name="cit-max">
                        </div>
                        <div class="row">
                            <label><strong>Author:</strong></label>
                            <input type="text" id="author" placeholder="Author" name="author">
                        </div>
                        <div class="row">
                            <div class="btn">
                                <button type="reset" class="btn-delete" id="delete">RESET</button>
                                <button type="submit" class="btn-search" id="search-btn">SEARCH</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php 
            //Query che restituisce in forma di tabella tutti i papers che hanno  
            //le caratteristiche scelte nel form dall'utente.
            $db = db_connect();
            $page = (!isset($_GET['page']))? 1 : $_GET['page']; 
            $prev = ($page - 1); 
            $next = ($page + 1);
            $max_results = 10;
            $from = (($page * $max_results) - $max_results); 
            if (isset($_REQUEST["search"])) {
                $search = $_REQUEST["search"];
                $query = "SELECT * FROM papers WHERE title LIKE '%$search%'";
                $pages = "search=$search";
                if (isset($_REQUEST["year-min"]) && strcmp($_REQUEST["year-min"], "")) {
                    $yearMin = $_REQUEST["year-min"];
                    $ymin = $db->quote($yearMin);
                    $query = $query . " AND year >= $ymin";
                    $pages = $pages . "&year-min=$yearMin";
                }
                if (isset($_REQUEST["year-max"]) && strcmp($_REQUEST["year-max"], "")) {
                    $yearMax = $_REQUEST["year-max"];
                    $ymax = $db->quote($yearMax);
                    $query = $query . " AND year <= $ymax";
                    $pages = $pages . "&year-max=$yearMax";
                }
                if (isset($_REQUEST["cit-min"]) && strcmp($_REQUEST["cit-min"], "")) {
                    $citMin = $_REQUEST["cit-min"];
                    $cmin = $db->quote($citMin);
                    $query = $query . " AND cit >= $cmin";
                    $pages = $pages . "&cit-min=$citMin";
                }
                if (isset($_REQUEST["cit-max"]) && strcmp($_REQUEST["cit-max"], "")) {
                    $citMax = $_REQUEST["cit-max"];
                    $cmax = $db->quote($citMax);
                    $query = $query . " AND cit <= $cmax";
                    $pages = $pages . "&cit-max=$citMax";
                }
                if (isset($_REQUEST["author"]) && strcmp($_REQUEST["author"], "")) {
                    $author = $_REQUEST["author"]; 
                    $query = $query . " AND author LIKE '%$author%'";
                    $pages = $pages . "&author=$author";
                }
                $result = $db->query($query);
                $total_pages = ceil($result->rowCount() / $max_results); 
                $query = $query . " LIMIT $from, $max_results";
                $rows = $db->query($query);
            } else {
                $search = $_REQUEST["title"];
                $result = $db->query("SELECT * FROM papers WHERE title LIKE '%$search%'");
                $total_pages = ceil($result->rowCount() / $max_results); 
                $rows = $db->query("SELECT * FROM papers WHERE title LIKE '%$search%' LIMIT $from, $max_results");
                $pages = "title=$search";
            }
            $maxBet =  $db->query("SELECT betweenness FROM papers ORDER BY betweenness DESC LIMIT 0,1");
            $maxInd =  $db->query("SELECT indegree FROM papers ORDER BY indegree DESC LIMIT 0,1");
            foreach($maxBet as $max) { ?>
                <h6><?= $max[0] ?></h6>
            <?php }
            foreach ($maxInd as $mind) { ?>
                <h5><?= $mind[0] ?></h5>
            <?php }
        ?>
        <h1><?= $search ?> search results</h1>
        <h2><?= $pages ?></h2>
        <div id="all-papers">  
        <?php
            if ($rows->rowCount()>0){ ?>
            <fieldset>
                <div id="leg">
                    <h3>Legend for Clustering and Pagerank:</h3>
                    <ul>
                        <li>values between 0 and 0.2: &#x2193;</li>
                        <li>values between 0.2 and 0.4: &#x2198;</li>
                        <li>values between 0.4 and 0.6: &#x2192;</li>
                        <li>values between 0.6 and 0.8: &#x2197;</li>
                        <li>values between 0.8 and 1: &#x2191;</li>
                    </ul>
                </div>
                <div id="leg">
                    <h3>Legend for Betweenness:</h3>
                    <ul>
                        <li>values between 0 and <?= $max[0]/5?>: &#x2193;</li>
                        <li>values between <?= $max[0]/5?> and <?= $max[0]/5*2?>: &#x2198;</li>
                        <li>values between <?= $max[0]/5*2?> and <?= $max[0]/5*3?>: &#x2192;</li>
                        <li>values between <?= $max[0]/5*3?> and <?= $max[0]/5*4?>: &#x2197;</li>
                        <li>values between <?= $max[0]/5*4?> and <?= $max[0]?>: &#x2191;</li>
                    </ul>
                </div>
                <div id="leg">
                    <h3>Legend for Indegree:</h3>
                    <ul>
                        <li>values between 0 and <?= $mind[0]/5?>: &#x2193;</li>
                        <li>values between <?= $mind[0]/5?> and <?= $mind[0]/5*2?>: &#x2198;</li>
                        <li>values between <?= $mind[0]/5*2?> and <?= $mind[0]/5*3?>: &#x2192;</li>
                        <li>values between <?= $mind[0]/5*3?> and <?= $mind[0]/5*4?>: &#x2197;</li>
                        <li>values between <?= $mind[0]/5*4?> and <?= $mind[0]?>: &#x2191;</li>
                    </ul>
                </div>
            </fieldset>
            <div id="order">
                <input type="button" id="ord" value="SORT BY DATE">
                <input type="button" id="ord-bet" value="SORT BY BETWEENNESS">
                <input type="button" id="ord-cit" value="SORT BY CIT">
                <input type="button" id="ord-ind" value="SORT BY INDEGREE">
                <input type="button" id="ord-clust" value="SORT BY CLUSTERING">
                <input type="button" id="ord-pagerank" value="SORT BY PAGERANK">
            </div> 
                <?php  
                    foreach ($rows as $row) { ?> 
                    <div id="papers">
                        <h3><a href="../final/final.php?paper=<?= $row[0] ?>" class="tooltip"><?= $row[1] ?>
                            <span class="tooltiptext">
                                <h3><?= $row[1] ?></h3>
                                <p><?= $row[2] ?></p>
                                <p><?= $row[3] ?></p>
                                <p><?= $row[5] ?></p>
                            </span>
                        </a></h3>
                        <div id="year-aut">
                            <p><?= $row[2] ?></p> 
                            <p><?= $row[3] ?></p> 
                        </div>
                        <?php if (strlen($row[5])>500) {?>
                            <div id="abstr"><?= substr($row[5], 0, 500) . "..." ?></div> 
                        <?php } else { ?>
                            <div id="abstr"><?= $row[5] ?></div> 
                        <?php } ?>
                        <div id="paperInfo">
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
                    </div>
                <?php      
                    }
                ?>
        </div>
            <?php } else { ?>
                <p id="not">Papers not found.</p>
            <?php
            }

            if ($rows->rowCount()>0 && $result->rowCount()>10) {
            ?> 
                <div id="pag">
                    <input type="button" id="prev-page" value="PREV">
                    <input type="button" id="next-page" value="NEXT">
                </div>   
                <div id="pag-ord">
                    <input type="button" id="prev-ord" value="PREV">
                    <input type="button" id="next-ord" value="NEXT">
                </div>  
                <div id="pag-cit">
                    <input type="button" id="prev-cit" value="PREV">
                    <input type="button" id="next-cit" value="NEXT">
                </div>  
                <div id="pag-bet">
                    <input type="button" id="prev-bet" value="PREV">
                    <input type="button" id="next-bet" value="NEXT">
                </div> 
                <div id="pag-ind">
                    <input type="button" id="prev-ind" value="PREV">
                    <input type="button" id="next-ind" value="NEXT">
                </div> 
                <div id="pag-clust">
                    <input type="button" id="prev-clust" value="PREV">
                    <input type="button" id="next-clust" value="NEXT">
                </div> 
                <div id="pag-rank">
                    <input type="button" id="prev-rank" value="PREV">
                    <input type="button" id="next-rank" value="NEXT">
                </div> 
            <?php } ?>
    </body>
</html>