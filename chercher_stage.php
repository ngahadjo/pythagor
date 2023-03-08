<?php
session_start();
include('cadre.php');
if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])){
echo '<html> <body> <div class="corp"> ';
echo '<img src="titre_img/cherche_stage.png" class="position_titre"><center><pre>';
if(isset($_GET['cherche_stage'])){ 
$retour=mysqli_query($con, "select distinct nom from classe"); // afficher les classes
$data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");
?>

<form action="chercher_stage.php" method="post" class="formulaire">
Last Name          :     <input type="text" name="nomel"><br/><br/>
First Name     :     <input type="text" name="prenomel"><br/><br/>
you can specify the promotion if you want : <br/><select name="promotion"> 
<option value="">Choose promotion</option>
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
You can specify the class if you want: :<br/> <select name="nomcl"> 
<option value="">Choose class</option>
<?php while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<input type="image" src="chercher.png">
</form>
<br/><br/><a href="index.php">Return to main page!</a>
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
	$cherche=mysqli_query($con, "select * from eleve,stage,classe where classe.codecl=eleve.codecl and stage.numel=eleve.numel and nomel LIKE '%$nomel%' and prenomel LIKE '%$prenomel%' ".$option."");//option contient les info suplimentaire
?>
<center><table id="rounded-corner">
<thead><tr><th class="rounded-company">Nom</th>
<th class="rounded-q1">Prenom</th>
<th class="rounded-q3">Lieu du stage</th>
<th class="rounded-q3">Date de debut</th>
<th class="rounded-q3">Date de fin</th>
<th class="rounded-q3">Classe</th>
<th class="rounded-q4">Promotion</th></tr></thead>
<tfoot>
<tr><td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td></tr>
</tfoot>
 <tbody>
 <?php
	while($a=mysqli_fetch_array($cherche)){
		echo '<tr><td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td >'.$a['lieu_stage'].'</td><td >'.$a['date_debut'].'</td><td >'.$a['date_fin'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td></tr>';
	}
	?>
	</tbody>
	</table></center>
	<br/><br/><a href="chercher_stage.php?cherche_stage=true">Return to main page !</a>
	<?php
	}
}
?>
</pre>
</div>
</center>
</body>
</html>