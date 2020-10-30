<?php
include_once("common.php");
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
        <link href="../css/index.css" type="text/css" rel="stylesheet">   
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    </head>
    <body>
        <div id="nav">
            <ul>
                <li><a href="index.php">Logo</a></li>
                <li><a href="../html/project.html">Project</a></li>
                <li><a href="../html/methods.html">Methods</a></li>
                <li style="float:right"><a href="#about" class="../html/about.html">About us</a></li>
            </ul>
        </div>
        <div><img src="../img/wave.jpg" alt="wave"/></div>
        <?php 
        $art = $_GET["paper"];
        $db = db_connect();
        $paper = $db->quote($art);
        //Query che restituisce tutte le informazioni del paper scelto
        $rs = $db->query("SELECT * FROM papers WHERE paper_id = $paper");
        if ($rs->rowCount()>0){ 
            foreach ($rs as $row) { ?>
        <div id="abstract">
            <h1><?= $row[1] ?> </h1>
            <p> <?= $row[2] ?> </p>
            <p> <?= $row[3] ?> </p>
            <p> <?= $row[5] ?> </p>
            <h6 id="paper"><?= $row[0] ?></h6>
        </div>     
        <?php }
        }
        /*Query che restituisce tutti i papers scritti dallo/gli stesso/i autore/i del paper scelto
        Quando il paper scelto ha più autori la stringa contenente gli autori viene scomposta per 
        ottenere tutti i singoli autori che poi vengono messi in OR nella query per trovare gli 
        articoli scritti da essi.
        */
        if (strpos($row[2], ',')) {
            $a = explode(',',$row[2]);
            for ($i=0; $i<count($a); $i++) {
                if (strpos($a[$i], '(')) {
                    $a[$i] = substr($a[$i],0, strpos($a[$i], '(')-1);
                }
            }
            $val = "SELECT title, paper_id, author, year FROM papers WHERE (author LIKE ";
            for ($j=0; $j<count($a); $j++) {
                if (count($a)-$j != 1) {
                    $val = $val . "'%$a[$j]%' OR author LIKE ";
                } else {
                    $val = $val . "'%$a[$j]%')";
                }
            }
            $val = $val . "AND paper_id != '$row[0]'";
            $prs = $db->query($val);
        } else if (strpos($row[2],'(')) {
            $aut = explode('(', $row[2]);
            $prs = $db->query("SELECT title, paper_id, author, year FROM papers WHERE author LIKE '%$aut[0]%' AND paper_id != '$row[0]'");
        } else {
            $aut = $row[2];
            $prs = $db->query("SELECT title, paper_id, author, year FROM papers WHERE author LIKE '%$aut%' AND paper_id != '$row[0]'");
        }
        if ($prs->rowCount()>0) { ?>
            <div id="art">
                <h2>Articoli degli stessi autori:</h2>
            <?php foreach($prs as $r) { ?>
                <ol>
                    <li><a href="final.php?paper=<?= $r[1] ?>"><?= $r[0] ?></a>, <?= $r[2] ?>, <?= $r[3] ?></li>
                </ol>  
            <?php } ?>
            </div>  
        <?php } else {
        }
        //Query che restituisce tutti i papers simili al paper scelto
        $qry = $db->query("SELECT p.title, p.paper_id, p.author, p.year FROM papers p JOIN most_similar s ON p.paper_id = s.similar WHERE s.paper_id = '$row[0]'");
        if ($qry->rowCount()>0) { ?>
            <div id="art">
            <h2>Articoli simili:</h2>
            <?php foreach($qry as $q) { ?>
                <ol>
                    <li><a href="final.php?paper=<?= $q[1] ?>"><?= $q[0] ?></a>, <?= $q[2] ?>, <?= $q[3] ?> </li>
                </ol>   
            <?php } ?>
            </div> 
        <?php } else {
        }
        ?>      
    </body>
</html>