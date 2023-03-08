<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "root", "");
mysqli_select_db($con, "gestion");
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");
$retour=mysqli_query($con, "select distinct nom from classe"); //pour afficher les classe existantes
?>
<html>
<body>
<div class="corp">
<img src="titre_img/affich_stage.png" class="position_titre">
<center><pre>
<?php
if(isset($_POST['nomcl']) and isset($_POST['promotion'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$donnee=mysqli_query($con, "select numstage,nomel,prenomel,nom,promotion,date_debut,date_fin,lieu_stage from eleve,stage,classe where classe.codecl=eleve.codecl and eleve.numel=stage.numel and classe.nom='$nomcl' and promotion='$promo'");//select nommat from matiere,classe where matiere.codecl=classe.codecl and classe.nom='$classe'
?><center><table id="rounded-corner">
<thead><tr><?php echo Edition(); ?>
<th class="<?php echo rond(); ?>">Student Last name</th>
<th class="rounded-q2">Student First Names</th>
<th class="rounded-q2">Class</th>
<th class="rounded-q2">Promotion</th>
<th class="rounded-q2">start date</th>
<th class="rounded-q2">end date</th>
<th class="rounded-q4">internship location</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(6,8); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '<td><a href="ajout_stage.php?modif_stage='.$a['numstage'].'" >modifier</a></td><td><a href="supp_stage.php?supp_stage='.$a['numstage'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">Supprimer</td>'; } echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['date_debut'].'</td><td>'.$a['date_fin'].'</td><td>'.$a['lieu_stage'].'</td></tr>'; //style="width:100px; height:22px; background-image: url(\'ajouter.png\'); color:red;  padding: 2px 0 2px 20px; display:block; background-repeat:no-repeat;"
}
?>
</tbody>
</table></center>
<?php
}//fin   if(isset($_POST['radio']
else{ ?>

<form method="post" action="afficher_stage.php" class="formulaire">
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
<?php }
?>
<br/><br/><a href="afficher_stage.php">Go back to the previous page !</a>
</pre></center>
</div>
</body>
</html>