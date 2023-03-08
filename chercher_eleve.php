<?php
session_start();
include('cadre.php');
if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])){
echo '<div class="corp">';
echo '<img src="titre_img/cherche_eleve.png" class="position_titre"><center>';
if(isset($_GET['cherche_eleve'])){ 
$retour=mysqli_query($con, "select distinct nom from classe"); // afficher les classes
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");
?>
<pre>
<form action="chercher_eleve.php" method="post" class="formulaire">
   <FIELDSET>
 <LEGEND align=top>Search criteria<LEGEND>  <pre>
Last Name          :        <input type="text" name="nomel"><br/><br/>
First Name      :       <input type="text" name="prenomel"><br/><br/>
you can specify the promotion if you want : <br/><select name="promotion"> 
<option value="">Choose promotion</option>
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
You can specify the class if you want: <br/><select name="nomcl"> 
<option value="">Choose class</option>
<?php while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/>
<center><input type="image" src="chercher.png"></center>
</pre></fieldset>
</form><a href="index.php">Return to main page!</a>
<?php
}
else if(isset($_POST['nomel'])){
	$nomel=$_POST['nomel'];
	$prenomel=$_POST['prenomel'];
	$nomcl=$_POST['nomcl'];
	$promo=$_POST['promotion'];
	$option="";
	if($nomcl!="" and $promo=="")
	$option="and eleve.codecl in (select codecl from classe where nom='$nomcl')";
	else if($promo!="" and $nomcl=="")
	$option="and eleve.codecl in (select codecl from classe where promotion='$promo')";
	else if($promo!="" and $nomcl!="")
	$option="and eleve.codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo')";
	$cherche=mysqli_query($con, "select * from eleve,classe where classe.codecl=eleve.codecl and nomel LIKE '%$nomel%' and prenomel LIKE '%$prenomel%' ".$option."");//option contient les info suplimentaire
?>
<table id="rounded-corner">
<thead><tr><th class="rounded-company">Last Name</th>
<th class="rounded-q1">First</th>
<th class="rounded-q3">Address</th>
<th class="rounded-q3">DOB</th>
<th class="rounded-q3">Phone</th>
<th class="rounded-q3">Class</th>
<th class="rounded-q4">Promotion</th></tr></thead>
<tfoot>
<tr><td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td></tr>
</tfoot>
 <tbody>
 <?php
	while($a=mysqli_fetch_array($cherche)){
		echo '<tr><td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td >'.$a['adresse'].'</td><td >'.$a['date_naissance'].'</td><td >'.$a['telephone'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td></tr>';
	}
	?>
	</tbody>
	</table>
	<a href="chercher_eleve.php?cherche_eleve=true">Go back to the previous page !</a>
	<?php
	}
}
?>
</div>
</pre>
</center>
</body>
</html>