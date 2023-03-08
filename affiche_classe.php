<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
?>
<div class="corp">
<img src="titre_img/affich_classe.png" class="position_titre">
<center>
<?php
$data=mysqli_query($con, "select codecl,classe.nom as nomcl,promotion,prof.nom as nomprof from classe,prof where classe.numprofcoord=prof.numprof");
?>
<table id="rounded-corner">
<thead><tr><?php echo Edition();?>
 <th class="<?php echo rond(); ?>">Class name</th>
 <th class="rounded-q1">Promotion</th>
 <th class="rounded-q4">Coordinating teacher</th></tr></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(2,4); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($data)){
?>
<tr><?php if(isset($_SESSION['admin'])){ 
?><td><a href="modif_classe.php?modif_classe=<?php echo $a['codecl']; ?>">Update</a></td><td><a href="modif_classe.php?supp_classe=<?php echo $a['codecl']; ?>" onclick="return(confirm('Are you sure you want to delete this entry?\all records related to this entry will be lost'));">Delete</a></td> <?php }
echo '<td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nomprof'].'</td></tr>';
}
?>
<tbody>
</table>
<?php
echo '<br/><br/><a href="index.php">Go back to the previous page !</a>';
?>
</center>
</div>
</html>