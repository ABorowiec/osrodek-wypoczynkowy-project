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

	if ($level == 6 || $level == 5 || $level == 4)
	{
	echo "<table><tr>";
	echo "<td>Dodaj</td>";
	echo "<td>>Edytuj</td>";
	echo "<td>Usuń</td>";
	echo "</tr></table>";	
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

<div style='bottom: 75px; left: 350px; position: absolute; text-align: center;'>
<a href='domki_panel_glowny.php'>Powrót na stronę główną</a>
</div>

</div>
</div>
</body>
</html>