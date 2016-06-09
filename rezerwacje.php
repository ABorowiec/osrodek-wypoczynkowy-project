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
if(isset($_SESSION['zalogowany'])) // jeśli zalogowany
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username']; // przypisz zmienne
	if ($level == 6 || $level == 5 || $level == 4 ||  $level == 3 || $level == 2 ) // sprawdź uprawnienia
	{
		if (isset($_POST['wyswietl'])) // jeśli kliknięto przycisk wyświetl
		{
			//podlaczenie do mysql i wybor danych
			if (isset($_POST['lista'])) // jeśli wybrano rezerwacje
			{
				//echo $_POST['lista'];
				$edytowane =  $_POST['lista']; // przypisz zmienną
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				//Tabela1 AS alias JOIN tabela2 AS alias ON warunki
				$wybrany_rekord = mysql_query("SELECT * FROM rezerwacja JOIN domek ON rezerwacja.ID_Domek = domek.ID JOIN klient ON rezerwacja.ID_klient = klient.ID WHERE rezerwacja.ID = '$edytowane'"); // wybierz rekord do wyświetlenia
				$liczba_wierszy = @mysql_num_rows($wybrany_rekord); // przypisz zmiennej
				echo "<h1 style='
	font-size: xx-large;
' class=tablefont id=operacje >Wybrana rezerwacja:</h1>";
				if ($liczba_wierszy > 0) //jeśli istnieją jakieś rekordy
				{
					echo "<table class = tabledomki border=1><tr>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>ID</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Domek</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Klient</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Rodzaj płatności</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Kwota</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Ilość dni</b></td></tr>";
					while ($row = mysql_fetch_row($wybrany_rekord))
					{
						echo "<tr id = tabledatafont>
						<td class = tablepadding>". $row[0] ."</td>";
						echo "<td class = tablepadding>". $row[7] ."</td>";
						echo "<td class = tablepadding>". $row[12] ."". $row[13] ."</td>";
						echo "<td class = tablepadding>". $row[3] ."</td>";
						echo "<td class = tablepadding>". $row[4] ."</td>";
						echo "<td class = tablepadding>". $row[5] ."</td></tr>";
					}
					echo "</table>";
					echo "<a class = zalogujbutton id = wroc href='rezerwacje.php'>Wróć</a>";
					$lista = $wybrany_rekord;
				}
			}
			else{ //...a jeśli nie
				echo "<p class=usuwanie id=brakdanych>Wybierz rezerwację</p>  "; //wyświetl komunikat
				echo "<a class = zalogujbutton id = wroc href='rezerwacje.php'>Wróć</a>";
			}
		}
		elseif (isset($_POST['wyszukaj'])) //jeśli klinięto wyszukaj
		{
			$nazwa_szukanego_rekordu = $_POST['nazwa']; //przypisz zmienne
			if  ((empty($nazwa_szukanego_rekordu))) //jeśli pole nie zostało wypełnione
			{
				echo "<p class=usuwanie id=brakdanych>Nie wypełniono formularza</p>  "; //wyświetl komunikat
				echo "<a class = zalogujbutton id = wroc href='rezerwacje.php'>Wróć</a>";
				header( 'refresh: 5; url=rezerwacje.php' );
				$pagenum = 1;
			}
			else // ...a jeśli zostało
			{
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą
				mysql_select_db($db_name); //wybierz bazę
				// Else
				$wyszukane = mysql_query("SELECT * FROM rezerwacja JOIN domek ON rezerwacja.ID_Domek = domek.ID JOIN klient ON rezerwacja.ID_klient = klient.ID WHERE domek.Nazwa LIKE '%$nazwa_szukanego_rekordu%' ORDER BY Nazwa ASC");
				$liczba_wierszy = @mysql_num_rows($wyszukane); // policz liczbę pobranych wierszy z bazy
				echo "<br/>Znalezionych rekordów: ".$liczba_wierszy."<br/>"; // ...i wyświetl ich ilość
				$lista = $wyszukane;
				if ($liczba_wierszy > 0) // jeśli zwrócono jakieś wiersze za bazy
				{
					echo "<div style ='width: 400px; height: 100px; top: 50px; left: 15px; position: absolute; border: 1px; border-style: none; border-color: #000000; overflow-y: auto; overflow-x: hidden'>";
					echo "<table border=1><tr>";
					echo "<td><b>ID</b></td>";
					echo "<td><b>Domek</b></td>";
					echo "<td><b>Klient</b></td></tr>";
					while ($row = mysql_fetch_row($lista))
					{
						echo "<tr><td>". $row[0] ."</td>";
						echo "<td>". $row[7] ."</td>";
						echo "<td>". $row[12] ." ". $row[13] ."</td></tr>";
					}
					echo "</table>";
					echo "</div>";
					echo"<br/><br/>";
					echo"<br/><br/>";
				}
				else // a jeśli nie zwrócono zadnych wierszy z bazy
				{
					echo "<p class=usuwanie id=brakdanych>Brak danych w bazie</p>  ";
				}
				echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
			}
		}
		elseif ((!isset($_POST['dodaj'])) and (!isset($_POST['usun'])) and (!isset($_POST['edytuj'])))
		{
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$wszystkie = mysql_query("SELECT * FROM rezerwacja JOIN domek ON rezerwacja.ID_Domek = domek.ID JOIN klient ON rezerwacja.ID_klient = klient.ID ORDER BY domek.Nazwa ASC");
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
			$data = "SELECT * FROM rezerwacja JOIN domek ON rezerwacja.ID_Domek = domek.ID JOIN klient ON rezerwacja.ID_klient = klient.ID ORDER BY domek.Nazwa ASC LIMIT $na_stronie OFFSET $offset";
			$lista = mysql_query($data);
			$liczba_wierszy = @mysql_num_rows($lista);
			//echo $liczba_wierszy;
			//koniec pejdżowania
			if ($liczba_wierszy > 0)
			{
				echo "<table border=1><tr>";
				//echo "<td><b>Nazwa</b></td>";
				echo "<td><b>ID</b></td>";
				echo "<td><b>Domek</b></td></tr>";
				while ($row = mysql_fetch_row($lista))
				{
					echo "<tr><td>". $row[0] ."</td>";
					//echo "<td>". $row[1] ."</td>";
					echo "<td>". $row[7] ."</td></tr>";
				}
				echo "</table>";
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
				echo "<p class=usuwanie id=brakdanych>Brak danych do wyświetlenia</p>  ";
			}
		}
		//  
		// formularz wyszukaj
		if (!isset($_POST['wyswietl']) and (!isset($_POST['dodaj'])) and (!isset($_POST['usun'])) and (!isset($_POST['edytuj'])) and (empty($lista))) // jeśli nie wypełniono żadnego formularza
		{
			echo"<form method='post' action=''>";	
			echo"<input style='
	margin-left: 477px;
	margin-top: 0px;
' class=zalogujbutton id= dodajdomek type='submit' name='dodaj' value='Dodaj' />";
			echo"</form>";
		}
		@mysql_data_seek($lista, 0); // powrót na początek listy
		If (!empty($lista)) //jeśli zmienna $lista nie jest pusta
		{
			echo "<h2>Wyszukaj: </h2><";
			echo "<form method='post' action=''>";
			echo "Nazwa: <input type='text' name='nazwa' size='20' placeholder='Wpisz szukane słowo...' /> ";
			echo "<input type='submit' name='wyszukaj' value='Wyszukaj' />";
			echo "</form>";
			echo"<form method='post' action=''>";
			echo"<SELECT name='lista'>";
			echo"<option selected disabled>Wybierz rezerwacje</option>";
			while ($row2 = mysql_fetch_row($lista))
			{
				echo "<option value='". $row2[0] ."'>". $row2[0] ."</option>";
			}
			echo"</SELECT>";
			echo"<input type='submit' name='dodaj' value='Dodaj' />";
			echo"<input type='submit' name='wyswietl' value='Wyświetl' />";
			echo"<input type='submit' name='edytuj' value='Edytuj' />";
			echo"<input type='submit' name='usun' value='Usuń' />";
			echo"</form>";
		}
		//[0] - ID rezerwacji, [1] - ID klient, [2] - ID domek, [3] - rodzaj płatności [4] - kwota, [5] - ilość dni, [6] - ID, [7] - Nazwa, [8] - Opis, [9] - Rezerwacja, [10] - Cena, [11] - ID, [12] - Imię, [13] - Nazwisko, [14] - ID Adres, [15] - Miasto, [16] - Telefon, [17] - PESEL
		if (isset($_POST['dodaj'])) // jeśli klinieto 'dodaj'
		{
			echo "<h1 class=tablefont id=dodajdobazy>Dodaj do bazy</h1>";
			echo "<form method='post' action='zatwierdz.php'>";
			echo "<div>
			<p class=domkinazwaokienko id= fontloginhaslo>Nazwa:</p><input class=okienko id=domkiokienko type='text' name='nazwa' size='15' /> </div>";
			echo "<div style='margin-top: 15px' >
			<p style='text-align: center; margin-left: -104px;' class=domkinazwaokienko id= fontloginhaslo>Klient:</p><input class=okienko id=domkiokienko type='text' name='klient' size='15' /> </div>";
			echo "<div style='margin-top: 15px'><p style = '    margin-left: -184px;     padding-left: 101px' class=domkinazwaokienko id= fontloginhaslo>Domek:</p><input class=okienko id=domkiokienko type='text' name='domek' size='15' /> </div>";
			echo "<div style='margin-top: 15px'><p style = '    margin-left: -175px; margin-right: -70px;' class=domkinazwaokienko id= fontloginhaslo>Rodzaj płatności:</p><input class=okienko id=domkiokienko type='text' name='rodzaj_platnosci' size='15' /> </div>";
			echo "<div style='margin-top: 15px'><p style = '    margin-left: 0px' class=domkinazwaokienko id= fontloginhaslo>Kwota:</p><input class=okienko id=domkiokienko type='text' name='kwota' size='15' /> </div>";
			echo "<div style='margin-top: 15px'><p style = '    margin-left: -110px' class=domkinazwaokienko id= fontloginhaslo>Ilość dni:</p><input class=okienko id=domkiokienko type='text' name='ilosc_dni' size='15' /> </div>";
			echo "<input class = zalogujbutton id = dodajdomek  type='submit' name='dodaj' value='Dodaj rezerwacje' />";
			echo "</form>";
			echo "<a class = zalogujbutton id = wroc href='rezerwacje.php'>Wróć</a>";
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
				$edytowany_rekord = mysql_query("SELECT * FROM rezerwacja JOIN domek ON rezerwacja.ID_Domek = domek.ID JOIN klient ON rezerwacja.ID_klient = klient.ID WHERE rezerwacja.ID = '$edytowane'");
				echo "<h1>Edytuj rezerwacje</h1>";
				if ($row = mysql_fetch_row($edytowany_rekord))
				{
					echo "<form method='post' action='zatwierdz.php'>";
					echo "ID: <input type='text' name='id' value='". $row[0] ."' size='15' /> <br/><br/>";
					echo "Klient: <input type='text' name='klient' value='". $row[12] ." ". $row[13] ."' size='15' readonly/> <br/><br/>";
					echo "Domek: <input type='text' name='domek' value='". $row[7] ."' size='15' /> <br/><br/>";
					echo "Rodzaj platnosci: <input type='text' name='rodzaj_platnosci' value='". $row[3] ."' size='15' /> <br/><br/>";
					echo "Kwota: <input type='text' name='kwota' value='". $row[4] ."' size='15' /> <br/><br/>";
					echo "Ilosc dni: <input type='text' name='ilosc_dni' value='". $row[5] ."' size='15' /> <br/><br/>";
					// to ma być we warunku echo"<input type='hidden' name='stare_id' value ='".$row[0]."' />";
					// echo"<input type='hidden' name='stary_klient' value ='".$row[1]."' />";
					// echo"<input type='hidden' name='stary_domek' value ='".$row[2]."' />";
					// echo"<input type='hidden' name='stary_rodzaj' value ='".$row[3]."' />";
					// echo"<input type='hidden' name='stara_kwota' value ='".$row[4]."' />";
					// echo"<input type='hidden' name='stara_ilosc' value ='".$row[5]."' />";
					echo "<input class = zalogujbutton id = dodajdomek  type='submit' name='edytuj' value='Edytuj rezerwacje' />";
					echo "</form>";
					echo "<a class = zalogujbutton id = wroc href='rezerwacje.php'>Wróć</a>";
					$lista = $edytowany_rekord;
				}
			}
			else{ //jeśli nie wybrano rekordu w formularzu
				echo "<p class=usuwanie id=brakdanych>Wybierz rezerwację</p>  ";
				echo "<a class = zalogujbutton id = wroc href='rezerwacje.php'>Wróć</a>";
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
				$usuwany_rekord = mysql_query("SELECT * FROM rezerwacja JOIN domek ON rezerwacja.ID_Domek = domek.ID JOIN klient ON rezerwacja.ID_klient = klient.ID WHERE rezerwacja.ID = '$usuwane'");
				echo "<h1>Usunąć rezerwacje z bazy?</h1>";
				if ($row = mysql_fetch_row($usuwany_rekord)) // jeśli wybrano rekord
				{
					echo "ID: " .$row[0] ."<br>";
					echo "Klient: " . $row[12] ." ". $row[13] ."<br>";
					echo "Domek: " .$row[7] ."<br>";
					echo "Rodzaj platnosci: " .$row[3] ."<br>";
					echo "Kwota: " .$row[4] ."<br>";
					echo "Ilosc dni: " .$row[5] ."<br>";
					echo "<form method='post' action='zatwierdz.php'>";
					echo "<input type='hidden' name='id' value='". $row[0] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='Id_domek' value='". $row[2] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='id_klient' value='". $row[1] ."' size='15' /> <br/><br/>";
					// to ma być we warunku echo "<input type='hidden' name='nazwa_domku' value='". $row[3] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='rodzaj_platnosci' value='". $row[3] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='kwota' value='". $row[4] ."' size='15' /> <br/><br/>";
					echo "<input type='hidden' name='ilosc_dni' value='". $row[5] ."' size='15' /> <br/><br/>";
					echo "<input class = zalogujbutton id = dodajdomek  type='submit' name='usun' value='Usuń rezerwacje' />";
					echo "</form>";
					echo "<a class = zalogujbutton id = wroc href='rezerwacje.php'>Wróć</a>";
					$lista = $usuwany_rekord;
				}
			}
			else{ // ...eśli nie wybrano rekordu
				echo "<p class=usuwanie id=brakdanych>Wybierz rezerwację</p>  ";
				echo "<a class = zalogujbutton id = wroc href='rezerwacje.php'>Wróć</a>";
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
<center><a class=footerbutton id =domkifooter  href='domki_panel_glowny.php'>Powrót na stronę główną</a></center>
</div>
</div>
</body>
</html>