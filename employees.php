<?php include("partials/menu.php");?>
<style>
    #active-emp{
        background-color: #1e272e;
    }
</style>
    <h2 class="text-center">Служители</h2>
    <div class="content" style="margin-bottom: 0;">
        <a href="employees/position.php" class="btn btn-primary">Позиции</a>
    </div>
    <div class="boxs-content">
        <div class="box-2">
            <h3>Добавяне в таблица Служители</h3>
            <form action="" method="post">
                <?php
            error_reporting(E_ALL ^ E_WARNING); 
                ?>
                <label>Име: </label><br>
                <input type="text" name="first_name" required><br>

                <label>Фамилия: </label><br>
                <input type="text" name="second_name" required><br>

                <label>Позиция: </label><br>

                <select name="id_position" required>
                <?php
                    //заяка
                    $sql_position = "SELECT * FROM web_prog_library.emp_position";
                    //изпълнение
                    $res_position = mysqli_query($conn, $sql_position);
                    //броене на редовете
                    $count_position = mysqli_num_rows($res_position);
                    if($count_position > 0){
                        //извеждане на данните
                        while($row = mysqli_fetch_assoc($res_position)){
                        
                        $id_position = $row['id_position'];
                        $position = $row['position'];
                ?>
                    <option value="<?php echo $id_position; ?>"><?php echo $position; ?></option>
                <?php
                    }
                }else{
                    ?>
                        <option value="0">Няма открити позиции.</option>
                    <?php
                }
                ?>
                </select><br>

                <label>Телефон: </label><br>
                <input type="text" name="telephone" required><br>

                <label>E-mail: </label><br>
                <input type="text" name="email" required><br><br>

                <input type="submit" name="input" value="Добави" class="btn btn-orange">

                <?php
                    if(isset($_POST['input'])){
                        $first_name = $_POST['first_name'];
                        $second_name = $_POST['second_name'];
                        $id_position = $_POST['id_position'];
                        $telephone = $_POST['telephone'];
                        $email = $_POST['email'];
                    

                    //sql заявка
                    $sql_position_insert = "INSERT INTO web_prog_library.employees SET
                                            first_name = '$first_name',
                                            second_name = '$second_name',
                                            id_position = $id_position,
                                            telephone = '$telephone',
                                            email = '$email'
                    ";
                    //изпълнение
                    $res_position_insert = mysqli_query($conn, $sql_position_insert);


                    if( $res_position_insert){
                        $_SESSION['input']= "<div class='success'>Успено добавяне.</div>";
                        header("location:".SITEURL."employees.php");
                        die();
                    }
                }
                ?>

                <?php
                //извеждане на съобщ за добавяне
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
                <label>ID Служител: </label>
                <?php
                //взема ид от url адреса
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                        echo $id;
                    }
                ?>
                <br>
                <input type="hidden" name="id" value="<?php echo $id;?>"><br>

                <?php
                if(isset($_GET['id'])){
                    //sql заявка зависи от ид
                    $sql2 = "SELECT * FROM web_prog_library.employees WHERE id_employee = $id
                    ";

                    //изпълнение
                    $res2 = mysqli_query($conn, $sql2);

                    //броене на редовете
                    $count = mysqli_num_rows($res2);

                    if($count==1){
                        $row = mysqli_fetch_assoc($res2);
                        $id_employee = $row['id_employee'];
                        $first_name = $row['first_name'];
                        $second_name = $row['second_name'];
                        $current_position = $row['id_position'];
                        $telephone = $row['telephone'];
                        $email = $row['email'];
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
                <label>Име: </label><br>
                <input type="text" name="first_name" value="<?php echo $first_name;?>" required><br>

                <label>Фамилия: </label><br>
                <input type="text" name="second_name" value="<?php echo $second_name;?>" required><br>

                <label>Позиция: </label><br>
                <select name="id_position"  required>
                    <?php
                        //заявка за позиции
                        $sql_position = "SELECT * FROM web_prog_library.emp_position";
                        //изпълнение
                        $res_position = mysqli_query($conn, $sql_position);
                        //броене на редовете
                        $count_position = mysqli_num_rows($res_position);
                        if($count_position > 0){
                            while($row = mysqli_fetch_assoc($res_position)){
                            
                            $id_position = $row['id_position'];
                            $position = $row['position'];
                    ?>
                        <option value="<?php echo $id_position; ?>" <?php if($current_position == $id_position ){echo 'selected';} ?>><?php echo $position ?></option>
                    <?php
                        }
                    }else{
                        ?>
                            <option value="0">Няма открити позиции.</option>
                        <?php
                    }
                    ?>
                    </select><br>

                <label>Телефон: </label><br>
                <input type="text" name="telephone" value="<?php echo $telephone;?>"  required><br>

                <label>E-mail: </label><br>
                <input type="text" name="email" value="<?php echo $email;?>"  required><br><br>
                
                <input type="submit" name="submit_update" value="Редактирай" class="btn btn-primary">

                <?php

                    if(isset($_POST['submit_update'])){
                        $id_emp = $_POST['id'];
                        $first_name = $_POST['first_name'];
                        $second_name = $_POST['second_name'];
                        $id_position = $_POST['id_position'];
                        $telephone = $_POST['telephone'];
                        $email = $_POST['email'];
                        //заявка за редактиране
                        $sql3 = "UPDATE web_prog_library.employees SET
                                first_name = '$first_name',
                                second_name = '$second_name',
                                id_position = '$id_position',
                                telephone = '$telephone',
                                email = '$email'
                                WHERE id_employee = $id_emp
                        ";

                        //изпълнение
                        $res3 = mysqli_query($conn, $sql3);
                        
                        //проверка
                        if($res3 == true){
                            $_SESSION['update'] = "Редактирано успешно.<br>";
                            header("location:".SITEURL."employees.php");
                            die();
                        }else{
                            $_SESSION['update'] = "Грешка в редактирането.<br>";
                            header("location:".SITEURL."employees.php");
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
        ?>
                    <table class="tbl">
                        <tr class="text-center">
                            <th>ID служ.</th>
                            <th>Име</th>
                            <th>Фамилия</th>
                            <th>Позиция</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Операция</th>
                        </tr>

                        <?php
                            //sql заявка
                            $sql2 = "SELECT id_employee, first_name, second_name, position, telephone, email
                                    FROM web_prog_library.employees
                                    INNER JOIN web_prog_library.emp_position
                                    ON employees.id_position = emp_position.id_position
                                    ";

                            //изпълнеине
                            $res2 = mysqli_query($conn, $sql2);

                            //броене на редовете
                            $count = mysqli_num_rows($res2);
                            if($count > 0){
                               //извеждане на данните
                                while($row = mysqli_fetch_assoc($res2)){
                                    $id_employee = $row['id_employee'];
                                    $first_name = $row['first_name'];
                                    $second_name = $row['second_name'];
                                    $position = $row['position'];
                                    $telephone = $row['telephone'];
                                    $email = $row['email'];
                            ?>
                            <tr>
                                <td><?php echo $id_employee; ?></td>
                                <td><?php echo $first_name; ?></td>
                                <td><?php echo $second_name; ?></td>
                                <td><?php echo $position; ?></td>
                                <td><?php echo $telephone; ?></td>
                                <td><?php echo $email; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_employee?>" class="btn btn-update">Редак</a><a href="<?php echo SITEURL;?>delete_employees.php?id=<?php echo $id_employee;?>" class="btn btn-delete">Изтрий</a>
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
<?php include("partials/footer.php");?>