<?php
session_start(); //dołącz plik z ustawieniami
require_once('config.php'); //wystartuj sesję
//header('Content-Type: text/html; charset=UTF-8');
?>
<html>
<head>
<META NAME="robots" CONTENT="noindex, nofollow">
<link rel="shortcut icon" href="dane\favicon.ico">
<link rel="Stylesheet" type="text/css" href="dane\style.css" />
</head>
<body>
<div  id=siteadmin>
<div id=mainsite>
<?php
if(isset($_SESSION['zalogowany'])) //jeśli zalogowany...
{
	function wyloguj() //funkcja wylogowywania
	{
		$_SESSION = array();
		session_destroy();
		header('Location: index.php');
	}
	if (isset($_GET['wyloguj'])){ //jeśli zadeklarowana zmienna wyloguj...
		if ($_GET['wyloguj'] == 'yes') { 
			wyloguj(); // wywołaj funkcję wyluguj() 
		} 
	}
	$level = $_SESSION['level'];
	$username = $_SESSION['username']; //...pobierz zmienne sesyjne
	echo "<div id=logout><br/>";
	echo "<p class = witaj>Witaj</p><span class = witaj id = username>".$username."</span><br/>";
	echo"<a class = button href='zmien_haslo.php'>Zmień hasło</a><br/>";
	echo"<a class = button href='?wyloguj=yes'>Wyloguj</a>";
	echo "</div>";
	//echo "<h2 style='text-align: center; margin-top: 10px;'>Panel pracownika</h2>";
	switch ($level) { //pobiera level i przypisuje zmiennej $usertype nazwę uprawnienia...
	case 1:
		$usertype = "przedstawiciela";
		break;
	case 2:
		$usertype = "recepcjonisty";
		break;
	case 3:
		$usertype = "promotora";
		break;
	case 4:
		$usertype = "księgowego";
		break;
	case 5:
		$usertype = "właściciela";
		break;
	case 6:
		$usertype = "administratora";
		break;
	}
	echo "<h2 style='text-align: center; margin-top: 10px;'>Panel ".$usertype."</h2>"; //... a potem wyświetla komuikat ze zmienną $usertype
	$connect=@mysql_connect ($db_host, $db_user, $db_pass) or die ('Nie udało się. Błąd:' .mysql_error()); //połącz się z bazą a w razie nieudanej próby wyświetl błąd
	mysql_select_db($db_name); // ...wybierz bazę
	$pokaz = "SELECT * FROM dzialy WHERE LEV_DOSTEPU = $level ORDER BY DZIAL ASC "; //pobiera nazwy działów z bazy wg leveli z bazy
	$results=mysql_query($pokaz) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error()); //zatwierdź komendę mysql
	$nowe_zamowienia = "SELECT * FROM zamowienia"; //pobiera nazwy działów z bazy wg leveli z bazy
	$ilosc=mysql_query($nowe_zamowienia) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error()); //zatwierdź komendę mysql
	$ilosc_zamowien = @mysql_num_rows($ilosc);
	echo "<table class = navbar-administrator><tr >";
	while ($row1 = mysql_fetch_row($results)) {
		$adres = $row1[1];
		$link = $row1[2]; //przypisz zmienne
		if ($adres != 'wiadomosci.php')
		{
			echo "<td ><a class = navbar href='".$adres."'>".$link."</a></td>"; //wyświetla nazwy działów z bazy wg leveli z bazy
		}
		else
		{
			echo "<td><a class = navbar href='".$adres."'>".$link." (".$ilosc_zamowien.")</a></td>"; //wyświetla nazwy działów z bazy wg leveli z bazy
		}
	}
	echo "</tr></table>";
}
else
{
	echo "<div id=login style='margin-top: 100px;'><br/>";
	echo "<h2 style='text-align: center; margin-top: 10px;'>Nie zalogowany. Zaloguj się!</h2>";
	echo "</div>";
	header('Location: index.php');
}
?>
</div>
</div>
</body>
</html>