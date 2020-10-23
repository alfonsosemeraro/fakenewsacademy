<?php
include_once("common.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Fake News</title>
        <meta charset="utf-8" >
        <link href="css/index.css" type="text/css" rel="stylesheet">  
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet"> 
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" class="init">	
        $(document).ready(function() {
            $('#myTable').DataTable();
        } );                        
        </script>
        
    </head>
    <body>
        <div id="nav">
            <ul>
                <li><a href="#logo">Logo</a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="#news">News</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#about">About</a></li>
            </ul>
        </div>
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
                            <select name="year">
                                <option selected="selected" value=<?= date("Y")-4 ?>-<?= date("Y") ?>><?= date("Y")-4 ?>-<?= date("Y") ?></option>
                                <option value=<?= date("Y")-20 ?>-<?= date("Y")-5 ?>><?= date("Y")-20 ?>-<?= date("Y")-5 ?></option>
                                <option value=<?= date("Y")-21 ?>>fino al <?= date("Y")-21 ?></option>
                            </select>
                            <select name="name">
                                <option>scegli</option>
                                <option></option>
                            </select>
                            <select name="cit">
                                <option selected="selected" value="650">da 650 citazioni in su</option>
                                <option value="0">qualsiasi numero di citazioni</option>
                            </select>
                        </div>
                        <div class="row">
                            <select name="name">
                                <option>scegli</option>
                                <option></option>
                            </select>
                            <select name="name">
                                <option>scegli</option>
                                <option></option>
                            </select>
                            <select name="name">
                                <option>scegli</option>
                                <option></option>
                            </select>
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
            $db = db_connect();
            if (isset($_REQUEST["search"])) {
                $search = $_REQUEST["search"];
                $year = $_REQUEST["year"];
                $query = "SELECT * FROM papers WHERE (title LIKE '%$search%' OR author LIKE '%$search%')";
                if (strpos($year,"-")) {
                    $first = substr($year,0, strpos($year,"-"));
                    $last = substr($year,strpos($year,"-")+1);
                    $yf = $db->quote($first);
                    $ly = $db->quote($last);
                    $query = $query. "AND (year >= $yf AND year <= $ly)";
                } else {
                    $y = $db->quote($year);
                    $query = $query. "AND year <= $y";
                }
                $cit = $_REQUEST["cit"];
                $ctz = $db->quote($cit);
                $query = $query. "AND cit >= $ctz";
                $rows = $db->query($query);
            } else {
                $search = $_GET["title"];
                $rows = $db->query("SELECT * FROM papers WHERE title LIKE '%$search%'");
            }
        ?>
        <h1>Risultati della ricerca di <?= $search ?></h1>
        <?php
            if ($rows->rowCount()>0){ ?>
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
                            <tr><td><a href="final.php?paper=<?= $row[0] ?>"><?= $row[1] ?></a></td> 
                            <td><?= $row[2] ?></td> <td><?= $row[3] ?></td> <td><?= $row[4] ?></td> 
                            <td><?= $row[5] ?></td> <td><?= $row[6] ?></td> <td><?= $row[7] ?></td> <td><?= $row[8] ?></td> <td><?= $row[9] ?></td></tr>   
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