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

	if ($level == 2 or $level == 5 or $level == 6)
	{
		
		$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
		mysql_select_db($db_name);
		$zamowienia = mysql_query("SELECT * FROM zamowienia ORDER BY ID ASC");
			
			//pejdżowanie
			
			$ilosc = mysql_num_rows($zamowienia);
		
			$na_stronie = 10;


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

			
			
			$data = "SELECT * FROM zamowienia ORDER BY ID ASC LIMIT $na_stronie OFFSET $offset";

			$lista = mysql_query($data);
			
			$liczba_wierszy = @mysql_num_rows($lista);
			
			//echo $liczba_wierszy;
			//koniec pejdżowania
			if ($liczba_wierszy > 0)
			{
				echo "<table border=1><tr>";
				echo "<td><b>Domek</b></td>";
				echo "<td><b>Imię klienta</b></td>";
				echo "<td><b>Nawisko klienta</b></td>";
				echo "<td><b>Numer tel</b></td>";
				echo "<td><b>Okres</b></td></tr>";
				while ($row = mysql_fetch_row($lista))
				{
					
					echo "<tr><td>". $row[1] ."</td>";
					echo "<td>". $row[2] ."</td>";
					echo "<td>". $row[3] ."</td>";
					echo "<td>". $row[4] ."</td>";
					echo "<td>". $row[5] ."</td></tr>";

				}
				echo "</table>";
				
				echo"<br/><br/>";
				echo"<br/><br/>";
				
				if ($ilosc > 10)
				{
					echo "Strona ".$pagenum." z ".$ostatnia_strona." ";

					
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
					
					
				}
				//Wyjebać
			}
			else{
				
				echo "Brak danych do wyświetlenia";
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


</div>

<div id=footer>
<center><a href='domki_panel_glowny.php'>Powrót na stronę główną</a></center>
</div>

</div>
</body>
</html>