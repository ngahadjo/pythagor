<?php
session_start();
include('cadre.php');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
?>
<html>
<div class="corp">

<img src="titre_img/ajout_classe.png" class="position_titre">
<center><pre>
<div class="formulaire">

<?php
if(isset($_POST['numprof'])){//if he clicked on add the 2nd time
$nomcl=$_POST['nomcl'];
$numprof=$_POST['numprof'];
$promo=$_POST['promotion'];
$compte=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb from classe where nom='$nomcl' and promotion='$promo'"));
$bool=true;
if($compte['nb']>0){
$bool=false;
echo '<h2>Erreur d\'insertion, l\'enregistrement existe déja </h2>';
}
if($bool==true){
mysqli_query($con, "insert into classe(nom,numprofcoord,promotion) values ('$nomcl','$numprof','$promo')");
?> <SCRIPT LANGUAGE="Javascript">	alert("Added successfully!"); </SCRIPT> <?php
}
echo '<br/><a href="ajout_classe.php">Go back to the previous page !</a>';
}
else {
$data=mysqli_query($con, "select numprof,nom from prof");//select pour les promotions
 ?>
 <form action="ajout_classe.php" method="POST">
 Classe Name        :       <input type="text" name="nomcl"><br/><br/>
 Promotion            :      <input type="text" name="promotion"><br/><br/>
 Coordinating teacher : <select name="numprof"> <br/><br/>
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['numprof'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<center><input type="image" src="button.png"></center>
</form>
<br/><a href="index.php">Return to main page !</a>
</div>
</pre></center>
<?php
}
?>
</div>
</pre>
</center>
</div>
</html>
