<?php

require_once('config.php');





$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);


$sql=
"INSERT INTO `domek` (`ID`, `Nazwa`, `Opis`, `Rezerwacja`, `Cena`) VALUES
(1, 'Domek nr 1', '5-sosbowy,łazienka,aneks kuchenny,telewizor,usytuowany za domem właścicieli', 0, 20),
(2, 'Domek nr 2', '5-osobowy+łóżeczko dziecięce,aneks kuchenny,łaziekna, telewizor,kanapa', 0, 20),
(3, 'Domek nr 3', '5-sosbowy,aneks kuchenny,łazienka,telewizor', 0, 20),
(4, 'Domek nr 4', '5-sosbowy,aneks kuchenny,łazienka,telewizor,balkon ', 0, 20),
(5, 'domek nr 5', '5-sosbowy,aneks kuchenny,łazienka,telewizor,usytuowany przed podjazdem', 0, 20),
(6, 'domek nr 6', '5-sosbowy,aneks kuchenny,łazienka,telewizor,usytuowany przed podjazdem', 0, 20),
(7, 'domek nr 7', '5-sosbowy,aneks kuchenny,łazienka,telewizor,kanapa', 0, 20),
(8, 'domek nr 8', '5-sosbowy,aneks kuchenny,łazienka,telewizor', 0, 20),
(9, 'domek nr 9', '5-sosbowy,aneks kuchenny,łazienka,telewizor,balkon', 0, 20),
(10, 'domek nr 10', '5-sosbowy,aneks kuchenny,łazienka,telewizor', 0, 20),
(11, 'domek nr 11', '5-sosbowy,aneks kuchenny,łazienka,telewizor,kanapa', 0, 20),
(12, 'domek nr 12', '5-sosbowy,aneks kuchenny,łazienka,telewizor,grill', 0, 20),
(13, 'domek nr 13', '5-sosbowy,aneks kuchenny,łazienka,telewizor,grill', 0, 20),
(14, 'Domek nr 14', '5-sosbowy,aneks kuchenny,łazienka,telewizor,usytuowany obok parkingu', 0, 20),
(15, 'Domek nr 15', '5-sosbowy,aneks kuchenny,łazienka,telewizor,usytuowany obok parkingu', 0, 20),
(16, 'Domek nr 16', '5-sosbowy,aneks kuchenny,łazienka,telewizor,grill, usytuowany obok placu zabaw', 0, 20),
(17, 'Domek nr 17', '5-sosbowy,aneks kuchenny,łazienka,telewizor,usytuowany obok placu zabaw', 0, 20),
(19, 'Hotel', 'Hotel 22', 0, 3),
(20, 'hahatel', 'Hotel444', 0, 0),
(21, 'Domekbhjbhjb', 'to jest nowy domek bitch', 0, 0),
(31, 'aa', 'noweeee', 1, 4444),
(33, 'cos', 'cos', 1, 0),
(35, 'domek2nvjbm', 'domek2vvvvvvv', 1, 0),
(36, 'domek3', 'domek3', 0, 0),
(38, 'doooomeeeeek', 'gjgkjlkjhgg', 0, 0),
(112, 'aaaaaaa', 'sadas', 1, 22),
(113, 'domek', 'dsa', 0, 1),
(115, 'domek000000000', 'no', 0, 20);";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
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
(14, 'dostepnesrodki.php', 'DostÄ™pne Å›rodki', 4),
(15, 'niezbednesrodki.php', 'NiezbÄ™dne Å›rodki', 4),
(16, 'usterki.php', 'Usterki', 4),
(17, 'domki.php', 'Domki', 5),
(18, 'rezerwacje.php', 'Rezerwacje', 5),
(19, 'dostepnesrodki.php', 'DostÄ™pne Å›rodki', 5),
(20, 'niezbednesrodki.php', 'NiezbÄ™dne Å›rodki', 5),
(21, 'oferty.php', 'Oferty', 5),
(22, 'usterki.php', 'Usterki', 5),
(23, 'firmy.php', 'Firmy', 5),
(24, 'kontrakty.php', 'Kontrakty', 5),
(25, 'promocje.php', 'Promocje', 5),
(26, 'klienci.php', 'Klienci', 5),
(27, 'domki.php', 'Domki', 6),
(28, 'rezerwacje.php', 'Rezerwacje', 6),
(29, 'niezbednesrodki.php', 'NiezbÄ™dne Å›rodki', 6),
(30, 'dostepnesrodki.php', 'DostÄ™pne Å›rodki', 6),
(31, 'oferty.php', 'Oferty', 6),
(32, 'usterki.php', 'Usterki', 6),
(33, 'firmy.php', 'Firmy', 6),
(34, 'promocje.php', 'Promocje', 6),
(35, 'kontrakty.php', 'Kontrakty', 6),
(36, 'klienci.php', 'Klienci', 6),
(37, 'uzytkownicy.php', 'UÅ¼ytkownicy', 6),
(38, 'wiadomosci.php', 'wiadomosci', 6),
(39, 'wiadomosci.php', 'wiadomosci', 5),
(40, 'wiadomosci.php', 'wiadomosci', 2);";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"INSERT INTO `d_srodki` (`ID`, `Nazwa`, `Ilosc`) VALUES
(1, 'Biała pościel', 100),
(2, 'Białe prześcieradło', 100),
(3, 'Białe poszewki', 100),
(4, 'Ręcznik', 20),
(5, 'Mydło', 20),
(6, 'Poduszka', 50),
(7, 'Kołdra', 50),
(8, 'Szklanka', 400),
(9, 'Sztućce', 100),
(10, 'Firanki', 70),
(11, 'Dywan', 20),
(12, 'Czajnik', 17),
(13, 'Odkurzacz', 3),
(14, 'Miotła', 5),
(15, 'Wiertarka', 2);";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
$sql=
"INSERT INTO `firma` (`ID`, `Nazwa`, `Adres`, `Miasto`, `NIP`, `REGON`, `Telefon`) VALUES
(1, 'Stokrotka', 'Słoneczna', 'Międzywodzie', 2147483647, 2147483647, 576345999),
(2, 'Kotwica', 'Zwycięstwa', 'Międzywodzie', 2147483647, 2147483647, 447234958),
(3, 'Alibaba', 'Słowacka', 'Kamień Pomorski', 2147483647, 2147483647, 888123477),
(4, 'Czyscioch', 'Miazga', 'Dziwnów', 2147483647, 2147483647, 58374095);
";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"INSERT INTO `klient` (`ID`, `Imie`, `Nazwisko`, `Adres`, `Miasto`, `Telefon`, `PESEL`) VALUES
(1, 'Jan', 'Kowalski', 'Bankowa ', 'Police', 879897789, 2147483647),
(2, 'Ania', 'Maj', 'Wyszynskiego', 'Szczecin', 576546589, 2147483647),
(3, 'Maciej', 'Kruk', 'Tarczaka', 'Warszawa', 987678985, 2147483647),
(4, 'Andrzej', 'Kot', 'Bankowa', 'Poznań', 789987632, 283009468),
(5, 'Bogdan', 'Nowak', 'Wroblewskiego', 'Katowice', 987618985, 2147483647),
(6, 'Maria', 'Kasprowicz', 'Złota', 'Szczecin', 567823980, 2147483647),
(7, 'Katarzyna', 'Nowak', 'Wroblewskiego', 'Koszalin', 959388455, 2147483647),
(8, 'Bogusława', 'Chmielewska', 'Wojska Polskiego', 'Szczecin', 998283447, 2147483647),
(9, 'Piotr', 'Zygi', 'Akacjowa', 'Kołobrzeg', 558029005, 2147483647),
(10, 'Kinga', 'Augustyniak', 'Sienkiewicza', 'Kraków', 58711294, 2147483647),
(11, 'Tomasz', 'Pera', 'Sikorskiego', 'Zielona Góra', 505948302, 2147483647),
(12, 'Aleksandra', 'Misiura', 'Borowikowa', 'Białystok', 958438223, 2147483647),
(13, 'Samanta', 'Brzezińska', 'Bracka', 'Stargard', 123948005, 2147483647),
(14, 'Mateusz', 'Gardziel', 'Siemiradzkiego', 'Lublin', 432567889, 2147483647),
(15, 'Natalia', 'Muszalska', 'Rolna', 'Wrocław', 154466678, 2147483647),
(16, 'Robert', 'Pietrzykowski', 'Skarbowa', 'Zakopane', 404909303, 2147483647),
(17, 'Kamil', 'Stachowicz', 'Saperska', 'Karpacz', 234567856, 2147483647),
(18, 'Mateusz', 'Zagórski', 'Słowackiego', 'Poznań', 223445687, 2147483647),
(19, 'Paweł', 'Wywijas', 'Kołłątaja', 'Szczecin', 856711235, 2147483647),
(20, 'Artur', 'Ziemba', 'Boczna', 'Chlebowo', 854634568, 2147483647);
";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"
INSERT INTO `kontrakt` (`ID`, `Nazwa`, `Opis`, `ID_Firma`) VALUES
(1, 'Kupony', 'Przez cały sierpień ośrodek dostaje od sklepu Stokrotka kupony ze zniżką na wędliny', 1),
(2, 'Obiady', 'W ciągu sezonu letniego restauracja Kotwica daje 10% zniżki dla gości ośrodka na zestawy obiadowe', 2),
(3, 'Środki czystości', 'Od 1 lipca do 31 sierpnia ośrodek posiada 50% zniżke na wszystkie produkty utrzymania czystości w hurtowni Alibaba', 3),
(4, 'Posciel', '10 pranie pościeli na koszt pralni Czyścioch', 4);
";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"INSERT INTO `n_srodki` (`ID`, `Nazwa`, `Ilosc`) VALUES
(1, 'Śrubokręt', 10),
(2, 'Śrubki', 50),
(3, 'Ajax', 30),
(4, 'Szmatki', 50),
(5, 'Doniczka', 10),
(6, 'Świeczka', 20),
(7, 'Solniczka', 17),
(8, 'Gąbka', 12),
(9, 'Mop', 3),
(10, 'Cif', 10),
(11, 'Kret', 10),
(12, 'Nawóz', 5),
(13, 'Węgiel', 4),
(14, 'Pilot', 5),
(15, 'Zapalniczka', 10);";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"INSERT INTO `oferta` (`ID`, `Nazwa`, `Opis`) VALUES
(1, 'Środki czystości', 'Od 1 lipca do 31 sierpnia ośrodek posiada 50% zniżke na wszystkie produkty utrzymania czystości w hurtowni Alibaba'),
(2, 'Posciel', '10 pranie pościeli na koszt pralni Czyścioch');
";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());


