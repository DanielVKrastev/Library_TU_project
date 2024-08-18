<?php
include("config/config.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
        //когато се изтрия НАЕМА НА КНИГА, книгата трябва да стане активна:
        //заявка за данните на НАЕМА
        $sql_rent = "SELECT * FROM web_prog_library.rental WHERE id_rent = $id";

        //изпълнение и броене на редове
        $res_rent = mysqli_query($conn, $sql_rent);
        $count_rent = mysqli_num_rows($res_rent);

        //извеждане на данните за книгата от НАЕМА
        if($count_rent = 1 ){
            $row = mysqli_fetch_assoc($res_rent);
            $id_book = $row['id_book'];
        }

        //правим книгата да е активна
        $active = "Yes";

        //заявка за редактиране в таблица КНИГИ
        $sql_books_update = "UPDATE web_prog_library.books SET
                            active = '$active'
                            WHERE id_book = $id_book
                            ";

        //изпълнение на заявката за КНИГИ
        $res_books_update = mysqli_query($conn, $sql_books_update);

        //проверка
        if($res_books_update){
            $_SESSION['active_book'] = "<div class='success'>Книгата е активна.</div><br>";
        }else{
            $_SESSION['active_book'] = "<div class='error'>Грешка в заявката за книги.</div><br>";
            }

        //заяка за изтриване на наема
        $sql = "DELETE FROM web_prog_library.rental WHERE id_rent=$id";

        //изпълнение
        $res = mysqli_query($conn, $sql);

        //изпращане на съобщ
        if($res == true){
            //успешно
            $_SESSION['delete_data'] = "<div class='success'>Успешно изтриване.</div>";
            //redirect
            header("location:".SITEURL."rent.php");
            die();
        }else{
            //грешка
            $_SESSION['delete_data'] = "<div class='error'>Неуспешно изтриване.</div>";
            //redirect
            header("location:".SITEURL."rent.php");
            die();
        }

    }
else{
    //рефреш ако ид-то е грешно
    header("location:".SITEURL."rent.php");
    die();
}
?>