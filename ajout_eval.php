<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
?>
<html>
<body>
<div class="corp">
<pre>
<img src="titre_img/ajout_eval.png" class="position_titre">
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
$_SESSION['semestre']=$_POST['radiosem'];
$nomcl=$_POST['nomcl'];
$semestre=$_SESSION['semestre'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$_POST['promotion'];
$donnee=mysqli_query($con, "select nommat from matiere,enseignement,classe where matiere.codemat=enseignement.codemat and enseignement.codecl=classe.codecl and classe.nom='$nomcl' and promotion='$promo' and enseignement.numsem='$semestre'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
$_SESSION['classe']=$nomcl;
?>
<form method="post" action="ajout_eval.php" class="formulaire">
Please choose the subject : <br/><br/>
   <?php
   $i=6;
   while($a=mysqli_fetch_array($donnee)){
		echo '<input type="radio" name="radio" value="'.$a['nommat'].'" id="choix'.$i.'" /> <label for="choix'.$i.'">'.$a['nommat'].'</label><br /><br />';
		$i++;
   }
   ?>
<input type="submit" value="Show homework">
</form>
<?php
}
else if(isset($_POST['radio'])){
$semestre=$_SESSION['semestre'];
$nommat=$_POST['radio'];
$_SESSION['radio_matiere']=$nommat;
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$donnee=mysqli_query($con, "select numdev,date_dev,nommat,nom,coeficient,numsem,n_devoir from devoir,matiere,classe where matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and classe.nom='$nomcl' and devoir.numsem='$semestre' and matiere.nommat='$nommat' and promotion='$promo'");
?><center><table id="rounded-corner">
<thead><tr><th scope="col" class="rounded-company">Assessment</th><th scope="col" class="rounded-q1">Course</th><th scope="col" class="rounded-q2">Date Assessment</th><th scope="col" class="rounded-q3">Class</th><th scope="col" class="rounded-q3">credit hour</th><th scope="col" class="rounded-q3">Semester</th><th scope="col" class="rounded-q4">1st/2nd Assessment</th></tr></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
echo '<td><a href="ajout_eval.php?ajout_eval='.$a['numdev'].'">Ajouter evaluation</a></td><td>'.$a['nommat'].'</td><td>'.$a['date_dev'].'</td><td>'.$a['nom'].'</td><td>'.$a['coeficient'].'</td><td>S'.$a['numsem'].'</td><td>'.$a['n_devoir'].'</td></tr>';
}
?>
 </tbody>
</table>
<br/><br/><a href="ajout_eval.php">Return to main page !</a></center>
<?php
}//fin   if(isset($_POST['radio']
else if(isset($_POST['numel'])){ // l'insertion, on recupere le numel et la note avec les autres session et on insert
$numel=$_POST['numel'];
$numdev=$_POST['numdev'];
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$note=str_replace(",",".",$_POST['note']);//replacer les , par . car c double
/*$codecl=mysqli_fetch_array(mysqli_query($con, "select codecl from classe where nom='$nomcl' and promotion='$promo'"));
$codecl=$codecl['codecl'];*/
$compte=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from evaluation where numdev='$numdev' and numel='$numel'"));//pour ne pas repeter le meme enregistrement
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">
alert("insertion error, the record already exists!");
</SCRIPT>
<br/><br/><a href="ajout_eval.php">Return to main page </a>
<?php
}
else{
mysqli_query($con, "insert into evaluation(numdev,numel,note) values('$numdev','$numel','$note')");
?>
<SCRIPT LANGUAGE="Javascript">
alert("Added successfully!");
</SCRIPT>
<br/><br/><a href="ajout_eval.php">Return to main page </a>
<?php
}
}
else if(isset($_GET['ajout_eval'])){// si on a cliquer sur voir l'evaluation d'un devoir
$semestre=$_SESSION['semestre'];
$nommat=$_SESSION['radio_matiere'];
$nomcl=$_SESSION['classe'];
$promo=$_SESSION['promo'];
$numdev=$_GET['ajout_eval'];
$donnee=mysqli_fetch_array(mysqli_query($con, "select date_dev,coeficient,n_devoir from devoir where numdev='$numdev'"));//  pour afficher les information du devoir k'il a choisis pour ajouter un devoir
$data=mysqli_query($con, "select numel,nomel,prenomel from eleve where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo')");//pour afficher les etudiants
?>
<form method="POST" action="ajout_eval.php" class="formulaire">
Class                 :          <?php echo $nomcl.' - '.$promo; ?><br/>
Course                :           <?php echo $nommat; ?><br/>
Semester               :           S<?php echo $semestre; ?><br/>
homework date           :           <?php echo $donnee['date_dev']; ?><br/>
Credit hour            :          <?php echo $donnee['coeficient']; ?><br/>
homework N°              :           <?php echo $donnee['n_devoir']; ?><br/>
Student               :        <select name="numel"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['numel'].'">'.$a['nomel'].' '.$a['prenomel'].'</option>';
}?></select><br/>
Grade                       :         <input type="text" name="note">
<input type="hidden" name="numdev" value="<?php echo $numdev; ?>">
<input type="image" src="button.png" style="margin-top:13px;">
</form>
<br/><br/><a href="ajout_eval.php">Return to main page !</a>
<?php }
else {
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");
?>
<h2>Please choose the Semester, promotion and class :</h2></br>
<form method="post" action="ajout_eval.php" class="formulaire">
Promotion       :         <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/>
<?php
$data=mysqli_query($con, "select distinct nom from classe"); ?>

Class                :        <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/>
Semester           :        <select name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/><br /><br />
<input type="submit" value="Show subjects">
</form>
<?php } ?>
</pre></center>
</div>
</body>
</html>