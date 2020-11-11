<?php
include_once("../common.php");

//Fa una echo degli articoli citati dall'articolo scelto e
//degli articoli che citano l'articolo scelto.

$db = db_connect();
if (isset($_REQUEST["paper"])) {
    $paper = $db->quote($_REQUEST["paper"]);
    $rows = $db->query("SELECT p.paper_id, p.title, r.source FROM papers p JOIN `references` r ON p.paper_id = r.target WHERE r.source = $paper");    
    $jsonarray = array();
    if($rows->rowCount()>0) {
        foreach ($rows as $row) {
            $jsonarray[] = $row;
        }
    }

    $rowws = $db->query("SELECT p.paper_id, p.title, r.target FROM papers p JOIN `references` r ON p.paper_id = r.source WHERE r.target = $paper");    
    if($rowws->rowCount()>0) {
        foreach ($rowws as $roww) {
            $jsonarray[] = $roww;
        }
    }
    echo json_encode($jsonarray); 
} 
?>