<html>
<head>
<title>Prenotazioni effettuate</title>
</head>
<body>
	<?php
  session_start();
  $db=mysqli_connect('localhost','root','','db_parcheggio')or
die ('Errore di comunicazione<br>');
    $email=$_SESSION['email'];
    $id_iscr_sql="select ID_ISCR from iscritti where EMAIL='$email'";
    $id_iscr_scr=mysqli_query($db, $id_iscr_sql);
    $id_iscr_conv=mysqli_fetch_array($id_iscr_scr,MYSQLI_NUM);
    $id_iscr=$id_iscr_conv[0];
    $riep_sql="select* from prenotazione where ID_ISCR_EK='$id_iscr'";
    		        $riep_scr=mysqli_query($db,$riep_sql);
                $counter=0;
                while($pre=mysqli_fetch_array($riep_scr,MYSQLI_NUM))
                {
print("CODICE: ");
print($pre[$counter]);
print(" / ");

$targa_sql="select TARGA from prenotazione where ID_PRE='$pre[$counter]'";
$targa_scr=mysqli_query($db, $targa_sql);
$targa_conv=mysqli_fetch_array($targa_scr,MYSQLI_NUM);
$targa=$targa_conv[0];

print("TARGA: ");
print($targa);
print(" / ");

$data_sql="select DATA_ORA from prenotazione where ID_PRE='$pre[$counter]'";
$data_scr=mysqli_query($db, $data_sql);
$data_conv=mysqli_fetch_array($data_scr,MYSQLI_NUM);
$data=$data_conv[0];

print("DATA: ");
print($data);
print(" / ");

$id_par_sql="select ID_PAR_EK from prenotazione where ID_PRE='$pre[$counter]'";
$id_par_scr=mysqli_query($db, $id_par_sql);
$id_par_conv=mysqli_fetch_array($id_par_scr,MYSQLI_NUM);
$id_par=$id_par_conv[0];
$par_sql="select VIA_PAR from parcheggio where ID_PAR='$id_par'";
$par_scr=mysqli_query($db, $par_sql);
$par_conv=mysqli_fetch_array($par_scr,MYSQLI_NUM);
$par=$par_conv[0];

print("PARCHEGGIO: ");
print($par);
print("<br>");

$counter=$counter++;
                            }
                mysqli_free_result($riep_scr);
                echo("<p><a href='area_user.php'>Ritorna all'area personale'</a></p>");
                mysqli_close($db);
                ?>
</body>
</html>
