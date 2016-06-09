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
<div  class=sitedomki >
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
				echo "<h1 style='
	font-size: xx-large;
' class=tablefont id=operacje >Wybrany domek:</h1>";
				if ($liczba_wierszy > 0) //jeśli istnieją jakieś rekordy
				{
					echo "<table class = tabledomki border=1><tr>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Nazwa</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Opis</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Cena</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Zarezerwowany</b></td></tr>";
					while ($row = mysql_fetch_row($wybrany_rekord))
					{
						echo "<tr id = tabledatafont>
						<td class = tablepadding>". $row[1] ."</td>";
						echo "<td class = tablepadding>". $row[2] ."</td>";
						echo "<td class = tablepadding>". $row[4] ."</td>";
						if ($row[3] == 0) //pobiera wartość rezerwacji i aamienia ją na wartość logiczną
						{
							$rezerwacja = "Nie";
						}	
						elseif ($row[3]	== 1)
						{
							$rezerwacja = "Tak";
						}
						echo "<td class = tablepadding >". $rezerwacja ."</td></tr>";
					}
					echo "</table>";
					echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
					$lista = $wybrany_rekord;
				}
			}
			else{ //...a jeśli nie
				echo "<p class=usuwanie id=brakdanych>Wybierz domek</p>  "; //wyświetl komunikat
				echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
			}
		}
		elseif (isset($_POST['wyszukaj'])) //jeśli klinięto wyszukaj
		{
			$nazwa_szukanego_rekordu = $_POST['nazwa']; //przypisz zmienne
			if  ((empty($nazwa_szukanego_rekordu))) //jeśli pole nie zostało wypełnione
			{
				echo "<p class=usuwanie id=brakdanych>Wypełnij pole wyszukiwania</p>";
				echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
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
				echo "<p class=tablefont id = rekordy >Znalezionych rekordów: ".$liczba_wierszy."</p>"; // ...i wyświetl ich ilość
				$lista = $wyszukane;
				if ($liczba_wierszy > 0) // jeśli zwrócono jakieś wiersze za bazy
				{
					echo "<div>";
					echo "<table class = tabledomki border=1><tr>";
					echo "<td class = tablepadding id=grey><b class = tablefont >Nazwa</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont >Opis</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont >Cena</b></td>";
					echo "<td class = tablepadding id=grey><b class = tablefont >Zarezerwowany</b></td></tr>";
					while ($row = mysql_fetch_row($lista))
					{
						echo "<tr id = tabledatafont><td class = tablepadding>". $row[1] ."</td>";
						echo "<td class = tablepadding>". $row[2] ."</td>";
						echo "<td class = tablepadding>". $row[4] ."</td>";
						if ($row[3] == 0) //pobiera wartość rezerwacji i aamienia ją na wartość logiczną
						{
							$rezerwacja = "Nie";
						}	
						elseif ($row[3]	== 1)
						{
							$rezerwacja = "Tak";
						}
						echo "<td class = tablepadding>". $rezerwacja ."</td></tr>";
					}
					echo "</table>";
					echo "</div>";
				}
				else // a jeśli nie zwrócono zadnych wierszy z bazy
				{
					echo "<p class=usuwanie id=brakdanych>Brak danych w bazie</p>";
				}
				echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
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
				echo "<table class = tabledomki border=1><tr>";
				echo "<td class = tablepadding id=grey><b class = tablefont id=grey>Nazwa</b></td>";
				while ($row = mysql_fetch_row($lista))
				{
					echo "<tr id = tabledatafont><td class = tablepadding> ". $row[1] ."</td>";
				}
				echo "</tr id = tabledatafont></table>";
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
						//echo"<a class=button id=buttondomki href='?pagenum=1'>Pierwsza strona</a>";
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
		if (!isset($_POST['wyszukaj']) and !isset($_POST['wyswietl']) and (!isset($_POST['dodaj'])) and (!isset($_POST['usun'])) and (!isset($_POST['edytuj'])) and (empty($lista))) // jeśli nie wypełniono żadnego formularza
		{
			echo"<form method='post' action=''>";	
			echo"<input type='submit' name='dodaj' value='Dodaj' />";
			echo"</form>";
		}
		@mysql_data_seek($lista, 0); // powrót na początek listy
		If (!empty($lista)) //jeśli zmienna $lista nie jest pusta
		{
			echo "<p class=tablefont id=wyszukajdomek >Wyszukaj domek: </p>";
			echo "<form style='padding-bottom: 51px; border-bottom: 1px solid #dddddd;' method='post' action=''>";
			echo "<p class=domkinazwaokienko id = fontloginhaslo>Nazwa: </p><input class=okienko id=domkiokienko  type='text' name='nazwa' size='20' placeholder='Wpisz szukane słowo...' /> <br/>";
			echo "<input style='margin-left: -10px;' type='checkbox' name='opis'/><p class= tablefont id=domkichekbox >Szukaj w opisach</p> ";
			echo "<input class = zalogujbutton id=wyszukajdomekbutton  type='submit' name='wyszukaj' value='Szukaj' />";
			echo "</form>";
			echo "<p class=tablefont id=operacje >Operacje na domkach:</p>";
			echo"<form style='
	margin-left: 276px;
	margin-right: auto;
	vertical-align: middle;
	margin-top: 47px;
' method='post' action=''>";
			echo"<SELECT class = okienko id = okienkodomkidol name='lista'>";
			echo"<option selected disabled> Wybierz domek</option>";
			while ($row2 = mysql_fetch_row($lista))
			{
				echo "<option value='". $row2[1] ."'>". $row2[1] ."</option>";
			}
			echo"</SELECT>";
			echo"<input class=zalogujbutton id = buttondomki type='submit' name='dodaj' value='Dodaj' />";
			echo"<input class=zalogujbutton id = buttondomki type='submit' name='wyswietl' value='Wyświetl' />";
			echo"<input class=zalogujbutton id = buttondomki type='submit' name='edytuj' value='Edytuj' />";
			echo"<input class=zalogujbutton id = buttondomki type='submit' name='usun' value='Usuń' />";
			echo"</form>";
		}
		if (isset($_POST['dodaj'])) // jeśli klinieto 'dodaj'
		{
			echo "<h1 class=tablefont id=dodajdobazy>Dodaj do bazy</h1>";
			echo "<form style='margin-left: auto;
	margin-right: auto;' method='post' action='zatwierdz.php'>"; 
			echo "<div>
			<p class=domkinazwaokienko id= fontloginhaslo>Nazwa:</p>
			<input class=okienko id=domkiokienko type='text' name='wartosci[]' size='15' /> 		
			</div>";
			echo "<div style='margin-top: 15px' >
			<p style='text-align: center; margin-left: -79px;' class=domkinazwaokienko id= fontloginhaslo>Opis:</p> 
			<input class=okienko id=domkiokienko type='text' name='wartosci[]' size='15' /></div> ";
			echo "<div style='margin-top: 15px'><p style = '    margin-left: -83px' class=domkinazwaokienko id= fontloginhaslo>Cena:</p> 
			<input class=okienko id=domkiokienko type='text' name='wartosci[]' size='15' /></div> ";
			echo "<input type='hidden' name='walidacja_tabela[]' value ='domek' />"; 
			echo "<input type='hidden' name='walidacja_kolumna[]' value ='*' />";
			echo "<input type='hidden' name='walidacja_warunek[]' value ='0' />";
			echo "<input type='hidden' name='tabela[]' value ='domek' />"; 
			echo "<input type='hidden' name='kolumna[]' value ='Nazwa' />";
			echo "<input type='hidden' name='kolumna[]' value ='Opis' />";
			echo "<input type='hidden' name='kolumna[]' value ='Cena' />";
			echo "<input type='hidden' name='strona_wroc' value ='domki.php' />";
			echo "<input type='hidden' name='komunikat_niepodzenie' value ='Operacja się nie powiodła' />";
			echo "<input type='hidden' name='komunikat_powodzenie' value ='Operacja się powiodła' />";
			echo "<input type='hidden' name='typ_komendy' value ='1' />";
			echo "<input class = zalogujbutton id = dodajdomek type='submit' name='submit' value='Dodaj domek' />";
			echo "</form>";
			echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
		}
		if (isset($_POST['edytuj'])) // jeśli kliknięto 'edytuj'
		{
			if (isset($_POST['lista'])) // jeśli wybrano rekord z formularza
			{
				$edytowane =  $_POST['lista']; // przypisz zmienną
				//podlaczenie do mysql i wybor danych
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				mysql_select_db($db_name);
				$edytowany_rekord = mysql_query("SELECT * FROM domek WHERE Nazwa = '$edytowane'");
				echo "<h1 class=tablefont id=dodajdobazy >Edytuj domek</h1>";
				if ($row = mysql_fetch_row($edytowany_rekord))
				{
					$nazwa = $row[1];
					$cena = $row[4];
					$opis= $row[2];
					echo "<form method='post' action='zatwierdz.php'>"; // formularz 'edytuj'
					echo "<div>
					<p class=domkinazwaokienko id=fontloginhaslo>Nazwa:</p>
					<input class=okienko id=domkiokienko type='text' name='wartosci[]' value='".$nazwa."' size='15' /> </div>";
					echo "<div style='margin-top: 15px'>
					<p style='text-align: center; margin-left: -85px;' class=domkinazwaokienko id=fontloginhaslo >Cena:</p>
					<input class=okienko id=domkiokienko type='text' name='wartosci[]' value='".$cena."' size='15' /></div> ";
					echo "<div style='margin-top: 15px'>
					<p style = '    margin-left: -85px' class=domkinazwaokienko id=fontloginhaslo >Opis:</p> 
					<input class=okienko id=domkiokienko type='text' name='wartosci[]' value='".$opis."' size='50' /></div> ";
					//mysql_data_seek($edytowany_rekord, 0); // powrót na początek listy
					echo"<input type='hidden' name='stare_wartosci[]' value ='".$nazwa."' />"; //stare wartosci
					echo"<input type='hidden' name='stare_wartosci[]' value ='".$opis."' />";
					echo"<input type='hidden' name='stare_wartosci[]' value ='".$cena."' />";
					//dodatkowe dane dla funkcji walidacja_wartosci	
					echo "<input type='hidden' name='walidacja_tabela[]' value ='domek' />"; //nazwa tabeli albo tabel w bazie
					echo "<input type='hidden' name='walidacja_kolumna[]' value ='Nazwa' />";
					$w1 = "Nazwa=quote".$nazwa."quote";
					$w2 = "Opis=quote".$opis."quote";
					$w3 = "Cena=quote".$cena."quote";
					// echo "<input type='hidden' name='walidacja_warunek[]' value ='Tu jest warunek walidacji' />"; //warunek where do funkcji walidacja
					echo "<input type='hidden' name='walidacja_warunek[]' value ='".$w1."' />";
					echo "<input type='hidden' name='walidacja_warunek[]' value ='".$w2."' />";
					echo "<input type='hidden' name='walidacja_warunek[]' value ='".$w3."' />";
					//dodatkowe dane dla funkcji baza
					echo "<input type='hidden' name='tabela[]' value ='domek' />"; //nazwa tabeli albo tabel w bazie
					echo "<input type='hidden' name='kolumna[]' value ='Nazwa' />"; //nazwy kolumn w bazie do których wpisujemu wartosci
					echo "<input type='hidden' name='kolumna[]' value ='Cena' />";
					echo "<input type='hidden' name='kolumna[]' value ='Opis' />";
					//mysql_data_seek($edytowany_rekord, 0); // powrót na początek listy
					$w1 = "Nazwa=quote".$nazwa."quote";
					$w2 = "Opis=quote".$opis."quote";
					$w3 = "Cena=quote".$cena."quote";
					echo "<input type='hidden' name='warunek[]' value ='".$w1."' />"; //warunek where do funkcji baza
					echo "<input type='hidden' name='warunek[]' value ='".$w3."' />";
					echo "<input type='hidden' name='warunek[]' value ='".$w2."' />";
					echo "<input type='hidden' name='strona_wroc' value ='domki.php' />";
					echo "<input type='hidden' name='komunikat_niepowodzenie' value ='Operacja się nie powiodła' />";
					echo "<input type='hidden' name='komunikat_powodzenie' value ='Operacja się powiodła' />";
					echo "<input type='hidden' name='typ_komendy' value ='2' />";
					echo "<input class=zalogujbutton id=dodajdomek type='submit' name='submit' value='Edytuj domek' />";
					echo "</form>";
					echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
					$lista = $edytowany_rekord;
				}
			}
			else{ //jeśli nie wybrano rekordu w formularzu
				echo "<p class=usuwanie id=brakdanych>Wybierz domek</p>";
				echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
			}
		}
		if (isset($_POST['usun'])) // jeśli kliknięto 'edytuj'
		{
			if (isset($_POST['lista'])) // jeśli wybrano rekord z formularza
			{
				//echo $_POST['lista'];
				$usuwane =  $_POST['lista']; // przypisz zmienną
				// pobierz z bazy nazwe ($usuwane) SELECT FROM BASE Nazwa, Opis WHERE Nazwa = '$usuwane' i przeslij te zmienne do formularza / <input type='text' name='nazwa' value "TU ZMIENNA USUWANA" size='15
				//podlaczenie do mysql i wybor danych
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
				mysql_select_db($db_name);
				$usuwany_rekord = mysql_query("SELECT * FROM domek WHERE Nazwa = '$usuwane'");
				echo "<h1 class=tablefont id=dodajdobazy >Usunąć domek z bazy?</h1>";
				if ($row = mysql_fetch_row($usuwany_rekord)) // jeśli wybrano rekord
				{
					$nazwa = $row[1];
					$cena = $row[4];
					$opis= $row[2];
					echo "<div ><p class=usuwanie id=wlasne>Nazwa:</p><p class=usuwanie>" .$nazwa."</p></div>";
					echo "<div class=bottomborder></div>"; 
					echo "<div><p class=usuwanie id=wlasne>Cena:</p><p class=usuwanie>" .$cena ."</p></div>";
					echo "<div class=bottomborder></div>";
					echo "<div ><p class=usuwanie id=wlasne>Opis:</p><p class=usuwanie>".$opis."</p></div>";
					echo "<div class=bottomborder></div>";
					echo "<form method='post' action='zatwierdz.php'>"; // formularz 'usuń'
					//dodatkowe dane dla funkcji walidacja_wartosci	
					echo "<input type='hidden' name='walidacja_tabela[]' value ='domek' />"; //nazwa tabeli albo tabel w bazie
					echo "<input type='hidden' name='walidacja_kolumna[]' value ='*' />";
					$w1 = "Nazwa=quote".$nazwa."quote";
					$w2 = "Rezerwacja=quote0quote";
					//$w3 = "Cena=".$row[4];
					echo "<input type='hidden' name='walidacja_warunek[]' value ='".$w1."' />"; //warunek where do funkcji walidacja
					echo "<input type='hidden' name='walidacja_warunek[]' value ='".$w2."' />";
					//dodatkowe dane dla funkcji baza
					echo "<input type='hidden' name='tabela[]' value ='domek' />"; //nazwa tabeli albo tabel w bazie
					$w1 = "Nazwa=quote".$nazwa."quote";
					$w2 = "Opis=quote".$opis."quote";
					//$w3 = "Cena=".$row[4];	
					echo "<input type='hidden' name='warunek[]' value ='".$w1."' />"; //warunek where do funkcji baza
					echo "<input type='hidden' name='warunek[]' value ='".$w2."' />";
					echo "<input type='hidden' name='strona_wroc' value ='domki.php' />";
					echo "<input type='hidden' name='komunikat_niepowodzenie' value ='Operacja się nie powiodła' />";
					echo "<input type='hidden' name='komunikat_powodzenie' value ='Operacja się powiodła' />";
					echo "<input type='hidden' name='typ_komendy' value ='3' />";
					echo "<input class=zalogujbutton id= dodajdomek type='submit' name='submit' value='Usuń domek' style='margin-left: 440px;'/>";
					echo "</form>";
					echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
					$lista = $usuwany_rekord;
				}
			}
			else{ // ...eśli nie wybrano rekordu
				echo "<p class=usuwanie id=brakdanych>Wybierz domek</p>  ";
				echo "<a class = zalogujbutton id = wroc href='domki.php'>Wróć</a>";
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