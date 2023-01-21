<?php
include ("connect.php");

$protected_area_print="";
$FIO_print=NULL;
$biography_print=NULL;
$act="";

$array= array();
$skript='select mentions.id, mentions.FIO, mentions.number_of_mentions, news.text
from mentions left join news
on mentions.id_news_has_mentions = news.id
Limit 100';

$skript_2='select id, name, date, link, text
from news';

if(isset($_GET['action'])){
    $act=$_GET['action'];
}
$value=0;

if($act == 'set'){
if($_GET['number_of_mentions']) {
    $FIO_print = $_GET['number_of_mentions'];
    $protected_area = mysqli_real_escape_string($induction, $_GET['number_of_mentions']);

    $array[]="mentions.number_of_mentions LIKE '%" . $protected_area . "%'";

}

if($_GET['FIO']) {
    $protected_area_print = $_GET['FIO'];
    $FIO_boba = mysqli_real_escape_string($induction, $_GET['FIO']);

    $array[]='mentions.FIO="' . $FIO_boba . '"';


}

if($_GET['Text']) {
    $biography_print = $_GET['Text'];
    $biography = mysqli_real_escape_string($induction, $_GET['Text']);
    
    $array[] ="news.text LIKE '%" . $biography . "%'";

}

if($_GET['number_of_mentions'] or $_GET['FIO'] or $_GET['Text']){



$skr =" WHERE ";

$skr .= implode(' and ', $array);

$skript .= $skr;
}
}

$result = mysqli_query($induction, $skript);
$bd_array_2= array();
while($bd = mysqli_fetch_assoc($result)) {
    $bd_array_2[]=$bd;
}


$result_2 = mysqli_query($induction, $skript_2);
$bd_array= array();
while($bd = mysqli_fetch_assoc($result_2)) {
    $bd_array[]=$bd;
}
?>






