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
<div id=mainsite style ="width: 850px; top: 100px; left: 100px; position: absolute; border: 1px; border-style: solid; border-color: #ffffff;">

<?php

if(isset($_SESSION['zalogowany']))
{
$level = $_SESSION['level'];
$user = $_SESSION['username'];

	//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	//mysql_select_db($db_name);
	//$level_z_bazy = mysql_query("SELECT level FROM users WHERE username = '$user'");

	if ($level == 1 or 2 or 3 or 4 or 5)
	{
		
		if (isset($_POST['dodaj']))
			{
				
				// dodawanie rekordu
			
			$nazwa_domku = $_POST['nazwa']; 
			$opis_domku = $_POST['opis']; 
			
			//echo $nazwa_domku;
			//echo $opis_domku;
			
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$dodawane = "INSERT INTO domek (Nazwa, Opis) VALUES ('$nazwa_domku', '$opis_domku')";
			$results=mysql_query($dodawane) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
			
				if ( $results  ) 
				{
				
				echo "Dodano rekord do bazy";
				
				}
				else
				{
					
				echo "Błąd. Nie dodano rekordu do bazy";	
					
				}	
			}
		if (isset($_POST['edytuj']))
			{
				// edycja rekordu	
			}
		if (isset($_POST['usun']))
			{
				// usuwanie rekordu
				
				
			$nazwa_domku = $_POST['nazwa']; 
			$opis_domku = $_POST['opis']; 
			
			//echo $nazwa_domku;
			//echo $opis_domku;
			
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$usuwane = "DELETE * FROM domek WHERE Nazwa = '$nazwa_domku' AND Opis = '$opis_domku'";
			$results=mysql_query($usuwane) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
			
				if ( $results  ) 
				{
				
				echo "Usunięto rekord z bazy";
				
				}
				else
				{
					
				echo "Błąd. Nie usunięto rekordu z bazy";	
					
				}
				
				
			}
		//else
		//	{
		//	
		//		echo "Brak danych";
		//	
		//	}
		
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

<!--
<div style='bottom: 75px; left: 350px; position: absolute; text-align: center;'>
<a href='index.html'>Powrót na stronę główną</a>
</div>
-->

</div>
</div>
</body>
</html>