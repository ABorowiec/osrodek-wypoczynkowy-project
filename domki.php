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
	if ($level == 6 || $level == 5 || $level == 4 || $level == 2 ) // sprawdź uprawnienia
	{
		if (isset($_POST['wyswietl'])) // jeśli kliknięto przycisk wyświetl
		{
			//podlaczenie do mysql i wybor danych
			if (isset($_POST['lista'])) // jeśli wybrano domek
			{
				//echo $_POST['lista'];
				$edytowane =  $_POST['lista']; // przypisz zmienną
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				$wybrany_rekord = mysql_query("SELECT * FROM domek WHERE Nazwa = '$edytowane'"); // wybierz rekord do wyświetlenia
				$liczba_wierszy = @mysql_num_rows($wybrany_rekord); // przypisz zmiennej
				echo "<h1>Wybrany domek:</h1>";
				if ($liczba_wierszy > 0) //jeśli istnieją jakieś rekordy
				{
					echo "<table border=1><tr>";
					echo "<td><b>Nazwa</b></td>";
					echo "<td><b>Opis</b></td>";
					echo "<td><b>Cena</b></td>";
					echo "<td><b>Zarezerwowany</b></td></tr>";
					while ($row = mysql_fetch_row($wybrany_rekord))
					{
						echo "<tr><td>". $row[1] ."</td>";
						echo "<td>". $row[2] ."</td>";
						echo "<td>". $row[4] ."</td>";
						if ($row[3] == 0) //pobiera wartość rezerwacji i aamienia ją na wartość logiczną
						{ 
							$rezerwacja = "Nie";
						}	
						elseif ($row[3]	== 1)
						{
							$rezerwacja = "Tak";
						}
						echo "<td>". $rezerwacja ."</td></tr>";
					}
					echo "</table>";
					echo"<br/><br/>";
					echo"<br/><br/>";
					echo "<a href='domki.php'>Wróć</a>";
					$lista = $wybrany_rekord;
				}
			}
			else{ //...a jeśli nie
				echo "Wybierz domek  "; //wyświetl komunikat
				echo"<br/><br/>";
				echo"<br/><br/>";
				echo "<a href='domki.php'>Wróć</a>";
			}
		}
		elseif (isset($_POST['wyszukaj'])) //jeśli klinięto wyszukaj
		{
			$nazwa_szukanego_rekordu = $_POST['nazwa']; //przypisz zmienne
			if  ((empty($nazwa_szukanego_rekordu))) //jeśli pole nie zostało wypełnione
			{
				echo "Nie wypełniono pola wyszukiwania...<br/>";
				echo "<a href='domki.php'>Wróć</a>";
				header( 'refresh: 5; url=domki.php' );
				$pagenum = 1;
			}
			else // ...a jeśli zostało
			{
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą
				mysql_select_db($db_name); //wybierz bazę
				if (isset($_POST['opis'])) {
					// If Checkbox is selected
					$wyszukane = mysql_query("SELECT * FROM domek WHERE (Nazwa LIKE '%$nazwa_szukanego_rekordu%') OR (Opis LIKE '%$nazwa_szukanego_rekordu%') ORDER BY Nazwa ASC");
				} 
				else
				{
					// Else
					$wyszukane = mysql_query("SELECT * FROM domek WHERE Nazwa LIKE '%$nazwa_szukanego_rekordu%' ORDER BY Nazwa ASC");
				}
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
					echo "<td><b>Cena</b></td>";
					echo "<td><b>Zarezerwowany</b></td></tr>";
					while ($row = mysql_fetch_row($lista))
					{
						echo "<tr><td>". $row[1] ."</td>";
						echo "<td>". $row[2] ."</td>";
						echo "<td>". $row[4] ."</td>";
						if ($row[3] == 0) //pobiera wartość rezerwacji i aamienia ją na wartość logiczną
						{ 
							$rezerwacja = "Nie";
						}	
						elseif ($row[3]	== 1)
						{
							$rezerwacja = "Tak";
						}
						echo "<td>". $rezerwacja ."</td></tr>";
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
				echo "<br><br><a href='domki.php'>Wróć</a>";
			}
		}
		elseif ((!isset($_POST['dodaj'])) and (!isset($_POST['usun'])) and (!isset($_POST['edytuj'])))
		{
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$wszystkie = mysql_query("SELECT * FROM domek ORDER BY Nazwa ASC");
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
			$data = "SELECT * FROM domek ORDER BY Nazwa ASC LIMIT $na_stronie OFFSET $offset";
			$lista = mysql_query($data);
			$liczba_wierszy = @mysql_num_rows($lista);
			//echo $liczba_wierszy;
			//koniec pejdżowania
			if ($liczba_wierszy > 0)
			{
				echo "<table border=1><tr>";
				echo "<td><b>Nazwa</b></td>";
				//echo "<td><b>Opis</b></td>";
				//echo "<td><b>Cena</b></td>";
				//echo "<td><b>Zarezerwowany</b></td></tr>";
				while ($row = mysql_fetch_row($lista))
				{
					echo "<tr><td>". $row[1] ."</td>";
					//echo "<td>". $row[2] ."</td>";
					//echo "<td>". $row[4] ."</td>";
					// if ($row[3] == 0) //pobiera wartość rezerwacji i aamienia ją na wartość logiczną
					// { 
						// $rezerwacja = "Nie";
					// }	
					// elseif ($row[3]	== 1)
					// {
						// $rezerwacja = "Tak";
					// }
					//echo "<td>". $rezerwacja ."</td></tr>";
				}
				echo "</tr></table>";
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
			echo "<input type='checkbox' name='opis'/> Szukaj w opisach <br/><br/>";
			echo "<input type='submit' name='wyszukaj' value='Wyszukaj' /><br/>";
			echo "</form>";
			echo"<form method='post' action=''>";
			echo"<SELECT name='lista'>";
			echo"<option selected disabled>Wybierz domek</option>";
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
			echo "<form method='post' action='zatwierdz.php'>";  // formularz 'dodaj'
			echo "Nazwa: <input type='text' name='wartosci[]' size='15' /> <br/><br/>";		//wpisywane wartości do bazy
			echo "Opis: <input type='text' name='wartosci[]' size='15' /> <br/><br/>";
			echo "Cena: <input type='text' name='wartosci[]' size='15' /> <br/><br/>";
		
			
			//dodatkowe dane dla funkcji walidacja_wartosci
			
			echo "<input type='hidden' name='walidacja_tabela[]' value ='domek' />"; //nazwa tabeli albo tabel w bazie
			
			
			echo "<input type='hidden' name='walidacja_kolumna[]' value ='Nazwa' />";
			echo "<input type='hidden' name='walidacja_kolumna[]' value ='Opis' />";
			echo "<input type='hidden' name='walidacja_kolumna[]' value ='Cena' />";
			
			echo "<input type='hidden' name='walidacja_warunek[]' value ='Tu jest warunek walidacji' />"; //warunek where do funkcji walidacja
			echo "<input type='hidden' name='walidacja_warunek[]' value ='Tu jest 2 warunek walidacji' />";
		
			//dodatkowe dane dla funkcji baza

			echo "<input type='hidden' name='tabela[]' value ='domek' />"; //nazwa tabeli albo tabel w bazie
			
			echo "<input type='hidden' name='kolumna[]' value ='Nazwa' />"; //nazwy kolumn w bazie do których wpisujemu wartosci
			echo "<input type='hidden' name='kolumna[]' value ='Opis' />";
			echo "<input type='hidden' name='kolumna[]' value ='Cena' />";
			
			echo "<input type='hidden' name='warunek[]' value ='Tu jest warunek bazy' />"; //warunek where do funkcji baza
			echo "<input type='hidden' name='warunek[]' value ='Tu jest 2 warunek bazy' />";
				
			echo "<input type='hidden' name='strona_wroc' value ='domki.php' />";
			echo "<input type='hidden' name='komunikat' value ='Tu daj komunikat' />";
			echo "<input type='hidden' name='typ _komendy' value ='1' />";
			
			//echo "<input type='hidden' name=name='warunek[]' value ='Tu jest warunek' />";
			
			echo "<input type='submit' name='submit' value='Dodaj domek' />";
			echo "</form>";
			echo "<a href='domki.php'>Wróć</a>";
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
				$edytowany_rekord = mysql_query("SELECT * FROM domek WHERE Nazwa = '$edytowane'");
				echo "<h1>Edytuj domek</h1>";
				if ($row = mysql_fetch_row($edytowany_rekord))
				{
					echo "<form method='post' action='zatwierdz.php'>"; // formularz 'edytuj'
					echo "Nazwa: <input type='text' name='nazwa' value='". $row[1] ."' size='15' /> <br/><br/>";
					echo "Cena: <input type='text' name='cena' value='". $row[4] ."' size='15' /> <br/><br/>";
					echo "Opis: <input type='text' name='opis' value='". $row[2] ."' size='15' /> <br/><br/>";
					echo"<input type='hidden' name='stara_nazwa' value ='".$row[1]."' />";
					echo"<input type='hidden' name='stary_opis' value ='".$row[2]."' />";
					echo"<input type='hidden' name='stara_cena' value ='".$row[4]."' />";
					echo "<input type='submit' name='submit' value='Edytuj domek' />";
					echo "</form>";
					echo "<a href='domki.php'>Wróć</a>";
					$lista = $edytowany_rekord;
				}
			}
			else{ //jeśli nie wybrano rekordu w formularzu
				echo "Wybierz domek  ";
				echo "</br></br></br><a href='domki.php'>Wróć</a>";
			}
		}
		if (isset($_POST['usun'])) // jeśli kliknięto 'edytuj'
		{
			if (isset($_POST['lista'])) // jeśli wybrano rekord z formularza
			{
				//echo $_POST['lista'];
				$usuwane =  $_POST['lista']; // przypisz zmienną
				// pobierz z bazy nazwe ($usuwane) SELECT FROM BASE Nazwa, Opis WHERE Nazwa = '$usuwane' i przeslij te zmienne do formularza / <input type='text' name='nazwa' value "TU ZMIENNA USUWANA" size='15
				//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				//mysql_select_db($db_name);
				//podlaczenie do mysql i wybor danych
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				mysql_select_db($db_name);
				$usuwany_rekord = mysql_query("SELECT * FROM domek WHERE Nazwa = '$usuwane'");
				echo "<h1>Usunąć domek z bazy?</h1>";
				if ($row = mysql_fetch_row($usuwany_rekord)) // jeśli wybrano rekord
				{
					echo "Nazwa: " .$row[1] ."<br>";
					echo "Cena: " .$row[4] ."<br>";
					echo "Opis: ".$row[2] ."<br>";
					echo "<form method='post' action='zatwierdz.php'>"; // formularz 'usuń'
					echo "<input type='hidden' name='id' value='". $row[0] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='nazwa' value='". $row[1] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='opis' value='". $row[2] ."' size='15' /> <br/><br/>";
					echo "<input type='submit' name='submit' value='Usuń domek' />";
					echo "</form>";
					echo "<a href='domki.php'>Wróć</a>";
					$lista = $usuwany_rekord;
				}
			}
			else{ // ...eśli nie wybrano rekordu
				echo "Wybierz domek  ";
				echo "<br/></br></br><a href='domki.php'>Wróć</a>";
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