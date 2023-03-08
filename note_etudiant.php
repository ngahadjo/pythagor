<?php
session_start();
include('cadre.php');
if(isset($_SESSION['etudiant'])){
$id=$_SESSION['etudiant'];
$data=mysqli_query($con, "select bulletin.numel,nomel,prenomel,nommat,numsem,promotion,notefinal,nom from matiere,bulletin,eleve,classe where classe.codecl=eleve.codecl and bulletin.numel=eleve.numel and matiere.codemat=bulletin.codemat and eleve.numel='$id' order by numsem");
?>
<div class="corp">
<img src="titre_img/affich_stage.png" class="position_titre">
<pre>
<center><table id="rounded-corner">
<thead><tr><th class="rounded-company">Last Name</th>
<th class="rounded-q2">First Name</th>
<th class="rounded-q2">Class</th>
<th class="rounded-q2">Promotion</th>
<th class="rounded-q2">Course</th>
<th class="rounded-q2">noFinal Grade</th>
<th class="rounded-q4">Semester</th></tr></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
<tbody>
<?php
while($a=mysqli_fetch_array($data)){
echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nommat'].'</td><td>'.$a['notefinal'].'</td><td>S'.$a['numsem'].'</td></tr>';
}
?>
</tbody>
</table></center>
<br/><br/><a href="index.php">Go back to the previous page !</a>
</pre></center>
</div>
<?php } ?>
</html>