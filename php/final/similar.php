<?php
include_once("../common.php");

//Fa una echo degli articoli simili all'articolo scelto.

$db = db_connect();
if (isset($_REQUEST["paper"])) {
    $paper = $db->quote($_REQUEST["paper"]);
    $rows = $db->query("SELECT p.title, p.paper_id, p.author, p.year FROM papers p JOIN most_similar s ON p.paper_id = s.similar WHERE s.paper_id = $paper");
    $jsonarray = array();
    if($rows->rowCount()>0) {
        foreach ($rows as $row) {
            $jsonarray[] = $row;
        }
    }
    echo json_encode($jsonarray); 
} 
?>