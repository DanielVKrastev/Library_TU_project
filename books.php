<?php include("partials/menu.php");?>
<style>
    #active-book{
        background-color: #1e272e;
    }
</style>
    <h2 class="text-center">Книги</h2>
    <div class="content" style="margin-bottom: 0;">
        <a href="<?php echo SITEURL;?>books/author.php" class="btn btn-primary">Автори</a>
        <a href="<?php echo SITEURL;?>books/publisher.php" class="btn btn-primary">Издателства</a>
        <a href="<?php echo SITEURL;?>books/type.php" class="btn btn-primary">Жанрове</a>
    </div>
    <div class="boxs-content">
        <div class="box-2">
            <h3>Добавяне в таблица Книги</h3>
            <form action="" method="post">

                <label>Заглавие: </label><br>
                <input type="text" name="title" required><br>

                <label>Автор: </label><br>
                <select name="id_author" required>
                <?php
                    //заявка за автори
                    $sql_author = "SELECT * FROM web_prog_library.author";
                    //изпълнение
                    $res_author = mysqli_query($conn, $sql_author);
                    //броене на редовете
                    $count_author = mysqli_num_rows($res_author);
                    if($count_author > 0){
                        //извеждане на информация
                        while($row = mysqli_fetch_assoc($res_author)){
                        
                        $id_author = $row['id_author'];
                        $author = $row['author'];
                ?>
                    <option value="<?php echo $id_author; ?>"><?php echo $author; ?></option>
                <?php
                    }
                }else{
                    ?>
                        <option value="0">Няма открити автори.</option>
                    <?php
                }
                ?>
                </select><br>


                <label>Година на издаване: </label><br>
                <input type="number" name="year" required><br>

                <label>Издателство: </label><br>
                <select name="id_publisher" required>
                <?php
                    //заявка за издателства
                    $sql_publisher = "SELECT * FROM web_prog_library.publisher";
                    //изпълнение
                    $res_publisher = mysqli_query($conn, $sql_publisher);
                    //броене на редовете
                    $count_publisher = mysqli_num_rows($res_publisher);
                    if($count_publisher > 0){
                        while($row = mysqli_fetch_assoc($res_publisher)){
                        
                        $id_publisher = $row['id_publisher'];
                        $publisher = $row['publisher'];
                ?>
                    <option value="<?php echo $id_publisher; ?>"><?php echo $publisher; ?></option>
                <?php
                    }
                }else{
                    ?>
                        <option value="0">Няма открити издателства.</option>
                    <?php
                }
                ?>
                </select><br>

                <label>Жанр: </label><br>
                <select name="id_type" required>
                <?php
                    //заявка за жанр
                    $sql_type = "SELECT * FROM web_prog_library.type";
                    //изпълнение
                    $res_type = mysqli_query($conn, $sql_type);
                    //броене на редовете
                    $count_type = mysqli_num_rows($res_type);
                    if($count_type > 0){
                        while($row = mysqli_fetch_assoc($res_type)){
                        //извеждане на данните
                        $id_type = $row['id_type'];
                        $type = $row['type'];
                ?>
                    <option value="<?php echo $id_type; ?>"><?php echo $type; ?></option>
                <?php
                    }
                }else{
                    ?>
                        <option value="0">Няма открити жанрове.</option>
                    <?php
                }
                ?>
                </select><br>

                <label>Активна: </label>
                <input type="radio" name="active" value="No" checked>Не
                <input type="radio" name="active" value="Yes">Да
                <br><br>

                <input type="submit" name="input" value="Добави" class="btn btn-orange">

                <?php
                    if(isset($_POST['input'])){
                        $title = $_POST['title'];
                        $id_author = $_POST['id_author'];
                        $year = $_POST['year'];
                        $id_publisher = $_POST['id_publisher'];
                        $id_type = $_POST['id_type'];
                        $counter_rent = 0;
                        $active = $_POST['active'];

                    

                    //sql изпълнение
                    $sql_books_insert = "INSERT INTO web_prog_library.books SET
                                            title = '$title',
                                            id_author = $id_author,
                                            year = $year,
                                            id_publisher = $id_publisher,
                                            id_type = $id_type,
                                            counter_rent = $counter_rent,
                                            active = '$active'
                    ";

                    //изпълнение
                    $res_books_insert = mysqli_query($conn, $sql_books_insert);


                    if( $res_books_insert){
                        $_SESSION['input']= "<div class='success'>Успешно добавяне.</div>";
                        header("location:".SITEURL."books.php");
                        die();
                    }
                }
                ?>

                <?php
                //извеждане на съобщ. за добавяне
                    if(isset($_SESSION['input'])){
                        echo $_SESSION['input'];
                        unset($_SESSION['input']);
                    }
                ?>
            </form>
        </div>

        <div class="box-2">
        <form action="" method="post">
            <h3>Редактиране на данни:</h3>

            <?php
           error_reporting(E_ALL ^ E_WARNING); 
            ?>

                <label>ID книга: </label><br>
                <?php
                //взема ид от url адреса
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                        echo $id;
                    }
                ?>
                <br>
                <input type="hidden" name="id" value="<?php echo $id;?>">

                <?php
                if(isset($_GET['id'])){
                    //sql заявка според ид
                    $sql2 = "SELECT * FROM web_prog_library.books WHERE id_book = $id
                    ";

                    //изпълнение
                    $res2 = mysqli_query($conn, $sql2);

                    //броене на редовете
                    $count = mysqli_num_rows($res2);

                    if($count==1){
                        //извеждане на данните
                        $row = mysqli_fetch_assoc($res2);
                        $id_book = $row['id_book'];
                        $title = $row['title'];
                        $current_author = $row['id_author'];
                        $year = $row['year'];
                        $current_publisher = $row['id_publisher'];
                        $current_type = $row['id_type'];
                        $counter_rent = $row['counter_rent'];
                        $active = $row['active'];
                    }else{
                        //refresh
                        $_SESSION['update-message-error'] = "<div class='error'>Несъществуващо ID.</div>";
                        header("location:".SITEURL."employees.php");
                        die();
                    }
                }
                    if(isset($_SESSION['update-message-error'])){
                        echo $_SESSION['update-message-error'];
                        unset($_SESSION['update-message-error']);
                    }

                ?>

                <label>Заглавие: </label><br>
                <input type="text" name="title" value="<?php echo $title; ?>" required><br>

                <label>Автор: </label><br>
                <select name="id_author" required>
                <?php
                    //заявка за автор
                    $sql_author = "SELECT * FROM web_prog_library.author";
                    //изпълнение
                    $res_author = mysqli_query($conn, $sql_author);
                    //броене на редовете
                    $count_author = mysqli_num_rows($res_author);
                    if($count_author > 0){
                        while($row = mysqli_fetch_assoc($res_author)){
                        
                        $id_author = $row['id_author'];
                        $author = $row['author'];
                ?>
                    <option value="<?php echo $id_author;?>" <?php if($current_author == $id_author ){echo 'selected';}?>><?php echo $author; ?></option>
                <?php
                    }
                }else{
                    ?>
                        <option value="0">Няма открити автори.</option>
                    <?php
                }
                ?>
                </select><br>


                <label>Година на издаване: </label><br>
                <input type="number" name="year" value="<?php echo $year; ?>" required><br>

                <label>Издателство: </label><br>
                <select name="id_publisher" required>
                <?php
                    //заявка за издателства
                    $sql_publisher = "SELECT * FROM web_prog_library.publisher";
                    //изпълнение
                    $res_publisher = mysqli_query($conn, $sql_publisher);
                    //броене на редовете
                    $count_publisher = mysqli_num_rows($res_publisher);
                    if($count_publisher > 0){
                        while($row = mysqli_fetch_assoc($res_publisher)){
                        
                        $id_publisher = $row['id_publisher'];
                        $publisher = $row['publisher'];
                ?>
                    <option value="<?php echo $id_publisher;?>" <?php if($current_publisher == $id_publisher ){echo 'selected';}?>><?php echo $publisher; ?></option>
                <?php
                    }
                }else{
                    ?>
                        <option value="0">Няма открити издателства.</option>
                    <?php
                }
                ?>
                </select><br>

                <label>Жанр: </label><br>
                <select name="id_type" required>
                <?php
                    //заявка за жанрове
                    $sql_type = "SELECT * FROM web_prog_library.type";
                    //изпълнение
                    $res_type = mysqli_query($conn, $sql_type);
                    //броене
                    $count_type = mysqli_num_rows($res_type);
                    if($count_type > 0){
                        while($row = mysqli_fetch_assoc($res_type)){
                        
                        $id_type = $row['id_type'];
                        $type = $row['type'];
                ?>
                    <option value="<?php echo $id_type; ?>" <?php if($current_type == $id_type ){echo 'selected';}?>><?php echo $type; ?></option>
                <?php
                    }
                }else{
                    ?>
                        <option value="0">Няма открити жанрове.</option>
                    <?php
                }
                ?>
                </select><br>

                
                <label>Брой наемания: </label><br>
                <input type="number" name="counter_rent" value="<?php echo $counter_rent;?>" required><br><br>

                <label>Активна: </label>
                <input type="radio" name="active" <?php if($active == 'No')echo "checked"; ?> value="No">Не
                <input type="radio" name="active" <?php if($active =='Yes')echo "checked"; ?> value="Yes">Да
                <br><br>

                <input type="submit" name="submit_update" value="Редактирай" class="btn btn-primary">

                <?php

                    if(isset($_POST['submit_update'])){
                        $id_bk = $_POST['id'];
                        $title = $_POST['title'];
                        $id_author = $_POST['id_author'];
                        $year = $_POST['year'];
                        $id_publisher = $_POST['id_publisher'];
                        $id_type = $_POST['id_type'];
                        $counter_rent = $_POST['counter_rent'];
                        $active = $_POST['active'];
                        //заявка за редактиране
                        $sql3 = "UPDATE web_prog_library.books SET
                                title = '$title',
                                id_author = $id_author,
                                year = $year,
                                id_publisher = $id_publisher,
                                id_type = $id_type,
                                counter_rent = $counter_rent,
                                active = '$active'
                                WHERE id_book = $id_bk
                        ";

                        //изпълнение
                        $res3 = mysqli_query($conn, $sql3);
                        
                        //проверка
                        if($res3 == true){
                            $_SESSION['update'] = "Редактирано успешно.<br>";
                            header("location:".SITEURL."books.php");
                            die();
                        }else{
                            $_SESSION['update'] = "Грешка в редактирането.<br>";
                            header("location:".SITEURL."books.php");
                            die();
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
    </div>

    <div class="content" style="padding-bottom: 8%;">
    <br><br>
    <div class="overflow">
        <?php
            if(isset($_SESSION['delete_data'])){
                echo $_SESSION['delete_data'];
                unset($_SESSION['delete_data']);
            }
        ?>
                    <table class="tbl">
                        <tr class="text-center">
                            <th>ID книга.</th>
                            <th>Заглавие</th>
                            <th>Автор</th>
                            <th>Година</th>
                            <th>Издателство</th>
                            <th>Жанр</th>
                            <th>Бр. наем</th>
                            <th>Активна</th>
                            <th>Операция</th>
                        </tr>

                        <?php
                            //sql заявка
                            $sql2 = "SELECT id_book, title ,author, year, publisher, type, counter_rent, active
                                    FROM web_prog_library.books
                                    INNER JOIN web_prog_library.author
                                    ON books.id_author = author.id_author
                                    INNER JOIN web_prog_library.publisher
                                    ON books.id_publisher = publisher.id_publisher
                                    INNER JOIN web_prog_library.type
                                    ON books.id_type = type.id_type
                                    ORDER BY id_book
                                    
                                    ";

                            //изпълнение
                            $res2 = mysqli_query($conn, $sql2);

                            //броене на редовете
                            $count = mysqli_num_rows($res2);
                            if($count > 0){
                                //извеждане на данните
                                while($row = mysqli_fetch_assoc($res2)){
                                    $id_book = $row['id_book'];
                                    $title = $row['title'];
                                    $author = $row['author'];
                                    $year = $row['year'];
                                    $publisher = $row['publisher'];
                                    $type = $row['type'];
                                    $counter_rent = $row['counter_rent'];
                                    $active = $row['active'];
                            ?>
                            <tr>
                                <td><?php echo $id_book; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $author; ?></td>
                                <td><?php echo $year; ?></td>
                                <td><?php echo $publisher; ?></td>
                                <td><?php echo $type; ?></td>
                                <td><?php echo $counter_rent; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_book?>" class="btn btn-update">Редак</a><a href="<?php echo SITEURL;?>delete_books.php?id=<?php echo $id_book;?>" class="btn btn-delete">Изтрий</a>
                                </td>
                            </tr>

                            <?php
                                }
                            }else{
                                echo "<tr><td colspan='9'>Няма данни в таблицата.</td></tr>";
                            }
                            ?>
                    </table>
            </div>
</div>

<?php include("partials/footer.php");?>