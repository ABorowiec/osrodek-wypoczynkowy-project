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
<div id=site>
<div id=mainsite>
<?php
if(isset($_SESSION['zalogowany'])) // jeśli zalogowany
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username']; // przypisz zmienne
	if ($level == 6 || $level == 5 || $level == 1 ) // sprawdź uprawnienia
	{
		if (isset($_POST['wyswietl'])) // jeśli kliknięto przycisk wyświetl
		{
			//podlaczenie do mysql i wybor danych
			if (isset($_POST['lista'])) // jeśli wybrano kontrakt
			{
				//echo $_POST['lista'];
				$edytowane =  $_POST['lista']; // przypisz zmienną
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				$wybrany_rekord = mysql_query("SELECT * FROM kontrakt WHERE Nazwa = '$edytowane'"); // wybierz rekord do wyświetlenia
				$liczba_wierszy = @mysql_num_rows($wybrany_rekord); // przypisz zmiennej
				echo "<h1>Wybrany kontrakt</h1>";
				if ($liczba_wierszy > 0) //jeśli istnieją jakieś rekordy
				{
					echo "<table border=1><tr>";
					echo "<td><b>Nazwa</b></td>";
					echo "<td><b>Opis</b></td>";
					echo "<td><b>Firma</b></td></tr>";
					while ($row = mysql_fetch_row($wybrany_rekord))
					{
						echo "<tr><td>". $row[1] ."</td>";
						echo "<td>". $row[2] ."</td>";
						echo "<td>". $row[3] ."</td></tr>";
					}
					echo "</table>";
					echo"<br/><br/>";
					echo"<br/><br/>";
					echo "<a href='kontrakty.php'>Wróć</a>";
					$lista = $wybrany_rekord;
				}
			}
			else{ //...a jeśli nie
				echo "Wybierz kontrakt  "; //wyświetl komunikat
				echo"<br/><br/>";
				echo"<br/><br/>";
				echo "<a href='kontrakty.php'>Wróć</a>";
			}
		}
		elseif (isset($_POST['wyszukaj'])) //jeśli klinięto wyszukaj
		{
			$nazwa_szukanego_rekordu = $_POST['nazwa']; //przypisz zmienne
			if  ((empty($nazwa_szukanego_rekordu))) //jeśli pole nie zostało wypełnione
			{
				echo "Nie wypełniono pola wyszukiwania...<br/>";
				echo "<a href='kontrakty.php'>Wróć</a>";
				header( 'refresh: 5; url=kontrakty.php' );
				$pagenum = 1;
			}
			else // ...a jeśli zostało
			{
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą
				mysql_select_db($db_name); //wybierz bazę
				// Else
				$wyszukane = mysql_query("SELECT * FROM kontrakt WHERE Nazwa LIKE '%$nazwa_szukanego_rekordu%' ORDER BY Nazwa ASC");
				$liczba_wierszy = @mysql_num_rows($wyszukane); // policz liczbę pobranych wierszy z bazy
				echo "<br/>Znalezionych rekordów: ".$liczba_wierszy."<br/>"; // ...i wyświetl ich ilość
				$lista = $wyszukane;
				echo"<br/><br/>";
				echo"<br/><br/>";
				if ($liczba_wierszy > 0) // jeśli zwrócono jakieś wiersze za bazy
				{
					echo "<div style ='width: 400px; height: 100px; top: 50px; left: 15px; position: absolute; border: 1px; border-style: none; border-color: #000000; overflow-y: auto; overflow-x: hidden'>";
					echo "<table border=1><tr>";
					echo "<td><b>Nazwa</b></td>";
					echo "<td><b>Opis</b></td>";
					echo "<td><b>Firma</b></td></tr>";
					while ($row = mysql_fetch_row($lista))
					{
						echo "<tr><td>". $row[1] ."</td>";
						echo "<td>". $row[2] ."</td>";
						echo "<td>". $row[3] ."</td></tr>";
					}
					echo "</table>";
					echo "</div>";
					echo"<br/><br/>";
					echo"<br/><br/>";
				}
				else // a jeśli nie zwrócono zadnych wierszy z bazy
				{
					echo "Brak danych w bazie";
				}
				echo "<br><br><a href='kontrakty.php'>Wróć</a>";
			}
		}
		elseif ((!isset($_POST['dodaj'])) and (!isset($_POST['usun'])) and (!isset($_POST['edytuj'])))
		{
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$wszystkie = mysql_query("SELECT * FROM kontrakt ORDER BY Nazwa ASC");
			//pejdżowanie
			$ilosc = mysql_num_rows($wszystkie);
			$na_stronie = 5;
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
			$data = "SELECT Nazwa FROM kontrakt ORDER BY Nazwa ASC LIMIT $na_stronie OFFSET $offset";
			$lista = mysql_query($data);
			$liczba_wierszy = @mysql_num_rows($lista);
			//echo $liczba_wierszy;
			//koniec pejdżowania
			if ($liczba_wierszy > 0)
			{
				echo "<table border=1><tr>";
				echo "<td><b>Nazwa</b></td></tr>";
				while ($row = mysql_fetch_row($lista))
				{
					echo "<tr><td>". $row[0] ."</td></tr>";
				}
				echo "</table>";
				echo"<br/><br/>";
				echo"<br/><br/>";
				if ($ilosc > 5)
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
						//echo" ";
						//echo"<a href='?pagenum=$ostatnia_strona'>Ostatnia strona</a>";
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
				// 
			}
			else{
				echo "Brak danych do wyświetlenia";
			}
		}
		//  
		echo"<br/><br/>";
		echo"<br/><br/>";
		// formularz wyszukaj
		if (!isset($_POST['wyswietl']) and (!isset($_POST['dodaj'])) and (!isset($_POST['usun'])) and (!isset($_POST['edytuj'])) and (empty($lista))) // jeśli nie wypełniono żadnego formularza
		{
			echo"<form method='post' action=''>";	
			echo"<input type='submit' name='dodaj' value='Dodaj' />";
			echo"</form>";
		}
		echo"<br/><br/>";
		echo"<br/><br/>";
		@mysql_data_seek($lista, 0); // powrót na początek listy
		If (!empty($lista)) //jeśli zmienna $lista nie jest pusta
		{
			echo "<h2>Wyszukaj: </h2><br />";
			echo "<form method='post' action=''>";
			echo "Nazwa: <input type='text' name='nazwa' size='20' placeholder='Wpisz szukane słowo...' /> <br/>";
			echo "<input type='submit' name='wyszukaj' value='Wyszukaj' /><br/>";
			echo "</form>";
			echo"<form method='post' action=''>";
			echo"<SELECT name='lista'>";
			echo"<option selected disabled>Wybierz kontrakt</option>";
			while ($row2 = mysql_fetch_row($lista))
			{
				echo "<option value='". $row2[1] ."'>". $row2[1] ."</option>";
			}
			echo"</SELECT>";
			echo"<input type='submit' name='dodaj' value='Dodaj' />";
			echo"<input type='submit' name='wyswietl' value='Wyświetl' />";
			echo"<input type='submit' name='edytuj' value='Edytuj' />";
			echo"<input type='submit' name='usun' value='Usuń' />";
			echo"</form>";
		}
		if (isset($_POST['dodaj'])) // jeśli klinieto 'dodaj'
		{
			echo "<h1>Dodaj do bazy</h1>";
			echo "<form method='post' action='zatwierdz.php'>";
			echo "Nazwa: <input type='text' name='nazwa' size='15' /> <br/><br/>";
			echo "Opis: <input type='text' name='opis' size='15' /> <br/><br/>";
			echo "Firma: <input type='text' name='firma' size='15' /> <br/><br/>";
			echo "<input type='submit' name='dodaj' value='Dodaj kontrakt' />";
			echo "</form>";
			echo "<a href='kontrakty.php'>Wróć</a>";
			//$lista = $wybrany_rekord;
		}
		if (isset($_POST['edytuj'])) // jeśli kliknięto 'edytuj'
		{
			if (isset($_POST['lista'])) // jeśli wybrano rekord z formularza
			{
				//echo $_POST['lista'];
				$edytowane =  $_POST['lista']; // przypisz zmienną
				//podlaczenie do mysql i wybor danych
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				mysql_select_db($db_name);
				$edytowany_rekord = mysql_query("SELECT * FROM kontrakt WHERE Nazwa = '$edytowane'");
				echo "<h1>Edytuj kontrakt</h1>";
				if ($row = mysql_fetch_row($edytowany_rekord))
				{
					echo "<form method='post' action='zatwierdz.php'>";
					echo "Nazwa: <input type='text' name='nazwa' value='". $row[1] ."' size='15' /> <br/><br/>";
					echo "Opis: <input type='text' name='opis' value='". $row[2] ."' size='15' /> <br/><br/>";
					echo "Firma: <input type='text' name='firma' value='". $row[3] ."' size='15' /> <br/><br/>";
					echo"<input type='hidden' name='stara_nazwa' value ='".$row[1]."' />";
					echo"<input type='hidden' name='stary_opis' value ='".$row[2]."' />";
					echo"<input type='hidden' name='stara_firma' value ='".$row[3]."' />";
					echo "<input type='submit' name='edytuj' value='Edytuj kontrakt' />";
					echo "</form>";
					echo "<a href='kontrakty.php'>Wróć</a>";
					$lista = $edytowany_rekord;
				}
			}
			else{ //jeśli nie wybrano rekordu w formularzu
				echo "Wybierz kontrakt  ";
				echo "</br></br></br><a href='kontrakty.php'>Wróć</a>";
			}
		}
		if (isset($_POST['usun'])) // jeśli kliknięto 'edytuj'
		{
			if (isset($_POST['lista'])) // jeśli wybrano rekord z formularza
			{
				//echo $_POST['lista'];
				$usuwane =  $_POST['lista']; // przypisz zmienną
				//podlaczenie do mysql i wybor danych
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				mysql_select_db($db_name);
				$usuwany_rekord = mysql_query("SELECT * FROM kontrakt WHERE Nazwa = '$usuwane'");
				echo "<h1>Usunąć kontrakt z bazy?</h1>";
				if ($row = mysql_fetch_row($usuwany_rekord)) // jeśli wybrano rekord
				{
					echo "Nazwa: " .$row[1] ."<br>";
					echo "Opis: " .$row[2] ."<br>";
					echo "Firma: " .$row[3] ."<br>";
					echo "<form method='post' action='zatwierdz.php'>";
					echo "<input type='hidden' name='id' value='". $row[0] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='nazwa' value='". $row[1] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='opis' value='". $row[2] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='firma' value='". $row[3] ."' size='15' /> <br/><br/>";
					echo "<input type='submit' name='usun' value='Usuń kontrakt' />";
					echo "</form>";
					echo "<a href='kontrakty.php'>Wróć</a>";
					$lista = $usuwany_rekord;
				}
			}
			else{ // ...eśli nie wybrano rekordu
				echo "Wybierz kontrakt  ";
				echo "<br/></br></br><a href='kontrakty.php'>Wróć</a>";
			}
		}
	}
	else	//jeśli uzytkownik nie ma uprawnień do wyswietlenia strony
	{
		echo "<b>Nieodpowiednie uprawnienia. Zostaniesz przekierowany w ciągu 5 sekund...</b>";
		header('Refresh: 5; url=domki_panel_glowny.php'); //przekieruj po 5 sek.
	}
}
else
{
	echo "<div id=login style='margin-top: 100px; width: 350px; text-align: center; position: absolute; margin-left: 225px; border-style: none;'><br/>";
	echo "<h2 style='text-align: center; margin-top: 10px;'>Niezalogowany. Zaloguj się!</h2>";
	echo "</div>";
	header('Refresh: 5; url=index.php');
}
?>
</div>
<div id=footer>
<center><a href='domki_panel_glowny.php'>Powrót na stronę główną</a></center>
</div>
</div>
</body>
</html>