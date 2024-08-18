<?php
include("../config/config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
        //заявка за изтриване
        $sql = "DELETE FROM web_prog_library.type WHERE id_type=$id";

        //изпълнение
        $res = mysqli_query($conn, $sql);

        //изпращане на съобщ и пренасочване
        if($res == true){
            //success
            $_SESSION['delete_data'] = "<div class='success'>Успешно изтриване.</div>";
            //redirect
            header("location:".SITEURL."books/type.php");
            die();
        }else{
            //error
            $_SESSION['delete_data'] = "<div class='error'>Неуспешно изтриване.</div>";
            //redirect
            header("location:".SITEURL."books/type.php");
            die();
        }

    }
else{
    //пренасочване ако ид не съществува
    header("location:".SITEURL."books/type.php");
    die();
}
?>