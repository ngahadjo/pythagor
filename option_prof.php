<?php
session_start();
include('cadre.php');

echo '<div class="corp">';
if(isset($_GET['matiere'])){
$id=$_GET['matiere'];
$data=mysqli_query($con, "select prof.nom,prenom,nommat,classe.nom as nomcl,promotion,numsem from prof,enseignement,matiere,classe where enseignement.numprof=prof.numprof and classe.codecl=enseignement.codecl and matiere.codemat=enseignement.codemat and  enseignement.numprof='$id' order by promotion desc");
?>
<center><h1>Subjects taught by this teacher</h1></center>
<table id="rounded-corner">
<thead><tr> <th scope="col" class="rounded-company">Last Name</th>
 <th scope="col" class="rounded-q2">First Names</th>
 <th scope="col" class="rounded-q2">Course</th>
 <th scope="col" class="rounded-q2">Class</th>
 <th scope="col" class="rounded-q2">Promotion</th>
 <th scope="col" class="rounded-q4">Semester</th></tr></thead>
<tfoot>
<tr>
<td colspan="5"class="rounded-foot-left"><em>&nbsp;</em></td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($data)){
echo '<tr><td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['nommat'].'</td><td>'.$a['nomcl'].'</td><td>'.$a['promotion'].'</td><td>'.$a['numsem'].'</td></tr>';
}
?>
<tbody>
</table>
<?php 
}
else if(isset($_GET['classe'])){
$id=$_GET['classe'];
$data=mysqli_query($con "select * from prof,classe where numprof=numprofcoord and numprof='$id' order by promotion desc");
?>
<center><h1>Classe coordonées par cet enseignant</h1></center>
<table id="rounded-corner">
<thead><tr> <th scope="col" class="rounded-company">Last Name</th>
 <th scope="col" class="rounded-q2">First Name</th>
 <th scope="col" class="rounded-q2">Class Place</th>
 <th scope="col" class="rounded-q4">Promotion</th></tr></thead>
<tfoot>
<tr>
<td colspan="3" class="rounded-foot-left">&nbsp;</td>
<td class="rounded-foot-right">&nbsp;</td>
</tr>
</tfoot>
 <tbody>
<?php
while($a=mysqli_fetch_array($data)){
echo '<tr><td>'.$a['nom'].'</td><td>'.$a['prenom'].'</td><td>'.$a['nom'].'</td><td>'.$a['promotion'].'</td></tr>';
}
?>
<tbody>
</table>
<?php
}
?>
</div>