$sql=
"INSERT INTO `promocja` (`ID`, `Nazwa`, `ID_domek`, `Znizka`, `Opis`) VALUES
(1, 'Tanie weekendy', 1, 20, 'Za zakupiony nocleg trwający weekend 20% taniej'),
(2, 'Początek miesiąca', 2, 100, 'Nocleg rozpoczynający się nowym dniem miesiąca, pierwsza noc za darmo'),
(3, 'Grillowany sierpień', 3, 35, 'W ciągu całego sierpnia można zdobyć kupony na tańszą wędlinę w sklepach'),
(4, 'Obiad w Kotwicy', 4, 10, 'Tańsze posiłki o 10% zjedzone w restauracji Kotwica');
";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());


$sql=
"INSERT INTO `rezerwacja` (`ID`, `ID_klient`, `ID_domek`, `Rodzaj_platnosci`, `Kwota`, `Ilosc_dni`) VALUES
(5, 2, 20, '', 0, 3),
(6, 4, 19, '', 9, 3),
(7, 5, 112, '', 66, 3),
(8,6, 31, '', 13332, 3),
(9, 7, 33, '', 0, 22),
(10, 8, 35, '', 0, 3),
(11, 11, 35, '', 0, 3);
";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());


$sql=
"INSERT INTO `users` (`username`, `password`, `level`, `reset`, `ip_login`, `date_register`, `date_login`) VALUES
('administrator', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 6, NULL, '::1', NULL, '2016-05-27 16:12:56'),
('ksiegowy', '2d170201ad779f420aab4a2a59dd80e4f447f834a5b1ccace4b07558e299e649', 4, NULL, NULL, '2016-04-23 18:20:15', NULL),
('promotor', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 3, NULL, '::1', NULL, '2016-04-25 14:38:58'),
('przedstawiciel', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1, NULL, '::1', NULL, '2016-04-09 13:46:10'),
('recepcjonista', '1f77a98a3f52316b285a3f103db0427029189becb29af809be9b5c2834d0e92b', 2, NULL, '::1', NULL, '2016-04-23 16:10:26'),
('wlasciciel', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 5, NULL, '::1', NULL, '2016-04-23 18:15:48');
";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());


$sql=
"INSERT INTO `usterka` (`ID`, `Nazwa`, `ID_domek`, `opis`) VALUES
(1, 'Rura', 3, 'Pęknieta rura w umywalce w łązience'),
(2, 'Telewizor', 10, 'Telewizor nie odbiera żadnych programów'),
(3, 'Krzesło', 5, 'Noga od krzesła została połamana'),
(4, 'Czajnik', 7, 'Czajnik nie gotuje wody'),
(5, 'Prysznic', 15, 'Woda cały czas cieknie z prysznica');
";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());



?>