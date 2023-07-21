<html>
<head>
<title>Pagina di registrazione</title>
</head>
<body>
	<?php
	session_start();
	 $_SESSION["email"] = $_POST['email'];
	 $_SESSION["pwd"] = $_POST['pwd'];
		$email=$_SESSION['email'];
    $password=$_SESSION['pwd'];
		$pwd = md5($password);
                        $db=mysqli_connect('localhost','root','','db_parcheggio')or
				die ('Errore di comunicazione<br>');
		        $checksql="select*from iscritti where EMAIL='$email' and PASSWORD='$pwd'";
		        $scr=mysqli_query($db,$checksql);
                        $nr=mysqli_num_rows($scr);
                        if ($nr>0)
		        {
			        print ("Accesso effettuato");
$rightsql="select*from iscritti where DIRITTI='User' and EMAIL='$email'";
$scr2=mysqli_query($db,$rightsql);
$nr2=mysqli_num_rows($scr2);
if($nr2>0){
	header("location: area_user.php");
}
else{
	header("location: area_admin.php");
}

		        }
                        else
                        {
print ("Credenziali errate");
echo("<p><a href='index.php'>Ritorna alla pagina principale</a></p>");
		        }
                        mysqli_close($db);
	?>

</body>

</html>
