<?php include("partials/menu.php");?>
<style>
    #active-rent{
        background-color: #1e272e;
    }
</style>
<h2 class="text-center">Заемане</h2>
<div class="content"></div>
    <div class="boxs-content">
        

        <div class="box-2">
        <form action="" method="post">
            <h3>Редактиране на данни:</h3>

            <?php
          // error_reporting(E_ALL ^ E_WARNING); 
          $current_id_book='';
          $current_id_reader='';
          $current_id_employee='';
            ?>

                <label>ID наем: </label><br>
                <?php
                //vzema na id ot url adresa
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                        echo $id;
                    }
                ?>
                <br>
                <input type="hidden" name="id" value="<?php echo $id;?>">

                <?php
                if(isset($_GET['id'])){
                    //sql zavka spored id-to
                    $sql2 = "SELECT * FROM web_prog_library.rental WHERE id_rent = $id
                    ";

                    //izpulnenie na zaqvkata
                    $res2 = mysqli_query($conn, $sql2);

                    //broene na redovete
                    $count = mysqli_num_rows($res2);

                    if($count==1){
                        $row = mysqli_fetch_assoc($res2);
                        $id_rent = $row['id_rent'];
                        $current_id_book = $row['id_book'];
                        $current_id_reader = $row['id_reader'];
                        $current_id_employee = $row['id_employee'];
                        $rent_date = $row['rent_date'];
                        $return_date = $row['return_date'];

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

                <label>Налични книги: </label><br>
                <select name="id_book" required>
                <?php
                    //zaqvka
                    $sql_book = "SELECT * FROM web_prog_library.books";
                    //izpulnenie
                    $res_book = mysqli_query($conn, $sql_book);
                    //broene
                    $count_book = mysqli_num_rows($res_book);
                    if($count_book > 0){
                        while($row = mysqli_fetch_assoc($res_book)){
                        
                        $id_book = $row['id_book'];
                        $title = $row['title'];
                        $active = $row['active'];
                ?>
                    <option value="<?php echo $id_book;?>" <?php if($current_id_book == $id_book ){echo 'selected';}?>><?php echo $id_book.". ".$title." ".$active; ?></option>
                <?php
                    }
                }else{
                    ?>
                        <option value="0">Няма открити книги.</option>
                    <?php
                }
                ?>
                </select><br>

                <label>Читател: </label><br>
                <select name="id_reader" required>
                                <?php
                                    //zaqvka
                                    $sql_reader = "SELECT * FROM web_prog_library.readers";
                                    //izpulnenie
                                    $res_reader = mysqli_query($conn, $sql_reader);
                                    //broene
                                    $count_reader = mysqli_num_rows($res_reader);
                                    if($count_reader > 0){
                                        while($row = mysqli_fetch_assoc($res_reader)){
                                        
                                        $id_reader = $row['id_reader'];
                                        $first_name = $row['first_name'];
                                        $second_name = $row['second_name'];
                                        $telephone = $row['telephone'];
                                        
                                ?>
                                    <option value="<?php echo $id_reader;?>" <?php if($current_id_reader == $id_reader ){echo 'selected';}?>><?php echo $first_name." ".$second_name." ".$telephone; ?></option>
                                <?php
                                    }
                                }else{
                                    ?>
                                        <option value="0">Няма открити издателства.</option>
                                    <?php
                                }
                                ?>
                            </select><br>


                <label>Служител: </label><br>
                <select name="id_employee" required>
                                <?php
                                    //zaqvka
                                    $sql_emp = "SELECT * FROM web_prog_library.employees";
                                    //izpulnenie
                                    $res_emp = mysqli_query($conn, $sql_emp);
                                    //broene
                                    $count_emp = mysqli_num_rows($res_emp);
                                    if($count_emp > 0){
                                        while($row = mysqli_fetch_assoc($res_emp)){
                                        
                                        $id_employee = $row['id_employee'];
                                        $first_name = $row['first_name'];
                                        $second_name = $row['second_name'];
                                        
                                ?>
                                    <option value="<?php echo $id_employee; ?>"<?php if($current_id_employee == $id_employee ){echo 'selected';}?>><?php echo $first_name." ".$second_name; ?></option>
                                <?php
                                    }
                                }else{
                                    ?>
                                        <option value="0">Няма открити издателства.</option>
                                    <?php
                                }
                                ?>
                            </select>
                            <br>
                    
                        <label>Дата на наемане /от/: </label><br>
                        <input type="date" name="rent_date" value="<?php echo date('Y-m-d', strtotime($rent_date));?>"><br>

                        <label>Срок на връщане /до/: </label><br>
                        <input type="date" name="return_date" value="<?php echo date('Y-m-d', strtotime($return_date));?>"><br><br>
            

                <input type="submit" name="submit_update" value="Редактирай" class="btn btn-primary">

                <?php

                    if(isset($_POST['submit_update'])){
                        $id_r = $_POST['id'];
                        $id_book = $_POST['id_book'];
                        $id_reader = $_POST['id_reader'];
                        $id_employee = $_POST['id_employee'];
                        $rent_date = $_POST['rent_date'];
                        $return_date = $_POST['return_date'];

                        //zaqvkata za update
                        $sql3 = "UPDATE web_prog_library.rental SET
                                id_book = $id_book,
                                id_reader = $id_reader,
                                id_employee = $id_employee,
                                rent_date = '$rent_date',
                                return_date = '$return_date'
                                WHERE id_rent = $id_r
                        ";

                        //izpulnenie
                        $res3 = mysqli_query($conn, $sql3);
                        
                        //proverka
                        if($res3 == true){
                            $_SESSION['update'] = "Редактирано успешно.<br>";
                            header("location:".SITEURL."rent.php");
                            die();
                        }else{
                            $_SESSION['update'] = "Грешка в редактирането.<br>";
                            header("location:".SITEURL."rent.php");
                            die();
                        }  
                    }

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

            if(isset($_SESSION['active_book'])){
                echo $_SESSION['active_book'];
                unset($_SESSION['active_book']);
            }
        ?>
                    <table class="tbl">
                        <tr class="text-center">
                            <th>ID наем.</th>
                            <th>Заглавие</th>
                            <th>Читател</th>
                            <th>Служител</th>
                            <th>Дата /от/</th>
                            <th>Срок /до/</th>
                            <th>Операция</th>
                        </tr>

                        <?php
                            //sql zqavka
                            $sql2 = "SELECT ren.id_rent, 
                                            b.title, 
                                            r.first_name AS reader_fname, 
                                            r.second_name AS reader_sname, 
                                            e.first_name AS emp_fname, 
                                            e.second_name AS emp_sname, 
                                            ren.rent_date, 
                                            ren.return_date
                                    FROM web_prog_library.rental ren
                                    INNER JOIN web_prog_library.books b
                                    ON ren.id_book = b.id_book
                                    INNER JOIN web_prog_library.readers r
                                    ON ren.id_reader = r.id_reader
                                    INNER JOIN web_prog_library.employees e
                                    ON ren.id_employee = e.id_employee
                                    ORDER BY ren.id_rent desc
                                    ";

                            //izpulnenie na zaqvkata
                            $res2 = mysqli_query($conn, $sql2);

                            //broene na redove
                            $count = mysqli_num_rows($res2);
                            if($count > 0){
                                //izvejdane na dannite
                                while($row = mysqli_fetch_assoc($res2)){
                                   $id_rent = $row['id_rent'];
                                   $title = $row['title'];
                                   $reader_fname = $row['reader_fname'];
                                   $reader_sname = $row['reader_sname'];
                                   $emp_fname = $row['emp_fname'];
                                   $emp_sname = $row['emp_sname'];
                                   $rent_date = $row['rent_date'];
                                   $return_date = $row['return_date'];
                            ?>
                            <tr>
                                <td><?php echo $id_rent; ?></td>
                                <td><?php echo $title; ?></td>
                                <td><?php echo $reader_fname." ".$reader_sname; ?></td>
                                <td><?php echo $emp_fname." ".$emp_sname; ?></td>
                                <td><?php echo $rent_date; ?></td>
                                <td><?php echo $return_date; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL;?>rent.php?id=<?php echo $id_rent?>" class="btn btn-update">Редак</a><a href="<?php echo SITEURL;?>delete_rent.php?id=<?php echo $id_rent;?>" class="btn btn-delete">Изтрий</a>
                                </td>
                            </tr>

                            <?php
                                }
                            }else{
                                echo "<tr><td colspan='7'>Няма данни в таблицата.</td></tr>";
                            }
                            ?>
                    </table>
            </div>
</div>

<?php include("partials/footer.php");?>