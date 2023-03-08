<?php
session_start();
include('cadre.php');

$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
echo '<div class="corp">';
if(isset($_GET['modif_matiere'])){//modif_el qu'on a recupérer de l'affichage (modifier)
$id=$_GET['modif_matiere'];
$ligne=mysqli_fetch_array(mysqli_query($con, "select * from matiere,classe where classe.codecl=matiere.codecl and codemat='$id'"));//classe pour afficher la promotion
$nom=stripslashes($ligne['nommat']);
$codecl=stripslashes($ligne['codecl']);
$promo=mysqli_fetch_array(mysqli_query($con, "select promotion,nom from classe where codecl='$codecl'"));//pour selection la classe par defualt et afficher la promotion
?>
<center>
  <h1>Update Course </h1>
</center>
<form action="modif_matiere.php" method="POST" class="formulaire">
Course :
  <input type="text" name="nommat" value="<?php echo $nom; ?>"><br/><br/>
Class : <?php echo $promo['nom']; ?><br/>
<br/>
Promotion : <?php echo $promo['promotion']; ?><br/><br/>
<input type="hidden" name="id" value="<?php echo $id; ?>"><!-- pour revenir en arriere et pour avoir l'id dont lequel on va modifier-->
<center><input type="image" src="button.png"></center>
</form>
<?php
echo '<br/><br/><a href="affiche_matiere.php?nomcl='.$promo['nom'].'">Go back to the previous page !</a>';
}
if(isset($_POST['nommat'])){//s'il a cliquer sur le bouton modifier
	if($_POST['nommat']!=""){
		$id=$_POST['id'];
		$nom=addslashes(Htmlspecialchars($_POST['nommat']));
		mysqli_query($con, "update matiere set nommat='$nom' where codemat='$id'");
		?> <SCRIPT LANGUAGE="Javascript">	alert("Modified successfully!"); </SCRIPT> <?php
	}
	else{
		?> <SCRIPT LANGUAGE="Javascript">	alert("error! You must fill all the fields"); </SCRIPT> <?php
		}
	echo '<br/><br/><a href="modif_matiere.php?modif_matiere='.$id.'">Go back to the previous page !</a>';
}
if(isset($_GET['supp_matiere'])){
$id=$_GET['supp_matiere'];
mysqli_query($con, "delete from matiere where codemat='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Successfully deleted!"); </SCRIPT> <?php
echo '<br/><br/><a href="index.php">Go back to the previous page!</a>'; //on revient à la page princippale car on n'a plus l'id dont on affiche la matiere dans la modification
}
?>
</div>