<?php include("../config/config.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Позиции</title>
</head>
<body>
    <h2>Добавяне на позиция за служители</h2>
    <br>
    <a href="<?php SITEURL;?>../employees.php" class="btn btn-primary">Назад</a><br><br>
    <div class="box-2">
        <br>
        <form action="" method="POST">
            <h3>Добавяне на позиции:</h3>
            <label>Позиция:</label> <input type="text" name="position">

            <?php
            //извеждане на съобщ. за добавяне
                if(isset($_SESSION['input'])){
                    echo $_SESSION['input'];
                    unset($_SESSION['input']);
                }
            ?>
    
            <br><br>
            <input type="submit" name="submit" class="btn btn-orange" value="Добави">

            <?php
                if(isset($_POST['submit'])){
                    
                    $position = $_POST['position'];


                    //sql заявка за добавяне
                    $sql = "INSERT INTO web_prog_library.emp_position SET
                            position = '$position'
                            ";

                    //изпълняване
                    $res = mysqli_query($conn, $sql);

                    if($res==true){
                        //успешно добавяне, съобщ и пренасочване
                        $_SESSION['input'] = "Успешно въвеждане на данни.";
                        header("location:".SITEURL."employees/position.php");
                    }else{
                        $_SESSION['input'] = "Неуспешно въвеждане на данни";
                        header("location:".SITEURL."employees/position.php");
                    }
                }


            ?>
        </form>
            </div>

    

    <div class="box-2">
        <h3>Таблица Позиции:</h3>
        <?php
        //извеждане на съобщ. за изтриване
                if(isset($_SESSION['delete_data'])){
                echo $_SESSION['delete_data'];
                unset($_SESSION['delete_data']);
            }

        ?>
            <div class="overflow">
                    <table class="tbl">
                        <tr class="text-center">
                            <th>ID позиция</th>
                            <th>Позиция</th>
                            <th>Операция</th>
                        </tr>

                        <?php
                            //sql заявка
                            $sql2 = "SELECT * FROM web_prog_library.emp_position";

                            //изпълнение
                            $res2 = mysqli_query($conn, $sql2);

                            //броене на редовете
                            $count = mysqli_num_rows($res2);
                            if($count > 0){
                                //извеждане на информация
                                while($row = mysqli_fetch_assoc($res2)){
                                    $id_position = $row['id_position'];
                                    $position = $row['position'];
                            ?>
                            <tr>
                                <td><?php echo $id_position; ?></td>
                                <td><?php echo $position; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_position?>" class="btn btn-update">Редак</a><a href="<?php echo SITEURL;?>employees/delete.php?id=<?php echo $id_position;?>" class="btn btn-delete">Изтрий</a>
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
            $position2 = '';
            if(isset($_GET['id'])){
                //sql заявка за позиции
                $sql2 = "SELECT * FROM web_prog_library.emp_position WHERE id_position=$id";

                //изпълнение
                $res2 = mysqli_query($conn, $sql2);

                //броене на редовете
                $count = mysqli_num_rows($res2);

                if($count==1){
                    $row = mysqli_fetch_assoc($res2);
                    $position2 = $row['position'];
                }else{
                    //refresh
                    $_SESSION['update-message-error'] = "<div class='error'>Несъществуващо ID.</div>";
                    header("location:".SITEURL."employees/position.php");
                    die();
                }
            }
                if(isset($_SESSION['update-message-error'])){
                    echo $_SESSION['update-message-error'];
                    unset($_SESSION['update-message-error']);
                }

            ?>

            Сегашна позиция: <input type="text" name="current_possition" value="<?php echo $position2; ?>"><br><br>
            Нова позиция: <input type="text" name="new_position"><br><br>
            <input type="submit" value="Редактирай" name="submit_update" class="btn btn-primary">

            <?php

                if(isset($_POST['submit_update'])){
                    if($_POST['current_possition'] != ''){
                    $id_pos = $_POST['id'];
                    $new_position = $_POST['new_position'];
                    //заявка за редактиране
                    $sql3 = "UPDATE web_prog_library.emp_position SET
                            position = '$new_position'
                            WHERE id_position = $id_pos
                    ";

                    //изпълнение
                    $res3 = mysqli_query($conn, $sql3);
                    
                    //проверка
                    if($res3 == true){
                        $_SESSION['update'] = "Редактирано успешно.<br>";
                        header("location:".SITEURL."employees/position.php");
                        die();
                    }else{
                        $_SESSION['update'] = "Грешка в редактирането.<br>";
                        header("location:".SITEURL."employees/position.php");
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


