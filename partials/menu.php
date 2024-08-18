<?php
    include("config/config.php");
    //echo "Test"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Mini Project</title>
</head>
<body>

    <div class="menu text-center">
        <br>
        <h2>Библиотека</h2>
        <ul>
            <a href="<?php echo SITEURL;?>"><li class="btn-menu" id="active-home">Начало</li></a>
            <a href="<?php echo SITEURL;?>books.php"><li class="btn-menu" id="active-book">Книги</li></a>
            <a href="<?php echo SITEURL;?>employees.php"><li class="btn-menu" id="active-emp">Служители</li></a>
            <a href="<?php echo SITEURL;?>readers.php"><li class="btn-menu" id="active-reader">Читатели</li></a>
            <a href="<?php echo SITEURL;?>rent.php"><li class="btn-menu" id="active-rent">Заемане</li></a>
            <a href="<?php echo SITEURL;?>reference.php"><li class="btn-menu" id="active-reference">Справки</li></a>
            <a href="<?php echo SITEURL;?>create.php"><li class="btn-menu" id="active-create">Създаване на база</li></a>
        </ul>
    </div>