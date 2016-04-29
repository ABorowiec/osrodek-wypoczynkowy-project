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
$username = $_SESSION['username'];

	//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	//mysql_select_db($db_name);
	//$level_z_bazy = mysql_query("SELECT level FROM users WHERE username = '$user'");

	if ($level == 6 || $level == 5 || $level == 4 || $level == 3 || $level == 2 || $level == 1  )
	{
		if (isset($_POST['zmien']))
		{
			$stare_haslo = ($_POST['old_password']);
			$nowe_haslo = ($_POST['new_password']);
			$nowe_powtorzone_haslo = ($_POST['repeat_new_password']);
			
			
		//if wypełniono wszystkie dane
		if ((empty($stare_haslo)) or (empty($nowe_haslo)) or (empty($nowe_powtorzone_haslo)))
		{
			$message = "Nie wypełniono wszystkich pól";	
			
			
	
		}
			else
	 		{
	 		$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
		
		
			$password = hash('sha256', $stare_haslo, false);	
		
				//if stare haslo jest dobre
			if (mysql_num_rows(mysql_query("SELECT username, password FROM users WHERE username = '$username' && password = '$password' ")) > 0)
			{
				
				//if nowe hasła się zgadzają
				if ($nowe_powtorzone_haslo == $nowe_haslo)
				
				{
		
		
	$zmienione_haslo = hash('sha256', $nowe_haslo, false);	
		
	$sql="UPDATE users SET password = '$zmienione_haslo' WHERE username='$username'";

	$data=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
	
				if (mysql_affected_rows() > 0) {
				$message ="Zmieniono hasło";
				}
				else {
				$message ="Błąd!";
				}
	
				}
				else{
					
					$message ="Nowe hasła się różnią";
					
				}
			}
			else
			{
				
				$message ="Stare hasło jest niepoprawne";
				
			}
		
			}
		
	}
	}
	else
	{
	echo "<b>Nieodpowiednie uprawnienia. Zostaniesz przekierowany w ciągu 5 sekund...</b>";
	header('Refresh: 5; url=domki_panel_glowny.php');
	}

echo "<div id=login><form method='POST' action=''> <br/>";
if (isset($message))
{
echo "<span style='color: #0000ff;'>".$message."</span>";
}
echo "<table><tr>";
echo "<td><b> Stare haslo:</b> </td><td><input type='password' name='old_password'> <br/> </td>";
echo "</tr><tr>";
echo "<td><b> Nowe hasło:</b> </td><td><input type='password' name='new_password'> <br/> </td>";
echo "</tr><tr>";
echo "<td><b>Powtórz nowe hasło:</b> </td><td><input type='password' name='repeat_new_password'> <br/> </td>";
echo "</tr></table>";

echo "<input type='submit' value='Zmień hasło' name='zmien'> <br/><br/>";	
	
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


<div style='bottom: 75px; left: 350px; position: absolute; text-align: center;'>
<a href='domki_panel_glowny.php'>Powrót na stronę główną</a>
</div>


</div>
</div>
</body>
</html>