﻿<?php
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
		
		if (isset($_POST['wyszukaj']))
			{
				
			$nazwa_szukanego_rekordu = $_POST['nazwa']; 
				
			if  ((empty($nazwa_szukanego_rekordu)))
			{
				
				echo "Nie wypełniono pola wyszukiwania...<br/>";
				echo "<a href='domki.php'>Wróć</a>";
				header( 'refresh: 5; url=domki.php' );
				$pagenum = 1;
				
			}
			else
			{
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			
			
			if (isset($_POST['opis'])) {

			// Checkbox is selected
	
			$wyszukane = mysql_query("SELECT * FROM domek WHERE (Nazwa LIKE '%$nazwa_szukanego_rekordu%') OR (Opis LIKE '%$nazwa_szukanego_rekordu%') ORDER BY Nazwa ASC");
	
			} 
			else
			{
				

			// Alternate code
   
			$wyszukane = mysql_query("SELECT * FROM domek WHERE Nazwa LIKE '%$nazwa_szukanego_rekordu%' ORDER BY Nazwa ASC");
   
			}
			
			
			
			
					$liczba_wierszy = @mysql_num_rows($wyszukane);
		
		echo "<br/>Znalezionych rekordów: ".$liczba_wierszy."<br/>";
		
		echo"<br/><br/>";
		echo"<br/><br/>";
		
		//pejdżowanie
	
	//$liczba_wierszy = @mysql_num_rows($wyszukane);
	
	$na_stronie = 5;
		
	$ostatnia_strona = ceil($liczba_wierszy/$na_stronie);
	
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
			
			
			
			if (isset($_POST['opis'])) {

			// Checkbox is selected
	
			$lista = mysql_query("SELECT * FROM domek WHERE (Nazwa LIKE '%$nazwa_szukanego_rekordu%') OR (Opis LIKE '%$nazwa_szukanego_rekordu%') ORDER BY Nazwa ASC LIMIT $na_stronie OFFSET $offset");
	
			} 
			else
			{
				

			// Alternate code
   
			$lista = mysql_query("SELECT * FROM domek WHERE Nazwa LIKE '%$nazwa_szukanego_rekordu%' ORDER BY Nazwa ASC LIMIT $na_stronie OFFSET $offset");
   
			}
			
			
			
			//$data = "SELECT * FROM domek LIKE '%$nazwa_szukanego_rekordu%' ORDER BY Nazwa ASC LIMIT $na_stronie OFFSET $offset";

			//$lista = mysql_query($lista);
		
			$liczba_wierszy = @mysql_num_rows($lista);
		
		
		if ($liczba_wierszy > 0)
		{
		while ($row = mysql_fetch_row($lista))
		{
		echo "<table border=1><tr>";
		echo "<td>". $row[1] ."</td>";
		echo "<td>". $row[2] ."</td>";
		echo "</tr></table>";
		}
	
		}
		else
		{
			
		echo "Brak danych w bazie";
			
		}
		}
		}
		
		
	else
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
		
		$liczba_wierszy = @mysql_num_rows($lista);
		
		//echo $liczba_wierszy;
		//koniec pejdżowania
if ($liczba_wierszy > 0)
	{
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
		//Wyjebać
		}
else{
	
	echo "Brak danych do wyświetlenia";
}
}
	

	// Wyjebać

	echo"<br/><br/>";
	echo"<br/><br/>";

	// formularz wyszukaj
	
			echo "<h2>Wyszukaj: </h2><br />";
			echo "<form method='post' action=''>";
			echo "Nazwa: <input type='text' name='nazwa' size='15' /> <br/>";
			echo "<input type='checkbox' name='opis'/> Szukaj w opisach <br/><br/>";
			echo "<input type='submit' name='wyszukaj' value='Wyszukaj' /><br/>";
			echo "</form>";
			
			
			
	echo"<br/><br/>";
	echo"<br/><br/>";
	
	@mysql_data_seek($lista, 0);
	
	echo"<form method='post' action=''>";
	echo"<SELECT name='lista'>";
	echo"<option selected disabled>Wybierz domek</option>";
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
			echo "<input type='submit' name='dodaj' value='Dodaj domek' />";
			echo "</form>";
			
			
		}
		if (isset($_POST['edytuj']))
		{
			//podlaczenie do mysql i wybor danych
			
			if (isset($_POST['lista']))
			{
				
			//echo $_POST['lista'];
			$edytowane =  $_POST['lista'];
			
			
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$edytowany_rekord = mysql_query("SELECT * FROM domek WHERE Nazwa = '$edytowane'");
			
			echo "<h1>Edytuj domek</h1>";
			
			if ($row = mysql_fetch_row($edytowany_rekord))
			{
			echo "<form method='post' action='zatwierdz.php'>";
			echo "Nazwa: <input type='text' name='nazwa' value='". $row[1] ."' size='15' /> <br/><br/>";
			echo "Opis: <input type='text' name='opis' value='". $row[2] ."' size='15' /> <br/><br/>";
			echo"<input type='hidden' name='stara_nazwa' value ='".$row[1]."' />";
			echo"<input type='hidden' name='stary_opis' value ='".$row[2]."' />";
			echo "<input type='submit' name='edytuj' value='Edytuj domek' />";
			echo "</form>";
			}
			
			}
			
				//if (isset($_POST['Edytuj rekord']))
				//{
					
					
					
				//}
			
		}
		if (isset($_POST['usun']))
		{
			
			if (isset($_POST['lista']))
			{
				
			//echo $_POST['lista'];
			$usuwane =  $_POST['lista'];
			
			// pobierz z bazy nazwe ($usuwane) SELECT FROM BASE Nazwa, Opis WHERE Nazwa = '$usuwane' i przeslij te zmienne do formularza / <input type='text' name='nazwa' value "TU ZMIENNA USUWANA" size='15
			
			//$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			//mysql_select_db($db_name);
			
			$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
			mysql_select_db($db_name);
			$usuwany_rekord = mysql_query("SELECT * FROM domek WHERE Nazwa = '$usuwane'");
			
			echo "<h1>Usunąć domek z bazy?</h1>";
			
			if ($row = mysql_fetch_row($usuwany_rekord))
			{
			echo "Nazwa: " .$row[1] ."<br>";	
			echo "Opis: ".$row[2] ."<br>";
			echo "<form method='post' action='zatwierdz.php'>";
			echo "<input type='hidden' name='nazwa' value='". $row[1] ."' size='15' /> <br/><br/>";
			echo "<input type='hidden' name='opis' value='". $row[2] ."' size='15' /> <br/><br/>";
			echo "<input type='submit' name='usun' value='Usuń domek' />";
			echo "</form>";
			}
			
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