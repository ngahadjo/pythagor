<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
?>
<html>
<div class="corp">
<img src="titre_img/ajout_prof.png" class="position_titre">
<center><pre>
<?php
if(isset($_POST['adresse'])){//s'il a cliquer sur ajouter la 2eme fois
if($_POST['nom']!="" and $_POST['prenom']!="" and $_POST['adresse']!="" and $_POST['telephone']!="" and $_POST['pseudo']!="" and $_POST['passe']!=""){
$nom=addslashes($_POST['nom']);
$prenom=addslashes($_POST['prenom']);//Premier ou 2eme devoir -- 1 ou 2
$adresse=addslashes(Nl2br(Htmlspecialchars($_POST['adresse'])));
$telephone=$_POST['telephone'];
$pseudo=$_POST['pseudo'];
$passe=$_POST['passe'];
$compte=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from prof where nom='$nom' and prenom='$prenom'"));// pour ne pas ajouter deux profs similaires
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">alert("error! This professor already exists ");</SCRIPT>
<?php
}
else{
mysqli_query($con, "insert into prof(nom,prenom,adresse,telephone) values('$nom','$prenom','$adresse','$telephone')");
	/*		Ajouter le num dans le login    */
$numprof=mysqli_fetch_array(mysqli_query($con, "select numprof from prof where nom='$nom' and prenom='$prenom'"));
$num=$numprof['numprof'];
mysqli_query($con, "insert into login(Num,pseudo,passe,type) values('$num','$pseudo','$passe','prof')");
?><SCRIPT LANGUAGE="Javascript">alert("Added successfully!");</SCRIPT>
<?php
}
}
else{
?>
<SCRIPT LANGUAGE="Javascript">alert("please complete all fields!");</SCRIPT>
<?php
}
echo '<br/><a href="ajout_prof.php">Go back to the previous page !</a>';
}
else {
 ?>
 <form action="ajout_prof.php" method="POST" class="formulaire">
 Last Name           :         <input type="text" name="nom"><br/>
 First Name      :         <input type="text" name="prenom"><br/>
 Address     :          <textarea name="adresse"> </textarea><br/>
 Phone  :       <input type="text" name="telephone"> <br/>
 Login        :      <input type="text" name="pseudo"> <br/>
 Password     :       <input type="password" name="passe"> <br/>
<center><input type="image" src="button.png"></center>
</form>
<?php
}
?>
</pre></center>
</div>
</html>
