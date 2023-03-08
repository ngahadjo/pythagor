<?php
session_start();
include('cadre.php');
include('calendrier.html');
echo '<div class="corp"><img src="titre_img/modif_enseign.png" class="position_titre"><pre>';
if(isset($_GET['modif_ensein'])){//modif_el qu'on a recupérer de l'affichage (modifier)
$id=$_GET['modif_ensein'];
$ligne=mysqli_fetch_array(mysqli_query($con, "select classe.codecl,prof.numprof,promotion,classe.nom as nomcl,prenom,prof.nom as nomp,matiere.codemat,nommat,numsem from classe,matiere,enseignement,prof where classe.codecl=enseignement.codecl and matiere.codemat=enseignement.codemat and prof.numprof=enseignement.numprof and id='$id'"));
$prof=mysqli_query($con, "select * from prof");
$mat=mysqli_query($con, "select * from matiere");
?>
<form action="modif_enseign.php" method="POST" class="formulaire">
Course     :     <select name="codemat"> 
<?php while($a=mysqli_fetch_array($mat)){
echo '<option value="'.$a['codemat'].'" '.choixpardefault2($a['codemat'],$ligne['codemat']).'>'.$a['nommat'].'</option>';
}?></select><br/><br/>
Professor :    <select name="numprof"> 
<?php while($a=mysqli_fetch_array($prof)){
echo '<option value="'.$a['numprof'].'" '.choixpardefault2($a['numprof'],$ligne['numprof']).'>'.$a['nom'].' '.$a['prenom'].'</option>';
}?></select><br/><br/>
Class        : <?php echo stripslashes($ligne['nomcl']); ?><br/><br/>
Promotion    :  <?php echo $ligne['promotion']; ?><br/><br/>
Semester      : <?php echo $ligne['numsem']; ?>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="codecl" value="<?php echo $ligne['codecl']; ?>">
<input type="hidden" name="numsem" value="<?php echo $ligne['numsem']; ?>">
<input type="image" src="modifier.png">
</form>
<?php
echo '<br/><br/><a href="afficher_devoir.php">Go back to the previous page !</a>';
}
if(isset($_POST['numprof'])){//s'il a cliquer sur le bouton modifier
	$id=$_POST['id'];
		$numprof=$_POST['numprof'];
		$codemat=$_POST['codemat'];
		$codecl=$_POST['codecl'];
		$numsem=$_POST['numsem'];
		$compte=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from enseignement where numprof='$numprof' and codemat='$codemat' and codecl='$codecl'"));
		if($compte['nb']!=0){//deux devoir similaire()2 devoirs par matiere
		?> <SCRIPT LANGUAGE="Javascript">	alert("modification error, this lesson already exists"); </SCRIPT> <?php
		}
		else{
		mysqli_query($con, "update enseignement set numprof='$numprof',codemat='$codemat' where id='$id'");
		$suppression=mysqli_query($con, "select * from devoir where codemat='$codemat' and codecl='$codecl' and numsem='$numsem'");//tres important()supprimier les devoir correspondants
		/*			Supprimer le devoir et l'evaluation correspondnt			*/
		while($a=mysqli_fetch_array($suppression)){
			$cle=$a['numdev'];
			mysqli_query("delete from evaluation where numdev='$cle'");
			mysqli_query("delete from devoir where numdev='$cle'");
		}
		?> <SCRIPT LANGUAGE="Javascript">	alert("Edited successfully!\all entries related to this record have been deleted"); </SCRIPT> <?php
		}
		
	echo '<br/><br/><a href="modif_enseign.php?modif_ensein='.$id.'">Go back to the previous page !</a>';
}
if(isset($_GET['supp_ensein'])){
$id=$_GET['supp_ensein'];
/* 		requete pour utiliser son retour afin de recuperer le numdev qu'on va supprimer aussi 		*/
$ligne=mysqli_fetch_array(mysqli_query($con, "select classe.codecl,matiere.codemat,numsem from classe,matiere,enseignement where classe.codecl=enseignement.codecl and matiere.codemat=enseignement.codemat and id='$id'"));
$codemat=$ligne['codemat'];
$codecl=$ligne['codecl'];
$numsem=$ligne['numsem'];
$suppression=mysqli_query($con "select * from devoir where codemat='$codemat' and codecl='$codecl' and numsem='$numsem'");//tres important()supprimier les devoir correspondants
		/*			Supprimer le devoir et l'evaluation correspondnte			*/
		while($a=mysql_fetch_array($suppression)){
			$cle=$a['numdev'];
			mysqli_query($con "delete from evaluation where numdev='$cle'");
			mysqli_query($con "delete from devoir where numdev='$cle'");
		}
mysqli_query($con "delete from enseignement where id='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Successfully deleted!\all entries related to this record have been deleted"); </SCRIPT> <?php
echo '<br/><br/><a href="index.php">Return to main page</a>'; //on revient à la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</pre>
</div>