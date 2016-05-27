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
<div id=mainsite style ="width: 850px; top: 100px; left: 100px; position: absolute; border: 1px; border-style: solid; border-color: #ffffff;">

<?php

if(isset($_SESSION['zalogowany'])) //jeśli zalogowany...
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username']; //...pobierz zienne sesyjne

	//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	//mysql_select_db($db_name);
	//$level_z_bazy = mysql_query("SELECT level FROM users WHERE username = '$user'");

	if ($level == 1 or 2 or 3 or 4 or 5 or 6) //jeśli użytkownik ma odpowiednie uprawnienia
	{
		
		function baza ($post, $nazwa_str_do_powrotu, $nazwa_tabeli_w_bazie, $typ_komendy)
		{
			// odczytanie rodzaju submit z tablicy POST
			
			//print_r($_POST);

			foreach ($post as $key => $value)
			echo $key."=".$value."<br/>";
		
			// if (in_array("Irix", $os))
				
				
			// if (in_array("Irix", $os)) 
			
			
			// if (in_array("Irix", $os)) 
			
			
			
			
			// odczytanie zmiennych z tablicy POST
			
			// wpisanie rodzaju komendy, nazwy tabeli i zmiennych do poleceania sql
			
			//
			
			// link do strony powrotnej
			
		// size=tab;
		
		// for i=0;i<size;i++
			
			// if tab[i]=szukanawartosc
			// true
			// else
			// false
		
			
			
		
		}
		
	}
	else
	{
		echo "<b>Nieodpowiednie uprawnienia. Zostaniesz przekierowany w ciągu 5 sekund...</b>";
		header('Refresh: 5; url=domki_panel_glowny.php'); // przekieruj po 5 sek.	
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

<!--
<div style='bottom: 75px; left: 350px; position: absolute; text-align: center;'>
<a href='index.html'>Powrót na stronę główną</a>
</div>
-->

</div>
</div>
</body>
</html>