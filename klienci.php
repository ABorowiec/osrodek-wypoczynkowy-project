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
<div class=sitedomki >
<div id=mainsite>
<?php
if(isset($_SESSION['zalogowany'])) // jeśli zalogowany
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username']; // przypisz zmienne
	if ($level == 6 || $level == 5 || $level == 2 ) // sprawdź uprawnienia
	{
		if (isset($_POST['wyswietl'])) // jeśli kliknięto przycisk wyświetl
		{
			//podlaczenie do mysql i wybor danych
			if (isset($_POST['lista'])) // jeśli wybrano klienta
			{
				//echo $_POST['lista'];
				$edytowane =  $_POST['lista']; // przypisz zmienną
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				$wybrany_rekord = mysql_query("SELECT * FROM klient WHERE Telefon = '$edytowane'"); // wybierz rekord do wyświetlenia
				$liczba_wierszy = @mysql_num_rows($wybrany_rekord); // przypisz zmiennej
				echo "<h1 style='
	font-size: xx-large;
' class=tablefont id=operacje >Wybrany klient:</h1>";
				if ($liczba_wierszy > 0) //jeśli istnieją jakieś rekordy
				{
					echo "<table class = tabledomki border=1><tr>";
					echo "<td  class = tablepadding id=grey><b class = tablefont id=grey>Imie</b></td>";
					echo "<td  class = tablepadding id=grey><b class = tablefont id=grey>Nazwisko</b></td>";
					echo "<td  class = tablepadding id=grey><b class = tablefont id=grey>Adres</b></td>";
					echo "<td  class = tablepadding id=grey><b class = tablefont id=grey>Miasto</b></td>";
					echo "<td  class = tablepadding id=grey><b class = tablefont id=grey>Telefon</b></td>
					</tr>";
					while ($row = mysql_fetch_row($wybrany_rekord))
					{
						echo "<tr id = tabledatafont >
						<td class = tablepadding>>". $row[1] ."</td>";
						echo "<td class = tablepadding>". $row[2] ."</td>";
						echo "<td class = tablepadding>". $row[3] ."</td>";
						echo "<td class = tablepadding>". $row[4] ."</td>";
						echo "<td class = tablepadding>". $row[5] ."</td></tr>";
					}
					echo "</table>";
					echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";
					$lista = $wybrany_rekord;
				}
			}
			else{ //...a jeśli nie
				echo "<p class=usuwanie id=brakdanych>Wybierz klienta</p>  ";	
				echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";			
			}
		}
		elseif (isset($_POST['wyszukaj'])) //jeśli klinięto wyszukaj
		{
			$nazwa_szukanego_rekordu = $_POST['nazwa']; //przypisz zmienne
			if  ((empty($nazwa_szukanego_rekordu))) //jeśli pole nie zostało wypełnione
			{
				echo "<p class=usuwanie id=brakdanych>Nie wypełniono pola wyszukiwania</p> ";
				echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";
				header( 'refresh: 5; url=klienci.php' );
				$pagenum = 1;
			}
			else // ...a jeśli zostało
			{
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą
				mysql_select_db($db_name); //wybierz bazę
				// Else
				$wyszukane = mysql_query("SELECT * FROM klient WHERE Imie LIKE '%$nazwa_szukanego_rekordu%' ORDER BY Nazwa ASC");
				$liczba_wierszy = @mysql_num_rows($wyszukane); // policz liczbę pobranych wierszy z bazy
				echo "<p class=tablefont id = rekordy >Znalezionych rekordów: ".$liczba_wierszy."</p>"; // ...i wyświetl ich ilość
				$lista = $wyszukane;
				if ($liczba_wierszy > 0) // jeśli zwrócono jakieś wiersze za bazy
				{
					echo "<div style ='width: 400px; height: 100px; top: 50px; left: 15px; position: absolute; border: 1px; border-style: none; border-color: #000000; overflow-y: auto; overflow-x: hidden'>";
					echo "<table class = tabledomki border=1><tr>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Imie</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Nazwisko</b></td></tr>";
					while ($row = mysql_fetch_row($lista))
					{
						echo "<tr id = tabledatafont><td  class = tablepadding>". $row[1] ."</td>";
						echo "<td  class = tablepadding>". $row[2] ."</td></tr>";
					}
					echo "</table>";
					echo "</div>";
				}
				else // a jeśli nie zwrócono zadnych wierszy z bazy
				{
					echo "<p class=usuwanie id=brakdanych>Brak danych w bazie</p>  ";
				}
				echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";
			}
		}
		elseif ((!isset($_POST['dodaj'])) and (!isset($_POST['usun'])) and (!isset($_POST['edytuj'])))
		{
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$wszystkie = mysql_query("SELECT * FROM klient ORDER BY Imie ASC");
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
			$data = "SELECT * FROM klient ORDER BY Imie ASC LIMIT $na_stronie OFFSET $offset";
			$lista = mysql_query($data);
			$liczba_wierszy = @mysql_num_rows($lista);
			//echo $liczba_wierszy;
			//koniec pejdżowania
			if ($liczba_wierszy > 0)
			{
				echo "<table class = tabledomki  border=1><tr>";
				echo "<td class = tablepadding id=grey><b  class = tablefont id=grey>Imie</b></td>";
				echo "<td class = tablepadding id=grey><b  class = tablefont id=grey>Nazwisko</b></td>";
				while ($row = mysql_fetch_row($lista))
				{
					echo "<tr id = tabledatafont><td  class = tablepadding>". $row[1] ."</td>";
					echo "<td  class = tablepadding>". $row[2] ."</td></tr>";
				}
				echo "</table>";
				if ($ilosc > 5)
				{
					echo "<p class=pmargindomki id =tabledatafont >Strona ".$pagenum." z ".$ostatnia_strona."</p> ";
					if ($pagenum == $ostatnia_strona) //jesli strona jest ostatnia
					{
						echo" ";
						echo"<a  style='margin-left: 523px;' class=button id=buttondomki href='?pagenum=1'>Pierwsza strona</a>";
					}
					else // jesli strona nie jest ostatnia
					{
						$next = $pagenum + 1;
						echo" ";
						echo"<a  style= 'margin-left: 523px;' class=button  id=buttondomki  href='?pagenum=$next'>Następna strona</a>";
						//echo" ";
						//echo"<a href='?pagenum=$ostatnia_strona'>Ostatnia strona</a>";
					}
					if ($pagenum == 1) //jesli strona jest pierwsza
					{
						echo" ";
						echo"<a style='margin-left: -300px;' class=button id=buttondomki  href='?pagenum=$ostatnia_strona'>Ostatnia strona</a>";
					}
					else // jesli strona nie jest pierwsza
					{
						//echo"<a href='?pagenum=1'>Pierwsza strona</a>";
						echo" ";
						$previous = $pagenum - 1;
						echo"<a style='margin-left: -323px;' class=button id=buttondomki href='?pagenum=$previous'>Poprzednia strona</a>";
					}
				}
				// 
			}
			else{
				echo "Brak danych do wyświetlenia";
			}
		}
		//  
		// formularz wyszukaj
		if (!isset($_POST['wyswietl']) and (!isset($_POST['dodaj'])) and (!isset($_POST['usun'])) and (!isset($_POST['edytuj'])) and (empty($lista))) // jeśli nie wypełniono żadnego formularza
		{
			//echo"<form method='post' action=''>";	
			//echo"<input type='submit' name='dodaj' value='Dodaj' />";
			//echo"</form>";
		}
		@mysql_data_seek($lista, 0); // powrót na początek listy
		If (!empty($lista)) //jeśli zmienna $lista nie jest pusta
		{
			echo "<p class=tablefont id=wyszukajdomek >Wyszukaj klienta:</p>";
			echo "<form style='padding-bottom: 51px; border-bottom: 1px solid #dddddd;' method='post' action=''>";
			echo "<p class=domkinazwaokienko id = fontloginhaslo>Nazwa: </p><input class=okienko id=domkiokienko  type='text' name='nazwa' size='20' placeholder='Wpisz szukane słowo' />";
			echo "<input style='margin-right: 29px;' class = zalogujbutton id=wyszukajdomekbutton  type='submit' name='wyszukaj' value='Szukaj' />";
			echo "</form>";
			echo"<form style='
	margin-left: 276px;
	margin-right: auto;
	vertical-align: middle;
	margin-top: 47px;
' method='post' action=''>";
			echo"<SELECT class = okienko id = okienkodomkidol name='lista'>";
			echo"<option selected disabled>Wybierz klienta</option>";
			while ($row2 = mysql_fetch_row($lista))
			{
				echo "<option value='". $row2[1] ."'>". $row2[1] ."</option>";
			}
			echo"</SELECT>";
			echo"<input  class=zalogujbutton id = buttondomki type='submit' name='dodaj' value='Dodaj' />";
			echo"<input  class=zalogujbutton id = buttondomki type='submit' name='wyswietl' value='Wyświetl' />";
			echo"<input  class=zalogujbutton id = buttondomki type='submit' name='edytuj' value='Edytuj' />";
			echo"<input  class=zalogujbutton id = buttondomki type='submit' name='usun' value='Usuń' />";
			echo"</form>";
		}
		if (isset($_POST['dodaj'])) // jeśli klinieto 'dodaj'
		{
			echo "<h1 class=tablefont id=dodajdobazy>Dodaj do bazy</h1>";
			echo "<form method='post' action='zatwierdz.php'>";
			echo "<div>
			<p class=domkinazwaokienko id= fontloginhaslo >Imię:</p><input class=okienko id=domkiokienko type='text' name='imie' size='15' /> </div>";
			echo "<div style='margin-top: 15px' >
			<p style='text-align: center; margin-left: -122px;' class=domkinazwaokienko id= fontloginhaslo>Nazwisko:</p><input  class=okienko id=domkiokienko type='text' name='nazwisko' size='15' /> </div>";
			echo "<div style='margin-top: 15px'><p style = '    margin-left: -90px' class=domkinazwaokienko id= fontloginhaslo>Adres:</p><input class=okienko id=domkiokienko type='text' name='adres' size='15' /></div>";
			echo "<div style='margin-top: 15px'><p style = '    margin-left: -94px' class=domkinazwaokienko id= fontloginhaslo>Miasto:</p><input class=okienko id=domkiokienko type='text' name='miasto' size='15' /></div>";
			echo "<div style='margin-top: 15px'><p style = '    margin-left: -101px' class=domkinazwaokienko id= fontloginhaslo>Telefon:</p><input class=okienko id=domkiokienko type='text' name='telefon' size='15' /></div>";
			echo "<input class = zalogujbutton id = dodajdomek type='submit' name='submit' value='Dodaj klienta' />";
			echo "</form>";
			echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";
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
				$edytowany_rekord = mysql_query("SELECT * FROM klient WHERE Imie = '$edytowane'");
				echo "<h1 class=tablefont id=dodajdobazy >Edytuj klienta</h1>";
				if ($row = mysql_fetch_row($edytowany_rekord))
				{
					echo "<form method='post' action='zatwierdz.php'>";
					echo "<div>
			<p class=domkinazwaokienko id= fontloginhaslo >Imię:</p> <input class=okienko id=domkiokienko type='text' name='imie' value='". $row[1] ."' size='15' /> </div>";
					echo "<div style='margin-top: 15px' >
			<p style='text-align: center; margin-left: -122px;' class=domkinazwaokienko id= fontloginhaslo>Nazwisko:</p><input class=okienko id=domkiokienko type='text' name='nazwisko' value='". $row[2] ."' size='15' /> </div>";
					echo "<div style='margin-top: 15px'><p style = '    margin-left: -90px' class=domkinazwaokienko id= fontloginhaslo>Adres:</p><input  class=okienko id=domkiokienko type='text' name='adres' value='". $row[3] ."' size='15' /> </div>";
					echo "<div style='margin-top: 15px'><p style = '    margin-left: -94px' class=domkinazwaokienko id= fontloginhaslo>Miasto:</p><input class=okienko id=domkiokienko type='text' name='miasto' value='". $row[4] ."' size='15' /> </div>";
					echo "<div style='margin-top: 15px'><p style = '    margin-left: -101px' class=domkinazwaokienko id= fontloginhaslo>Telefon:</p><input class=okienko id=domkiokienko type='text' name='telefon' value='". $row[5] ."' size='15' /> </div>";
					echo"<input type='hidden' name='stare_imie' value ='".$row[1]."' />";
					echo"<input type='hidden' name='stare_nazwisko' value ='".$row[2]."' />";
					echo"<input type='hidden' name='stary_adres' value ='".$row[3]."' />";
					echo"<input type='hidden' name='stare_miasto' value ='".$row[4]."' />";
					echo"<input type='hidden' name='stary_telefon' value ='".$row[5]."' />";
					echo "<input class = zalogujbutton id = dodajdomek type='submit' name='edytuj' value='Edytuj klienta' />";
					echo "</form>";
					echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";
					$lista = $edytowany_rekord;
				}
			}
			else{ //jeśli nie wybrano rekordu w formularzu
				echo "<p class=usuwanie id=brakdanych>Wybierz klienta</p>  ";
				echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";
			}
		}
		if (isset($_POST['usun'])) // jeśli kliknięto 'usun'
		{
			if (isset($_POST['lista'])) // jeśli wybrano rekord z formularza
			{
				//echo $_POST['lista'];
				$usuwane =  $_POST['lista']; // przypisz zmienną
				//podlaczenie do mysql i wybor danych
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				mysql_select_db($db_name);
				$usuwany_rekord = mysql_query("SELECT * FROM klient WHERE Imie = '$usuwane'");
				echo "<h1 class=tablefont id=dodajdobazy >Usunąć klienta z bazy?</h1>";
				if ($row = mysql_fetch_row($usuwany_rekord)) // jeśli wybrano rekord
				{
					echo "<div ><p class=usuwanie id=wlasne>Imię:</p><p class=usuwanie>" .$row[1] ."</p></div>";
					echo "<div class=bottomborder></div>"; 
					echo "<div ><p class=usuwanie id=wlasne>Nazwisko:</p><p class=usuwanie>" .$row[2] ."</p></div>";
					echo "<div class=bottomborder></div>"; 
					echo "<div ><p class=usuwanie id=wlasne>Adres:</p><p class=usuwanie>" .$row[3] ."</p></div>";
					echo "<div class=bottomborder></div>"; 
					echo "<div ><p class=usuwanie id=wlasne>Miasto:</p><p class=usuwanie>" .$row[4] ."</p></div>";
					echo "<div class=bottomborder></div>"; 
					echo "<div ><p class=usuwanie id=wlasne>Telefon:</p><p class=usuwanie>" .$row[5] ."</p></div>";
					echo "<div class=bottomborder></div>"; 
					echo "<form method='post' action='zatwierdz.php'>";
					echo "<input type='hidden' name='id' value='". $row[0] ."' size='15' /> ";
					echo "<input type='hidden' name='imie' value='". $row[1] ."' size='15' /> ";
					echo "<input type='hidden' name='nazwisko' value='". $row[2] ."' size='15' /> ";
					echo "<input type='hidden' name='adres' value='". $row[3] ."' size='15' /> ";
					echo "<input type='hidden' name='miasto' value='". $row[4] ."' size='15' /> ";
					echo "<input type='hidden' name='telefon' value='". $row[5] ."' size='15' /> ";
					echo "<input style='margin-left: 440px;' class=zalogujbutton id= dodajdomek type='submit' name='usun' value='Usuń klienta' />";
					echo "</form>";
					echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";
					$lista = $usuwany_rekord;
				}
			}
			else{ // ...eśli nie wybrano rekordu
				echo "<p class=usuwanie id=brakdanych>Wybierz klienta</p>  ";
				echo "<a class = zalogujbutton id = wroc href='klienci.php'>Wróć</a>";
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
<center><a class=footerbutton id =domkifooter href='domki_panel_glowny.php'>Powrót na stronę główną</a></center>
</div>
</div>
</body>
</html>