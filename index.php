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
<div class=sitecolor id=site >
<div id=mainsite>
<?php
if(isset($_SESSION['zalogowany']))
{
	$level = $_SESSION['level'];
	$user = $_SESSION['username'];
	if ($level == 6 || $level == 5 || $level == 4 || $level == 3 || $level == 2 || $level == 1 )
	{
		header('Location: domki_panel_glowny.php'); // Redirect
	}
	echo "<div id='login'>";
	echo "<h2 class = button id= bungalow>BungalowMS</h2>";
	echo "<table style='text-align: center; 
							margin-left: auto; 
							margin-right: auto;'>
							<tr>
							<td>";
	echo "<a class = button id=index href='zaloguj.php'>Wejdź jako pracownik</a>";
	echo "</td><td>";
	echo "<a class = button id=index href='rezerwuj.php'>Wejdź jako klient</a>";
	echo "</td></tr></table>";
	echo "</div>";
}
else
{
	echo "<div id='login'>";
	echo "<h2 class = button id= bungalow>BungalowMS</h2>";
	echo "<table style='text-align: center; 
							margin-left: auto; 
							margin-right: auto;'><tr><td>";
	echo "<a class = button id=index href='zaloguj.php'>Wejdź jako pracownik</a>";
	echo "</td><td>";
	echo "<a class = button id=index href='rezerwuj.php'>Wejdź jako klient</a>";
	echo "</td></tr></table>";
	echo "</div>";
}
?>
</div>
<div id=footer>
</div>
</div>
</body>
</html>