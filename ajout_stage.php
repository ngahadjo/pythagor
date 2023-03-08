<?php
session_start();
include('cadre.php');
include('calendrier.html');
$con = mysqli_connect("localhost", "root", "");
mysqli_select_db($con, "gestion");
?>
<html>
<div class="corp">
<img src="titre_img/ajout_stage.png" class="position_titre">
<center><pre>
<?php if(isset($_SESSION['modif_stage']) and isset($_POST['lieu'])){//si on a cliquer sur ajouter/modifier pour modifier le post pour ne pas entr
	if(!empty($_POST['lieu']) and !empty($_POST['date_debut']) and !empty($_POST['date_fin'])){
		$id=$_SESSION['modif_stage'];
	//	$numel=$_POST['numel'];
		$date_debut=$_POST['date_debut'];
		$date_fin=$_POST['date_fin'];
		$lieu=$_POST['lieu'];
		mysqli_query($con, "update stage set lieu_stage='$lieu', date_debut='$date_debut', date_fin='$date_fin' where numstage='$id'");
		?> 	<SCRIPT LANGUAGE="Javascript">alert("Change successfully ! ");	</SCRIPT> 	<?php
		unset($_SESSION['modif_stage']);
			echo '<br/><br/><a href="index.php">Revenir à la page d\'accueill !</a>';

	}
	else{
			?> 	<SCRIPT LANGUAGE="Javascript">alert("please complete all fields ");	</SCRIPT> 	<?php
		}
}
else if(isset($_POST['lieu'])){		//s'il a cliquer sur ajouter /modifier la 2eme fois pour ajouter
if(!empty($_POST['lieu']) and !empty($_POST['date_debut']) and !empty($_POST['date_fin'])){
	$numel=$_POST['numel'];
	$date_debut=addslashes(Nl2br(Htmlspecialchars($_POST['date_debut'])));//Premier ou 2eme devoir -- 1 ou 2
	$date_fin=addslashes(Nl2br(Htmlspecialchars($_POST['date_fin'])));
	$lieu=addslashes(Nl2br(Htmlspecialchars($_POST['lieu'])));
	$compte=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from stage where lieu_stage='$lieu' and numel='$numel' and date_debut='$date_debut' and date_fin='$date_fin'"));
	$bool=true;
	if($compte['nb']>0){
	$bool=false;
	?> 	<SCRIPT LANGUAGE="Javascript">alert("Insert error, the internship already exists!");	</SCRIPT> 	<?php
	}
	if($bool==true){
	mysqli_query($con, "insert into stage(lieu_stage,date_debut,date_fin,numel) values ('$lieu','$date_debut','$date_fin','$numel')");
		?>	<SCRIPT LANGUAGE="Javascript">alert("Added successfully!");</SCRIPT> 	<?php
	}
	echo '<a href="index.php">Revenir à la page d\'accueill !</a>';
}
else{
?> 	<SCRIPT LANGUAGE="Javascript">alert("You must fill all the fields!");	</SCRIPT> 	<?php
echo '<a href="index.php">Revenir à la page d\'accueill !</a>';
}
}
else if(!isset($_POST['nomcl']) and !isset($_GET['modif_stage'])){
	$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");//select pour les promotions
	$retour=mysqli_query($con, "select distinct nom from classe");
 ?>
 <form action="ajout_stage.php" method="POST" class="formulaire">
 Please choose class and promotion : <br/><br/>
Promotion         :       <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Class                :        <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<center><input type="submit" value="Next"></center>
</form>
<?php }
if((isset($_POST['nomcl']) and isset($_POST['promotion'])) or isset($_GET['modif_stage'])){// si on a cliquer sur suivant ou sur modifier
$id="";
$lieu="";
$date_debut="";
$date_fin="";
if(isset($_GET['modif_stage'])){// si c'est une modification
$id=$_GET['modif_stage'];
$_SESSION['modif_stage']=$id;
$donnee=mysqli_fetch_array(mysqli_query($con, "select * from stage where numstage='$id'")); //	On selectione les champ qu'on va modifier dans la table stage
$lieu=$donnee['lieu_stage'];
$date_debut=$donnee['date_debut'];
$date_fin=$donnee['date_fin'];
$data=mysqli_fetch_array(mysqli_query($con, "select numel,nomel,prenomel from eleve where numel=(select numel from stage where numstage='$id')"));// 	on reselectionne le numel pour que ça soit similaire à la requete de l'ajout
}
else{//si c 'est l'ajout
	$_SESSION['promo']=$_POST['promotion'];//pour l'envoyer la 2eme fois 
	$promo=$_POST['promotion'];
	$nomcl=$_POST['nomcl'];
$data=mysqli_query($con, "select numel,nomel,prenomel from eleve,classe where classe.codecl=eleve.codecl and nom='$nomcl' and promotion='$promo'");
}
?>
<form action="ajout_stage.php" method="POST" class="formulaire">
Student                   :       <?php if(isset($_GET['modif_stage'])){echo $data['nomel'].' '.$data['prenomel'];}else{
?> <select name="numel"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['numel'].'">'.$a['nomel'].' '.$a['prenomel'].'</option>';
}?></select><br/><br/> <?php
} ?>

place of internship     :     <input type="text" name="lieu" value="<?php echo $lieu; ?>"><br/><br/>
Start date       :        <input type="text" name="date_debut" class="calendrier" value="<?php echo $date_debut; ?>"><br/><br/>
End date        :      <input type="text" name="date_fin" class="calendrier" value="<?php echo $date_fin; ?>"><br/><br/>
<center><input type="image" src="button.png"></center>
</form>
<?php } ?>
</pre></center>
</div>
</html>
