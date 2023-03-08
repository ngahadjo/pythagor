<?php
session_start();
include('cadre.php');
$data=mysqli_query($con, "select distinct Promotion from Class order by Promotion desc");
$retour=mysqli_query($con, "select distinct nom from Class"); //pour afficher les Class existantes
?>
<div class="corp">
<img src="titre_img/affiche_conseil.png" class="position_titre">
<center><pre>
<?php
if(isset($_GET['supp_conseil'])){
$id=$_GET['supp_conseil'];
mysqli_query("delete from conseil where id='$id'");
?> <SCRIPT LANGUAGE="Javascript">	alert("Successfully deleted!"); </SCRIPT> <?php
}
else if(isset($_POST['nomcl']) and isset($_POST['numsem'])){
$nomcl=$_POST['nomcl'];
$promo=$_POST['Promotion'];
$numsem=$_POST['numsem'];
$donnee=mysqli_query($con, "select * from Class,conseil where Class.codecl=conseil.codecl and Class.codecl=(select codecl from Class where nom='$nomcl' and Promotion='$promo') and numsem='$numsem'");//select nommat from matiere,Class where matiere.codecl=Class.codecl and Class.nom='$Class'
?><center><table id="rounded-corner">
<thead><tr><?php if(isset($_SESSION['admin'])) echo '<th class="rounded-company">DELETE</th>'; ?>
<th class="<?php echo rond(); ?>">Semester</th>
<th class="rounded-q4">Class</th>
</tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(1,2); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
if(isset($_SESSION['admin'])){
echo '</td><td><a href="affiche_conseil.php?supp_conseil='.$a['id'].'" onclick="return(confirm(\'Are you sure you want to delete this entry?\'));">DELETE</td>'; } echo '<td>S'.$a['numsem'].'</td><td>'.$a['nom'].'</td></tr>';
}
?>
</tbody>
</table></center>
<?php
}//fin   if(isset($_POST['radio']
else{ ?>

<form method="post" action="affiche_conseil.php" class="formulaire">
Please choose class and Promotion :<br/><br/>
Class              :       <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
Promotion        :       <select name="Promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['Promotion'].'">'.$a['Promotion'].'</option>';
}?></select><br/>
Semester           :        <select name="numsem"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semester'.$i.'</option>'; } ?>
</select><br/><br/>
<input type="submit" value="View Internships">
</form>
<?php }
?>
<br/><br/><a href="affiche_conseil.php">Go back to the previous page!</a>
</pre></center>
</div>
</body>
</html>