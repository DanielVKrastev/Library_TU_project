<?php include("partials/menu.php");?>
<style>
    #active-reference{
        background-color: #1e272e;
    }
</style>
<h2 class="text-center">Справки</h2>
<div class="content" style="margin-bottom: 15px;"></div>
<div class="boxs-content">

    <!-- НАЧАЛО - СПРАВКА ЗА ЗАЕТИ КНИГИ ОТ ЧИТАТЕЛ -->
        <div class="box-1">
            <h3>Заети книги от читател</h3>
            <form action="" method="post">
                <label>Въведи ID читател: </label>
                <input type="number" name="id_reader" required><br>
                <input type="submit" name="submit_book_reader" value="Търси" class="btn btn-primary">

                <table class="tbl">
                <?php
                //ако не е натиснат
                    if(!isset($_POST['submit_book_reader'])){
                ?>
                    <tr>
                        <th colspan="2"></th>
                    </tr>

                    <tr>
                        <th>ID книга</th>
                        <th>Заглавие</th>
                    </tr>

                <?php
                    }
                    
                    if(isset($_POST['submit_book_reader'])){
                        $id_reader = $_POST['id_reader'];
                        //заявка за заетите книги по читател
                        $sql_book_reader = "SELECT r.id_book, r.id_reader, b.title, rd.first_name, rd.second_name
                                            FROM web_prog_library.rental r
                                            INNER JOIN web_prog_library.books b
                                            ON r.id_book = b.id_book
                                            NATURAL JOIN web_prog_library.readers rd
                                            WHERE id_reader = $id_reader";
                        //изпълнение за заявката
                        $res_book_reader = mysqli_query($conn, $sql_book_reader);
                        //броене на редове
                        $count_book_reader = mysqli_num_rows($res_book_reader);

                        if($count_book_reader > 0){
                            //извеждане на данните от първия ред
                            $row = mysqli_fetch_assoc($res_book_reader);
                            $id_reader = $row['id_reader'];
                            $first_name = $row['first_name'];
                            $second_name = $row['second_name'];
                            $id_book = $row['id_book'];
                            $title = $row['title'];
                            ?>
                                <tr>
                                    <th colspan="2"><?php echo $id_reader.". ".$first_name." ".$second_name; ?></th>
                                </tr>

                                <tr>
                                    <th>ID книга</th>
                                    <th>Заглавие</th>
                                </tr>

                                <tr>
                                    <td><?php echo $id_book; ?></td>
                                    <td><?php echo $title; ?></td>
                                </tr>
                                
                            <?php
                            //извеждане на данните от останалите редове
                            while($row = mysqli_fetch_assoc($res_book_reader)){
                                $id_book = $row['id_book'];
                                $title = $row['title'];
                                ?>

                                <tr>
                                    <td><?php echo $id_book; ?></td>
                                    <td><?php echo $title; ?></td>
                                </tr>
                                <?php
                            }
                        }else{
                            ?>
                            
                                <tr>
                                    <th colspan="2">Този читател няма заети книги.</th>
                                </tr>
                                <tr>
                                    <th>ID книга</th>
                                    <th>Заглавие</th>
                                </tr>

                            <?php
                        }
                    }
                ?>
                </table>
            </form>
        </div>
        <!-- КРАЙ - СПРАВКА ЗА ЗАЕТИ КНИГИ ОТ ЧИТАТЕЛ -->

        <!-- НАЧАЛО - НЕВЪРНАТИ КНИГИ ПОДРЕДЕНИ ПО ДАТА НА ВРЪЩАНЕ -->
        <div class="box-1">
            <h3>Невърнати книги подредени по дата на връщане</h3>
            
            <form action="" method="post">
                <input type="submit" value="Търси" name="submit_book_date" class="btn btn-primary">
                <table class="tbl">

                    <tr>
                        <?php $today = date('Y-m-d'); ?>

                        <th colspan="3">Днес: <?php echo $today; ?></th>
                    </tr>

                    <tr>
                        <th>ID книга</th>
                        <th>Заглавие</th>
                        <th>Срок на връщане</th>
                    </tr>

                    <?php
                    
                    if(isset($_POST['submit_book_date'])){
                    
                        //заявка на заемани книги
                        $sql_rental = "SELECT id_book, title, return_date
                                    FROM web_prog_library.rental
                                    NATURAL JOIN web_prog_library.books
                                    ORDER BY return_date
                        ";

                        //изпълнение на заявката
                        $res_rental = mysqli_query($conn, $sql_rental);

                        //броене на редовете
                        $count_rental = mysqli_num_rows($res_rental);
                        
                        //извеждане на данни ако има такива
                        if($count_rental > 0){
                            while($row = mysqli_fetch_assoc($res_rental)){
                                $id_book = $row['id_book'];
                                $title = $row['title'];
                                $return_date = $row['return_date'];

                                //ако дата на връщане е по малка от днес да се изведе следното
                                if($return_date < $today){
                                ?>

                                <tr>
                                    <td><?php echo $id_book; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $return_date; ?></td>
                                </tr>

                                <?php
                                }
                            }
                            //ако няма данни в таблицата
                        }else{
                            
                            ?>

                            <tr>
                                <td colspan="3">Няма невърнати книги.</td>
                            </tr>

                            <?php
                        }
                    }

                    ?>
                </table>
            </form>
        </div>
        <!-- КРАЙ - НЕВЪРНАТИ КНИГИ ПОДРЕДЕНИ ПО ДАТА НА ВРЪЩАНЕ -->

        <!-- НАЧАЛО - СВОБОДНИ КНИГИ ПОДРЕДЕНИ ПО БРОЙ ЗАЕМАНИЯ -->
        <div class="box-1">
            <h3>Свободни книги подредени по брой заемания</h3>

            <form action="" method="post">
                <input type="submit" name="submit_book_countrent" value="Търси" class="btn btn-primary">

                <table class="tbl">

                    <tr>
                        <th>ID книга</th>
                        <th>Заглавие</th>
                        <th>Заемания</th>
                    </tr>

                    <?php

                    if(isset($_POST['submit_book_countrent'])){
                        //заявка в табл. Книги дали е активна и подредба по брой заемания
                        $sql_book_active = "SELECT id_book, title, counter_rent, active
                                            FROM web_prog_library.books
                                            WHERE active = 'Yes'
                                            ORDER BY counter_rent DESC                                          
                                            ";
                        //изпълнение на заявката
                        $res_book_active = mysqli_query($conn, $sql_book_active);

                        //броене на редовете
                        $count_book_active = mysqli_num_rows($res_book_active);

                        //проверка дали има данни и извеждане
                        if($count_book_active > 0){
                            while($row = mysqli_fetch_assoc($res_book_active)){
                                $id_book = $row['id_book'];
                                $title = $row['title'];
                                $counter_rent = $row['counter_rent'];

                                ?>

                                <tr>
                                    <td><?php echo $id_book; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $counter_rent; ?></td>
                                </tr>                                

                                <?php
                            }
                        }else{
                            ?>

                                <tr>
                                    <td colspan="3">Няма свободни книги.</td>
                                </tr>

                            <?php
                        }

                    }

                    ?>
                </table>
            </form>
        </div>
        <!-- КРАЙ - СВОБОДНИ КНИГИ ПОДРЕДЕНИ ПО БРОЙ ЗАЕМАНИЯ -->

        <!-- НАЧАЛО - НАЙ-ЧЕСТО ЗАЕМАНИ КНИГИ -->
        <div class="box-1">
            <h3>Най-често заемани книги</h3>

            <table class="tbl">

                <tr>
                    <th colspan="3">Топ 5</th>
                </tr>

                <tr>
                    <th>Заглавие</th>
                    <th>Автор</th>
                    <th>Заемания</th>
                </tr>

                <?php
                    //заявка за табл. Книги сортирани по брой заемане
                    $sql_top_book = "SELECT title, author, counter_rent
                                    FROM web_prog_library.books
                                    NATURAL JOIN web_prog_library.author
                                    ORDER BY counter_rent DESC
                                    LIMIT 5
                                    ";
                    //изпълнение на заявката
                    $res_top_book = mysqli_query($conn, $sql_top_book);

                    //броене на редовете
                    $count_top_book = mysqli_num_rows($res_top_book);

                    //проверка и извеждане на данни
                    if($count_top_book > 0){
                        while($row = mysqli_fetch_assoc($res_top_book)){
                            $title = $row['title'];
                            $author = $row['author'];
                            $counter_rent = $row['counter_rent'];

                            ?>

                            <tr>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $author; ?></td>
                                <td><?php echo $counter_rent; ?></td>
                            </tr>

                            <?php
                        }
                    }
                ?>
            </table>
        </div>
        <!-- КРАЙ - НАЙ-ЧЕСТО ЗАЕМАНИ КНИГИ -->

        <!-- НАЧАЛО - ТОП 5 КЛАСАЦИЯ НА СЛУЖИТЕЛИ ПО БРОЙ ЗАЕТИ КНИГИ -->
        <div class="box-1">
            <h3>Топ 5 класация на 'СЛУЖИТЕЛИ' по брой заети книги</h3>

            <table class="tbl">
                
                <tr>
                    <th>Място</th>
                    <th>Служител</th>
                    <th>Бр.</th>
                </tr>

                <?php

                //заявка в таблица ЗАЕМАНЕ и подреждане на служители по брой заемания
                $sql_top_emp = "SELECT r.id_employee, e.first_name, e.second_name, COUNT(*) AS count_emp
                                FROM web_prog_library.rental r
                                NATURAL JOIN web_prog_library.employees e
                                GROUP BY id_employee
                                ORDER BY count_emp DESC
                                LIMIT 5

                                "; 
                //изпълнение на заявката
                $res_top_emp = mysqli_query($conn,$sql_top_emp);
                //броене на редовете
                $count_top_emp = mysqli_num_rows($res_top_emp);

                $place = 1;
                //проверка и извеждане на данни
                if($count_top_emp > 0){
                    while($row = mysqli_fetch_assoc($res_top_emp)){
                        $id_employee = $row['id_employee'];
                        $first_name = $row['first_name'];
                        $second_name = $row['second_name'];
                        $count_emp = $row['count_emp'];
                        ?>

                        <tr>
                            <td><?php echo $place++; ?></td>
                            <td><?php echo $id_employee.". ".$first_name." ".$second_name; ?></td>
                            <td><?php echo $count_emp; ?></td>
                        </tr>

                        <?php
                    }
                }
            ?>
        </table>
        </div>
        <!-- КРАЙ - ТОП 5 КЛАСАЦИЯ НА ЧИТАТЕЛИ ПО БРОЙ ЗАЕТИ КНИГИ -->

                <!-- НАЧАЛО - ТОП 5 КЛАСАЦИЯ НА СЛУЖИТЕЛИ ПО БРОЙ ЗАЕТИ КНИГИ -->
                <div class="box-1">
            <h3>Топ 5 класация на 'ЧИТАТЕЛИ' по брой заети книги</h3>

            <table class="tbl">
                
                <tr>
                    <th>Място</th>
                    <th>Читател</th>
                    <th>Бр.</th>
                </tr>

                <?php

                //заявка в таблица ЗАЕМАНЕ и подреждане на читатели по брой заемания
                $sql_top_reader = "SELECT r.id_reader, rd.first_name, rd.second_name, COUNT(*) AS count_reader
                                FROM web_prog_library.rental r
                                NATURAL JOIN web_prog_library.readers rd
                                GROUP BY id_reader
                                ORDER BY count_reader DESC
                                LIMIT 5

                                "; 
                //изпълнение на заявката
                $res_top_reader = mysqli_query($conn,$sql_top_reader);
                //броене на редовете
                $count_top_reader = mysqli_num_rows($res_top_reader);

                $place = 1;
                //проверка и извеждане на данни
                if($count_top_reader > 0){
                    while($row = mysqli_fetch_assoc($res_top_reader)){
                        $id_reader = $row['id_reader'];
                        $first_name = $row['first_name'];
                        $second_name = $row['second_name'];
                        $count_reader = $row['count_reader'];
                        ?>

                        <tr>
                            <td><?php echo $place++; ?></td>
                            <td><?php echo $id_reader.". ".$first_name." ".$second_name; ?></td>
                            <td><?php echo $count_reader; ?></td>
                        </tr>

                        <?php
                    }
                }
            ?>
        </table>
        </div>
        <!-- КРАЙ - ТОП 5 КЛАСАЦИЯ НА ЧИТАТЕЛИ ПО БРОЙ ЗАЕТИ КНИГИ -->
</div>


<?php include("partials/footer.php");?>