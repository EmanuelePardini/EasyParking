<html>
<head>
<title>Prenotazione</title>
</head>
<body>
	<?php
  session_start();
	$error=false;
		$data=$_REQUEST['parking-time'];
		$veicolo=$_REQUEST['veicolo'];
    $targa=$_REQUEST['targa'];
		$parcheggio=$_REQUEST['parcheggio'];
		$pagamento=$_REQUEST['pagamento'];
    $email=$_SESSION['email'];

		$db=mysqli_connect('localhost','root','','db_parcheggio')or
die ('Errore di comunicazione<br>');
//ACQUISIZIONE CHIAVI
        $id_iscr_sql="select ID_ISCR from iscritti where EMAIL='$email'";
        $id_iscr_scr=mysqli_query($db, $id_iscr_sql);
				$id_iscr_conv=mysqli_fetch_array($id_iscr_scr,MYSQLI_NUM);
				$id_iscr=$id_iscr_conv[0];
        $id_par_sql="select ID_PAR from parcheggio where VIA_PAR='$parcheggio'";
        $id_par_scr=mysqli_query($db, $id_par_sql);
				$id_par_conv=mysqli_fetch_array($id_par_scr,MYSQLI_NUM);
				$id_par=$id_par_conv[0];
        $id_pag_sql="select ID_PAG from pagamenti where TIPOLOGIA='$pagamento'";
        $id_pag_scr=mysqli_query($db, $id_pag_sql);
				$id_pag_conv=mysqli_fetch_array($id_pag_scr,MYSQLI_NUM);
				$id_pag=$id_pag_conv[0];
//CONTROLLO PRENOTAZIONE EFFETTUATA
$checksql="select*from prenotazione where TARGA='$targa' and DATA_ORA='$data'";
		        $scr=mysqli_query($db,$checksql);
                        $nr1=mysqli_num_rows($scr);
                        if ($nr1>0)
		        {
			        print ("Prenotazione già effettuata");
							$error=true;
							echo("<p><a href='area_user.php'>Ritorna all'area personale'</a></p>");
		        }

						if($veicolo=="auto"){
							$num_par_sql="select N_P_NORM from parcheggio where ID_PAR='$id_par'";
							$num_par_scr=mysqli_query($db, $num_par_sql);
							$num_par_conv=mysqli_fetch_array($num_par_scr,MYSQLI_NUM);
	            $num_par=$num_par_conv[0];
							$sezione="A";
						}
						else if($veicolo=="moto"){
							$num_par_sql="select N_P_MOTO from parcheggio where ID_PAR='$id_par'";
							$num_par_scr=mysqli_query($db, $num_par_sql);
							$num_par_conv=mysqli_fetch_array($num_par_scr,MYSQLI_NUM);
	            $num_par=$num_par_conv[0];
							$sezione="B";
						}
						else if($veicolo=="guida con disabilità"){
							$num_par_sql="select N_P_DIS from parcheggio where ID_PAR='$id_par'";
							$num_par_scr=mysqli_query($db, $num_par_sql);
							$num_par_conv=mysqli_fetch_array($num_par_scr,MYSQLI_NUM);
	            $num_par=$num_par_conv[0];
							$sezione="C";
						}
//CONTROLLO DISPONIBILITA' POSTI
		$giorno= split("\ ", $data);
		$num_pre_sql="select COUNT(*) from prenotazione where (ID_PAR_EK='$id_par' and DATA_ORA like'$giorno[0]%')";
						$num_pre_scr=mysqli_query($db, $num_pre_sql);
						$num_pre_conv=mysqli_fetch_array($num_pre_scr,MYSQLI_NUM);
						$num_pre=$num_pre_conv[0];
if($num_pre >= $num_par){
print("Il parcheggio è pieno");
$error=true;
echo("<p><a href='area_user.php'>Ritorna all'area personale'</a></p>");
}
//CONTROLLO PAGAMENTI
if($id_pag=="6"){
	$id_abb_sql="select* from abbonati where (ID_ISCR_EK='$id_iscr')";
	$id_abb_scr=mysqli_query($db, $id_abb_sql);
	$nr2=mysqli_num_rows($id_abb_scr);
if ($nr2<1)
{
print("Pagamento non accettato");
print("Effettua prima l'abbonamento");
$error=true;
echo("<p><a href='mod_abbonamento.html'>Effettua l'abbonamento'</a></p>");
}
}
//EFFETTUAZIONE PRENOTAZIONE
                        if($error==false)
                        {
			        $reg_pre_sql="INSERT INTO prenotazione (ID_PAR_EK,ID_PAG_EK,ID_ISCR_EK,TARGA,DATA_ORA,TIPO_MEZZO) ".
			        "VALUES ('".$id_par."','".$id_pag."','".$id_iscr."','".$targa."','".$data."','".$veicolo."');";
			        print('Tentativo di prenotazione<br>');
			        $pre_scr=mysqli_query($db,$reg_pre_sql);
		                if (!$pre_scr)
		                {
		                	print ("Errore nella prenotazione<br>");
											echo("<p><a href='area_user.php'>Ritorna all'area personale</a></p>");
		                }
		                else
		                {
											//EFFETTUAZIONE PAGAMENTO
											if($id_pag==2){
											$carta_sql="select CARTA_CREDITO from iscritti where EMAIL='$email'";
											$carta_scr=mysqli_query($db, $carta_sql);
											$carta_conv=mysqli_fetch_array($carta_scr,MYSQLI_NUM);
											$carta=$carta_conv[0];
														        print("Pagamento effettuato con la carta:<br>". $carta);

											}
											if($id_pag==1){
												$cod_pre_sql="select ID_PRE from prenotazione where DATA_ORA='$data' and ID_ISCR_EK='$id_iscr'";
												$cod_pre_scr=mysqli_query($db, $cod_pre_sql);
												$cod_pre_conv=mysqli_fetch_array($cod_pre_scr,MYSQLI_NUM);
												$cod_pre=$cod_pre_conv[0];
												echo("Presenta il seguente codice prenotazione al casello:<br>". $cod_pre);
											}
											if($id_pag==6){
												$id_abb_conv=mysqli_fetch_array($id_abb_scr,MYSQLI_NUM);
												$id_abb=$id_abb_conv[0];
											echo("Presenta il seguente codice abbonamento al casello: ". $id_abb);
											}
											echo("<p><a href='area_user.php'>Ritorna all'area personale</a></p>");
											}
		                }
$posto_par= $num_par - $num_pre;
	echo("<br> La locazione del tuo parcheggio è: ". $posto_par.$sezione);
mysqli_close($db);
	?>

</body>
</html>
