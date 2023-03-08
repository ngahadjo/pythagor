<?php
session_start();
include('cadre.php');
include('calendrier.html');
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
?>
<html>
<div class="corp">
<center><pre><img src="titre_img/ajout_devoir.png" class="position_titre">
<form action="ajout_devoir.php" method="POST" class="formulaire">
<?php
if(isset($_POST['nomcl'])){
$_SESSION['nomcl']=$_POST['nomcl'];
$nomcl=$_POST['nomcl'];
$promo=$_POST['promotion'];
$_SESSION['promo']=$promo;
$donnee=mysqli_query($con, "select codemat,nommat from matiere,classe where matiere.codecl=classe.codecl and nom='$nomcl' and promotion='$promo'");
?>
<FIELDSET>
<LEGEND align=top>Add an assignment<LEGEND><pre>
Matiére                   :          <select name="choix_mat" id="choix">
<?php
while($a=mysqli_fetch_array($donnee)){
   echo '<option value="'.$a['codemat'].'">'.$a['nommat'].'</option>';
}
?>
</select><br/><br/>
assignment date        :              <input type="text" name="date" class="calendrier"><br/>
Credit hour              :       <select name="coefficient"><?php for($i=1;$i<=15;$i++){ echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
</select><br/><br/>
Semestre                  :      <select name="semestre"><?php for($i=1;$i<=4;$i++){ echo '<option value="'.$i.'">Semestre'.$i.'</option>'; } ?>
</select><br/>
1st / 2nd assignment    :       <input type="radio" name="devoir" value="1" id="choix1" /> <label for="choix1">1st homework</label>
                                          <input type="radio" name="devoir" value="2" id="choix2" /> <label for="choix2">2nd homework</label><br/>
<center><input type="image" src="button.png"></center>
</pre></fieldset>
</form>
<?php }
else if(isset($_POST['date'])){//s'il a cliquer sur ajouter la 2eme fois
$date=addslashes(Nl2br(Htmlspecialchars($_POST['date'])));
$coefficient=$_POST['coefficient'];
$semestre=$_POST['semestre'];
$codemat=$_POST['choix_mat'];
$nomcl=$_SESSION['nomcl'];
$n_devoir=$_POST['devoir'];
$promo=$_SESSION['promo'];

$data=mysqli_query($con, "select count(*) as nb from devoir where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and codemat='$codemat' and numsem='$semestre' and n_devoir='$n_devoir'");

$valider=mysqli_query($con, "select count(*) as nb from enseignement where codecl=(select codecl from classe where nom='$nomcl' and promotion='$promo') and codemat='$codemat' and numsem='$semestre'");

$nb=mysqli_fetch_array($data);

$nb2=mysqli_fetch_array($valider);

$bool=true;


	if($nb2['nb']!=0){
		$bool=false;
		echo '<br\><h2>Erreur d\'insertion!! This lesson does not exist </h2>';
	}

	if($nb['nb']>0){
		$bool=false;
		echo '<br\><h2>Insert error!! Incorrect assignment number (cannot add two similar assignments)</h2>';
	}
	if($bool==true){
	$codeclasse=mysqli_query($con, "select codecl from classe where nom='$nomcl' and promotion='$promo'");
	$code=mysqli_fetch_array($codeclasse);
	$codecl=$code['codecl'];
	mysqli_query($con, "insert into devoir(date_dev,coeficient,codemat,codecl,numsem,n_devoir) values('$date','$coefficient','$codemat','$codecl','$semestre','$n_devoir')");
	echo '<h1>Insertion avec succés </h1>';
	}
}
 else {
 $retour=mysqli_query($con, "select distinct nom from classe"); 
 $data=mysqli_query($con, "select distinct promotion from classe order by promotion desc");
 ?>
 <form action="ajout_devoir.php" method="POST">
    <FIELDSET>
 <LEGEND align=top>Class/promotion<LEGEND>  <pre>
Promotions      :        <select name="promotion"> 
<?php while($a=mysqli_fetch_array($data)){
echo '<option value="'.$a['promotion'].'">'.$a['promotion'].'</option>';
}?></select><br/><br/>
Classe               :         <select name="nomcl"> 
<?php while($a=mysqli_fetch_array($retour)){
echo '<option value="'.$a['nom'].'">'.$a['nom'].'</option>';
}?></select><br/><br/>
<center><input type="submit" value="Suivant"></center>
</pre></fieldset>
</form>
<?php } ?>
</pre></center>
</div>
</html>
