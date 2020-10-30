<?php
include_once("common.php");
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
        <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"> 
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <link href="../css/index.css" type="text/css" rel="stylesheet">  
        <script type="text/javascript" src="../javascript/tab.js"></script>
        
    </head>
    <body>
        <div id="nav">
            <ul>
                <li><a href="index.php">Logo</a></li>
                <li><a href="../html/project.html">Project</a></li>
                <li><a href="../html/methods.html">Methods</a></li>
                <li style="float:right"><a href="../html/about.html">About us</a></li>
            </ul>
        </div>
        <div><img src="../img/wave.jpg" alt="wave"/></div>
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
            if (isset($_REQUEST["search"])) {
                $search = $_REQUEST["search"];
                $yearMin = strcmp($_REQUEST["year-min"],"") ? $db->quote($_REQUEST["year-min"]) : "1852";
                $date = date("Y");
                $yearMax = strcmp($_REQUEST["year-max"], "") ? $db->quote($_REQUEST["year-max"]) : $db->quote($date);
                $citMin = strcmp($_REQUEST["cit-min"], "") ? $db->quote($_REQUEST["cit-min"]) : "0";
                $query = "SELECT * FROM papers WHERE title LIKE '%$search%' AND (year >= $yearMin AND year <= $yearMax) AND cit >= $citMin";
                if (strcmp($_REQUEST["cit-max"], "")) {
                    $citMax = $db->quote($_REQUEST["cit-max"]);
                    $query = $query . " AND cit <= $citMax";
                }
                if (strcmp($_REQUEST["author"], "")) {
                    $author = $_REQUEST["author"]; 
                    $query = $query . " AND author LIKE '%$author%'";
                }
                $rows = $db->query($query);
            } else {
                $search = $_GET["title"];
                $rows = $db->query("SELECT * FROM papers WHERE title LIKE '%$search%'");
            }
        ?>
        <h1><?= $search ?> search results</h1>
        <?php
            if ($rows->rowCount()>0){ ?>
                <fieldset>
                    <h3>Legend:</h3>
                    <ul>
                        <li>values between 0 and 0.2: &darr;</li>
                        <li>values between 0.2 and 0.4: &#x2197;</li>
                        <li>values between 0.4 and 0.6: &rarr;</li>
                        <li>values between 0.6 and 0.8: &#x2198;</li>
                        <li>values between 0.8 and 1: &uarr;</li>
                    </ul>
                </fieldset>
                <table id="myTable" class="tablesorter-blue">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>Cit</th>
                            <th>Abstract</th>
                            <th>Betweenness</th>
                            <th>Indegree</th>
                            <th>Clustering</th>
                            <th>Pagerank</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  
                        foreach ($rows as $row) { ?>
                            <tr>
                                <td>    
                                    <a href="final.php?paper=<?= $row[0] ?>" class="tooltip"><?= $row[1] ?>
                                        <span class="tooltiptext">
                                            <h3><?= $row[1] ?></h3>
                                            <p><?= $row[2] ?></p>
                                            <p><?= $row[3] ?></p>
                                            <p><?= $row[5] ?></p>
                                        </span>
                                    </a>
                                </td> 
                                <td><?= $row[2] ?></td> 
                                <td><?= $row[3] ?></td> 
                                <td><?= $row[4] ?></td> 
                                <td><?= $row[5] ?></td> 
                                <td><?= $row[6] ?></td> 
                                <td><?= $row[7] ?></td> 
                                <td>
                                    <p id="number"><?= $row[8] ?></p>
                                </td> 
                                <td>
                                    <p id="number"><?= $row[9] ?></p>
                                </td>
                            </tr>   
                    <?php      
                        }
                    ?>
                    </tbody> 
                </table>
            <?php } else { ?>
                <p>Papers not found.</p>
            <?php
            }
        ?>
    </body>
</html>