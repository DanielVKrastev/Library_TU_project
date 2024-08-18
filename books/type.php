<?php include("../config/config.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Жанрове</title>
</head>
<body>
    <h2>Добавяне на жанрове за КНИГИ</h2>
    <br>
    <a href="<?php SITEURL;?>../books.php" class="btn btn-primary">Назад</a><br><br>
    <div class="box-2">
        <br>
        <form action="" method="POST">
            <h3>Добавяне на жанрове:</h3>
            <label>Жанр:</label> <input type="text" name="type">

            <?php
                if(isset($_SESSION['input'])){
                    echo $_SESSION['input'];
                    unset($_SESSION['input']);
                }
            ?>
    
            <br><br>
            <input type="submit" name="submit" class="btn btn-orange" value="Добави">

            <?php
                if(isset($_POST['submit'])){
                    
                    $type = $_POST['type'];


                    //sql заявка
                    $sql = "INSERT INTO web_prog_library.type SET
                            type = '$type'
                            ";

                    //изпълнение
                    $res = mysqli_query($conn, $sql);

                    if($res==true){
                        //успешно добавяне, съобщ и пренасочване
                        $_SESSION['input'] = "Успешно въвеждане на данни.";
                        header("location:".SITEURL."books/type.php");
                    }else{
                        $_SESSION['input'] = "Неуспешно въвеждане на данни";
                        header("location:".SITEURL."books/type.php");
                    }
                }


            ?>
        </form>
            </div>

    

    <div class="box-2">
        <h3>Таблица Позиции:</h3>
        <?php
        //съобщ. за изтриване
                if(isset($_SESSION['delete_data'])){
                echo $_SESSION['delete_data'];
                unset($_SESSION['delete_data']);
            }

        ?>
            <div class="overflow">
                    <table class="tbl">
                        <tr class="text-center">
                            <th>ID жанр</th>
                            <th>Жанрове</th>
                            <th>Операция</th>
                        </tr>

                        <?php
                            //sql заявка
                            $sql2 = "SELECT * FROM web_prog_library.type";

                            //изпълнение
                            $res2 = mysqli_query($conn, $sql2);

                            //броене на редовете
                            $count = mysqli_num_rows($res2);
                            if($count > 0){
                                //извеждане на данните
                                while($row = mysqli_fetch_assoc($res2)){
                                    $id_type = $row['id_type'];
                                    $type = $row['type'];
                            ?>
                            <tr>
                                <td><?php echo $id_type; ?></td>
                                <td><?php echo $type; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_type?>" class="btn btn-update">Редак</a><a href="<?php echo SITEURL;?>books/delete_type.php?id=<?php echo $id_type;?>" class="btn btn-delete">Изтрий</a>
                                </td>
                            </tr>

                            <?php
                                }
                            }else{
                                echo "<tr><td colspan='3'>Няма данни в таблицата.</td></tr>";
                            }
                            ?>
                    </table>
            </div>
    </div>

    <div class="box-2">
        <br>
        <h3>Редактиране на данни:</h3>
        <form action="" method="POST">
            <p>ID: 

            <?php
            //взема ид от url адреса
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    echo $id;
                }
            ?>
    <input type="hidden" name="id" value="<?php echo $id;?>">
            </p><br>
            
            <?php
            $type2 = '';
            if(isset($_GET['id'])){
                //sql заявка според ид
                $sql2 = "SELECT * FROM web_prog_library.type WHERE id_type=$id";

                //изпълнение
                $res2 = mysqli_query($conn, $sql2);

                //броене на редовете
                $count = mysqli_num_rows($res2);

                if($count==1){
                    $row = mysqli_fetch_assoc($res2);
                    $type2 = $row['type'];
                }else{
                    //refresh
                    $_SESSION['update-message-error'] = "<div class='error'>Несъществуващо ID.</div>";
                    header("location:".SITEURL."books/type.php");
                    die();
                }
            }
                if(isset($_SESSION['update-message-error'])){
                    echo $_SESSION['update-message-error'];
                    unset($_SESSION['update-message-error']);
                }

            ?>

            Сегашен жанр: <input type="text" name="current_type" value="<?php echo $type2; ?>"><br><br>
            Нов жанр: <input type="text" name="new_type"><br><br>
            <input type="submit" value="Редактирай" name="submit_update" class="btn btn-primary">

            <?php

                if(isset($_POST['submit_update'])){
                    if($_POST['current_type'] != ''){
                    $id_typ = $_POST['id'];
                    $new_type = $_POST['new_type'];
                    //zaqvkata за редактиране
                    $sql3 = "UPDATE web_prog_library.type SET
                            type = '$new_type'
                            WHERE id_type = $id_typ
                    ";

                    //изпълнение
                    $res3 = mysqli_query($conn, $sql3);
                    
                    //проверка
                    if($res3 == true){
                        $_SESSION['update'] = "Редактирано успешно.<br>";
                        header("location:".SITEURL."books/type.php");
                        die();
                    }else{
                        $_SESSION['update'] = "Грешка в редактирането.<br>";
                        header("location:".SITEURL."books/type.php");
                        die();
                    }  
                }else{
                    echo "Избери позиция за редактиране.";
                }
            }

            //извеждане на съобщ. за редактиране
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>

        </form>
    </div>
</body>
</html>

