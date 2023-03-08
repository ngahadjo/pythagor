<?php
session_start();
include('cadre.php');
?>
<div class="corp">
<img src="titre_img/affich_eleve.png" class="position_titre">
<pre>
<?php
if(isset($_GET['nomcl'])){//affichage de la promotion
$nomcl=$_GET['nomcl'];
$_SESSION['nomcl']=$_GET['nomcl'];//session du nomcl choisis dans le menu pour laisser la variable jusqu'a la page ou on va afficher la liste
$data=mysqli_query($con, "select promotion from classe where nom='$nomcl' order by promotion desc");
?>
<form action="listeEtudiant.php" method="POST" class="formulaire">
Please choose Promotion for the class <?php echo $_GET['nomcl']; ?>: <br/><br/>
   <FIELDSET>
 <LEGEND align=top>Promotion <LEGEND>  <pre>
 <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
<input type="submit" value="List">
</pre></fieldset>
</form>
<br/><br/><a href="index.php?">Go back to the previous page !</a>
<?php } 
if(isset($_POST['promotion'])){
$nomcl=$_SESSION['nomcl'];
$promo=$_POST['promotion'];
$donnee=mysqli_query($con, "select numel,nomel,prenomel,date_naissance,adresse,telephone,eleve.codecl,nom,promotion from eleve,classe where eleve.codecl=classe.codecl and nom='$nomcl' and promotion='$promo'");
?>
<center><table id="rounded-corner">
<thead><?php echo Edition(); ?><th class="<?php echo rond();?>">Last Name</th>
<th class="rounded-q2">First Name</th>
<th class="rounded-q2">DOB</th>
<th class="rounded-q2">Address</th>
<th class="rounded-q2">Phone</th>
<th class="rounded-q2">class</th>
<th class="rounded-q2">Promotion</th>
<th class="rounded-q4">Professors</th></thead>
<tfoot>
<tr>
<td colspan="<?php echo colspan(7,9); ?>" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($donnee)){
?>
<tr><?php if(isset($_SESSION['admin']) or isset($_SESSION['etudiant']) or isset($_SESSION['prof'])){
echo '<td><a href="modif_eleve.php?modif_el='.$a['numel'].'">modifier</a></td><td><a href="modif_eleve.php?supp_el='.$a['numel'].'" onclick="return(confirm(\'Are you sure you want to delete this entry? all records related to this entry will be lost\'));">supprimer</a></td>';}
echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['date_naissance'].'</td><td>'.$a['adresse'].'</td><td>'.$a['telephone'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td><td><a href="listeEtudiant.php?voir_ensei='.$a['numel'].'">See his Professor</a></td></tr>';
}
?>
<tbody>
</table></center>
<?php
echo '<br/><br/><a href="listeEtudiant.php?nomcl='.$nomcl.'">Go back to the previous page !</a>';
}
if(isset($_GET['voir_ensei'])){
$id=$_GET['voir_ensei'];
$data=mysqli_query($con, "select prof.nom,prenom,nomel,prenomel,classe.nom as nomcl,numsem,nommat,prof.adresse,promotion from prof,matiere,classe,eleve,enseignement where prof.numprof=enseignement.numprof and enseignement.codemat=matiere.codemat and eleve.codecl=classe.codecl and classe.codecl=enseignement.codecl and numel='$id'");
?>
<h2>The chosen student's teachers: </h2><br/>
<center><table id="rounded-corner">
<thead><th class="rounded-company">Last Name</th>
<th class="rounded-q2">First Name</th>
<th class="rounded-q2">Class</th>
<th class="rounded-q2">promotion</th>
<th class="rounded-q2">Professor Full Name</th>
<th class="rounded-q2">Semestre</th>
<th class="rounded-q4">Course</th></thead>
<tfoot>
<tr>
<td colspan="6" class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($data)){
?>
<tr><?php
echo '<td>'.$a['nomel'].'</td><td>'.$a['prenomel'].'</td><td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['nom'].' '.$a['prenom'].'</td><td>'.$a['numsem'].'</td><td>'.$a['nommat'].'</td></tr>';
}
?>
<tbody>
</table></center> <?php
}

?>
</pre>
</div>
