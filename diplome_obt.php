<?php
session_start();
include('cadre.php');
?>
<html>
<body>
<div class="corp">
<img src="titre_img/obt_diplome.png" class="position_titre">
<center><pre>
<?php
if(isset($_POST['nomcl']) and isset($_POST['promotion'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$donnee=mysqli_query($con, "select id,titre_dip,nomel,prenomel,nom,promotion,note,commentaire,etablissement,lieu,annee_obtention from eleve,eleve_diplome,classe,diplome where diplome.numdip=eleve_diplome.numdip and classe.codecl=eleve.codecl and eleve.numel=eleve_diplome.numel and classe.nom='$nomcl' and promotion='$promo'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
?><center><table id="rounded-corner">
<thead><tr><?php echo Edition(); ?>
<th class="<?php echo rond(); ?>">First Names</th>
<th class="rounded-q2">Last Names</th>
<th class="rounded-q2">Class</th>
<th class="rounded-q2">Promotion</th>
<th class="rounded-q2">Title_dipploma</th>
<th class="rounded-q2">GPA</th>
<th class="rounded-q2">Comment</th>
<th class="rounded-q2">University</th>
<th class="rounded-q2">State</th>
<th class="rounded-q4">Year</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(9,11); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '<td><a href="modif_diplome.php?modif_dip='.$a['id'].'" >modifier</a></td><td><a href="modif_diplome.php?supp_dip='.$a['id'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">Supprimer</td>'; } echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['titre_dip'].'</td><td>'.$a['note'].'</td><td>'.$a['commentaire'].'</td><td>'.$a['etablissement'].'</td><td>'.$a['lieu'].'</td><td>'.$a['annee_obtention'].'</td></tr>'; //style="width:100px; height:22px; background-image: url(\'ajouter.png\'); color:red;  padding: 2px 0 2px 20px; display:block; background-repeat:no-repeat;"
}
?>
</tbody>
</table></center>
<br/><br/><a href="diplome_obt.php">Return to main page </a>
<?php
}//fin   if(isset($_POST['radio']
else{ 
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");
$retour=mysqli_query($con, "select distinct nom from classe");
?>
<form method="post" action="diplome_obt.php" class="formulaire">
Please choose class and promotion :<br/><br/>
Promotion       :       <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Class              :       <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<input type="submit" value="View Internships">
</form>
<br/><br/><a href="index.php">Return to main page </a>
<?php }
?>

</pre></center>
</div>
</body>
</html>