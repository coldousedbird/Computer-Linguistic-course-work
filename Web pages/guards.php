<?php
include("conect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список всех охранников</title>
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


            <h5 class="txt_white">Персона или достопримечательность:</h5>
            <select name="mentions_FIO" id="" selected="<?php echo $protected_area_print ?>">
                <option value="" >Не выбрано</option>
                <option value="Бочаров Андрей Иванович" <?php if($protected_area_print == 'Бочаров Андрей Иванович'){ ?> selected="selected"<?php }?>>Бочаров Андрей Иванович</option>
                <option value="Прошаков Андрей Павлович"<?php if($protected_area_print == 'Прошаков Андрей Павлович'){ ?> selected="selected"<?php }?>>Прошаков Андрей Павлович</option>
                <option value="Писемская Анна Сергеевна"<?php if($protected_area_print == 'Писемская Анна Сергеевна'){ ?> selected="selected"<?php }?>>Писемская Анна Сергеевна</option>
                <option value="Марченко Владимир Васильевич"<?php if($protected_area_print == 'Марченко Владимир Васильевич'){ ?> selected="selected"<?php }?>>Марченко Владимир Васильевич</option>
                <option value="Бельских Игорь Евгеньевич"<?php if($protected_area_print == 'Бельских Игорь Евгеньевич'){ ?> selected="selected"<?php }?>>Бельских Игорь Евгеньевич</option>
                <option value='Стадион "Волгоград Арена"'<?php if($protected_area_print == 'Стадион "Волгоград Арена"'){ ?> selected="selected"<?php }?>>Стадион "Волгоград Арена"</option>
                <option value='Музей-заповедник "Старая Сарепта"'<?php if($protected_area_print == 'Музей-заповедник "Старая Сарепта"'){ ?> selected="selected"<?php }?>>Музей-заповедник "Старая Сарепта"</option>
                <option value="Волгоградский музей изобразительных искусств им. И.И. Машкова"<?php if($protected_area_print == 'Волгоградский музей изобразительных искусств им. И.И. Машкова'){ ?> selected="selected"<?php }?>>Волгоградский музей изобразительных искусств им. И.И. Машкова</option>
                <option value="Областная универсальная научная библиотека им. М. Горького"<?php if($protected_area_print == 'Областная универсальная научная библиотека им. М. Горького'){ ?> selected="selected"<?php }?>>Областная универсальная научная библиотека им. М. Горького</option>
            </select>


            

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
                    Имя
                </div>

            </div>

            <div class="col">
                <div class="content">
                   Количество упоминаний
                </div>

            </div>

            <div class="col">
                <div class="content">
                   Текст
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
                   <?php echo $bd['FIO'];?>
                </div>

            </div>

            <div class="col">
                <div class="content">
                   <?php echo $bd['number_of_mentions'];?>
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