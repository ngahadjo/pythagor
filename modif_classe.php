<?php
session_start();
include('cadre.php');
if(isset($_GET['modif_classe'])){//modif_el qu'on a recupérer de l'affichage (modifier)
$id=$_GET['modif_classe'];
$ligne=mysqli_fetch_array(mysqli_query($con, "select codecl,classe.nom as nomcl,promotion,numprofcoord,prof.nom,prenom from classe,prof where numprof=numprofcoord and codecl='$id'"));
$promo=mysqli_query($con, "select distinct promotion from classe");
$prof=mysqli_query($con, "select numprof,nom,prenom from prof");
$nom=stripslashes($ligne['nomcl']);
$numprof=stripslashes($ligne['numprofcoord']);
$promotion=stripslashes($ligne['promotion']);
?>
<div class="corp">
<img src="titre_img/modifier_classe.png" class="position_titre">
<center><pre>
<form action="modif_classe.php" method="POST" class="formulaire">
<h4>Please choose the new information  :</h4></br>
Class Name        :        <input type="text" name="nom" value="<?php echo $nom; ?>"></br></br><br/><br/>
Prof coordinator     :        <select name="prof"> 
<?php while($a=mysqli_fetch_array($prof)){
echo '<option value="'.$a['numprof'].'" '.choixpardefault2($a['numprof'],$numprof).'>'.$a['nom'].' '.$a['prenom'].'</option>';
}?></select><br/><br/>
Promotion                  :        <select name="promo"> 
<?php while($a=mysqli_fetch_array($promo)){
echo '<option value="'.$a['promotion'].'" '.choixpardefault2($a['promotion'],$promotion).'>'.$a['promotion'].'</option>';
}?></select><br/><br/>
<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
<center><input type="image" src="modifier.png"></center>
</form>
<br/><br/><a href="affiche_classe.php">Go back to the previous page !</a>
<?php
}
if(isset($_POST['nom'])){//s'il a cliquer sur le bouton modifier
	if($_POST['nom']!=""){
		$id=$_POST['id'];
		$nom=addslashes(Htmlspecialchars($_POST['nom']));
		$prof=addslashes(Htmlspecialchars($_POST['prof']));
		$promo=addslashes(Htmlspecialchars($_POST['promo']));
		mysqli_query($con, "update classe set nom='$nom',numprofcoord='$prof',promotion='$promo' where codecl='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modified successfully!"); </SCRIPT> <?php
		echo '<br/><br/><a href="modif_classe.php?modif_classe='.$id.'">Go back to the previous page !</a>';
	}
	else{
		echo '<h1>error! You must fill in all fields<h1>';
		echo '<br/><br/><a href="modif_classe.php?modif_classe='.$id.'">Go back to the previous page !</a>';
	}
}
if(isset($_GET['supp_classe'])){
$id=$_GET['supp_classe'];
mysqli_query($con, "delete from classe where codecl='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Successfully deleted!"); </SCRIPT> <?php
echo '<br/><br/><a href="affiche_classe.php">Go back to the previous page !</a>';
}
?>
</center></pre>
</div>