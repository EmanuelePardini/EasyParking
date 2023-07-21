<html>
<head>
<title>Pagina di registrazione</title>
</head>
<body>
	<?php
		$nome=$_REQUEST['nome'];
		$cognome=$_REQUEST['cognome'];
		$carta=$_REQUEST['carta'];
    $citta=$_REQUEST['citta'];
		$via=$_REQUEST['via'];
		$prov=$_REQUEST['prov'];
		$email=$_REQUEST['email'];
    $password=$_REQUEST['pwd'];
		$pwd = md5($password);
		$data_nasc=$_REQUEST['data_nasc'];
		$diritti="User";
                        $db=mysqli_connect('localhost','root','','db_parcheggio')or
				die ('Errore di comunicazione<br>');
		        $checksql="select*from iscritti where EMAIL='$email'";
		        $scr=mysqli_query($db,$checksql);
                        $nr=mysqli_num_rows($scr);
                        if ($nr>0)
		        {
			        print ("Questo utente è già registrato");
		        }
                        else
                        {
			        $regsql="INSERT INTO iscritti (NOME,COGNOME,CARTA_CREDITO,CITTA,VIA,PROVINCIA,EMAIL,PASSWORD,DATA_NASC, DIRITTI) ".
			        "VALUES ('".$nome."','".$cognome."','".$carta."','".$citta."','".$via."','".$prov."','".$email."','".$pwd."','".$data_nasc."','".$diritti."');";
			        print('Tentativo di registrazione<br>');
			        $scr2=mysqli_query($db,$regsql);
		                if (!$scr2)
		                {
		                	print ("Errore nella registrazione<br>");
											echo("<p><a href='index.php'>Ritorna alla pagina principale</a></p>");
		                }
		                else
		                {
		                header("location: index.php");
		                }
		        }
                        mysqli_close($db);
	?>

</body>

</html>
