<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
?>
<div class="corp">
<img src="titre_img/ajout_conseil.png" class="position_titre">
<pre>
<?php
if(isset($_POST['nomcl']) and isset($_POST['radiosem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$semestre=$_POST['radiosem'];
$code_classe=mysqli_fetch_array(mysqli_query($con, "select codecl from classe where nom='$nomcl' and promotion='$promo'"));
$codecl=$code_classe['codecl'];


$compte=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from conseil where numsem='$semestre' and codecl='$codecl'"));
if($compte['nb']>0){
?>
<SCRIPT LANGUAGE="Javascript">alert("error! This advisor already exists ");</SCRIPT>
<?php
}
else{
mysqli_query($con, "insert into conseil(numsem,codecl) values ('$semestre','$codecl')");
/*
  on the eve of each class council: we assume that a student takes 2 assignments in the same subject in a semester, we specify the semester in the request, so if we group by number and codemat we will find a maximum of 2 notes
*/
$bulletin=mysqli_query($con, "select eleve.numel,matiere.codemat,avg(note) as moyen from eleve,devoir,matiere,evaluation,classe where matiere.codemat=devoir.codemat and classe.codecl=devoir.codecl and devoir.numdev=evaluation.numdev and evaluation.numel=eleve.numel and devoir.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and numsem='$semestre' group by numel,matiere.codemat");
while($b=mysqli_fetch_array($bulletin)){
$numel=$b['numel'];
$codemat=$b['codemat'];
$notef=$b['moyen'];
mysqli_query($con, "insert into bulletin(numsem,numel,codemat,notefinal) values('$semestre','$numel','$codemat','$notef')");
}
?>	<SCRIPT LANGUAGE="Javascript">alert("Added successfully!");</SCRIPT> 	<?php
}
?>
<br/><br/><a href="ajout_conseil.php">Go back to the previous page !</a>
</form>

<?php
}
else {
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");
$retour=mysqli_query($con, "select distinct nom from classe"); // afficher les classes
?>
<form method="post" action="ajout_conseil.php" class="formulaire">
Please choose the Semester, promotion and class :<br/><br/><br/>
Promotion      :       <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Class              :       <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
Semester        :        <select name="radiosem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="Validate advisor">
</form>
<?php } ?>
</pre>
</div>
</body>
</html>