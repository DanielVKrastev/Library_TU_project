<?php
include("config/config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
        //sql заявка аа изтриване
        $sql = "DELETE FROM web_prog_library.employees WHERE id_employee=$id";

        //изпълнение
        $res = mysqli_query($conn, $sql);

        //пренасочване и съобщ
        if($res == true){
            //success
            $_SESSION['delete_data'] = "<div class='success'>Успешно изтриване.</div>";
            //redirect
            header("location:".SITEURL."employees.php");
            die();
        }else{
            //error
            $_SESSION['delete_data'] = "<div class='error'>Неуспешно изтриване.</div>";
            //redirect
            header("location:".SITEURL."employees.php");
            die();
        }

    }
else{
    //пренасочване
    header("location:".SITEURL."employees.php");
    die();
}
?>