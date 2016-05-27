<?php

require_once('config.php');





$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);


$sql=
"INSERT INTO `dzialy` (`ID`, `ADRES`, `DZIAL`, `LEV_DOSTEPU`) VALUES
(1, 'promocje.php', 'Promocje', 1),
(2, 'kontakty.php', 'Kontrakty', 1),
(3, 'firmy.php', 'Firmy', 1),
(4, 'oferty.php', 'Oferty', 1),
(6, 'klienci.php', 'Klienci', 2),
(7, 'rezerwacje.php', 'Rezerwacje', 2),
(8, 'domki.php', 'Domki', 2),
(9, 'promocje.php', 'Promocje', 3),
(10, 'oferty.php', 'Oferty', 3),
(11, 'rezerwacje.php', 'Rezerwacje', 3),
(12, 'domki.php', 'Domki', 4),
(13, 'rezerwacje.php', 'Rezerwacje', 4),
(14, 'dostepnesrodki.php', 'Dostępne środki', 4),
(15, 'niezbednesrodki.php', 'Niezbędne środki', 4),
(16, 'usterki.php', 'Usterki', 4),
(17, 'domki.php', 'Domki', 5),
(18, 'rezerwacje.php', 'Rezerwacje', 5),
(19, 'dostepnesrodki.php', 'Dostępne środki', 5),
(20, 'niezbednesrodki.php', 'Niezbędne środki', 5),
(21, 'oferty.php', 'Oferty', 5),
(22, 'usterki.php', 'Usterki', 5),
(23, 'firmy.php', 'Firmy', 5),
(24, 'kontrakty.php', 'Kontrakty', 5),
(25, 'promocje.php', 'Promocje', 5),
(26, 'klienci.php', 'Klienci', 5),
(27, 'domki.php', 'Domki', 6),
(28, 'rezerwacje.php', 'Rezerwacje', 6),
(29, 'niezbednesrodki.php', 'Niezbędne środki', 6),
(30, 'dostepnesrodki.php', 'Dostępne środki', 6),
(31, 'oferty.php', 'Oferty', 6),
(32, 'usterki.php', 'Usterki', 6),
(33, 'firmy.php', 'Firmy', 6),
(34, 'promocje.php', 'Promocje', 6),
(35, 'kontrakty.php', 'Kontrakty', 6),
(36, 'klienci.php', 'Klienci', 6),
(37, 'uzytkownicy.php', 'Użytkownicy', 6),
(38, 'wiadomosci.php', 'wiadomosci', 6),
(39, 'wiadomosci.php', 'wiadomosci', 5),
(40, 'wiadomosci.php', 'wiadomosci', 2)";

//ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());


?>