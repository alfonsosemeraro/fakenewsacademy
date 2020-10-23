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
        <script src="javascript/cit-graph.js" type="text/javascript"></script>
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
        <?php 
        $art = $_GET["paper"];
        $db = db_connect();
        $paper = $db->quote($art);
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
        if (strpos($row[2], ',')) {
            $a = explode(',',$row[2]);
            for ($i=0; $i<count($a); $i++) {
                if (strpos($a[$i], '(')) {
                    $a[$i] = substr($a[$i],0, strpos($a[$i], '(')-1);
                }
            }
            $val = "SELECT title, paper_id FROM papers WHERE (author LIKE ";
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
            $prs = $db->query("SELECT title, paper_id FROM papers WHERE author LIKE '%$aut[0]%' AND paper_id != '$row[0]'");
        } else {
            $aut = $row[2];
            $prs = $db->query("SELECT title, paper_id FROM papers WHERE author LIKE '%$aut%' AND paper_id != '$row[0]'");
        }
        if ($prs->rowCount()>0) { ?>
            <div id="art">
            <?php foreach($prs as $r) { ?>
                <ol>
                    <li><a href="final.php?paper=<?= $r[1] ?>"><?= $r[0] ?></a></li>
                </ol>  
            <?php } ?>
            </div>  
        <?php } else {
        }
        $qry = $db->query("SELECT p.title, p.paper_id FROM papers p JOIN most_similar s ON p.paper_id = s.similar WHERE s.paper_id = '$row[0]'");
        if ($qry->rowCount()>0) { ?>
            <div id="art">
            <?php foreach($qry as $q) { ?>
                <ol>
                    <li><a href="final.php?paper=<?= $q[1] ?>"><?= $q[0] ?></a></li>
                </ol>   
            <?php } ?>
            </div> 
        <?php } else {
        }
        ?>        
    </body>
</html>