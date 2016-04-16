<html>
<head>
<META NAME="robots" CONTENT="noindex, nofollow">
<link rel="shortcut icon" href="dane\favicon.ico">
<link rel="Stylesheet" type="text/css" href="dane\style.css" />
</head>
<body>

<?php

session_start();

if(isset($_SESSION['zalogowany']))
{
header('Location: domki_panel_glowny.php');
}

if (isset($_POST['submit']))
{
if ($_POST['submit'] == 'Zaloguj')
{
$username = ($_POST['username']);
$password = ($_POST['password']);

$password = hash('sha256', $password, false);

require_once('config.php');

$connection=mysql_connect ($db_host, $db_user, $db_pass) or die ("Próba połączenie z bazą danych nie powiodła się. Spróbuj ponownie");
mysql_select_db($db_name);

	if(mysql_num_rows(mysql_query("SELECT username, password FROM users WHERE username = '$username' && password = '$password' ")) > 0)
    {
	
	$sql = "SELECT level FROM users WHERE username = '$username' && password = '$password' ";
	
	$lev = mysql_query($sql);
	//echo $username;
	//echo $password;
	
	$row = mysql_fetch_row($lev);
	$level = $row[0];
	$ip = $_SERVER['REMOTE_ADDR'];
	$obecna_data = date("Y-m-d H:i:s");
	
	$update =	"UPDATE users SET ip_login='$ip', date_login='$obecna_data'
				WHERE username = '$username'";
	$updating = mysql_query($update);
	
		if ( $updating)
		{
			$_SESSION['zalogowany'] = true;
			$_SESSION['username'] = $username;
			$_SESSION['level'] = $level;
			header('Location: domki_panel_glowny.php');
		}
	
	
	
	
		
			  
	
	
	}
	else
	{
	//echo mysql_error();
	$message = '<B>Nieprawidłowy login lub hasło</B>';
	}
}	
//else
//{
//	header('Location: index.php');
//}
}


?>

<div id=site>
<div id=mainsite style ="width: 850px; height: 1000px; top: 100px; left: 100px; position: absolute; border: 1px; border-style: solid; border-color: #ffffff;">
<h2 style='text-align: center; margin-top: 10px;'>Zaloguj się</h2>


<div id=login><form method='POST' action=''> <br/>
<table><tr>
<td><b>nazwa uzytkownika:</b> </td><td><input type='text' name='username'> <br/> </td>
</tr><tr>
<td><b>hasło:</b> </td><td><input type='password' name='password'> <br/> </td>
</tr></table>

<input type='submit' value='Zaloguj' name='submit'> <br/><br/>

<?php
if(isset($message))
{
echo $message;
}
?>
</form>

</div>



</div>
</div>
</body>
</html>
