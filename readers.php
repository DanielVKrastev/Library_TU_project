<?php include("partials/menu.php");?>
<style>
    #active-reader{
        background-color: #1e272e;
    }
</style>
    <h2 class="text-center">Читатели</h2>
   <div class="content" style="margin-bottom: 15px;"></div>
   <div class="boxs-content">
        <div class="box-2">
            <h3>Добавяне в таблица Читатели</h3>
            <form action="" method="post">
                <?php
            error_reporting(E_ALL ^ E_WARNING); 
                ?>
                <label>Име: </label><br>
                <input type="text" name="first_name" required><br>

                <label>Фамилия: </label><br>
                <input type="text" name="second_name" required><br>

                <label>Телефон: </label><br>
                <input type="text" name="telephone" required><br>

                <label>E-mail: </label><br>
                <input type="text" name="email" required><br><br>

                <input type="submit" name="input" value="Добави" class="btn btn-orange">

                <?php
                    if(isset($_POST['input'])){
                        $first_name = $_POST['first_name'];
                        $second_name = $_POST['second_name'];
                        $telephone = $_POST['telephone'];
                        $email = $_POST['email'];
                    

                    //sql zaqvka
                    $sql_readers_insert = "INSERT INTO web_prog_library.readers SET
                                            first_name = '$first_name',
                                            second_name = '$second_name',
                                            telephone = '$telephone',
                                            email = '$email'
                    ";

                    $res_readers_insert = mysqli_query($conn, $sql_readers_insert);


                    if( $res_readers_insert){
                        $_SESSION['input']= "<div class='success'>Успено добавяне.</div>";
                        header("location:".SITEURL."readers.php");
                        die();
                    }
                }
                ?>

                <?php
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
                <label>ID Читател: </label>
                <?php
                //vzema na id ot url adresa
                    if(isset($_GET['id'])){
                        $id = $_GET['id'];
                        echo $id;
                    }
                ?>
                <br>
                <input type="hidden" name="id" value="<?php echo $id;?>"><br>

                <?php
                if(isset($_GET['id'])){
                    //sql zavka spored id-to
                    $sql2 = "SELECT * FROM web_prog_library.readers WHERE id_reader = $id
                    ";

                    //izpulnenie na zaqvkata
                    $res2 = mysqli_query($conn, $sql2);

                    //broene na redovete
                    $count = mysqli_num_rows($res2);

                    if($count==1){
                        $row = mysqli_fetch_assoc($res2);
                        $id_reader = $row['id_reader'];
                        $first_name = $row['first_name'];
                        $second_name = $row['second_name'];
                        $telephone = $row['telephone'];
                        $email = $row['email'];
                    }else{
                        //refresh
                        $_SESSION['update-message-error'] = "<div class='error'>Несъществуващо ID.</div>";
                        header("location:".SITEURL."readers.php");
                        die();
                    }
                }
                    if(isset($_SESSION['update-message-error'])){
                        echo $_SESSION['update-message-error'];
                        unset($_SESSION['update-message-error']);
                    }

                ?>
                <?php
            error_reporting(E_ALL ^ E_WARNING); 
                ?>
                <label>Име: </label><br>
                <input type="text" name="first_name" value="<?php echo $first_name; ?>" required><br>

                <label>Фамилия: </label><br>
                <input type="text" name="second_name" value="<?php echo $second_name; ?>" required><br>

                <label>Телефон: </label><br>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" required><br>

                <label>E-mail: </label><br>
                <input type="text" name="email" value="<?php echo $email; ?>" required><br><br>

                <input type="submit" name="submit_update" value="Редактирай" class="btn btn-primary">
                <?php

                    if(isset($_POST['submit_update'])){
                        $id_rdr = $_POST['id'];
                        $first_name = $_POST['first_name'];
                        $second_name = $_POST['second_name'];
                        $telephone = $_POST['telephone'];
                        $email = $_POST['email'];
                        //zaqvkata za update
                        $sql3 = "UPDATE web_prog_library.readers SET
                                first_name = '$first_name',
                                second_name = '$second_name',
                                telephone = '$telephone',
                                email = '$email'
                                WHERE id_reader = $id_rdr
                        ";

                        //izpulnenie
                        $res3 = mysqli_query($conn, $sql3);
                        
                        //proverka
                        if($res3 == true){
                            $_SESSION['update'] = "Редактирано успешно.<br>";
                            header("location:".SITEURL."readers.php");
                            die();
                        }else{
                            $_SESSION['update'] = "Грешка в редактирането.<br>";
                            header("location:".SITEURL."readers.php");
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
                    <th>ID чл</th>
                    <th>Име</th>
                    <th>Фамилия</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Операция</th>
                </tr>

                <?php
                    //sql zqavka
                    $sql2 = "SELECT id_reader, first_name, second_name, telephone, email
                            FROM web_prog_library.readers
                            ";

                    //izpulnenie na zaqvkata
                    $res2 = mysqli_query($conn, $sql2);

                    //broene na redove
                    $count = mysqli_num_rows($res2);
                    if($count > 0){
                        //izvejdane na dannite
                        while($row = mysqli_fetch_assoc($res2)){
                            $id_reader = $row['id_reader'];
                            $first_name = $row['first_name'];
                            $second_name = $row['second_name'];
                            $telephone = $row['telephone'];
                            $email = $row['email'];
                            ?>

                            <tr>
                                <td><?php echo $id_reader; ?></td>
                                <td><?php echo $first_name; ?></td>
                                <td><?php echo $second_name; ?></td>
                                <td><?php echo $telephone; ?></td>
                                <td><?php echo $email; ?></td>
                                <td>
                                    <a href="?id=<?php echo $id_reader?>" class="btn btn-update">Редак</a><a href="<?php echo SITEURL;?>delete_readers.php?id=<?php echo $id_reader;?>" class="btn btn-delete">Изтрий</a>
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