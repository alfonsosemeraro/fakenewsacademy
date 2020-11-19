<?php
include_once("../common.php");
//Fa una echo degli articoli ordinati secondo clustering.

$db = db_connect();
if (isset($_REQUEST["page"])) {
    $page = $_REQUEST["page"]; 
    $max_results = 10;
    $from = (($page * $max_results) - $max_results); 
    if (isset($_REQUEST["search"])) {
        $search = $_REQUEST["search"];
        $query = "SELECT * FROM papers WHERE title LIKE '%$search%'";
        if (isset($_REQUEST["year-min"]) && strcmp($_REQUEST["year-min"], "")) {
            $yearMin = $_REQUEST["year-min"];
            $ymin = $db->quote($yearMin);
            $query = $query . " AND year >= $ymin";
        }
        if (isset($_REQUEST["year-max"]) && strcmp($_REQUEST["year-max"], "")) {
            $yearMax = $_REQUEST["year-max"];
            $ymax = $db->quote($yearMax);
            $query = $query . " AND year <= $ymax";
        }
        if (isset($_REQUEST["cit-min"]) && strcmp($_REQUEST["cit-min"], "")) {
            $citMin = $_REQUEST["cit-min"];
            $cmin = $db->quote($citMin);
            $query = $query . " AND cit >= $cmin";
        }
        if (isset($_REQUEST["cit-max"]) && strcmp($_REQUEST["cit-max"], "")) {
            $citMax = $_REQUEST["cit-max"];
            $cmax = $db->quote($citMax);
            $query = $query . " AND cit <= $cmax";
        }
        if (isset($_REQUEST["author"]) && strcmp($_REQUEST["author"], "")) {
            $author = $_REQUEST["author"]; 
            $query = $query . " AND author LIKE '%$author%'";
        }
        $result = $db->query($query);
        $total_pages = ceil($result->rowCount() / $max_results); 
        $query = $query . " ORDER by clustering DESC LIMIT $from, $max_results";
        $rows = $db->query($query);
    } else {
        $search = $_REQUEST["title"];
        $result = $db->query("SELECT * FROM papers WHERE title LIKE '%$search%'");
        $total_pages = ceil($result->rowCount() / $max_results); 
        $rows = $db->query("SELECT * FROM papers WHERE title LIKE '%$search%' OR abstract LIKE '%$search%' ORDER by clustering DESC LIMIT $from, $max_results");
    }
    if($rows->rowCount()>0) {
        foreach ($rows as $row) {
            $jsonarray[] = $row;
        }
    }
    echo json_encode($jsonarray); 
}
?>