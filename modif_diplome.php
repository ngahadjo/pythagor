<?php
session_start();
include('cadre.php');
echo '<div class="corp">';
if(isset($_GET['modif_dip'])){//modif_el qu'on a recupérer de l'affichage (modifier)
$id=$_GET['modif_dip'];
$ligne=mysqli_fetch_array(mysqli_query($con, "select * from eleve,classe,eleve_diplome,diplome where eleve.numel=eleve_diplome.numel and classe.codecl=eleve.codecl and diplome.numdip=eleve_diplome.numdip and id='$id'"));
$titre=mysqli_query($con, "select numdip,titre_dip from diplome");
?>

<img src="titre_img/modif_diplom.png" class="position_titre">
<center><pre>
<form action="modif_diplome.php" method="POST" class="formulaire">
Full Name          :         <?php echo $ligne['nomel'].' '.$ligne['prenomel']; ?><br/>
Class              	      :       <?php echo $ligne['nom']; ?><br/>
Promotion                   :          <?php echo $ligne['promotion']; ?><br/>
Title diplôme       		 <select name="titre"><?php while($var=mysql_fetch_array($titre)){  
 echo '<option value="'.$var['numdip'].'" '.choixpardefault2($var['titre_dip'],$ligne['titre_dip']).'>'.$var['titre_dip'].'</option>'; 
} ?> </select><br/>
Grade                            :         <input type="text" name="note" value="<?php echo $ligne['note']; ?>"><br/>
Comment                 :      <input type="text" name="comment" value="<?php echo $ligne['commentaire']; ?>"><br/>
University              :       <input type="text" name="etabli" value="<?php echo $ligne['etablissement']; ?>"><br/>
State                             :        <input type="text" name="lieu" value="<?php echo $ligne['lieu']; ?>"><br/>
Year        :       <input type="text" name="ann_obt" value="<?php echo $ligne['annee_obtention']; ?>"><br/>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<center><input type="image" src="modifier.png"></center>
</form>
<br/><br/><a href="listeEtudiant.php?nomcl=<?php echo $ligne['nom']; ?>">Go back to the previous page !</a>

<?php
}
if(isset($_POST['titre'])){
	if($_POST['titre']!="" and $_POST['note']!="" and $_POST['etabli']!="" and $_POST['lieu']!="" and $_POST['ann_obt']!=""){
		$id=$_POST['id'];
		$numdip=addslashes(Htmlspecialchars($_POST['titre']));
		$note=addslashes(Htmlspecialchars($_POST['note']));
		$lieu=addslashes(Htmlspecialchars($_POST['lieu']));
		$etabli=addslashes(Htmlspecialchars($_POST['etabli']));
		$comment=addslashes(Htmlspecialchars($_POST['comment']));
		$annee=addslashes(Htmlspecialchars($_POST['ann_obt']));
		mysqli_query($con "update eleve_diplome set numdip='$numdip', lieu='$lieu', etablissement='$etabli', commentaire='$comment', note='$note', annee_obtention='$annee' where id='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modified successfully!"); </SCRIPT> 
		<?php
	}
	else{
	?> <SCRIPT LANGUAGE="Javascript">	alert("error! You must fill all the fields"); </SCRIPT> <?php
	}
	echo '<a href="modif_diplome.php?modif_dip='.$id.'">Revenir à la page precedente !</a>';
}
if(isset($_GET['supp_dip'])){
$id=$_GET['supp_dip'];
mysqli_query($con "delete from eleve_diplome where id='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Successfully deleted!"); </SCRIPT> <?php
echo '<br/><br/><a href="index.php?">Return to main page !</a>';
}
?>
</center></pre>
</div>
