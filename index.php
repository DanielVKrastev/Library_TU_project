<?php include("partials/menu.php") ?>
<style>
    #active-home{
        background-color: #1e272e;
    }
</style>
    <h2 class="text-center">Начало</h2>
    <br>

    <div class="content">

            <form action="" class="search" method="post">
                <h3>Търсене на книги:</h3>
                <input type="search" name="search" placeholder="Потърси книги" class="input-style" required><br>
                <input type="submit" name="submit_author" formaction="<?php echo SITEURL;?>" value="По автор" class="btn btn-primary">
                <input type="submit" name="submit_title" formaction="<?php echo SITEURL;?>" value="По наименование" class="btn btn-primary">
                <input type="submit" name="submit_type" formaction="<?php echo SITEURL;?>" value="По жанр" class="btn btn-primary"> <!-- formaction - презареждане -->

            <?php
                //присвояване на търсенето
                if(isset($_POST['search'])){
                    $search = mysqli_real_escape_string($conn, $_POST['search']);
                }
            ?>

                <div class="overflow">
                    <table class="tbl">

                        <?php
                        if(!isset($_POST['submit_author'])
                            && !isset($_POST['submit_title'])
                            && !isset($_POST['submit_type']))
                        {
                        ?>

                        <tr>
                            <th colspan='8'>Всички налични книги</th>
                        </tr>
                        
                        <tr class="text-center">
                            <th>ID книга.</th>
                            <th>Заглавие</th>
                            <th>Автор</th>
                            <th>Година</th>
                            <th>Издателство</th>
                            <th>Жанр</th>
                            <th>Бр. наем</th>
                            <th>Операция</th>
                        </tr>

                        <?php
                            //заявка за книги
                            $sql2 = "SELECT id_book, title ,author, year, publisher, type, counter_rent, active
                                    FROM web_prog_library.books
                                    INNER JOIN web_prog_library.author
                                    ON books.id_author = author.id_author
                                    INNER JOIN web_prog_library.publisher
                                    ON books.id_publisher = publisher.id_publisher
                                    INNER JOIN web_prog_library.type
                                    ON books.id_type = type.id_type
                                    WHERE active = 'Yes'
                                    
                                    ";

                            //изпълнение на заявката
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
                            ?>
                            <tr>
                                <td><?php echo $id_book; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $author; ?></td>
                                <td><?php echo $year; ?></td>
                                <td><?php echo $publisher; ?></td>
                                <td><?php echo $type; ?></td>
                                <td><?php echo $counter_rent; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_book?>#rent" class="btn btn-update">Наеми</a>
                                </td>
                            </tr>

                            <?php
                                }
                            }else{
                                echo "<tr><td colspan='9'>Няма данни в таблицата.</td></tr>";
                            }
                        }

                        //търсене по автор:
                        if(isset($_POST['submit_author'])){

                            ?>

                            <tr>
                                <th colspan='8'>Търсене по автор: <?php echo $search; ?></th>
                            </tr>
                            
                            <tr class="text-center">
                                <th>ID книга.</th>
                                <th>Заглавие</th>
                                <th>Автор</th>
                                <th>Година</th>
                                <th>Издателство</th>
                                <th>Жанр</th>
                                <th>Бр. наем</th>
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
                                    WHERE active = 'Yes' && author LIKE '%$search%'
                                    
                                    ";

                            //изпълнение на заявката
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
                            ?>
                            <tr>
                                <td><?php echo $id_book; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $author; ?></td>
                                <td><?php echo $year; ?></td>
                                <td><?php echo $publisher; ?></td>
                                <td><?php echo $type; ?></td>
                                <td><?php echo $counter_rent; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_book?>#rent" class="btn btn-update">Наеми</a>
                                </td>
                            </tr>

                            <?php
                                }
                            }else{
                                echo "<tr><td colspan='9'>Няма книги търсени по автор.</td></tr>";
                            }
                        }
                            

                        //търсене по жанр:
                        if(isset($_POST['submit_type'])){

                            ?>

                            <tr>
                                <th colspan='8'>Търсене по жанр: <?php echo $search; ?></th>
                            </tr>
                            
                            <tr class="text-center">
                                <th>ID книга.</th>
                                <th>Заглавие</th>
                                <th>Автор</th>
                                <th>Година</th>
                                <th>Издателство</th>
                                <th>Жанр</th>
                                <th>Бр. наем</th>
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
                                    WHERE active = 'Yes' && type LIKE '%$search%'
                                    
                                    ";

                            //изпълнение на заявката
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
                            ?>
                            <tr>
                                <td><?php echo $id_book; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $author; ?></td>
                                <td><?php echo $year; ?></td>
                                <td><?php echo $publisher; ?></td>
                                <td><?php echo $type; ?></td>
                                <td><?php echo $counter_rent; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_book?>#rent" class="btn btn-update">Наеми</a>
                                </td>
                            </tr>

                            <?php
                                }
                            }else{
                                echo "<tr><td colspan='9'>Няма книги търсени по автор.</td></tr>";
                            }
                        }
                        

                        //търсене по ключови думи от заглавие:
                        if(isset($_POST['submit_title'])){

                            ?>

                            <tr>
                                <th colspan='8'>Търсене по наименование: <?php echo $search; ?></th>
                            </tr>
                            
                            <tr class="text-center">
                                <th>ID книга.</th>
                                <th>Заглавие</th>
                                <th>Автор</th>
                                <th>Година</th>
                                <th>Издателство</th>
                                <th>Жанр</th>
                                <th>Бр. наем</th>
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
                                    WHERE active = 'Yes' && title LIKE '%$search%'
                                    
                                    ";

                            //изпълнение на заявката
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
                            ?>
                            <tr>
                                <td><?php echo $id_book; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $author; ?></td>
                                <td><?php echo $year; ?></td>
                                <td><?php echo $publisher; ?></td>
                                <td><?php echo $type; ?></td>
                                <td><?php echo $counter_rent; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_book?>#rent" class="btn btn-update">Наеми</a>
                                </td>
                            </tr>

                            <?php
                                }
                            }else{
                                echo "<tr><td colspan='9'>Няма книги търсени по автор.</td></tr>";
                            }
                        }
                            ?>

                            
                    </table>
            </div>
            </form>
    <br>
        <!--
            <div class="boxs">
            <h3>Данни:</h3>
                <div class="box text-center">
                    <h1>10</h1>
                    <hr>
                    <p>Книги</p>
                </div>

                <div class="box text-center">
                    <h1>2</h1>
                    <hr>
                    <p>Автора</p>
                </div>

                <div class="box text-center">
                    <h1>3</h1>
                    <hr>
                    <p>Издателства</p>
                </div>

                <div class="box text-center">
                    <h1>5</h1>
                    <hr>
                    <p>Жанра</p>
                </div>

                <div class="box text-center">
                    <h1>8</h1>
                    <hr>
                    <p>Служителя</p>
                </div>

                <div class="box text-center">
                    <h1>3</h1>
                    <hr>
                    <p>Служ. позиции</p>
                </div>

                <div class="box text-center">
                    <h1>16</h1>
                    <hr>
                    <p>Читателя</p>
                </div>
            </div> -->
        </div>

        <div class="content" id="rent" style="padding-bottom: 8%;">
            <h3>Заемане на книга /избери от таблицата/</h3>
            
            <form class="rent-book" action="" method="post"> 
                    <table class="tbl">

                        <tr>
                            <th>ID книга: </th>
                            <th>
                            <?php 
                            $id = "";
                            //вземаде на ид от url адреса
                                if(isset($_GET['id'])){
                                    $id = $_GET['id'];
                                    echo $id;
                                }
                            ?>
                            <input type="hidden" name="id_book" value="<?php echo $id;?>">
                            </th>
                            <th>Дата на наемане: </th>
                            <th style="min-width: 200px;">
                                <input type="date" name="rent_date" value="<?php echo date('Y-m-d');?>"><br>
                            </th>
                        </tr>

                        <tr>
                            <th>Заглавие: </th>
                            <th>
                                <?php
                                if($id != ''){
                                //заявка за извеждане на данните:
                                $sql = "SELECT title FROM web_prog_library.books
                                        WHERE id_book = $id";
                                
                                //изпълнение
                                $res = mysqli_query($conn, $sql);

                                //броене на редовете
                                $count = mysqli_num_rows($res);
                                
                                if($count == 1){
                                    $row = mysqli_fetch_assoc($res);
                                    $title = $row['title'];
                                }else{
                                    //пренасочване
                                    $_SESSION['update-message-error'] = "<div class='error'>Несъществуващо ID.</div>";
                                    header("location:".SITEURL."index.php");
                                    die();
                                }

                                if(isset($_SESSION['update-message-error'])){
                                    echo $_SESSION['update-message-error'];
                                    unset($_SESSION['update-message-error']);
                                }

                                echo $title;
                            }
                            ?>
                                <input type="hidden" name="title" value="<?php echo $title; ?>">
                            </th>
                            <th>Срок за връщане: </th>
                            <th>
                               30 Дни.
                            </th>
                        </tr>

                        <tr>
                            <th>Читател: </th>
                            <th colspan="3">
                            <input type="number" name="id_reader" placeholder="ID на читател" style="width: 150px;">
                            <a href="<?php echo SITEURL; ?>readers.php" class="btn btn-primary">Създай читател</a>
                            </th>
                        </tr>

                        <tr>
                            <th>Служител: </th>
                            <th colspan="3">
                            <select name="id_employee" required>
                                <?php
                                    //заявка
                                    $sql_emp = "SELECT * FROM web_prog_library.employees";
                                    //изпълнение
                                    $res_emp = mysqli_query($conn, $sql_emp);
                                    //броене
                                    $count_emp = mysqli_num_rows($res_emp);
                                    if($count_emp > 0){
                                        while($row = mysqli_fetch_assoc($res_emp)){
                                        
                                        $id_employee = $row['id_employee'];
                                        $first_name = $row['first_name'];
                                        $second_name = $row['second_name'];
                                        
                                ?>
                                    <option value="<?php echo $id_employee; ?>"><?php echo $first_name." ".$second_name; ?></option>
                                <?php
                                    }
                                }else{
                                    ?>
                                        <option value="0">Няма открити издателства.</option>
                                    <?php
                                }
                                ?>
                            </select>
                            </th>
                        </tr>

                        <tr>
                            <th colspan="4"> <input type="submit" name="submit_rent" value="Наеми" class="btn btn-primary"> </th>
                        </tr>
                    
                        <?php
                            if(isset($_POST['submit_rent'])){
                                $id_book = $_POST['id_book'];
                                $id_reader = $_POST['id_reader'];
                                $id_employee = $_POST['id_employee'];
                                $rent_date = $_POST['rent_date'];
                                $return_date = date('Y-m-d', strtotime($rent_date."+ 30 days"));

                                //sql заявка
                                $sql_rent = "INSERT INTO web_prog_library.rental SET
                                            id_book = $id_book,
                                            id_reader = $id_reader,
                                            id_employee = $id_employee,
                                            rent_date = '$rent_date',
                                            return_date = '$return_date'
                                            ";
                                //изпълнение
                                $res_rent = mysqli_query($conn, $sql_rent);

                                if( $res_rent){
                                    $_SESSION['input']= "<div class='success'>Успешно наемане.</div>";
                                }

                            //при наемане броя на наемане се увеличава с 1 и книгата става неактивна
                                $active = "No";
                                //заявка за книги по ид
                                $sql_books = "SELECT * FROM web_prog_library.books WHERE id_book = $id_book";

                                //изпълнение на заявката
                                $res_books = mysqli_query($conn, $sql_books);

                                //броене на редовете
                                $count_books = mysqli_num_rows($res_books);

                                if($count_books == 1){
                                    $row = mysqli_fetch_assoc($res_books);
                                    $counter_rent = $row['counter_rent'];
                                    $counter_rent++;
                                }

                                //заявка за редактиране в таблицата
                                $sql_books_update = "UPDATE web_prog_library.books SET
                                                    counter_rent = $counter_rent,
                                                    active = '$active'
                                                    WHERE id_book = $id_book
                                ";
                                
                                //изпълнение
                                $res_books_update = mysqli_query($conn, $sql_books_update);

                                //проверка
                                if($res_books_update){
                                    $_SESSION['update'] = "<div class='success'>Книгата вече не е АКТИВНА.</div><br>";
                                    header("location:".SITEURL."#rent");
                                    die();
                                }else{
                                    $_SESSION['update'] = "<div class='error'>Грешка в брой наемания.</div><br>";
                                    header("location:".SITEURL."#rent");
                                    die();
                                }
                            }

                            if(isset($_SESSION['input'])){
                                echo $_SESSION['input'];
                                unset($_SESSION['input']);
                            }

                            if(isset($_SESSION['update'])){
                                echo $_SESSION['update'];
                                unset($_SESSION['update']);
                            }

                        ?>
                    </table>
            </form>
    </div>
                    

<?php include("partials/footer.php"); ?>