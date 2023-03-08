<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "root", "");
mysqli_select_db($con, "gestion");
?>
<html>
<div class="corp">
<img src="titre_img/ajout_enseignemt.png" class="position_titre">
<?php
if(isset($_POST['nomcl'])){
$_SESSION['nomcl']=$_POST['nomcl'];
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$promo;//pour l'envoyer la 2eme fois 
$donnee=mysqli_query($con, "select codemat,nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$nomcl' and promotion='$promo'");
$prof=mysqli_query($con, "select numprof,nom,prenom from prof");
?>
<form action="ajout_enseignement.php" method="POST" class="formulaire">
   <FIELDSET>
 <LEGEND align=top>Add Professor<LEGEND>  <pre>
Course       :    <select name="choix_mat" id="choix">
<?php
while($a=mysqli_fetch_array($donnee)){
   echo '<option value="'.$a['codemat'].'">'.$a['nommat'].'</option>';
}
?>
</select><br/><br/>
Professor  :  <select name="n_prof"><?php while($prof2=mysql_fetch_array($prof)){
echo '<option value="'.$prof2['numprof'].'">'.$prof2['nom'].' '.$prof2['prenom'].'</option>';
}
?>
</select><br/><br/>
Semester       :    <select name="semestre"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<center><input type="image" src="button.png"></center>
</pre></fieldset>
</form>
<?php }
else if(isset($_POST['semestre'])){//s'il a cliquer sur ajouter la 2eme fois
$semestre=$_POST['semestre'];
$codemat=$_POST['choix_mat'];
$nomcl=$_SESSION['nomcl'];
$n_prof=$_POST['n_prof'];
$promo=$_SESSION['promo'];
$codeclasse=mysqli_fetch_array(mysqli_query($con, "select codecl from classe where nom='$nomcl' and promotion='$promo'")) ;
$codecl=$codeclasse['codecl'];

$data=mysqli_query($con, "select count(*) as nb from enseignement where codecl='$codecl'  and codemat='$codemat' and numsem='$semestre'");

 
$nb=mysqli_fetch_array($data);


$bool=true;

	if($nb['nb']>0){
		$bool=false;
		echo '<br\><h2>Insert error!! (impossible to add two similar Professor)</h2>';
		?><SCRIPT LANGUAGE="Javascript">alert("Insert error\cannot add two similar lessons");</SCRIPT><?php
	}
	if($bool==true){
	mysql_query("insert into enseignement(codecl,codemat,numprof,numsem) values('$codecl','$codemat','$n_prof','$semestre')");
	?> <SCRIPT LANGUAGE="Javascript">	alert("Ajouté avec succés!"); </SCRIPT> <?php
	}
	echo '<br/><br/><a href="ajout_enseignement.php?">Go back to the previous page !</a>';
}
 else {
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");//select pour les promotions
$donnee=mysqli_query($con, "select distinct nom from classe"); 
?>
 <form action="ajout_enseignement.php" method="POST" class="formulaire">
 Please choose class and promotion : <br/><br/>
    <FIELDSET>
 <LEGEND align=top>Addition criteria<LEGEND>  <pre>
 Class          :       <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($donnee)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
 Promotion   :     <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>

<center><input type="submit" value="Display"></center>
</pre></fieldset>
</form>
<?php } ?>
</center></pre>
</div>
</html>
