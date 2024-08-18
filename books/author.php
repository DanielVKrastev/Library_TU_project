<?php include("../config/config.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Автори</title>
</head>
<body>
    <h2>Добавяне на автори за КНИГИ</h2>
    <br>
    <a href="<?php SITEURL;?>../books.php" class="btn btn-primary">Назад</a><br><br>
    <div class="box-2">
        <br>
        <form action="" method="POST">
            <h3>Добавяне на автори:</h3>
            <label>Автор:</label> <input type="text" name="author">

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
                    
                    $author = $_POST['author'];


                    //sql заявка за добавяне
                    $sql = "INSERT INTO web_prog_library.author SET
                            author = '$author'
                            ";

                    //изпълняване
                    $res = mysqli_query($conn, $sql);

                    if($res==true){
                        //успешно добавяне, извеждане на съобщение, пренасочване
                        $_SESSION['input'] = "Успешно въвеждане на данни.";
                        header("location:".SITEURL."books/author.php");
                    }else{
                        //грешка, съобщ, пренасочване
                        $_SESSION['input'] = "Неуспешно въвеждане на данни";
                        header("location:".SITEURL."books/author.php");
                    }
                }


            ?>
        </form>
            </div>

    

    <div class="box-2">
        <h3>Таблица Автори:</h3>
        <?php
                if(isset($_SESSION['delete_data'])){
                echo $_SESSION['delete_data'];
                unset($_SESSION['delete_data']);
            }

        ?>
            <div class="overflow">
                    <table class="tbl">
                        <tr class="text-center">
                            <th>ID автор</th>
                            <th>Автор</th>
                            <th>Операция</th>
                        </tr>

                        <?php
                            //sql заявйа
                            $sql2 = "SELECT * FROM web_prog_library.author";

                            //изпълнение на заявката
                            $res2 = mysqli_query($conn, $sql2);

                            //броене на редове
                            $count = mysqli_num_rows($res2);
                            if($count > 0){
                                //извеждане на данните
                                while($row = mysqli_fetch_assoc($res2)){
                                    $id_author = $row['id_author'];
                                    $author = $row['author'];
                            ?>
                            <tr>
                                <td><?php echo $id_author; ?></td>
                                <td><?php echo $author; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_author?>" class="btn btn-update">Редак</a><a href="<?php echo SITEURL;?>books/delete_author.php?id=<?php echo $id_author;?>" class="btn btn-delete">Изтрий</a>
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
            //взема id от url адреса
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    echo $id;
                }
            ?>
    <input type="hidden" name="id" value="<?php echo $id;?>">
            </p><br>
            
            <?php
            $author2 = '';
            if(isset($_GET['id'])){
                //заявка в зависи от ид
                $sql2 = "SELECT * FROM web_prog_library.author WHERE id_author=$id";

                //изпълнение на заявката
                $res2 = mysqli_query($conn, $sql2);

                //броене на редове
                $count = mysqli_num_rows($res2);

                if($count==1){
                    $row = mysqli_fetch_assoc($res2);
                    $author2 = $row['author'];
                }else{
                    //рефреш
                    $_SESSION['update-message-error'] = "<div class='error'>Несъществуващо ID.</div>";
                    header("location:".SITEURL."books/author.php");
                    die();
                }
            }
                if(isset($_SESSION['update-message-error'])){
                    echo $_SESSION['update-message-error'];
                    unset($_SESSION['update-message-error']);
                }

            ?>

            Сегашен автор: <input type="text" name="current_author" value="<?php echo $author2; ?>"><br><br>
            Нов автор: <input type="text" name="new_author"><br><br>
            <input type="submit" value="Редактирай" name="submit_update" class="btn btn-primary">

            <?php

                if(isset($_POST['submit_update'])){
                    if($_POST['current_author'] != ''){
                    $id_auth = $_POST['id'];
                    $new_author = $_POST['new_author'];
                    //заявка за редактиране
                    $sql3 = "UPDATE web_prog_library.author SET
                            author = '$new_author'
                            WHERE id_author = $id_auth
                    ";

                    //изпълнение
                    $res3 = mysqli_query($conn, $sql3);
                    
                    //проверка
                    if($res3 == true){
                        $_SESSION['update'] = "Редактирано успешно.<br>";
                        header("location:".SITEURL."books/author.php");
                        die();
                    }else{
                        $_SESSION['update'] = "Грешка в редактирането.<br>";
                        header("location:".SITEURL."books/author.php");
                        die();
                    }  
                }else{
                    echo "Избери автор за редактиране.";
                }
            }

            //извеждане на съобщение за редактиране
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>

        </form>
    </div>
</body>
</html>


