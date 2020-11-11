<?php
//Fa una echo degli articoli scritti dagli stessi autori 
//dell'articolo scelto.
include_once("../common.php");
$db = db_connect();

if (isset($_REQUEST["author"]) && isset($_REQUEST["paper"])) {
    $author = $_REQUEST["author"];
    $paper = $db->quote($_REQUEST["paper"]);

    if (strpos($author, ',')) {
        $a = explode(',',$author);
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
        $val = $val . "AND paper_id != $paper";
        $prs = $db->query($val);
    } else if (strpos($author,'(')) {
        $aut = explode('(', $author);
        $prs = $db->query("SELECT title, paper_id, author, year FROM papers WHERE author LIKE '%$aut[0]%' AND paper_id != $paper");
    } else {
        $aut = $author;
        $prs = $db->query("SELECT title, paper_id, author, year FROM papers WHERE author LIKE '%$aut%' AND paper_id != $paper");
    }
    $jsonarray = array();
    if($prs->rowCount()>0) {
        foreach ($prs as $row) {
            $jsonarray[] = $row;
        }
    }
    echo json_encode($jsonarray); 
} 
?>