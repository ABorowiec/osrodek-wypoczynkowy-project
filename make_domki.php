<?php

require_once('config.php');





$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error());

mysql_select_db($db_name);

//$sql=
//	"
//	
//	)ENGINE=INNODB DEFAULT CHARACTER SET utf8    COLLATE utf8_general_ci";

//$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `domek` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Nazwa` varchar(30) COLLATE utf8_polish_ci UNIQUE NOT NULL,
`Opis` text COLLATE utf8_polish_ci NOT NULL,
`Rezerwacja` INT (1) UNSIGNED COLLATE utf8_polish_ci NOT NULL,
`Cena` INT UNSIGNED COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";

$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `dzialy` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`ADRES` varchar(30) COLLATE utf8_polish_ci NOT NULL,
`DZIAL` varchar(30) COLLATE utf8_polish_ci NOT NULL,
`LEV_DOSTEPU` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `d_srodki` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`Ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());


$sql=
"CREATE TABLE `firma` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Nazwa` varchar(50) COLLATE utf8_polish_ci UNIQUE NOT NULL,
`Adres` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`Miasto` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`NIP` int(15) NOT NULL,
`REGON` int(15) NOT NULL,
`Telefon` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `klient` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Imie` varchar(20) COLLATE utf8_polish_ci NOT NULL,
`Nazwisko` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`Adres` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`Miasto` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`Telefon` int(9) UNIQUE NOT NULL,
`PESEL` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `kontrakt` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`Opis` text COLLATE utf8_polish_ci NOT NULL,
`ID_Firma` INT UNSIGNED NOT NULL,
FOREIGN KEY (ID_Firma) REFERENCES firma (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `n_srodki` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`Ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `oferta` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`Opis` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

// $sql=
// "CREATE TABLE `platnosc` (
// `ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
// `Karta` int(11) NOT NULL,
// `Gotowka` int(11) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


// $results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `promocja` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Nazwa` text COLLATE utf8_polish_ci NOT NULL,
`ID_domek` INT UNSIGNED NOT NULL,
`Znizka` INT UNSIGNED NOT NULL,
`Opis` text COLLATE utf8_polish_ci NOT NULL,
FOREIGN KEY (ID_domek) REFERENCES domek (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `rezerwacja` (
`ID` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`ID_klient` INT UNSIGNED NOT NULL,
`ID_domek` INT UNSIGNED NOT NULL,
`Rodzaj_platnosci` INT UNSIGNED,
`Kwota` int(11),
`Ilosc_dni` int(11),
FOREIGN KEY (ID_klient) REFERENCES klient (ID) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (ID_domek) REFERENCES domek (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `usterka` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`Nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL,
`ID_domek` INT UNSIGNED NOT NULL,
`opis` text COLLATE utf8_polish_ci NOT NULL,
FOREIGN KEY (ID_domek) REFERENCES domek (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";


$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

$sql=
"CREATE TABLE `users` (
`username` varchar(60) NOT NULL PRIMARY KEY,
`password` tinytext NOT NULL,
`level` int(2) NOT NULL,
`reset` tinytext,
`ip_login` varchar(30),
`date_register` datetime,
`date_login` datetime
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";

$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error()); 


$sql=
"CREATE TABLE `zamowienia` (
`ID`  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`ID_Domek` INT UNSIGNED COLLATE utf8_polish_ci NOT NULL,
`Imie` varchar(30) COLLATE utf8_polish_ci NOT NULL,
`Nazwisko` varchar(30) COLLATE utf8_polish_ci NOT NULL,
`Telefon` varchar(20) COLLATE utf8_polish_ci NOT NULL,
`Uwagi` varchar(45) COLLATE utf8_polish_ci NOT NULL,
FOREIGN KEY (ID_Domek) REFERENCES domek (ID) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci";

$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

?>