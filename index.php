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
                <li><a href="#portfolio" id="portfolio-link"><span class="icon solid fa-th">О нашем техникуме</span></a></li>
                <li><a href="#about" id="about-link"><span class="icon solid fa-user">День открытых дверей</span></a></li>
                <li><a href="#contact" id="contact-link"><span class="icon solid fa-envelope">Контакты</span></a></li>
                <li><a href="#login"><span class="icon solid fa-user">Авторизация</span></a></li>
                <div id="login" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Авторизация</h3>
                                <a href="#close" title="Close" class="close">×</a>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <form method="POST">
                                        <input name="field" type="text" required placeholder="Логин"><br>
                                        <input name="password" type="password" required placeholder="Пароль"><br>
                                        <?
                                        // Страница авторизации
                                        $field = $_REQUEST['field'];
                                        $value = $_REQUEST['password'];
                                        // Функция для генерации случайной строки
                                        function generateCode($length = 6)
                                        {
                                            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
                                            $code = "";
                                            $clen = strlen($chars) - 1;
                                            while (strlen($code) < $length) {
                                                $code .= $chars[mt_rand(0, $clen)];
                                            }
                                            return $code;
                                        }
                                        $link = mysqli_connect("localhost", "root", "", "kva-kva");
                                        if (isset($_POST['submit'])) {
                                            // Вытаскиваем из БД запись, у котоврой логин равняеться веденному
                                            $query = mysqli_query($link, "SELECT id, user_password, value FROM users WHERE field ='" . mysqli_real_escape_string($link, $_POST['field']) . "' LIMIT 1");
                                            $data = mysqli_fetch_assoc($query);
                                            // Сравниваем пароли
                                            if ($data['user_password'] === md5(md5($_POST['password']))) {
                                                if ($field = 'Админ') {
                                                    $hash = md5(generateCode(10));
                                                    header("Location: admin.php");
                                                    exit();
                                                } else {
                                                    $hash = md5(generateCode(10));
                                                    header("Location: index.php");
                                                    exit();
                                                }
                                            } else {
                                                $Color = "red";
                                                $Text = "Неверный логин или пароль";
                                                echo '<div style="Color:' . $Color . '">' . $Text . '</div>';
                                            }
                                        }
                                        ?>
                                        <br><input name="submit" type="submit" value="Войти">
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
<div></div>
<div id="main">

    <section id="top" class="one dark cover">
        <div class="container">

            <header>
                <h2 class="alt">ㅤ
                    <p></p>
                    <p>Добро пожаловать</p>
                </h2>
            </header>

        </div>
    </section>


    <section id="portfolio" class="two">
        <div class="container">
            <header>
                <?php
                require 'phpmailer/PHPMailer.php';
                require 'phpmailer/SMTP.php';
                require 'phpmailer/Exception.php';
                // Переменные, которые отправляет пользователь
                $name = $_POST['name'];
                $email = $_POST['email'];
                $text = $_POST['text'];

                $title = "Новый обращение";
                $body = "
                <h2>Новое письмо</h2>
                <b>Имя:</b> $name<br>
                <b>Почта:</b> $email<br><br>
                <b>Сообщение:</b><br>$text";
                // Настройки PHPMailer
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                try {
                    $mail->isSMTP();
                    $mail->CharSet = "UTF-8";
                    $mail->SMTPAuth = true;
                    //$mail->SMTPDebug = 2;
                    $mail->Debugoutput = function ($str, $level) {
                        $GLOBALS['status'][] = $str;
                    };

                    $mail->Host = 'ssl://smtp.gmail.com'; // SMTP сервера вашей почты
                    $mail->Username = 'example.news.mail@gmail.com'; // Логин на почте
                    $mail->Password = 'wqtmxkgcvcwkrolx'; // Пароль на почте
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->setFrom('example.news.mail@gmail.com', 'Имя отправителя'); // Адрес самой почты и имя отправителя

                    // Получатель письма
                    $mail->addAddress('example.news.mail@gmail.com');

                    // Прикрипление файлов к письму

// Отправка сообщения
                    $mail->isHTML(true);
                    $mail->Subject = $title;
                    $mail->Body = $body;
                    if (strlen($_POST['email']) <= 0 or strlen($_POST['name']) <= 0) {
                        $Color = "red";
                        $Text = "Заполните поля";
                        echo '<h3><div class = box style="Color:' . $Color . '">' . $Text . '</div><br></h3>';
                        $result = "success";
                    } else {
                        if ($mail->send()) {
                            $Color = "green";
                            $Text = "Сообщение успешно отправлено";
                            echo '<h3><div class = box style="Color:' . $Color . '">' . $Text . '</div><br></h3>';
                            $result = "success";
                        }
                    }
                } catch (Exception $e) {
                    $result = "error";
                    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
                }
                ?>
                <h2>О нас</h2>
            </header>
            <div class="row">
                <div class="col-4 col-12-mobile">
                    <article class="item">
                    <a href="#" class="image fit"><img src="images/zakr.jpg" alt=""/></a>
                        <header>
                            <h3>Специальность 09.02.07</h3>
                        </header>
                    </article>
                    <article class="item">
                        <p>«Информационные системы и программирование» по специализации «Специалист по тестированию в области информационных технологий» осуществляет подготовку специалистов по контролю качества программного обеспечения его разработки.
                        </p>
                    </article>
                </div>
                <div class="col-4 col-12-mobile">
                    <article class="item">
                        <p></p>
                        <p>«Информационные системы и программирование» по специализации «Специалист по тестированию» осуществляет подготовку современных разработчиков программного обеспечения.</p>
                    </article>
                    <article class="item">
                        <a href="#" class="image fit"><img src="images/prem.jpg" alt=""/></a>
                        <header>
                            <h3>Специальность 09.02.07 </h3>
                        </header>
                    </article>
                </div>
                <div class="col-4 col-12-mobile">
                    <article class="item">
                    <a href="#" class="image fit"><img src="images/spa.jpg" alt=""/></a>
                        <header>
                            <h3>Экономисты</h3>
                        </header>
                    </article>
                    <article class="item">
                        <p>Деятельность нашего отделения направлена на подготовку квалифицированных специалистов в области юриспруденции. Главная обязанность в юридической профессии: защита прав и свобод человека и гражданина. Юрист – это профессионал, стоящий на страже закона. Если Вы «заблудились» в поисках своего призвания, обратите внимание, насколько нужной и популярной остается во все времена профессия «ЮРИСТ».</p>
                    </article>
                </div>
            </div>

        </div>
    </section>
    <section id="about" class="three">
        <div class="container">

            <header>
                <h2>Вопросы ответы</h2>
                <p></p>
                <h4 class="alt">
                    <p>Узнай все о поступлении на программы среднего профессионального образования Московского приборостроительного техникума ФГБОУ ВО "РЭУ им.Г.В. Плеханова".</p>
                    <p>День открытых дверей состоится 18 февраля (суббота) в 14:30 по адресу Нежинская ул., д.7.</p>
                    <p>На время проведения мероприятия разрешен въезд на личном автотранспорте.</p>
                </h4>
            </header>

            <p></p>

        </div>

    </section>

    <section id="contact" class="four">
        <div class="container">

            <header>
                <h2>Контакты</h2>
            </header>
            <p>Телефон для связи +7 (977) 112 52 71</p>
            <p>Главное здание: г. Москва, Нежинская улица, 7</p>
            <p>Здание №2: г. Москва, Нахимовский проспект, 21</p>

            <form method="post" action="#">
                <div class="row">
                    <div class="col-6 col-12-mobile"><input type="text" name="name" placeholder="Имя"/></div>
                    <div class="col-6 col-12-mobile"><input type="text" name="email" placeholder="Почта"/></div>
                    <div class="col-12">
                        <textarea name="text" placeholder="Сообщение"></textarea>
                    </div>
                    <div class="col-12">
                        <input type="submit" value="Отправить"/>
                    </div>
                </div>
            </form>
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
<script>setTimeout(function () {
        $('.box').fadeOut('fast')
    }, 3000);</script>
</body>
</html>