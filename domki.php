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
<div id=mainsite style ="width: 850px; height: 1040px; top: 100px; left: 100px; position: absolute; border: 1px; border-style: solid; border-color: #ffffff;">

<?php

if(isset($_SESSION['zalogowany']))
{

$level = $_SESSION['level'];
$user = $_SESSION['username'];

	//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	//mysql_select_db($db_name);
	//$level_z_bazy = mysql_query("SELECT level FROM users WHERE username = '$user'");
	

	if ($level == 6 || $level == 5 || $level == 4 || $level == 2 )
	{
	
	$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
	mysql_select_db($db_name);
	$wszystkie = mysql_query("SELECT * FROM domek ORDER BY Nazwa ASC");
	
	//pejdżowanie
	
	$ilosc = mysql_num_rows($wszystkie);
	
	$na_stronie = 5;


	$ostatnia_strona = ceil($ilosc/$na_stronie);
		
		if (!isset($_GET['pagenum']))
		{
		$pagenum = 1;
		}
		else
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
	
	while ($row = mysql_fetch_row($lista))
	{
	echo "<table border=1><tr>";
	echo "<td>". $row[1] ."</td>";
	echo "<td>". $row[2] ."</td>";
	echo "</tr></table>";
	}
	
	echo"<br/><br/>";
	echo"<br/><br/>";

		echo "Strona ".$pagenum." z ".$ostatnia_strona." ";


		if ($pagenum == 1) //jesli strona jest pierwsza
		{
			echo" ";
			echo"<a href='?pagenum=$ostatnia_strona'>Ostatnia strona</a>";
		} 
		else // jesli strona nie jest pierwsza
		{
		
			//echo"<a href='?pagenum=1'>Pierwsza strona</a>";
		
			echo" ";
			$previous = $pagenum - 1;
		echo"<a href='?pagenum=$previous'>Poprzednia strona</a>";
		}
		if ($pagenum == $ostatnia_strona) //jesli strona jest ostatnia
		{
		echo" ";
		echo"<a href='?pagenum=1'>Pierwsza strona</a>";
		}
		else // jesli strona nie jest ostatnia
		{
		$next = $pagenum + 1;
		echo" ";
		echo"<a href='?pagenum=$next'>Następna strona</a>";
		
		//echo" ";
		//echo"<a href='?pagenum=$ostatnia_strona'>Ostatnia strona</a>";
			
		}
	
		
	
	// koniec pejdżowania
	
	echo"<br/><br/>";
	echo"<br/><br/>";
	
	mysql_data_seek($lista, 0);
	
	echo"<form method='post' action=''>";
	echo"<SELECT name='lista'>";
	while ($row2 = mysql_fetch_row($lista))
	{
	echo "<option value='". $row2[1] ."'>". $row2[1] ."</option>";
	}
	echo"</SELECT>";
	echo"<input type='submit' name='dodaj' value='Dodaj' />";
	echo"<input type='submit' name='edytuj' value='Edytuj' />";
	echo"<input type='submit' name='usun' value='Usuń' />";
	echo"</form>";
	
		
		if (isset($_POST['dodaj']))
		{
			
					
			echo "<h1>Dodaj do bazy</h1>";
			echo "<form method='post' action='zatwierdz.php'>";
			echo "Nazwa: <input type='text' name='nazwa' size='15' /> <br/><br/>";
			echo "Opis: <input type='text' name='opis' size='15' /> <br/><br/>";
			echo "<input type='submit' name='dodaj' value='Dodaj' />";
			echo "</form>";
			
			
		}
		if (isset($_POST['edytuj']))
		{
			//podlaczenie do mysql i wybor danych
			
			
			
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$edytowane = mysql_query("SELECT * FROM domek ORDER BY Nazwa ASC");
			
			echo "<h1>Edytuj z bazy</h1>";
			echo "<form method='post' action='zatwierdz.php'>";
			echo "Nazwa: <input type='text' name='nazwa' size='15' /> <br/><br/>";
			echo "Opis: <input type='text' name='opis' size='15' /> <br/><br/>";
			echo "<input type='submit' name='edytuj' value='Edytuj' />";
			echo "</form>";
			
				if (isset($_POST['Edytuj rekord']))
				{
					
					
					
				}
			
		}
		if (isset($_POST['usun']))
		{
			
			if (isset($_POST['lista']))
			{
				
			echo $_POST['lista'];
			$usuwane =  $_POST['lista'];
			
			// pobierz z bazy nazwe ($usuwane) SELECT FROM BASE Nazwa, Opis WHERE Nazwa = '$usuwane' i przeslij te zmienne do formularza / <input type='text' name='nazwa' value "TU ZMIENNA USUWANA" size='15
			
			//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			//mysql_select_db($db_name);
			
			
			echo "<form method='post' action='zatwierdz.php'>";
			echo "Nazwa: <input type='text' name='nazwa' size='15' /> <br/><br/>";
			echo "Opis: <input type='text' name='opis' size='15' /> <br/><br/>";
			echo "<input type='submit' name='edytuj' value='Edytuj' />";
			echo "</form>";
			
			
			}
			
			
		}
		
		
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