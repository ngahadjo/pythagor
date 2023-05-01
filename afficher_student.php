<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
?>

<html>
<div class="corp">
<img src="titre_img/affich_prof.png" class="position_titre">
<pre>
<?php
$data=mysqli_query($con, "select * from eleve");
?>
<center><table id="rounded-corner">
<thead><tr><?php echo Edition();?>
 <th scope="col" class="<?php echo rond(); ?>">First Name</th>
 <th scope="col" class="rounded-q2">Last Name</th>
 <th scope="col" class="rounded-q2">Address</th>
 <th scope="col" class="rounded-q2">Phone</th>
 <th scope="col" class="rounded-q2">course taught</th>
 <th scope="col" class="rounded-q4">Coordinated classes</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(5,7); ?>"class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($con, $data)){
?>
<tr><?php if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])){
echo '<tr><td><a href="modif_prof.php?modif_prof='.$a['numprof'].'">modifier</a></td><td><a href="modif_prof.php?supp_prof='.$a['numprof'].'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer cette entrée?\'));">supprimer</a></td>';}
echo '<td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['adresse'].'</td><td>'.$a['telephone'].'</td><td><a href="option_prof.php?matiere='.$a['numprof'].'">Voir</a><td><a href="option_prof.php?classe='.$a['numprof'].'">Voir</a></tr>';
}
?>
<tbody>
</table></center>
<?php
echo '<br/><br/><a href="index.php">Go back to the previous page !</a>';
?>
</pre>
</div>
</html>
