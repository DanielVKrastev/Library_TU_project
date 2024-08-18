<?php include("../config/config.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Издателства</title>
</head>
<body>
    <h2>Добавяне на издателства за КНИГИ</h2>
    <br>
    <a href="<?php SITEURL;?>../books.php" class="btn btn-primary">Назад</a><br><br>
    <div class="box-2">
        <br>
        <form action="" method="POST">
            <h3>Добавяне на издателства:</h3>
            <label>Издателство:</label> <input type="text" name="publisher">

            <?php
            //извеждане на съобщение
                if(isset($_SESSION['input'])){
                    echo $_SESSION['input'];
                    unset($_SESSION['input']);
                }
            ?>
    
            <br><br>
            <input type="submit" name="submit" class="btn btn-orange" value="Добави">

            <?php
                if(isset($_POST['submit'])){
                    
                    $publisher = $_POST['publisher'];


                    //sql заявка за добавяне
                    $sql = "INSERT INTO web_prog_library.publisher SET
                            publisher = '$publisher'
                            ";

                    //изпълняване
                    $res = mysqli_query($conn, $sql);

                    if($res==true){
                        //успешно добавяне, съобщение и пренасочване
                        $_SESSION['input'] = "Успешно въвеждане на данни.";
                        header("location:".SITEURL."books/publisher.php");
                    }else{
                        $_SESSION['input'] = "Неуспешно въвеждане на данни";
                        header("location:".SITEURL."books/publisher.php");
                    }
                }


            ?>
        </form>
            </div>

    

    <div class="box-2">
        <h3>Таблица Издателства:</h3>
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
                            <th>ID Издателство</th>
                            <th>Издателства</th>
                            <th>Операция</th>
                        </tr>

                        <?php
                            //sql заявка
                            $sql2 = "SELECT * FROM web_prog_library.publisher";

                            //изпълнение
                            $res2 = mysqli_query($conn, $sql2);

                            //броене на редовете
                            $count = mysqli_num_rows($res2);
                            if($count > 0){
                                //извеждане на данните
                                while($row = mysqli_fetch_assoc($res2)){
                                    $id_publisher = $row['id_publisher'];
                                    $publisher = $row['publisher'];
                            ?>
                            <tr>
                                <td><?php echo $id_publisher; ?></td>
                                <td><?php echo $publisher; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_publisher?>" class="btn btn-update">Редак</a><a href="<?php echo SITEURL;?>books/delete_publisher.php?id=<?php echo $id_publisher;?>" class="btn btn-delete">Изтрий</a>
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
            $publisher2 = '';
            if(isset($_GET['id'])){
                //sql заявка според ид-то
                $sql2 = "SELECT * FROM web_prog_library.publisher WHERE id_publisher=$id";

                //изпълнение
                $res2 = mysqli_query($conn, $sql2);

                //броене на редовете
                $count = mysqli_num_rows($res2);

                if($count==1){
                    $row = mysqli_fetch_assoc($res2);
                    $publisher2 = $row['publisher'];
                }else{
                    //refresh
                    $_SESSION['update-message-error'] = "<div class='error'>Несъществуващо ID.</div>";
                    header("location:".SITEURL."books/publisher.php");
                    die();
                }
            }
                if(isset($_SESSION['update-message-error'])){
                    echo $_SESSION['update-message-error'];
                    unset($_SESSION['update-message-error']);
                }

            ?>

            Сегашно издателство: <input type="text" name="current_publisher" value="<?php echo $publisher2; ?>"><br><br>
            Ново издателство: <input type="text" name="new_publisher"><br><br>
            <input type="submit" value="Редактирай" name="submit_update" class="btn btn-primary">

            <?php

                if(isset($_POST['submit_update'])){
                    if($_POST['current_publisher'] != ''){
                    $id_publ = $_POST['id'];
                    $new_publisher = $_POST['new_publisher'];
                    //заявка за редактраине
                    $sql3 = "UPDATE web_prog_library.publisher SET
                            publisher = '$new_publisher'
                            WHERE id_publisher = $id_publ
                    ";

                    //изпълнение
                    $res3 = mysqli_query($conn, $sql3);
                    
                    //проверка
                    if($res3 == true){
                        $_SESSION['update'] = "Редактирано успешно.<br>";
                        header("location:".SITEURL."books/publisher.php");
                        die();
                    }else{
                        $_SESSION['update'] = "Грешка в редактирането.<br>";
                        header("location:".SITEURL."books/publisher.php");
                        die();
                    }  
                }else{
                    echo "Избери позиция за редактиране.";
                }
            }

                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>

        </form>
    </div>
</body>
</html>


