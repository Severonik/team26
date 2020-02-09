<?PHP
//Запускаем сессию
session_start();

//Добавляем файл подключения к БД
require_once("dbconnect.php");

    //Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
$_SESSION["error_messages"] = '';

    //Объявляем ячейку для добавления успешных сообщений
$_SESSION["success_messages"] = '';

// Записываем массив сессии	
$_SESSION["number"] ='';
$_SESSION["inn"] = '';
$_SESSION["organisationType"] = '';
$_SESSION["organisationName"] = '';
$_SESSION["jurAddress_1"] = '';
$_SESSION["jurAddress_2"] = '';



$_POST = json_decode(file_get_contents('php://input'), true);


// Регистрация
if ( 
	isset($_POST['number']) && $_POST['number']
	&& isset($_POST['inn']) && $_POST['inn']
	&& isset($_POST['organisationType']) && $_POST['organisationType']
	&& isset($_POST['organisationName']) && $_POST['organisationName']
	&& isset($_POST['jurAddress_1']) && $_POST['jurAddress_1']
	&& isset($_POST['jurAddress_2']) && $_POST['jurAddress_2']
	&& isset($_POST['mail']) && $_POST['mail']
	&& isset($_POST['password']) && $_POST['password']
)
{

		// Записываем массив сессии	
	$_SESSION["number"] .= $_POST['number'];
	$_SESSION["inn"] .= $_POST['inn'];
	$_SESSION["organisationType"] .= $_POST['organisationType'];
	$_SESSION["organisationName"] .= $_POST['organisationName'];
	$_SESSION["jurAddress_1"] .= $_POST['jurAddress_1'];
	$_SESSION["jurAddress_2"] .= $_POST['jurAddress_2'];




	// echo json_encode(array('success' => 1));

    //Шифруем папроль
	$password = md5($_POST['password']."top_secret");

    //Запрос на добавления данных в БД
	$result_query_insert = $mysqli->query("INSERT INTO users (num, inn, organisationType, organisationName,  jurAddress_1, jurAddress_2, mail, password) VALUES (
		'".$_POST['number']."', 
		'".$_POST['inn']."', 
		'".$_POST['organisationType']."',
		'".$_POST['organisationName']."',
		'".$_POST['jurAddress_1']."', 
		'".$_POST['jurAddress_2']."', 
		'".$_POST['mail']."',
		'".$password."')
		");

	if(!$result_query_insert){
    // Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на добавления пользователя в БД</p>";

		// echo $_SESSION["error_messages"];
    //Останавливаем  скрипт
		exit();
	}else{

		$_SESSION["success_messages"] = "<p class='success_message'>Регистрация прошла успешно!!! <br />Теперь Вы можете авторизоваться используя Ваш логин и пароль.</p>";
		// echo $_SESSION["success_messages"];
	}

	/* Завершение запроса */
	$result_query_insert->close();

//Закрываем подключение к БД
	$mysqli->close();

}
// Авторизация
elseif (
	isset($_POST['mail']) && $_POST['mail'] 
	&& isset($_POST['pass']) && $_POST['pass']) {
	// echo json_encode(array('success' => 1));
	//Шифруем пароль
	$password = md5($_POST['pass']."top_secret");

 	//Запрос в БД на выборке пользователя.
	$result_query_select = $mysqli->query("SELECT * FROM users WHERE mail = '".$_POST['mail']."' AND password = '".$password."'");

	
	if(!$result_query_select){
    // Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на выборке пользователя из БД</p>";

    //Останавливаем скрипт
		exit();
	}else{

    //Проверяем, если в базе нет пользователя с такими данными, то выводим сообщение об ошибке
		if($result_query_select->num_rows == 1){

        // Если введенные данные совпадают с данными из базы, то сохраняем логин и пароль в массив сессий.
			$_SESSION['email'] =$_POST['mail'];
			$_SESSION['password'] = $password;

			$_SESSION["error_messages"] .= "<p class='mesage_error' >Вы авторизованы</p>";


			//Выводим все организации данного аккаунта
			while($row = mysqli_fetch_array($result_query_select)){
				$_SESSION["id"] =  $row['id'];
				$_SESSION["num"] =  $row['num'];
				$_SESSION["inn"] = $row['inn'];
				$_SESSION["organisationType"] = $row['organisationType'];
				$_SESSION["organisationName"] = $row['organisationName'];
				$_SESSION["jurAddress_1"] = $row['jurAddress_1'];
				$_SESSION["jurAddress_2"] = $row['jurAddress_2'];
				$_SESSION["fio"] =  '';
				$_SESSION["passport"] = '';

			}

				//Выводим сотрудников этого id
				while ($row = mysqli_fetch_array($staff)) {
					$_SESSION["fio"] .= $row['fio'].', ';
					$_SESSION["passport"] .= $row['passport'].', ';
		
				}
		
	


			//Запишем количество сотрудников
			$_SESSION["count"] = $count;
			// echo json_encode(array(True));
			echo json_encode(array(
				'id'=>$_SESSION["id"],
				'number'=>$_SESSION["num"],
				'inn'=>$_SESSION["inn"],
				'organisationType'=>$_SESSION["organisationType"],
				'organisationName'=>$_SESSION["organisationName"],
				'jurAddress_1'=>$_SESSION["jurAddress_1"],
				'jurAddress_2'=>$_SESSION["jurAddress_2"],
				'mail'=> $_SESSION['email'],
				'fio' => $_SESSION["fio"],
				'passport'=> $_SESSION["passport"],

			));


        //Перемещаем пользователя в личный кабинет

		}else{
        // Сохраняем в сессию сообщение об ошибке. 
			$_SESSION["error_messages"] .= "<p class='mesage_error' >Неправильный логин и/или пароль</p>";

        //Возвращаем пользователя на страницу авторизации
			echo json_encode(array(False));

        //Останавливаем скрипт
			exit();
		}
	}
}
// Если не то и не другое
else {
	echo json_encode(array('success' => 0));
}
