<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
echo '<div class="corp"><img src="titre_img/modif_prof.png" class="position_titre"><pre>';
if(isset($_GET['modif_prof'])){//modif_el qu'on a recupérer de l'affichage (modifier)
$id=$_GET['modif_prof'];
$ligne=mysqli_fetch_array(mysqli_query($con, "select * from prof where numprof='$id'"));
$nom=stripslashes($ligne['nom']);
$prenom=stripslashes($ligne['prenom']);
$phone=stripslashes($ligne['telephone']);
$adresse=stripslashes($ligne['adresse']);
?>

<form action="modif_prof.php" method="POST" class="formulaire">
Student Last Name       :       <?php echo $nom; ?><br/><br/>
First Name                  :     <?php echo $prenom; ?><br/><br/>
Address               :       <textarea name="adresse" ><?php echo $adresse; ?></textarea><br/><br/>
Phone             :         <input type="text" name="phone" value="<?php echo $phone; ?>"><br/><br/>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<center><input type="image" src="button.png"></center>
</form>
<br/><br/><a href="afficher_prof.php?nomcl=<?php echo $ligne['nom']; ?>">Go back to the previous page !</a>
<?php
}
if(isset($_POST['nom'])){
	if($_POST['adresse']!="" and $_POST['phone']!=""){
		$id=$_POST['id'];
		$phone=addslashes(Htmlspecialchars($_POST['phone']));
		$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
		mysqli_query("update prof set adresse='$adresse', telephone='$phone' where numprof='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modified successfully!"); </SCRIPT> <?php
		echo '<br/><br/><a href="modif_prof.php?modif_prof='.$id.'">Go back to the previous page !</a>';
	}
	else{
	?> <SCRIPT LANGUAGE="Javascript">	alert("erreur! You must fill in all fields"); </SCRIPT> <?php
		echo '<br/><br/><a href="index.php?">Revenir à la page principale !</a>';
	}
}
if(isset($_GET['supp_prof'])){
$id=$_GET['supp_prof'];
mysqli_query($con, "delete from prof where numprof='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Successfully deleted!"); </SCRIPT> <?php
echo '<br/><br/><a href="index.php?">Revenir à la page principale !</a>';
}
?>
</pre>
</div>