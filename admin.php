<!DOCTYPE HTML>
<html>
<head>
    <title>Главная страница</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
</head>
<body class="is-preload">


<div id="header">

    <div class="top">

        <nav id="nav">
            <ul>
                <li><a href="#top" id="top-link"><span class="icon solid fa-home">Главная</span></a></li>
                <li><a href="table\users.php" id="portfolio-link"><span class="icon solid fa-th">Все пользователи</span></a></li>
                <li><a href="table\tovar.php" id="about-link"><span class="icon solid fa-user">Все базы практик</span></a></li>
                <li><a href="#reg"><span class="icon solid fa-user">Новые пользователи</span></a></li>
                <li><a href="index.php"><span>Назад</span></a></li>
                <div id="reg" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">`
                            <div class="modal-header">
                                <h3 class="modal-title">Новые пользователи</h3>
                                <a href="#close" title="Close" class="close">×</a>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <form method="POST">
                                        <input name="field" type="text" required placeholder="Логин"><br>
                                        <input name="password" type="password" required placeholder="Пароль"><br>
                                        <?
                                        $field = $_REQUEST['field'];
                                        $link = mysqli_connect("localhost", "root", "", "kva-kva");
                                        $sql = "SELECT staff_id, name FROM `staff`";
                                        $result_select = mysqli_query($link, $sql);
                                        // Страница регистрации нового пользователяё
                                        echo "<select name = 'status'>";
                                        while ($object = mysqli_fetch_object($result_select)) {
                                            echo "<option value = '$object->name' > $object->name </option>";
                                        }
                                        echo "</select>";
                                        // Соединямся с БД
                                        if (isset($_POST['submit'])) {
                                            $err = [];
                                            $status = $_POST['status'];
                                            // проверям логин
                                            if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['field'])) {
                                                $Color = "red";
                                                $Text = "Логин может состоять только из букв английского алфавита и цифр";
                                                echo '<div style="Color:' . $Color . '">' . $Text . '</div>';
                                            }

                                            if (strlen($_POST['field']) < 3 or strlen($_POST['field']) > 30) {
                                                $Color = "red";
                                                $Text = "Логин должен быть не меньше 3-х символов и не больше 30";
                                                echo '<div style="Color:' . $Color . '">' . $Text . '</div>';
                                            }

                                            // проверяем, не сущестует ли пользователя с таким именем
                                            $query = mysqli_query($link, "SELECT id FROM users WHERE field='" . mysqli_real_escape_string($link, $_POST['field']) . "'");
                                            if (mysqli_num_rows($query) > 0) {
                                                $Color = "red";
                                                $Text = "Пользователь с таким логином уже существует в базе данных";
                                                echo '<div style="Color:' . $Color . '">' . $Text . '</div>';
                                            }
                                            // Если нет ошибок, то добавляем в БД нового пользователя
                                            else {
                                                $login = $_POST['field'];
                                                // Убераем лишние пробелы и делаем двойное хеширование
                                                $password = md5(md5(trim($_POST['password'])));
                                                mysqli_query($link, "INSERT INTO users SET field='" . $login . "', user_password='" . $password . "', value='" . $status . "'");
                                                header("Location: admin.php");
                                                exit();
                                            }
                                        }
                                        ?>
                                        <br><input name="submit" type="submit" value="Создать">
                                    </form>
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </nav>

    </div>

    <div class="bottom">

        <ul class="icons">
            <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
        </ul>

    </div>

</div>


<div id="main">

    <section id="top" class="one dark cover">
        <div class="container">

            <header>
                <p></p>
                <h2 class="alt"><p></p>Добро пожаловать в главное окно администратора<p></p></h2>
                <p></p>

            </header>

        </div>
    </section>


</div>


<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>