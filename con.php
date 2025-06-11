<?php
  $host = 'localhost';  // Хост, у нас все локально
  $user = 'minance_usr';    // Имя созданного вами пользователя
  $pass = 'Hu8XuhfhAjTve792'; // Установленный вами пароль пользователю
  $db_name = 'minance';   // Имя базы данных
  $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

  // Ругаемся, если соединение установить не удалось
  if (!$link) {
    echo 'Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
    exit;
  }
?>