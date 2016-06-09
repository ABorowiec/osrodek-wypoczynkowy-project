<?php
session_start(); //dołącz plik z ustawieniami
require_once('config.php'); //wystartuj sesję
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
if(isset($_SESSION['zalogowany'])) //jeśli zalogowany...
{
	$level = $_SESSION['level']; 
	$username = $_SESSION['username']; //...pobierz zienne sesyjne
	if ($level == 6 || $level == 5 || $level == 4 || $level == 3 || $level == 2 || $level == 1  ) //jeśli użytkownik ma odpowiednie uprawnienia
	{
		if (isset($_POST['zmien'])) //jeśli wysłano formularz
		{
			$stare_haslo = ($_POST['old_password']);
			$nowe_haslo = ($_POST['new_password']);
			$nowe_powtorzone_haslo = ($_POST['repeat_new_password']); //przypisz zmienne z formularza
			if ((empty($stare_haslo)) or (empty($nowe_haslo)) or (empty($nowe_powtorzone_haslo))) //jeśli ne wypełniono wszystkich pól...
			{
				$message = "Nie wypełniono wszystkich pól";	//...wyświetl komunikat...
			}
			else //...a jeśli wypełniono wszystkie pola...
			{
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz się z bazą a w razie nieudanej próby wyświetl błąd
				mysql_select_db($db_name); // ...wybierz bazę
				$password = hash('sha256', $stare_haslo, false); // zaszyfruj stare hasło	
				if (mysql_num_rows(mysql_query("SELECT username, password FROM users WHERE username = '$username' && password = '$password' ")) > 0) //jeśli stare haslo jest poprawne
				{
					if ($nowe_powtorzone_haslo == $nowe_haslo) //jeśli nowe hasła się zgadzają
					{
						$zmienione_haslo = hash('sha256', $nowe_haslo, false);	//zaszyfruj nowe hasło
						$sql="UPDATE users SET password = '$zmienione_haslo' WHERE username='$username'"; //zmień hasło w bazie danych
						$data=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error()); //zatwierdź komendę mysql
						if (mysql_affected_rows() > 0) { //jeśli wykonano operację...
							$message ="Zmieniono hasło"; //...wyświetl komunikat
						}
						else { //...a jeśli nie...
							$message ="Błąd!"; 
						}
					}
					else{ //jeśli hasła się nie zgadzają
						$message ="Nowe hasła się różnią"; //...wyświetl komunikat
					}
				}
				else //jeśli stare hasło jest niepoprawne
				{
					$message ="Stare hasło jest niepoprawne"; //...wyświetl komunikat
				}
			}
		}
	}
	else // jeśli użytkownik nie ma wymaganych uprawnień...
	{
		echo "<b>Nieodpowiednie uprawnienia. Zostaniesz przekierowany w ciągu 5 sekund...</b>"; //...wyświetl komunikat
		header('Refresh: 5; url=domki_panel_glowny.php'); // przekieruj do strony logowania po 5 sek.
	}
	echo "<div id=login><form method='POST' action=''> <br/>";
	if (isset($message)) //jeśli zmienna komunikatu jest zadeklarowana
	{
		echo "<span style='
	margin-top: 136px; margin-bottom: -102px;
' class=usuwanie id=brakdanych>".$message."</span>"; //...wyświetl komunikat
	}
	echo "<table style='
		margin-top: 220px;
	margin-left: -135px;
	margin-right: 268px;
'><tr>";
	echo "<td><p style='
	padding-top: 1px;
	margin-bottom: 1px;
' class=domkinazwaokienko id= fontloginhaslo>Stare hasło:</p> </td>
	<td><input class=okienko id=domkiokienko type='password' name='old_password'> <br/> </td>";
	echo "</tr><tr>";
	echo "<td><p style='
	padding-top: 1px;
	margin-bottom: 1px;
' class=domkinazwaokienko id= fontloginhaslo> Nowe hasło:</p> </td>
	<td><input class=okienko id=domkiokienko type='password' name='new_password'> <br/> </td>";
	echo "</tr><tr>";
	echo "<td><p style='
	padding-top: 1px;
	margin-bottom: 1px;
' class=domkinazwaokienko id= fontloginhaslo>Powtórz nowe hasło:</p> </td>
	<td><input class=okienko id=domkiokienko type='password' name='repeat_new_password'> <br/> </td>";
	echo "</tr></table>";
	echo "<input class=zalogujbutton id= dodajdomek type='submit' value='Zmień hasło' name='zmien'>";	
	echo "</div>";
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
<center><a style='
	margin-top: 13px;
' class=footerbutton id =domkifooter href='domki_panel_glowny.php'>Powrót na stronę główną</a></center>
</div>
</div>
</body>
</html>