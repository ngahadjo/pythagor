<?php
session_start();
include('cadre.php');
include('calendrier.html');
$con = mysqli_connect("localhost", "root", "");
mysqli_select_db($con, "gestion");

if(isset($_GET['modif_el'])){//modif_el qu'on a recupérer de l'affichage (modifier)
$id=$_GET['modif_el'];
$ligne=mysqli_fetch_array(mysqli_query($con, "select * from eleve,classe where eleve.codecl=classe.codecl and numel='$id'"));
$nom=stripslashes($ligne['nomel']);
$prenom=stripslashes($ligne['prenomel']);
$date=stripslashes($ligne['date_naissance']);
$phone=stripslashes($ligne['telephone']);
$adresse=str_replace("<br />",' ',$ligne['adresse']);
$codecl=stripslashes($ligne['codecl']);
?>
<div class="corp">
<img src="titre_img/modif_eleve.png" class="position_titre">
<center><pre>
<form action="modif_eleve.php" method="POST" class="formulaire">
   <FIELDSET>
 <LEGEND align=top>Edit a student<LEGEND>  <pre>
Student Last Name        :           <?php echo $nom; ?><br/>
First Name                  :          <?php echo $prenom; ?><br/>
DOB    :               <input type="text" name="date" class="calendrier" value="<?php echo $date; ?>"><br/>
Adress                  :        <textarea name="adresse" ><?php echo $adresse; ?></textarea><br/>
Phone                :          <input type="text" name="phone" value="<?php echo $phone; ?>"><br/>
Class                      :              <?php echo $ligne['nom']; ?><br/>
Promotion               :             <?php echo $ligne['promotion']; ?>
<input type="hidden" name="id" value="<?php echo $id; ?>"><br/>
<input type="image" src="button.png">
</pre></fieldset>
</form><a href="listeEtudiant.php?nomcl=<?php echo $ligne['nom']; ?>">Go back to the previous page !</a>
</div>
<?php
}
if(isset($_POST['adresse'])){
	if($_POST['date']!="" and $_POST['adresse']!="" and $_POST['phone']!=""){
		$id=$_POST['id'];
		$date=addslashes(Htmlspecialchars($_POST['date']));
		$phone=addslashes(Htmlspecialchars($_POST['phone']));
		$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
		mysqli_query($con, "update eleve set date_naissance='$date', adresse='$adresse', telephone='$phone' where numel='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modifié avec succés!"); </SCRIPT> 
		<?php
		
	}
	else{
	?> <SCRIPT LANGUAGE="Javascript">	alert("error! You must fill all the fields"); </SCRIPT> <?php
	}
	echo '<div class="corp"><br/><br/><a href="modif_eleve.php?modif_el='.$id.'">Go back to the previous page !</a></div>';
}
if(isset($_GET['supp_el'])){
$id=$_GET['supp_el'];
mysqli_query($con, "delete from eleve where numel='$id'");
mysqli_query($con, "delete from evaluation where numel='$id'");/*	Supprimier tous les entres en relation		*/
mysqli_query($con, "delete from stage where numel='$id'");
mysqli_query($con, "delete from bulletin where numel='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Successfully deleted!"); </SCRIPT> <?php
echo '<br/><br/><a href="index.php?">Return to main page !</a>';
}
?>
</center></pre>

</body>
</html>