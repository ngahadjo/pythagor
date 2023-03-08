<?php
session_start();
include('cadre.php');
echo '<div class="corp"><img src="titre_img/modif_evalu.png" class="position_titre"><pre>';
if(isset($_GET['modif_eval'])){//modif_el qu'on a recupérer de l'affichage (modifier)
$id=$_GET['modif_eval'];
$ligne=mysqli_fetch_array(mysqli_query($con, "select * from evaluation,eleve,classe where eleve.numel=evaluation.numel and eleve.codecl=classe.codecl and numeval='$id'"));//Pour afficher le nom de l'eleve et la note par deflault et le devoir,
$codecl=$ligne['codecl'];
$eleve=mysqli_query($con "select numel,nomel,prenomel from eleve where codecl='$codecl'");
$numdev=stripslashes($ligne['numdev']);
$mat_dev=mysqli_fetch_array(mysqli_query($con, "select * from matiere,devoir where devoir.codemat=matiere.codemat and numdev='$numdev'"));//pour selection la classe par defualt et afficher la promotion
?>
<form action="modif_eval.php" method="POST" class="formulaire">
Course            :      <?php echo $mat_dev['nommat']; ?><br/>
Class                :     <?php echo stripslashes($ligne['nom']); ?><br/>
Promotion        :       <?php echo stripslashes($ligne['promotion']); ?><br/>
Assignment date :      <?php echo stripslashes($mat_dev['date_dev']); ?><br/>
Credit hour        :      <?php echo stripslashes($mat_dev['coeficient']); ?><br/>
Semester            :    S<?php echo $mat_dev['numsem']; ?><br/>
Devoir N°         :     <?php echo $mat_dev['n_devoir']; ?><br/>
Etudiant            :     <select name="numel"> 
<?php while($a=mysqli_fetch_array($eleve)){
echo '<option value="'.$a['numel'].'" '.choixpardefault2($a['numel'],$ligne['numel']).'>'.$a['nomel'].' '.$a['prenomel'].'</option>';
}?></select><br/>
Note                 :      <input type="text" name="note" value="<?php echo $ligne['note']; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
<center><input type="image" src="modifier.png" style="margin-top:13px;"></center>
</form>
<?php
echo '<br/><br/><a href="afficher_evaluation.php">Go back to the previous page !</a>';
}
if(isset($_POST['numel'])){//s'il a cliquer sur le bouton modifier
	if($_POST['note']!=""){
		$id=$_POST['id'];
		$numel=$_POST['numel'];
		$note=str_replace(",",".",$_POST['note']);//remplacer la , par .
		mysqli_query($con "update evaluation set numel='$numel', note='$note' where numeval='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modified successfully!"); </SCRIPT> <?php
	}
	else{
		?> <SCRIPT LANGUAGE="Javascript">	alert("error! You must fill all the fields"); </SCRIPT> <?php
		}
	echo '<br/><br/><a href="modif_eval.php?modif_eval='.$id.'">Go back to the previous page !</a>';
}
if(isset($_GET['supp_eval'])){
$id=$_GET['supp_eval'];
mysqli_query($con, "delete from evaluation where numeval='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Successfully deleted!"); </SCRIPT> <?php
echo '<br/><br/><a href="afficher_evaluation.php">Return to the page on display</a>'; //on revient à la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</pre>
</div>