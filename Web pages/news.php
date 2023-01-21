<?php
include("connect news.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>
    <link rel="stylesheet" href="HomeCss.css">
    <link rel="stylesheet" href="guardCss.css">
    <link rel="stylesheet" href="bootstrap-5.2.2/dist/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="bootstrap-5.2.2/dist/css/bootstrap.css">
    <script src="bootstrap-5.2.2/dist/js/bootstrap.bundle.js"></script>
</head>
<body>


    <section class="sort container">


        <form action="" method="get">
        <div class="row">
            <h5 class="txt_white">Фильтры:</h5>

            <h5 class="txt_white">Название:</h5>
            <input type="text" placeholder="Название" name="name" value="<?php echo $name_print ?>">

            <h5 class="txt_white">Дата:</h5>
            <input type="text" placeholder="Дата" name="date" value="<?php echo $date_print ?>">

            <h5 class="txt_white">Ссылка:</h5>
            <input type="text" placeholder="Ссылка" name="link" value="<?php echo $link_print ?>">
           
            <h5 class="txt_white">Текст:</h5>
            <input type="text" placeholder="Текст" name="text" value="<?php echo $text_print ?>">
        </div>

        <div class="row"> 
                <button type="submit" name="action" value="set">Применить</button>  
                <button type="submit" name="action" value="clear">Очистить</button>          
        </div>
        </form>
    </section>

    <hr>
    <section class="row p">
            
            <div class="col">
                <div class="content">
                    Название
                </div>

            </div>

            <div class="col">
                <div class="content">
                   Дата новости
                </div>

            </div>

            <div class="col">
                <div class="content">
                   Ссылка
                </div>

            </div>
            
            <div class="col">
                <div class="content">
                   Текст новости
                </div>

            </div>

    </section>
    <hr>
    <?php 
    while($bd = mysqli_fetch_assoc($result))
    
    {
        ?>
    <section class="row p">

            
            <div class="col">
                <div class="content">
                   <?php echo $bd['name'];?>
                </div>

            </div>

            <div class="col">
                <div class="content">
                   <?php echo $bd['date'];?>
                </div>

            </div>

            <div class="col">
                <div class="content">
                   <?php echo $bd['link'];?>
                </div>

            </div>
            
            <div class="col">
                <div class="content">
                   <?php echo $bd['text'];?>
                </div>

            </div>

    </section>

    

    <hr>
    <?php 
    }
        ?>
</body>