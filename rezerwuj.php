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


if (isset($_POST['rezerwuj']))
{
	
	if ((!empty($_POST['lista'])) and (!empty($_POST['imie'])) and (!empty($_POST['nazwisko'])) and (!empty($_POST['telefon'])) and (!empty($_POST['okres'])))
	{
		//$nazwa_domku = $_POST['lista']; //przypisz zmienne
		$id_domku = $_POST['lista'];
		$imie_klienta = $_POST['imie'];
		$nazwisko_klienta = $_POST['nazwisko'];
		$telefon = $_POST['telefon'];
		$uwagi = $_POST['okres'];
		//echo $uwagi;
		//echo $id_domku;
		
		if ((is_numeric($telefon)) and (is_numeric($uwagi)))
	{
		
		$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
		mysql_select_db($db_name);
		
		
		// if(mysql_num_rows(mysql_query("SELECT Telefon FROM klient WHERE Telefon = '$telefon' ")) == 0) //jeśli w bazie występuje  (ilość > 0)...
		// {
			
		$dodawane = "INSERT INTO zamowienia (ID_Domek, Imie, Nazwisko, Telefon, Uwagi) VALUES ($id_domku, '$imie_klienta', '$nazwisko_klienta', '$telefon', '$uwagi')"; //wstaw nowy rekord
		$results=mysql_query($dodawane) or die ('Wykonanie zapytania nie powodło sie. Błąd:' .mysql_error()); //zatwierdź komendę lub wyświetl błąd
			
			
			if ( $results) //jeśli operacja została wykonana pomyślnie...
			{
				
				$message = "Wysłano zamówienie"; //...wyświetl komunikat
				
			}
			
		// }
		// else
		// {
			
			// $message = "Taki telefon już istnieje w bazie..."; //...wyświetl komunikat
			
			}
			else{
				
				$message = "Telefon lub ilość dni nie jest liczbą"; //...wyświetl komunikat
				
			}
		// }
	}
	else
	{
		
		$message = "Nie wypełniono wszystkich pól"; //...wyświetl komunikat
		
	}
	
}


echo "<h2 style='text-align: center; margin-top: 10px;'>Zarezerwuj domek</h2>";


$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
mysql_select_db($db_name);
$wszystkie = mysql_query("SELECT * FROM domek ORDER BY Rezerwacja ASC");

//pejdżowanie

$ilosc = mysql_num_rows($wszystkie);

$na_stronie = 5;


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



$data = "SELECT * FROM domek ORDER BY Rezerwacja ASC LIMIT $na_stronie OFFSET $offset";

$lista = mysql_query($data);

$liczba_wierszy = @mysql_num_rows($lista);

//echo $liczba_wierszy;
//koniec pejdżowania



if ($liczba_wierszy > 0)
{
	echo "<table border=1><tr>";
	echo "<td><b>Nazwa</b></td>";
	echo "<td><b>Opis</b></td>";
	echo "<td><b>Cena</b></td>";
	echo "<td><b>Zarezerwowany</b></td></tr>";
	while ($row = mysql_fetch_row($lista))
	{
		
		echo "<tr><td>". $row[1] ."</td>";
		echo "<td>". $row[2] ."</td>";
		echo "<td>". $row[4] ."</td>";
		
		if ($row[3] == 0) //pobiera wartość rezerwacji i aamienia ją na wartość logiczną
		{ 
			
			$rezerwacja = "Nie";
			
		}	
		elseif ($row[3]	== 1)
		{
			$rezerwacja = "Tak";
			
		}
		
		
		echo "<td>". $rezerwacja ."</td></tr>";

	}
	echo "</table>";
	
	echo"<br/><br/>";
	echo"<br/><br/>";
	
	if ($ilosc > 5)
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
	
	$data = "SELECT ID, Nazwa FROM domek WHERE Rezerwacja = 0 ORDER BY Nazwa ASC";

	$do_rezerwacji= mysql_query($data);
	
	$liczba_w = @mysql_num_rows($do_rezerwacji);
	
	echo"<br/><br/>";
	
	echo "<br/>Wolnych domków: ".$liczba_w."<br/>";
	
	//echo"<br/><br/>";
	echo"<br/><br/>";
	
	//mysql_data_seek($do_rezerwacji, 0);
	
	If ((!empty($do_rezerwacji)) AND ($liczba_w != 0)) //jeśli zmienna $lista nie jest pusta
	{
		echo"<form method='post' action=''>";
		echo"<SELECT name='lista'>";
		echo"<option selected disabled>Wybierz domek</option>";
		while ($row = mysql_fetch_row($do_rezerwacji))
		{
			echo "<option value='". $row[0] ."'>". $row[1] ."</option>";
			
		}
		echo"</SELECT><br/><br/>";
		
		//mysql_fetch_field($do_rezerwacji, 0); // powrót na początek listy nie działaaaaaaaaaaaaaaaaaaaaaaaaaa
		
		//mysql_data_seek($do_rezerwacji, 0); // powrót na początek listy nie działaaaaaaaaaaaaaaaaaaaaaaaaaa
		
		//while ($row2 = mysql_fetch_row($do_rezerwacji)) //nie działaaaaaaaaaaaaaaaaaaaaaaaaaaa
		//{
		//echo "<input type=hidden name=id_domku value='". $row[0] ."'>";  //pole ID
		//}
		echo "Imię: <input type='text' name='imie' size='15' /> <br/>";
		//echo"<br/><br/>";
		
		echo "Nazwisko: <input type='text' name='nazwisko' size='15' /> <br/> ";
		//echo"<br/><br/>";
		
		echo "Numer tel: <input type='text' name='telefon' size='15' /> <br/>";
		//echo"<br/><br/>";
		
		echo "Ilość dni: <input type='text' name='okres' size='15' /> <br/><br/>";
		//echo"<br/><br/>";
		
		echo"<input type='submit' name='rezerwuj' value='Rezerwuj' /><br/>";
		echo"</form>";
		
		echo $message;
		
		//echo $row[1];
		
		// while ($row2 = mysql_fetch_row($do_rezerwacji)) //nie działaaaaaaaaaaaaaaaaaaaaaaaaaaa
		// {
			// echo $row2[0] ."<br>";  //pole ID
		// }
		
		
		
	}
	else{
		
		echo "Brak domków do rezerwacji";
		
	}
	
	
}
else{
	
	echo "Brak danych do wyświetlenia";
}



?>


</div>

<div id=footer>
<center><a href='index.php'>Powrót na stronę główną</a></center>
</div>

</div>
</body>
</html>