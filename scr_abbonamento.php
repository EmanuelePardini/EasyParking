<html>
<head>
<title>Abbonamento</title>
</head>
<body>
	<?php
  session_start();
	$error=false;
		$abbonamento=$_REQUEST['abbonamento'];
		$carta=$_REQUEST['carta'];
		$data_iniz=$_REQUEST['validita'];
    $email=$_SESSION['email'];
		$db=mysqli_connect('localhost','root','','db_parcheggio')or
die ('Errore di comunicazione<br>');
//ACQUISIZIONE CHIAVI
        $id_iscr_sql="select ID_ISCR from iscritti where EMAIL='$email'";
        $id_iscr_scr=mysqli_query($db, $id_iscr_sql);
				$id_iscr_conv=mysqli_fetch_array($id_iscr_scr,MYSQLI_NUM);
				$id_iscr=$id_iscr_conv[0];
//CONTROLLO ABBONAMENTO EFFETTUATO
$checksql="select*from abbonati where ID_ISCR_EK='$id_iscr'";
		        $scr=mysqli_query($db,$checksql);
                        $nr1=mysqli_num_rows($scr);
                        if ($nr1>0)
		        {
			        print ("Sei già abbonato");
							echo("<p><a href='area_user.php'>Ritorna all'area personale'</a></p>");
							$error=true;
		        }
//CONTROLLO PAGAMENTO
						$checksql1="select*from iscritti where ID_ISCR='$id_iscr' and CARTA_CREDITO='$carta'";
								        $scr1=mysqli_query($db,$checksql1);
						                        $nr2=mysqli_num_rows($scr1);
						                        if ($nr2<1)
								        {
									        print ("Numero della carta errato");
													echo("<p><a href='area_user.php'>Ritorna all'area personale'</a></p>");
													$error=true;
								        }
//EFFETTUAZIONE
$nuovadata= split("\-", $data_iniz);
if($error==false){
						if($abbonamento=="Abbonamento annuale"){
							$nuovadata[3]=$nuovadata[0]+ 1;
							$scad="$nuovadata[3]-$nuovadata[1]-$nuovadata[2]";
							$abb_sql="INSERT INTO abbonati (DATA_INIZ,SCADENZA,ID_ISCR_EK) ".
						  "VALUES ('".$data_iniz."','".$scad."','".$id_iscr."');";

						}
						else if($abbonamento=="Abbonamento semestrale"){
							$nuovadata[3]=$nuovadata[1]+ 6;
							$scad="$nuovadata[0]-$nuovadata[3]-$nuovadata[2]";
							if($nuovadata[3]>12){
                $nuovadata[4]=$nuovadata[0] + 1;
								$nuovadata[3]=$nuovadata[3]-12;
								$scad="$nuovadata[4]-$nuovadata[3]-$nuovadata[2]";
							}
							$abb_sql="INSERT INTO abbonati (DATA_INIZ,SCADENZA,ID_ISCR_EK) ".
						  "VALUES ('".$data_iniz."','".$scad."','".$id_iscr."');";
						}
						else if($abbonamento=="Abbonamento mensile"){
							$nuovadata[3]=$nuovadata[1]+ 1;
							$scad="$nuovadata[0]-$nuovadata[3]-$nuovadata[2]";
							if($nuovadata[3]>12){
								$nuovadata[4]==$nuovadata[0] + 1;
								$nuovadata[3]=$nuovadata[3]-12;
			          $scad="$nuovadata[4]-$nuovadata[3]-$nuovadata[2]";
							}

							$abb_sql="INSERT INTO abbonati (DATA_INIZ,SCADENZA,ID_ISCR_EK) ".
						  "VALUES ('".$data_iniz."','".$scad."','".$id_iscr."');";

						}



						$abb_scr=mysqli_query($db,$abb_sql);
						if (!$abb_scr)
						{
							print ("Errore nella prenotazione<br>");
							echo("<p><a href='area_user.php'>Ritorna all'area personale'</a></p>");
						}
						else
						{
							print("Prenotazione effettuata con successo!");
							echo("<p><a href='area_user.php'>Ritorna all'area personale'</a></p>");
							}}

                        mysqli_close($db);
	?>

</body>
</html>
