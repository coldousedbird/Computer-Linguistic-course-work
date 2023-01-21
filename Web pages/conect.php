<?php
$par1_ip = "localhost";
$par2_name = "root";
$par3_p = "";
$par4_db = "aboba";

$induction = mysqli_connect($par1_ip, $par2_name, $par3_p, $par4_db);
if($induction == false){
    echo "Ошибка подкл";
}



function konken($value_1, $value_2) {   
    
    $res = $value_1 . $value_2;

    return   $res    ; 
}


$protected_area_print="";
$FIO_print=NULL;
$biography_print=NULL;
$act="";

$skript='select mentions.FIO, mentions.number_of_mentions, news.text
from mentions left join news
on mentions.id_news_has_mentions = news.id';

if(isset($_GET['action'])){
$act=$_GET['action'];
}
$value=0;

if($act == 'set'){




if($_GET['mentions_FIO']){
    $protected_area_print=$_GET['mentions_FIO'];
    $protected_area=mysqli_real_escape_string($induction,$_GET['mentions_FIO']);

    $script_1='mentions.FIO="' . $protected_area . '"';

    if($value == 0){
        $skript .= konken(' WHERE ', $script_1);
        $value=1;
    }
    else{
    $skript .= konken(' AND ', $script_1);
    }
}



}

$result = mysqli_query($induction, $skript);

?>