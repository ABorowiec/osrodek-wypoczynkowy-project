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

if(isset($_SESSION['zalogowany']))
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username'];
	
	//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	//mysql_select_db($db_name);
	//$level_z_bazy = mysql_query("SELECT level FROM users WHERE username = '$user'");

	if ($level == 6 || $level == 5 || $level == 4 || $level == 3 || $level == 2 || $level == 1 )
	{
		header('Location: domki_panel_glowny.php'); // Redirect
	}
	echo "<div id='login'>";
	
	echo "<table style='text-align: center; 
							margin-left: auto; 
							margin-right: auto;'><tr><td>";
	
	echo "<a href='zaloguj.php'>Wejdź jako pracownik</a>";
	
	echo "</td><td>";
	
	echo "<a href='rezerwuj.php'>Wejdź jako klient</a>";
	
	echo "</td></tr></table>";
	
	echo "</div>";

}
else
{
	echo "<div id='login'>";
	
	echo "<table style='text-align: center; 
							margin-left: auto; 
							margin-right: auto;'><tr><td>";
	
	echo "<a href='zaloguj.php'>Wejdź jako pracownik</a>";
	
	echo "</td><td>";
	
	echo "<a href='rezerwuj.php'>Wejdź jako klient</a>";
	
	echo "</td></tr></table>";
	
	echo "</div>";
}

?>


</div>

<div id=footer>
<!-- <center><a href='domki_panel_glowny.php'>Powrót na stronę główną</a></center> -->
</div>

</div>
</body>
</html>