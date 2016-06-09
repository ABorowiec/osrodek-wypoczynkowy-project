<?php
session_start();
require_once('config.php');
?>
<html>
<head>
<META NAME="robots" CONTENT="noindex, nofollow">
<link rel="shortcut icon" href="dane\favicon.ico">
<link rel="Stylesheet" type="text/css" href="dane\style.css" />
</head>
<body>
<div class=sitedomki>
<div id=mainsite>
<?php
if(isset($_SESSION['zalogowany']))
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username'];
	if ($level == 2 or $level == 5 or $level == 6)
	{
		if (isset($_POST['zaakceptuj'])) // jeśli kliknięto przycisk zaakceptuj
		{
			if (isset($_POST['lista'])) // jeśli wybrano domek
			{
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				$message = "Zatwierdzono wybrane zamowienia: ";
				echo $message;
				echo "<table border = 1>";
				echo "<tr><td>Wybrany domek</td>";
				echo "<td>Imię</td>";
				echo "<td>Nazwisko</td>";
				echo "<td>Telefon</td>";
				echo "<td>Ilość dni</td></tr>";
				foreach($_POST['lista'] as $wybrane_do_akceptacji)
				{
					$data = "SELECT zamowienia.*, domek.Nazwa FROM zamowienia, domek WHERE zamowienia.ID = $wybrane_do_akceptacji AND zamowienia.ID_Domek = domek.ID ORDER BY zamowienia.ID ASC";
					$results=mysql_query($data) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
					while ($row =  mysql_fetch_row($results))
					{
						$wybrany_domek =  $row[6]; // przypisz zmienne
						$id_zamowienia =  $row[0];
						$imie =  $row[2];
						$nazwisko =  $row[3];
						$tel =  $row[4];
						$uwagi =  $row[5];
						$sql="CALL Nowa_rezerwacja('$wybrany_domek', '$imie', '$nazwisko', $tel, $uwagi, $id_zamowienia)";
						$results2=mysql_query($sql) or die ('Wykonanie proc nie powodło sie. Błąd:' .mysql_error());
						echo "<tr><td>". $row[6] ."</td>";
						echo "<td>". $row[2] ."</td>";
						echo "<td>". $row[3] ."</td>";
						echo "<td>". $row[4] ."</td>";
						echo "<td>". $row[5] ."</td>";
						echo "</tr>";
					}
					echo "<br/><br/>";
				}
				echo "</table>";
			}
			else //...a jeśli nie
			{ 
				$message = "Wybierz zamówienie"; //wyświetl komunikat
			}
		}
		elseif (isset($_POST['usun'])) // jeśli kliknięto przycisk usuń
		{
			if (isset($_POST['lista'])) // jeśli wybrano domek
			{
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				foreach($_POST['lista'] as $wybrane_do_usuniecia)
				{
					$sql="DELETE from zamowienia WHERE ID = $wybrane_do_usuniecia";
					$results3=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
					$message ="Usunięto wybrane zamówienia.";
					echo $message;
				}
			}
			else //...a jeśli nie
			{ 
				$message = "Wybierz zamówienie"; //wyświetl komunikat
			}
		}
		$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
		mysql_select_db($db_name);
		$zamowienia = mysql_query("SELECT * FROM zamowienia ORDER BY ID ASC");
		//pejdżowanie
		$ilosc = mysql_num_rows($zamowienia);
		$na_stronie = 10;
		$ostatnia_strona = ceil($ilosc/$na_stronie);
		if ((!isset($_GET['pagenum'])))// and (!isset($_GET['search']))) // Jesli nie zadeklarowano zmiennej search
		{
			$pagenum = 1;
		}
		elseif ((isset($_GET['pagenum'])))// and (!isset($_GET['search'])))
		{
			$pagenum = $_GET['pagenum'];
		}
		if ($pagenum < 1)
		{
			$pagenum = 1;
		}
		elseif ($pagenum > $ostatnia_strona)
		{
			$pagenum = $ostatnia_strona;
		}
		$offset = ($pagenum -1) * $na_stronie;
		$data = "SELECT zamowienia.*, domek.Nazwa FROM zamowienia, domek WHERE zamowienia.ID_Domek = domek.ID ORDER BY zamowienia.ID ASC LIMIT $na_stronie OFFSET $offset";
		$lista = mysql_query($data);
		$liczba_wierszy = @mysql_num_rows($lista);
		//echo $liczba_wierszy;
		//koniec pejdżowania
		if ($liczba_wierszy > 0)
		{
			echo"<form method='post' action=''>";
			echo "<table border=1><tr>";
			echo "<td><b>Nr zam</b></td>";
			echo "<td><b>Domek</b></td>";
			echo "<td><b>Imię klienta</b></td>";
			echo "<td><b>Nawisko klienta</b></td>";
			echo "<td><b>Numer tel</b></td>";
			echo "<td><b>Okres</b></td>";
			echo "<td><b>Zatwierdź</b></td></tr>";
			while ($row =  mysql_fetch_row($lista))
			{
				echo "<tr><td>". $row[0] ."</td>";
				echo "<td>". $row[6] ."</td>";
				echo "<td>". $row[2] ."</td>";
				echo "<td>". $row[3] ."</td>";
				echo "<td>". $row[4] ."</td>";
				echo "<td>". $row[5] ."</td>";
				echo "<td>"; 
				echo "<input type='checkbox' name='lista[]' value='".$row[0]."'>";
				echo "</td></tr>";
			}
			echo "</table>";
			echo"<br/><br/>";
			echo"<input type='submit' name='zaakceptuj' value='Zaakceptuj' />";
			echo"<input type='submit' name='usun' value='Usuń' />";
			echo"<br/><br/>";
			echo"<br/><br/>";
			if ($ilosc > 10)
			{
				echo "Strona ".$pagenum." z ".$ostatnia_strona." ";
				if ($pagenum == $ostatnia_strona) //jesli strona jest ostatnia
				{
					echo" ";
					echo"<a href='?pagenum=1'>Pierwsza strona</a>";
				}
				else // jesli strona nie jest ostatnia
				{
					$next = $pagenum + 1;
					echo" ";
					echo"<a href='?pagenum=$next'>Następna strona</a>";
				}
				if ($pagenum == 1) //jesli strona jest pierwsza
				{
					echo" ";
					echo"<a href='?pagenum=$ostatnia_strona'>Ostatnia strona</a>";
				}
				else // jesli strona nie jest pierwsza
				{
					//echo"<a href='?pagenum=1'>Pierwsza strona</a>";
					echo" ";
					$previous = $pagenum - 1;
					echo"<a href='?pagenum=$previous'>Poprzednia strona</a>";
				}
			}
		}
		else{
			echo "<p class=usuwanie id=brakdanych>Brak nowych zamówień do wyświetlenia</p>";
		}
	}
	else
	{
		echo "<b>Nieodpowiednie uprawnienia. Zostaniesz przekierowany w ciągu 5 sekund...</b>";
		header('Refresh: 5; url=domki_panel_glowny.php');
	}
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
<div id=footer>
<center><a class=footerbutton id =domkifooter  href='domki_panel_glowny.php'>Powrót na stronę główną</a></center>
</div>
</div>
</body>
</html>