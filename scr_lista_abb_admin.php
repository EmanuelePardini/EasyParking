<html>
<head>
<title>Lista abbonati</title>
</head>
<body>
	<?php
  session_start();
  $db=mysqli_connect('localhost','root','','db_parcheggio')or
die ('Errore di comunicazione<br>');
    $id_iscr_sql="select ID_ISCR from iscritti order by NOME";
    		        $id_iscr_scr=mysqli_query($db,$id_iscr_sql);
                $counter=0;
								print("ID_ISCRITTO / NOME / COGNOME / CARTA DI PAGAMENTO / DATA DI ISCRIZIONE / DATA DI SCADENZA<br>");
                while($id_abb=mysqli_fetch_array($id_iscr_scr,MYSQLI_NUM))
                {
                  $checksql="select*from abbonati where ID_ISCR_EK='$id_abb[$counter]'";
					        $scr=mysqli_query($db,$checksql);
			                        $nr=mysqli_num_rows($scr);
									if($nr>0){

										print($id_abb[$counter]);
										print(" / ");

										$nome_sql="select NOME from iscritti where ID_ISCR='$id_abb[$counter]'";
										$nome_scr=mysqli_query($db, $nome_sql);
										$nome_conv=mysqli_fetch_array($nome_scr,MYSQLI_NUM);
										$nome=$nome_conv[0];

										print($nome);
										print(" / ");

										$cognome_sql="select COGNOME from iscritti where ID_ISCR='$id_abb[$counter]'";
										$cognome_scr=mysqli_query($db, $cognome_sql);
										$cognome_conv=mysqli_fetch_array($cognome_scr,MYSQLI_NUM);
										$cognome=$cognome_conv[0];

										print($cognome);
										print(" / ");

										$carta_sql="select CARTA_CREDITO from iscritti where ID_ISCR='$id_abb[$counter]'";
										$carta_scr=mysqli_query($db, $carta_sql);
										$carta_conv=mysqli_fetch_array($carta_scr,MYSQLI_NUM);
										$carta=$carta_conv[0];

										print($carta);
										print(" / ");

										$data_iniz_sql="select DATA_INIZ from abbonati where ID_ISCR_EK='$id_abb[$counter]'";
										$data_iniz_scr=mysqli_query($db, $data_iniz_sql);
										$data_iniz_conv=mysqli_fetch_array($data_iniz_scr,MYSQLI_NUM);
										$data_iniz=$data_iniz_conv[0];

										print($data_iniz);
										print(" / ");

										$scad_sql="select SCADENZA from abbonati where ID_ISCR_EK='$id_abb[$counter]'";
										$scad_scr=mysqli_query($db, $scad_sql);
										$scad_conv=mysqli_fetch_array($scad_scr,MYSQLI_NUM);
										$scad=$scad_conv[0];

										print($scad);
										print("<br>");
									}
$counter=$counter++;
                            }
                echo("<p><a href='area_admin.php'>Ritorna all'area amministrativa</a></p>");
                mysqli_close($db);
                ?>
</body>
</html>
