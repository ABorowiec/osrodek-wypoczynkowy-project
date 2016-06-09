<html>
<head>
<META NAME="robots" CONTENT="noindex, nofollow">
<link rel="shortcut icon" href="dane\favicon.ico">
<link rel="Stylesheet" type="text/css" href="dane\style.css" />
</head>
<body>
<?php
require_once('config.php'); //dołącz plik z ustawieniami
session_start(); //wystartuj sesję
if(isset($_SESSION['zalogowany'])) //jeśli user jest zalogowany...
{
	header('Location: domki_panel_glowny.php'); //...przenieś go na do panelu głównego
}
if (isset($_POST['submit'])) //jeśli formularz został wysłany
{
	//if ($_POST['submit'] == 'Zaloguj')
	//{
	$username = ($_POST['username']); //przypisz zmiennej nazwę i hasło
	$password = ($_POST['password']);
	$password = hash('sha256', $password, false); //zaszyfruj hasło
	//echo $username."<br>";
	//echo $password;
	$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz się z bazą a w razie nieudanej próby wyświetl błąd
	mysql_select_db($db_name); // wybierz bazę dabych
	if(mysql_num_rows(mysql_query("SELECT username, password FROM users WHERE username = '$username' && password = '$password' ")) > 0) //jeśli w bazie występuje użytkownik o takiej nazwie i haśle (ilość > 0)...
	{
		$sql = "SELECT level FROM users WHERE username = '$username' && password = '$password' "; //...pobierz uprawnienia tego użytkownika z bazy
		$lev = mysql_query($sql); //zatwierdź komendę mysql
		//echo $username;
		//echo $password;
		$row = mysql_fetch_row($lev); //przypisanie zmiennej wierszy z bazy
		$level = $row[0]; // przypisz zmiennej uprawnienia pobrane z bazy
		$ip = $_SERVER['REMOTE_ADDR']; // pobierz adres IP logowania użytkownika
		$obecna_data = date("Y-m-d H:i:s"); // pobierz obecną datę
		$update =	"UPDATE users SET ip_login='$ip', date_login='$obecna_data'
				WHERE username = '$username'"; // wpisz do bazy datę jako datę logowania
		$updating = mysql_query($update); // zatwierdź komendę mysql...
		if ( $updating) //...a jeśli operacja została wykonana pomyślnie...
		{
			$_SESSION['zalogowany'] = true;
			$_SESSION['username'] = $username;
			$_SESSION['level'] = $level; //...przypisz zmiennym sesyjnym nazwę, hasło oraz uprawnienia użytkownika...
			header('Location: domki_panel_glowny.php'); //... i przejdź do panelu głównego
		}
	}
	else // jeśli nie znaleziono takiego użytkownika z hasłem w bazie...
	{
		//echo mysql_error();
		$message = "<B style='
	color: red;
'>Nieprawidłowy login lub hasło</B>"; //...wyświetl komunikat
	}
}
?>
<div class=sitecolor  id=site>
<!-- <div id=site style='height: 615px;'> -->
<div id=mainsite>
<h2 id=logowanie >Logowanie</h2>
<div id=login><form method='POST' action=''> <br/>
<table class=loginhaslo>
<tr id = loginsize>
<td>
<b id = fontloginhaslo>Login:</b> </td><td><input class=okienko  type='text' name='username'> <br/> 
</td>
</tr>
<tr id = loginsize>
<td><b id = fontloginhaslo>Hasło:</b> </td><td><input class=okienko type='password' name='password'> <br/> </td>
</tr></table>
<input class = zalogujbutton type='submit' value='Zaloguj' name='submit'> <br/><br/> <!-- nazwa przycisku - porównaj z linijką nr 20 -->
<?php
if(isset($message)) //jeśli zadeklarowano zmienną komunikatu...
{
	echo $message; //...wyświetl komunikat
}
?>
</form>
</div>
</div>
<div id=footer>
<center><a style='
	margin-top: -96px;
' class = footerbutton href='index.php'>Powrót na stronę główną</a></center>
</div>
</div>
</body>
</html>