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
		
		if (isset($_POST['zaakceptuj'])) // jeśli kliknięto przycisk zaakceptuj
		{
			
			if (isset($_POST['lista'])) // jeśli wybrano domek
			{
			$wybrany_domek =  $_POST['lista']; // przypisz zmienne
			$id_zamowienia =  $_POST['id'];
			$imie =  $_POST['imie'];
			$nazwisko =  $_POST['nazwisko'];
			$tel =  $_POST['telefon'];
			$uwagi =  $_POST['uwagi'];
			//echo $wybrany_domek;
			echo $imie."<br>";
			echo $nazwisko;
			
			
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				//$wybrany_rekord = ""; // wybierz rekord do wyświetlenia
				//mysql_query($wybrany_rekord);
				// CALL PROCEDURE Nowa_rezerwacja (nazwy zmiennych)
				
				
			// CREATE PROCEDURE Nowa_rezerwacja (IN Domek varchar(30), IN Imie varchar(20), IN Nazwisko VARCHAR(50), IN Telefon int(9), IN Ilosc_dni int(11), IN ID int)

				
				$sql="CALL Nowa_rezerwacja('$wybrany_domek', '$imie', '$nazwisko', $tel, $uwagi, $id_zamowienia)";

				$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
				
				
				if ( $results  ) //jeśli powiodło się
					{
						
						$message = "Dodano nową rezerwację";
						
						
					}

				
				
			}
			else //...a jeśli nie
			{ 
				
				$message = "Wybierz domek kurwiu"; //wyświetl komunikat

				
				

			}
			
			
		}
		elseif (isset($_POST['usun'])) // jeśli kliknięto przycisk usuń
		{
			
			if (isset($_POST['lista'])) // jeśli wybrano domek
			{
			$wybrany_domek =  $_POST['lista']; // przypisz zmienne
			$id_zamowienia =  $_POST['id'];
			//echo $wybrany_domek."<br><br>";
			//echo $$id_zamowienia;
			
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				//$wybrany_rekord = ""; // wybierz rekord do wyświetlenia
				//mysql_query($wybrany_rekord);
				// CALL PROCEDURE Nowa_rezerwacja (nazwy zmiennych)
				
				$sql="DELETE from zamowienia WHERE ID = '$id_zamowienia' AND domek='$wybrany_domek'";

					
					
				$results=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());

					
					if ( $results  ) //jeśli powiodło się
					{
						
						$message = "Usunięto zamówienie";
						
						
					}
					
			}
			else //...a jeśli nie
			{ 
				
				$message = "Wybierz domek kurwiu"; //wyświetl komunikat

				
				

			}
			
		}
		
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
				
			}
			else{
				
				echo "Brak danych do wyświetlenia";
			}
			
				@mysql_data_seek($lista, 0); // powrót na początek listy
		
				If (!empty($lista)) //jeśli zmienna $lista nie jest pusta
				{
				echo"<form method='post' action=''>";
				echo"<SELECT name='lista'>";
				echo"<option selected disabled>Wybierz domek</option>";
				while ($row2 = mysql_fetch_row($lista))
				{
					echo "<option value='". $row2[1] ."'>". $row2[1] ."</option>";  //pole domek
				}
				echo"</SELECT>";
				@mysql_data_seek($lista, 0); // powrót na początek listy

				while ($row3 = mysql_fetch_row($lista))
				{
					echo "<input type=hidden name=id_domku value='". $row3[5] ."'>";  //pole uwagi
					echo "<input type=hidden name=id value='". $row3[0] ."'>";  //pole id_zamówienia
					echo "<input type=hidden name=imie value='". $row3[2] ."'>";  //pole imie
					echo "<input type=hidden name=nazwisko value='". $row3[3] ."'>";  //pole nazwisko
					echo "<input type=hidden name=telefon value='". $row3[4] ."'>";  //pole telefon
					echo "<input type=hidden name=uwagi value='". $row3[5] ."'>";  //pole uwagi
				}
				echo"<input type='submit' name='zaakceptuj' value='Zaakceptuj' />";
				echo"<input type='submit' name='usun' value='Usuń' />";
				echo"<br/><br/>";
				echo $message;
				echo"</form>";
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