<?php
session_start();
include('cadre.php');
?>
<div class="corp">
<pre>
<?php
if(isset($_GET['ajout_type'])){ ?>
<img src="titre_img/ajout_diplome.png" class="position_titre">
 <form action="ajout_diplome.php" method="POST" class="formulaire">
 Please enter the title of the degree to add : <br/>
 <br/>
 Degree title       :       
 <input type="text" name="ajout_titre"><br/><br/>
<center><input type="image" src="button.png"></center>
</form>
<?php
}
else if(isset($_GET['ajout_diplome'])){ 
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");//select pour les promotions
$nomclasse=mysqli_query($con, "select distinct nom from classe");
 ?>
 <img src="titre_img/ajout_diplome.png" class="position_titre">
 <form action="ajout_diplome.php" method="POST" class="formulaire">
 Please choose class and promotion : <br/>
 Promotion        :             <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Class                 :         
<select name="nomcl"> 
<?php while($a=mysqli_fetch_array($nomclasse)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<input type="submit" value="Next">
</form>
<?php }
else if(isset($_POST['nomcl'])){ 
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$data=mysqli_query($con, "select numel,nomel,prenomel from eleve where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo')");
$titre=mysqli_query($con, "select numdip,titre_dip from diplome");
?>
<img src="titre_img/ajout_diplome.png" class="position_titre">
 <form action="ajout_diplome.php" method="POST" class="formulaire">
 Please fill in the information : <br/>
Student               :        
<select name="numel"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['numel'].'">'.$a['nomel'].' '.$a['prenomel'].'</option>';
}?></select><br/>
Degree title        :    
<select name="titre"><?php while($var=mysqli_fetch_array($titre)){  
 echo '<option value="'.$var['numdip'].'">'.$var['titre_dip'].'</option>'; 
} ?> </select><br/>
Grade                    :               
<input type="text" name="note"><br/>
Comment        :         
<input type="text" name="comment"><br/>
Faculty        :      
<input type="text" name="etabli"><br/>
State                     :       
<input type="text" name="lieu"><br/>
Year of graduation             :       
<input type="text" name="ann_obt"><br/>
<center><input type="image" src="button.png"></center>
</form>
<?php
}
else if(isset($_POST['numel'])){
if($_POST['note']!="" and $_POST['lieu']!="" and $_POST['comment']!="" and $_POST['etabli']!="" and $_POST['ann_obt']!=""){
	$note=str_replace(',','.',$_POST['note']);
	$comment=addslashes(Htmlspecialchars($_POST['comment']));
	$etabli=addslashes(Htmlspecialchars($_POST['etabli']));
	$annee=addslashes(Htmlspecialchars($_POST['ann_obt']));
	$lieu=addslashes(Nl2br(Htmlspecialchars($_POST['lieu'])));
	$numel=$_POST['numel'];
	$numdip=$_POST['titre'];
	echo 'numel--> '.$numel;
	$nb=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from eleve_diplome where numel='$numel'"));
		if($nb['nb']!=0){
			?><SCRIPT LANGUAGE="Javascript">alert("erreur! this recording already exists!");</SCRIPT><?php
		}
		else{
		mysqli_query($con, "insert into eleve_diplome(numdip,numel,note,commentaire,etablissement,lieu,annee_obtention) values('$numdip','$numel','$note','$comment','$etabli','$lieu','$annee')");
		?>	<SCRIPT LANGUAGE="Javascript">alert("Ajout avec succés!");</SCRIPT> 	<?php
		}
}
else {
?> 	<SCRIPT LANGUAGE="Javascript">alert("You must fill all the fields!");	</SCRIPT> 	<?php
}
echo '<br/><br/><a href="ajout_diplome.php?ajout_diplome">Revenir à la page précédente !</a>';
}
else if(isset($_POST['ajout_titre'])){
	$titre=$_POST['ajout_titre'];
	$nb=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from diplome where titre_dip='$titre'"));
	if($nb['nb']!=0){
	?><SCRIPT LANGUAGE="Javascript">alert("erreur! this recording already exists!");</SCRIPT><?php
	}
	else{
	mysqli_query($con, "insert into diplome(titre_dip) values('$titre')");
	?>	<SCRIPT LANGUAGE="Javascript">alert("Added successfully!");</SCRIPT> 	<?php
	}
	echo '<br/><br/><a href="ajout_diplome.php?ajout_type">Revenir à la page précédente !</a>';
}


?>