<?php

require_once('config.php');





$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);


$sql=
"CREATE TABLE `zamowienia` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Domek` varchar(30) COLLATE utf8_polish_ci NOT NULL,
`Imie` varchar(30) COLLATE utf8_polish_ci NOT NULL,
`Nazwisko` varchar(30) COLLATE utf8_polish_ci NOT NULL,
`Telefon` varchar(20) COLLATE utf8_polish_ci NOT NULL,
`Uwagi` varchar(45) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";

$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());



?>