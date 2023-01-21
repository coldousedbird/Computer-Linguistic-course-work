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

$name_print=NULL;
$date_print=NULL;
$link_print=NULL;
$text_print=NULL;
$act="";

$skript='select name, date, link, text
from news';

if(isset($_GET['action'])){
$act=$_GET['action'];
}
$value=0;

if($act == 'set'){

if($_GET['name']){
    $name_print=$_GET['name'];
    $name_boba=mysqli_real_escape_string($induction, $_GET['name']);

    $script_1 ="news.name LIKE '%" . $name_boba . "%'";

    if($value == 0){
        $skript .= konken(' WHERE ', $script_1);
        $value=1;
    }
    else{
    $skript .= konken(' AND ', $script_1);
    }
}

if($_GET['date']){
    $date_print=$_GET['date'];
    $date_boba=mysqli_real_escape_string($induction, $_GET['date']);

    $script_1 ="news.date LIKE '%" . $date_boba . "%'";

    if($value == 0){
        $skript .= konken(' WHERE ', $script_1);
        $value=1;
    }
    else{
        $skript .= konken(' AND ', $script_1);
    }
}

if($_GET['link']){
    $link_print=$_GET['link'];
    $link_boba=mysqli_real_escape_string($induction, $_GET['link']);

    $script_1 ="news.link LIKE '%" . $link_boba . "%'";

    if($value == 0){
        $skript .= konken(' WHERE ', $script_1);
        $value=1;
    }
    else{
    $skript .= konken(' AND ', $script_1);
    }
}

if($_GET['text']){
    $text_print=$_GET['text'];
    $text_boba= mysqli_real_escape_string($induction, $_GET['text']);
    
    $script_1 ="news.text LIKE '%" . $text_boba . "%'";

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