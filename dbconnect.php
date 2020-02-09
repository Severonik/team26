<?PHP
// Указываем кодировку
    header('Content-Type: text/html; charset=utf-8');
 
    $server = "a320612.ftp.mchost.ru"; /* имя хоста (уточняется у провайдера), если работаем на локальном сервере, то указываем localhost */
    $username = "a320612_komanda1"; /* Имя пользователя БД */
    $password = "123456Q"; /* Пароль пользователя, если у пользователя нет пароля то, оставляем пустым */
    $database = "a320612_komanda1"; /* Имя базы данных, которую создали */
     
    // Подключение к базе данный через MySQLi
    $mysqli = new mysqli($server, $username, $password, $database);
 
    // Проверяем, успешность соединения. 
    if (mysqli_connect_errno()) { 
        echo "<p><strong>Ошибка подключения к БД</strong>. Описание ошибки: ".mysqli_connect_error()."</p>";
        exit(); 
    }
 
    // Устанавливаем кодировку подключения
    $mysqli->set_charset('utf8');
 
    //Для удобства, добавим здесь переменную, которая будет содержать название нашего сайта
    $address_site = "http://komanda1.mcdir.ru/";
?>