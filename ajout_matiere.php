<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
?>
<div class="corp">
<img src="titre_img/ajout_matiere.png" class="position_titre">
<div class="formulaire">
<pre>
<?php
if(isset($_POST['promotion'])){
$_SESSION['promo']=$_POST['promotion'];//pour l'envoyer la 2eme fois 
$_SESSION['nomcl']=$_POST['nomcl'];
?>
<form action="ajout_matiere.php" method="POST" >
Please enter the new subject : <br/><br/>
Course       :      <input type="text" name="nommat"><br/><br/>
<center><input type="image" src="button.png"></center>
</form>
<?php }
else if(isset($_POST['nommat'])){//s'il a cliquer sur ajouter la 2eme fois
	if($_POST['nommat']!=""){
		$nomcl=$_SESSION['nomcl'];
		$nommat=addslashes(Htmlspecialchars($_POST['nommat']));
		$promo=$_SESSION['promo'];
		$codeclasse=mysqli_fetch_array(mysqli_query($con, "select codecl from classe where nom='$nomcl' and promotion='$promo'"));
		$codecl=$codeclasse['codecl'];
		$compte=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from matiere where nommat='$nommat' and codecl='$codecl'"));
		$bool=true;
		if($compte['nb']>0){
			$bool=false;
			?> <SCRIPT LANGUAGE="Javascript">	alert("insertion error, the record already exists!"); </SCRIPT> <?php
		}
		if($bool==true){
			mysqli_query($con, "insert into matiere(nommat,codecl) values ('$nommat','$codecl')");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Added successfully!"); </SCRIPT> <?php
		}
	}
	else {
	?> <SCRIPT LANGUAGE="Javascript">	alert("please complete all fields!"); </SCRIPT> <?php
	}
	echo '<a href="Ajout_matiere.php">Revenir à la page précédente !</a>';
}
 else{
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");//select pour les promotions
$nomclasse=mysqli_query($con, "select distinct nom from classe");
 ?>
 <form action="ajout_matiere.php" method="POST">
 Promotion        :             <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Class                 :         <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($nomclasse)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<center><input type="submit" value="Next"></center>
</form>
<?php } ?>
</pre>
</div>
</div>
</html>
