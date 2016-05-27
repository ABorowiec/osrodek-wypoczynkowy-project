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
				//$wybrany_domek =  $_POST['lista']; // przypisz zmienne
				//$id_zamowienia =  $_POST['id'];
				//$imie =  $_POST['imie'];
				//$nazwisko =  $_POST['nazwisko'];
				//$tel =  $_POST['telefon'];
				//$uwagi =  $_POST['uwagi'];
				
				//echo $wybrany_domek;
				//echo $imie."<br>";
				//echo $nazwisko;
				
				//$ilosc = count($wybrany_domek);
				
				//for($i=0; $i < $ilosc; $i++)
				//{
				//	echo($wybrany_domek [$i] . "<br> ");
				//}
				
				
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				
				
				// echo "<table border=1><tr>";
				// echo "<td><b>Domek</b></td>";
				// echo "<td><b>Imię klienta</b></td>";
				// echo "<td><b>Nawisko klienta</b></td>";
				// echo "<td><b>Numer tel</b></td>";
				// echo "<td><b>Okres</b></td>";
				// echo "<td><b>Do akc.</b></td>";
				// echo "</tr>";
				
				
				foreach($_POST['lista'] as $wybrane_do_akceptacji)
				{
					
		
					
					
					$data = "SELECT zamowienia.*, domek.Nazwa FROM zamowienia, domek WHERE zamowienia.ID = $wybrane_do_akceptacji AND zamowienia.ID_Domek = domek.ID ORDER BY zamowienia.ID ASC";
					//$data = "SELECT zamowienia.*, domek.Nazwa FROM zamowienia, domek WHERE zamowienia.ID_Domek = domek.ID ORDER BY zamowienia.ID ASC LIMIT $na_stronie OFFSET $offset";
					$results=mysql_query($data) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
					
					echo "<table border = 1>";
					echo "<tr><td>Wybrany domek</td>";
					echo "<td>Imię</td>";
					echo "<td>Nazwisko</td>";
					echo "<td>Telefon</td>";
					echo "<td>Ilość dni</td></tr>";
					//echo $id_zamowienia."<br>";
			
			while ($row =  mysql_fetch_row($results))
			{
				
						$wybrany_domek =  $row[6]; // przypisz zmienne
						$id_zamowienia =  $row[0];
						$imie =  $row[2];
						$nazwisko =  $row[3];
						$tel =  $row[4];
						$uwagi =  $row[5];
						
						// echo $wybrany_domek."<br>";
						// echo $imie."<br>";
						// echo $nazwisko."<br>";
						// echo $tel."<br>";
						// echo $uwagi."<br>";
						// echo $id_zamowienia."<br>";
				
						$sql="CALL Nowa_rezerwacja('$wybrany_domek', '$imie', '$nazwisko', $tel, $uwagi, $id_zamowienia)";
						$results2=mysql_query($sql) or die ('Wykonanie proc nie powodło sie. Błąd:' .mysql_error());
						echo "<tr><td>". $row[6] ."</td>";
						echo "<td>". $row[2] ."</td>";
						echo "<td>". $row[3] ."</td>";
						echo "<td>". $row[4] ."</td>";
						echo "<td>". $row[5] ."</td>";
						//echo "<td><b>".$wybrane_do_akceptacji."</b></td>";
						echo "</tr>";
				
			}
			
					
				
				
				echo "</table>";
				
				echo "<br/><br/>";
				
				
				
				
				// CREATE PROCEDURE Nowa_rezerwacja (IN Domek varchar(30), IN Imie varchar(20), IN Nazwisko VARCHAR(50), IN Telefon int(9), IN Ilosc_dni int(11), IN ID int)

				
				
				
				
				// if ( $results2  ) //jeśli powiodło się
				// {
					// mysql_data_seek($results2, 0); // powrót na początek listy
					// $message = "<br/><br/>Dodano nową rezerwację:<br/></br/>";
					
					
				// $message .= "<table border=1><tr>
				// <td><b>Domek</b></td>
				// <td><b>Imię klienta</b></td>
				// <td><b>Nawisko klienta</b></td>
				// <td><b>Numer tel</b></td>
				// <td><b>Okres</b></td>
				// </tr>";
				
				
				// foreach($_POST['lista'] as $wybrane_do_akceptacji)
				// {
					
		
					
					
					// $data = "SELECT zamowienia.*, domek.Nazwa FROM zamowienia, domek WHERE zamowienia.ID = $wybrane_do_akceptacji AND zamowienia.ID_Domek = domek.ID ORDER BY zamowienia.ID ASC";
					// //$data = "SELECT zamowienia.*, domek.Nazwa FROM zamowienia, domek WHERE zamowienia.ID_Domek = domek.ID ORDER BY zamowienia.ID ASC LIMIT $na_stronie OFFSET $offset";
					// $results=mysql_query($data) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
					
			
				
			
			// while ($row =  mysql_fetch_row($results))
			// {
				
						// $message .="<tr><td>". $row[6] ."</td>
						// <td>". $row[2] ."</td>
						// <td>". $row[3] ."</td>
						// <td>". $row[4] ."</td>
						// <td>". $row[5] ."</td>
						// </tr>";
				
			// }
			
					
				// }
				
				// $message .= "</table>";
					
					
				// }

				
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
				//$id_zamowienia =  $_POST['lista']; // przypisz zmienne
				
				
				$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie"); //połącz z bazą/wyświetl błąd
				mysql_select_db($db_name); //wybierz bazę
				//$wybrany_rekord = ""; // wybierz rekord do wyświetlenia
				//mysql_query($wybrany_rekord);
				// CALL PROCEDURE Nowa_rezerwacja (nazwy zmiennych)
				
				//$ilosc = count($id_zamowienia);
				
				//for($i=0; $i < $ilosc; $i++)
				//{
				//	$sql="DELETE from zamowienia WHERE ID = '$id_zamowienia[$i]'";
					//echo($wybrany_domek [$i] . "<br> ");
				//}
				
				
				//$sql="DELETE from zamowienia WHERE ID = '$id_zamowienia' AND ID_DOMEK='$wybrany_domek'";

				
				foreach($_POST['lista'] as $wybrane_do_usuniecia)
				{
					
					$sql="DELETE from zamowienia WHERE ID = $wybrane_do_usuniecia";
					$results3=mysql_query($sql) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error());
					
					
					// if ($results3) //jeśli powiodło się
					// {
						
						// mysql_data_seek($results3, 0);
						
						// while ($row =  mysql_fetch_row($results3))
							// {
				
								// $message .="<br><br>Usunięto zamówienie nr: ". $row[0]
								// ;
				
							
					
						// // $message = "Usunięto zamówienie nr: <br><br>";
						// // $message .= "<table border=1><tr>
						// // <td><b>Nr zam</b></td>
						// // </tr>";
						
						// // //mysql_data_seek($results, 0); // powrót na początek listy
					
				
					
							// // while ($row =  mysql_fetch_row($results))
							// // {
				
								// // $message .="<tr><td>". $row[0] ."</td>
								// // </tr>";
				
							// // }
			
					
				
				
					// // $message .= "</table>";
					
					
						// }
					
				// }
				
				
				

				
				// if ( $results  ) //jeśli powiodło się
				// {
					
					// mysql_data_seek($results, 0); // powrót na początek listy
					// $message = "Usunięto zamówienie nr: <br><br>";
				
					// $message .= "<table border=1><tr>
					// <td><b>Nr zam</b></td>
					// </tr>";
					
							// while ($row =  mysql_fetch_row($results))
							// {
				
								// $message .="<tr><td>". $row[0] ."</td>
								// </tr>";
				
							// }
			
					
				
				
				// $message .= "</table>";
					
					
				// }
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

		
		$data = "SELECT zamowienia.*, domek.Nazwa FROM zamowienia, domek WHERE zamowienia.ID_Domek = domek.ID ORDER BY zamowienia.ID ASC LIMIT $na_stronie OFFSET $offset";
		//$data = "SELECT zamowienia.*, domek.ID FROM zamowienia, domek RIGHT JOIN domek ON zamowienia.ID_Domek = domek.ID  ORDER BY zamowienia.ID ASC LIMIT $na_stronie OFFSET $offset";

		$lista = mysql_query($data);
		
		$liczba_wierszy = @mysql_num_rows($lista);
		
		//echo $liczba_wierszy;
		//koniec pejdżowania
		if ($liczba_wierszy > 0)
		{
			
			echo"<form method='post' action=''>";
			
			echo "<table border=1><tr>";
			echo "<td><b>Nr zam</b></td>";
			echo "<td><b>Domek</b></td>";
			echo "<td><b>Imię klienta</b></td>";
			echo "<td><b>Nawisko klienta</b></td>";
			echo "<td><b>Numer tel</b></td>";
			echo "<td><b>Okres</b></td>";
			//echo "<td><b>Temp</b></td>";
			//echo "<td><b>Temp2</b></td>";
			echo "<td><b>Zatwierdź</b></td></tr>";
			
				
			
			while ($row =  mysql_fetch_row($lista))
			{
				
				echo "<tr><td>". $row[0] ."</td>";
				echo "<td>". $row[6] ."</td>";
				echo "<td>". $row[2] ."</td>";
				echo "<td>". $row[3] ."</td>";
				echo "<td>". $row[4] ."</td>";
				echo "<td>". $row[5] ."</td>";
				//echo "<td>". $row[6] ."</td>";
				//echo "<td>". $row[7] ."</td>";
				echo "<td>"; 
				//$row[0]
				echo "<input type='checkbox' name='lista[]' value='".$row[0]."'>";
				echo "</td></tr>";
				
			}
			echo "</table>";
			
			echo"<br/><br/>";
			//echo"<br/><br/>";
			
			echo"<input type='submit' name='zaakceptuj' value='Zaakceptuj' />";
			echo"<input type='submit' name='usun' value='Usuń' />";
			
			echo"<br/><br/>";
			echo"<br/><br/>";
			
			//echo $message;
			
			
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
			
			echo "Brak nowych zamówień do wyświetlenia<br>";
		}
		
		echo $message;
		
		// mysql_data_seek($lista, 0); // powrót na początek listy
		
		// If (!empty($lista)) //jeśli zmienna $lista nie jest pusta
		// {
			// echo"<form method='post' action=''>";
			// echo"<SELECT name='lista'>";
			// echo"<option selected disabled>Wybierz domek</option>";
			// while ($row2 =  mysql_fetch_row($lista))
			// {
				// echo "<option value='". $row2[1] ."'>". $row2[1] ."</option>";  //pole domek
			// }
			// echo"</SELECT>";
			// mysql_data_seek($lista, 0); // powrót na początek listy

			// //while ($row3 =  mysql_fetch_row($lista)) //nie działaaaaaaaaaaaaaaaaaaaaaaaaaaa
			// //{
				// //echo "<input type=hidden name=id_domku value='". $row2[1] ."'>";  //id_domku
				// echo "<input type=hidden name=nazwa_domku value='". $row2[1] ."'>";  //nazwa_domku poprawić nr rowa
				// echo "<input type=hidden name=id value='". $row2[0] ."'>";  //pole id_zamówienia
				// echo "<input type=hidden name=imie value='". $row2[2] ."'>";  //pole imie
				// echo "<input type=hidden name=nazwisko value='". $row2[3] ."'>";  //pole nazwisko
				// echo "<input type=hidden name=telefon value='". $row2[4] ."'>";  //pole telefon
				// echo "<input type=hidden name=uwagi value='". $row2[5] ."'>";  //pole uwagi
			// //}
			// echo"<input type='submit' name='zaakceptuj' value='Zaakceptuj' />";
			// echo"<input type='submit' name='usun' value='Usuń' />";
			// echo"<br/><br/>";
			// echo $message;
			// echo"</form>";
		// }
		
		
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