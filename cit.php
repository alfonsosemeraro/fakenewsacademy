<?php
include("common.php");
$title = $_REQUEST["paper"];
$db = db_connect();
$result = [];
$pcit = $db->query("SELECT p.title, p.paper_id, p.cit FROM papers p JOIN `references` r ON p.paper_id = r.source WHERE r.target = $title"); 
while ($p = $pcit->fetch(PDO::FETCH_ASSOC)) {
    $result[] = $p;
} 
echo json_encode($result);
?>