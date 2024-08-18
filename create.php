<?php include("partials/menu.php");?>
<style>
    #active-create{
        background-color: #1e272e;
    }
</style>

<div class="content">
    <h2 class="text-center">Създаване на база</h2>

    <form action="<?php echo SITEURL; ?>create.php" method="POST">
        <div class="create">
            <h3>1. Създаване на база от данни:</h3>
            <input type="submit" name="submit_base" class="btn btn-primary" value="База от данни">
            
            <?php 
                //създаване на база от данни
                if(isset($_POST['submit_base'])){
                   // echo "<span class='error'>test</span>";
                   $sql_base = 'CREATE Database IF NOT EXISTS web_prog_library';
                   if($res_base = mysqli_query($conn, $sql_base)){
                    $CREATE_DATABASE = "Yes";
                    echo "<span class='success'>Базата данни е създадена.</span>";
                   }
                   else
                   {
                    echo "<span class='success'>Грешка при създаване на базата данни.</span>";
                   }
                }
            
            ?>
        </div>
        
        <div class="create">
            <h3>2. Таблица Книги: /създават се последователно/</h3>
            <br>
            <h4>Създаване на табл. Автор:</h4>
            <input type="submit" name="submit_author" class="btn btn-primary" value="Автор">
            
            <?php
                //създаване на таблица АВТОР
            if(isset($_POST['submit_author'])){
                $sql_author = "CREATE TABLE IF NOT EXISTS web_prog_library.author(
                                id_author INT(10) NOT NULL AUTO_INCREMENT,
                                author VARCHAR(50) DEFAULT NULL,
                                PRIMARY KEY (id_author)
                                ) ENGINE=INNODB DEFAULT CHARSET=utf8";
                $res_author = mysqli_query($conn, $sql_author);
                if($res_author){
                    echo "<span class='success'>Таблицата е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на таблицата.</span>";
                    die();
                }
            }
            ?>

            <br>
            <h4>Създаване на табл. Издателства:</h4>
            <input type="submit" name="submit_publisher" class="btn btn-primary" value="Издателства">

            <?php
                //създаване на таблица Издателства
            if(isset($_POST['submit_publisher'])){
                $sql_publisher = "CREATE TABLE IF NOT EXISTS web_prog_library.publisher(
                                id_publisher INT(10) NOT NULL AUTO_INCREMENT,
                                publisher VARCHAR(50) DEFAULT NULL,
                                PRIMARY KEY (id_publisher)
                                ) ENGINE=INNODB DEFAULT CHARSET=utf8";
                $res_publisher = mysqli_query($conn, $sql_publisher);
                if($res_publisher){
                    echo "<span class='success'>Таблицата е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на таблицата.</span>";
                    die();
                }
            }
            ?>

            <br>
            <h4>Създаване на табл. Жанр:</h4>
            <input type="submit" name="submit_type" class="btn btn-primary" value="Жанр">

            <?php
                //създаване на таблица Жанр
            if(isset($_POST['submit_type'])){
                $sql_type = "CREATE TABLE IF NOT EXISTS web_prog_library.type(
                                id_type INT(10) NOT NULL AUTO_INCREMENT,
                                type VARCHAR(50) DEFAULT NULL,
                                PRIMARY KEY (id_type)
                                ) ENGINE=INNODB DEFAULT CHARSET=utf8";
                $res_type = mysqli_query($conn, $sql_type);
                if($res_type){
                    echo "<span class='success'>Таблицата е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на таблицата.</span>";
                    die();
                }
            }
            ?>

            <br>
            <h4>Създаване на табл. Книги:</h4>
            <input type="submit" name="submit_book" class="btn btn-primary" value="Книги">
            
            <?php
                //създаване на таблица Книги
            if(isset($_POST['submit_book'])){
                $sql_book = "CREATE TABLE IF NOT EXISTS web_prog_library.books(
                    id_book INT(10) NOT NULL AUTO_INCREMENT,
                    title VARCHAR(50) DEFAULT NULL,
                    id_author INT(10) NOT NULL,
                    year INT(4) NOT NULL,
                    id_publisher INT(10) NOT NULL,
                    id_type INT(10) NOT NULL,
                    counter_rent INT(10) NOT NULL,
                    active VARCHAR(10) DEFAULT NULL,
                    INDEX(id_author),
                    INDEX(id_publisher),
                    INDEX(id_type),
                    UNIQUE KEY unique_title (title),
                    PRIMARY KEY (id_book)
                    ) ENGINE=INNODB DEFAULT CHARSET=utf8";
                $res_book = mysqli_query($conn, $sql_book);
                if($res_book){
                    echo "<span class='success'>Таблицата е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на таблицата.</span>";
                    die();
                }
            }
            ?>
        </div>

        <div class="create">
            <h3>3. Таблица Служители:</h3>
            <br>
            <h4>Създаване на табл. Позиции /за служители/:</h4>
            <input type="submit" name="submit_position" class="btn btn-primary" value="Позиции">

            <?php

                //създаване на таблица Позиции
            if(isset($_POST['submit_position'])){
                $sql_position = "CREATE TABLE IF NOT EXISTS web_prog_library.emp_position(
                    id_position INT(10) NOT NULL AUTO_INCREMENT,
                    position VARCHAR(50) DEFAULT NULL,
                    PRIMARY KEY (id_position)
                    ) ENGINE=INNODB DEFAULT CHARSET=utf8";
                $res_position = mysqli_query($conn, $sql_position);
                if($res_position){
                    echo "<span class='success'>Таблицата е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на таблицата.</span>";
                    die();
                }
            }

            ?>
            <br>
            <h4>Създаване на табл. Служители:</h4>
            <input type="submit" name="submit_employees" class="btn btn-primary" value="Служители">

            <?php

                //създаване на таблица Служители
            if(isset($_POST['submit_employees'])){
                $sql_employees = "CREATE TABLE IF NOT EXISTS web_prog_library.employees(
                    id_employee INT(10) NOT NULL AUTO_INCREMENT,
                    first_name VARCHAR(50) DEFAULT NULL,
                    second_name VARCHAR(50) DEFAULT NULL,
                    id_position INT(10) NOT NULL,
                    telephone VARCHAR(12) DEFAULT NULL,
                    email VARCHAR(50) DEFAULT NULL,
                    PRIMARY KEY (id_employee)
                    ) ENGINE=INNODB DEFAULT CHARSET=utf8";
                $res_employees = mysqli_query($conn, $sql_employees);
                if($res_employees){
                    echo "<span class='success'>Таблицата е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на таблицата.</span>";
                    die();
                }
            }

            ?>
        </div>

        <div class="create">
            <h3>4. Таблица Читатели:</h3>
            <br>
            <h4>Създаване на табл. Читатели:</h4>
            <input type="submit" name="submit_reader" class="btn btn-primary" value="Читатели">
            <?php

            //създаване на таблица Читатели
            if(isset($_POST['submit_reader'])){
                $sql_readers = "CREATE TABLE IF NOT EXISTS web_prog_library.readers(
                    id_reader INT(10) NOT NULL AUTO_INCREMENT,
                    first_name VARCHAR(50) DEFAULT NULL,
                    second_name VARCHAR(50) DEFAULT NULL,
                    telephone VARCHAR(12) DEFAULT NULL,
                    email VARCHAR(50) DEFAULT NULL,
                    UNIQUE KEY unique_email (email),
                    PRIMARY KEY (id_reader)
                    ) ENGINE=INNODB DEFAULT CHARSET=utf8";
                $res_readers = mysqli_query($conn, $sql_readers);
                if($res_readers){
                    echo "<span class='success'>Таблицата е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на таблицата.</span>";
                    die();
                }
            }

            ?>
        </div>


        <div class="create">
            <h3>5. Таблица Заемане:</h3>
            <br>
            <h4>Създаване на табл. Заемане:</h4>
            <input type="submit" name="submit_rent" class="btn btn-primary" value="Заемане">
            <?php

            //създаване на таблица Заемане
            if(isset($_POST['submit_rent'])){
                $sql_rent = "CREATE TABLE IF NOT EXISTS web_prog_library.rental(
                    `id_rent` INT(10) NOT NULL AUTO_INCREMENT , 
                    `id_book` INT(10) NOT NULL , 
                    `id_reader` INT(10) NOT NULL , 
                    `id_employee` INT(10) NOT NULL , 
                    `rent_date` DATE NOT NULL , 
                    `return_date` DATE NOT NULL ,
                    UNIQUE KEY `unique_book` (`id_book`),
                    PRIMARY KEY (`id_rent`)
                    ) ENGINE=INNODB DEFAULT CHARSET=utf8";
                $res_rent = mysqli_query($conn, $sql_rent);
                if($res_rent){
                    echo "<span class='success'>Таблицата е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на таблицата.</span>";
                    die();
                }
            }

            ?>

        </div>
        
        <div class="create">
            <h3>6. Връзки между таблици: </h3>
            <br>
            <h4>Връзка с "Книги" и "Автор"</h4>
            <input type="submit" name="submit_book_author" class="btn btn-primary" value="Книги - Автор">

            <?php
            if(isset($_POST['submit_book_author'])){
                $sql_book_author = "ALTER TABLE web_prog_library.books
                        ADD CONSTRAINT book_author FOREIGN KEY (id_author) REFERENCES author (id_author) ON DELETE CASCADE ON UPDATE CASCADE
                        ";
                $res_book_author = mysqli_query($conn, $sql_book_author);
                if($res_book_author){
                    echo "<span class='success'>Връзката е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на връзка.</span>";
                    die();
                }
            }
            ?>

            <br>
            <h4>Връзка с "Книги" и "Издателства"</h4>
            <input type="submit" name="submit_book_publisher" class="btn btn-primary" value="Книги - Издателства">

            <?php
            if(isset($_POST['submit_book_publisher'])){
                $sql_book_publisher = "ALTER TABLE web_prog_library.books
                        ADD CONSTRAINT book_publisher FOREIGN KEY (id_publisher) REFERENCES publisher (id_publisher) ON DELETE CASCADE ON UPDATE CASCADE
                        ";
                $res_book_publisher = mysqli_query($conn, $sql_book_publisher);
                if($res_book_publisher){
                    echo "<span class='success'>Връзката е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на връзка.</span>";
                    die();
                }
            }
            ?>

            <br>
            <h4>Връзка с "Книги" и "Жанр"</h4>
            <input type="submit" name="submit_book_type" class="btn btn-primary" value="Книги - Жанр">

            <?php
            if(isset($_POST['submit_book_type'])){
                $sql_book_type = "ALTER TABLE web_prog_library.books
                        ADD CONSTRAINT book_type FOREIGN KEY (id_type) REFERENCES type (id_type) ON DELETE CASCADE ON UPDATE CASCADE
                        ";
                $res_book_type = mysqli_query($conn, $sql_book_type);
                if($res_book_type){
                    echo "<span class='success'>Връзката е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на връзка.</span>";
                    die();
                }
            }
            ?>
            
            <br>
            <h4>Връзка със "Служители" и "Позиции"</h4>
            <input type="submit" name="submit_emp_position" class="btn btn-primary" value="Служители - Позиции">

            <?php
            if(isset($_POST['submit_emp_position'])){
                $sql_emp_position = "ALTER TABLE web_prog_library.employees
                        ADD CONSTRAINT employees_ibfk_1 FOREIGN KEY (id_position) REFERENCES emp_position (id_position) ON DELETE CASCADE ON UPDATE CASCADE
                        ";
                $res_emp_position = mysqli_query($conn, $sql_emp_position);
                if($res_emp_position){
                    echo "<span class='success'>Връзката е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на връзка.</span>";
                    die();
                }
            }
            ?>

            <br>
            <h4>Връзка със "Заемане" -> "Книги", "Служители" и "Читатели"</h4>
            <input type="submit" name="submit_rent_relelation" class="btn btn-primary" value="Връзка със ЗАЕМАНЕ">

            <?php
            if(isset($_POST['submit_rent_relelation'])){
                $sql_rent_relelation = "ALTER TABLE web_prog_library.rental
                        ADD CONSTRAINT rental_book FOREIGN KEY (id_book) REFERENCES books (id_book) ON DELETE CASCADE ON UPDATE CASCADE,
                        ADD CONSTRAINT rental_reader FOREIGN KEY (id_reader) REFERENCES readers (id_reader) ON DELETE CASCADE ON UPDATE CASCADE,
                        ADD CONSTRAINT rental_employee FOREIGN KEY (id_employee) REFERENCES employees (id_employee)  ON DELETE CASCADE ON UPDATE CASCADE
                        ";
                $res_rent_relelation = mysqli_query($conn, $sql_rent_relelation);
                if($res_rent_relelation){
                    echo "<span class='success'>Връзката е създадена!</span>";
                }
                else
                {
                    echo "<span class='error'>Грешка при създаване на връзка.</span>";
                    die();
                }
            }
            ?>

        </div>
    </form>
</div>
<?php include("partials/footer.php");?>