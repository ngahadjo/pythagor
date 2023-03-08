<?php
session_start();
include('cadre.php');
include('calendrier.html');
?>
<div class="corp">
<img src="titre_img/ajout_etudiant.png" class="position_titre">
<center><pre>
<?php
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
if(isset($_POST['nom'])){
	if($_POST['nom']!="" and $_POST['prenom']!="" and $_POST['date']!="" and $_POST['adresse']!="" and $_POST['phone']!="" and $_POST['pseudo']!="" and $_POST['passe']!=""){
	$nom=addslashes(Htmlspecialchars($_POST['nom']));
	$prenom=addslashes(Htmlspecialchars($_POST['prenom']));
	$date=addslashes(Htmlspecialchars($_POST['date']));
	$phone=addslashes(Htmlspecialchars($_POST['phone']));
	$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
	$nomcl=$_POST['nomcl'];
	$promo=$_POST['promotion'];
	$pseudo=$_POST['pseudo'];
	$passe=$_POST['mdp'];
	$nb=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from eleve where nomel='$nom' and prenomel='$prenom'"));
	if($nb['nb']!=0){
	?><SCRIPT LANGUAGE="Javascript">alert("erreur! this record already exists!");</SCRIPT><?php
	}
	else{
	$data=mysqli_fetch_array(mysqli_query($con, "select codecl from classe where nom='$nomcl' and promotion='$promo'"));
	$codecl=$data['codecl'];
	mysqli_query($con, "insert into eleve(nomel,prenomel,date_naissance,adresse,telephone,codecl) values('$nom','$prenom','$date','$adresse','$phone','$codecl')");
	/*		Ajouter le num dans le login    */
	$numel=mysqli_fetch_array(mysqli_query($con, "select numel from eleve where nomel='$nom' and prenomel='$prenom'"));
	$num=$numel['numel'];
	mysqli_query($con, "insert into login(Num,pseudo,passe,type) values('$num','$pseudo','$passe','etudiant')");
	?>	<SCRIPT LANGUAGE="Javascript">alert("Added successfully!");</SCRIPT> 	<?php
	}
	}
	else{
	?> 	<SCRIPT LANGUAGE="Javascript">alert("You must fill all the fields!");	</SCRIPT> 	<?php
	}
}
?>
<?php
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");
?>
<form action="Ajout_etudiant.php" method="POST" class="formulaire">
   <FIELDSET>
 <LEGEND align=top>Add a Student<LEGEND>  <pre>
First Name        :       <input type="text" name="nom"><br/>
      Last Name   :       <input type="text" name="prenom"><br/>
DOB  :                    <input type="text" name="date" class="calendrier" ><br/>
     Address:             <input type="text" name="adresse"><br/>
  Phone          :        <input type="text" name="phone"><br/>
  login          :        <input type="text" name="pseudo"><br/>
Password         :        <input type="password" name="mdp"><br/>
Classe               :        <select name="nomcl"> 
<?php 
$retour=mysqli_query($con, "select distinct nom from classe"); // afficher les classes
while($a=mysql_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/>
Promotion             :      <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/>
<center><input type="image" src="button.png"></center>
</pre></fieldset>
</form>
</pre></center>
</div>
</body>
</html>