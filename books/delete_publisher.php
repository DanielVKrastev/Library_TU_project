<?php
include("../config/config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
        //заявка за изтриване
        $sql = "DELETE FROM web_prog_library.publisher WHERE id_publisher=$id";

        //изпълнение
        $res = mysqli_query($conn, $sql);

        //изпращане на съобщение за данните
        if($res == true){
            //success
            $_SESSION['delete_data'] = "<div class='success'>Успешно изтриване.</div>";
            //redirect
            header("location:".SITEURL."books/publisher.php");
            die();
        }else{
            //error
            $_SESSION['delete_data'] = "<div class='error'>Неуспешно изтриване.</div>";
            //redirect
            header("location:".SITEURL."books/publisher.php");
            die();
        }

    }
else{
    //пренасочване ако ид не съществува
    header("location:".SITEURL."books/publisher.php");
    die();
}
?>