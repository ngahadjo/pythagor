<?php
//session_start();
/*****Verification du mot de passe ****/
if(isset($_POST['mdp'])){
if($_POST['mdp']!="" and $_POST['pseudo']!=""){
	$mdp=$_POST['mdp'];
	$pseudo=$_POST['pseudo'];
	$nb=mysqli_fetch_array(mysqli_query($con, "select count(*) as nb,type,Num from login where pseudo='$pseudo' and passe='$mdp'"));
	if($nb['nb']==1){
		if($nb['type']=="etudiant")
			$_SESSION['etudiant']=$nb['Num'];
		else if($nb['type']=="prof")
			$_SESSION['prof']=$nb['Num'];
		else if($nb['type']=="admin")
			$_SESSION['admin']=$nb['Num'];
	}
	else{
	?>	<SCRIPT LANGUAGE="Javascript">alert("Incorrect login or password");</SCRIPT> 	<?php
	}
	}
	else{
	?> 	<SCRIPT LANGUAGE="Javascript">alert("You must fill all the fields!");	</SCRIPT> 	<?php
	}
}
else if(isset($_GET['sortir'])){
session_destroy();
header("location:index.php");
}
Function colspan($min,$max){
if(isset($_SESSION['admin']))
	return $max;
else
	return $min;
}
Function rond(){
if(isset($_SESSION['admin']))
	return 'rounded-q1';	
else
	return 'rounded-company';
}
Function Edition(){
 if(isset($_SESSION['admin']))
 return '<th colspan="2" class="rounded-company">EDITION</th>';
 else
 return '';
}
Function Edition2(){//si on veut affcher edtition pour le prof aussi
 if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
 return '<th colspan="2" class="rounded-company">EDITION</th>';
 else
 return '';
}
Function rond2(){//si on veut affcher edtition pour le prof aussi
if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
	return 'rounded-q1';	
else
	return 'rounded-company';
}
Function colspan2($min,$max){//si on veut affcher edtition pour le prof aussi
if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
	return $max;
else
	return $min;
}
Function choixpardefault2($var1,$var2)//pour selection l'element à modifier par defautl
{
if($var1==$var2)
return 'selected="selected"';
else
return "";
}

$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
$data=mysqli_query($con, "select distinct nom from classe");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<link rel="stylesheet" media="screen" type="text/css" title="Essai" href="style.css" />
<link rel="stylesheet" media="screen" type="text/css" title="Essai" href="table.css" />
<body>
<div class="ombre"></div>
<div class="entete"><center></center></div>

<div class="menu">
&nbsp;&nbsp;&nbsp;<font color="white">Menu</font><br/><br/>
<div id="monmenu" >
		<ul class="niveau1">
			<li><a href="1" class="fly">Student </a>
				<ul class="niveau2" style="top : 4px;">
					<li><a href="listeEtudiant.php?list=true">Consult the list</a>
						<ul class="niveau3">
						<?php $retour=mysqli_query("select distinct nom from classe");
							while($a=mysqli_fetch_array($retour)){
							echo '<li><a href="listeEtudiant.php?nomcl='.$a['nom'].'">'.$a['nom'].'</a></li>';				
							}
							?>
						</ul>
					</li>
					<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){/*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/
					echo '<li><a href="afficher_note.php">Consult the Grade</a>
							<ul class="niveau3">';
								while($nomcl=mysqli_fetch_array($data)){
								echo '<li><a href="afficher_note.php?nomcl='.$nomcl['nom'].'">'.$nomcl['nom'].'</a></li>';
								}
						echo '</ul>
						</li>';
				if(!isset($_SESSION['prof'])){ echo '<li><a href="Ajout_etudiant.php">Add a student</a></li>';
					} }
				if(isset($_SESSION['etudiant'])){ echo '<li><a href="note_etudiant.php">Consult the Grade</a></li>'; } ?>
					<li><a href="chercher_eleve.php?cherche_eleve=true">Search student</a></li>
				</ul>
			</li>
			<li><a href="#">Professor</a>
				<ul class="niveau2" >
					<li><a href="afficher_prof.php">Professor list</a></li>
					<?php if((isset($_SESSION['admin'])) or (isset($_SESSION['prof']))){
					if(!isset($_SESSION['prof'])){echo '<li><a href="ajout_prof.php">Add Professor</a></li>';}
					}
					?>	
					<li><a href="chercher_prof.php?cherche_prof=true">Search Professor</a></li>
				</ul>
			</li>
			<?php
			$data=mysqli_query($con, "select distinct nom from classe");
			echo '<li><a href="#">Classes</a>
					<ul class="niveau2" >
						<li><a href="affiche_classe.php">View Classes</a></li>';
						if(!isset($_SESSION['admin']))
						echo '</ul>';
						 else{
						echo '<li><a href="ajout_classe.php">Add a class</a></li>
					</ul>
				</li>';	}?>
			<li><a href="#">Stages</a>
					<ul class="niveau2" >
						<li><a href="afficher_stage.php">See internship</a></li>
					<?php if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_stage.php">Add an internship</a></li>'; } ?>
						<li><a href="chercher_stage.php?cherche_stage=true">Search internship</a></li>
					</ul>
			</li>			
			<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ echo '<li><a href="#">Advisor</a>
					<ul class="niveau2" >';
					echo '<li><a href="affiche_conseil.php">See advisor</a></li>'; 
					if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_conseil.php">Add Advisor</a></li>'; } 
				echo '</ul>
				</li>'; } ?>
			<li><a href="#">Course </a>
				<ul class="niveau2">
					<li><li><a href="#">See Courses</a>
						<ul class="niveau3">
							<?php	while($nomcl=mysqli_fetch_array($data)){
								echo '<li><a href="afficher_matiere.php?nomcl='.$nomcl['nom'].'">'.$nomcl['nom'].'</a></li>';
								}
					echo '</ul>
					</li>';
				if(isset($_SESSION['admin'])){ echo '<li><li><a href="ajout_matiere.php">Add Course</a></li>'; }
				echo '</ul>
			</li>';
			if(isset($_SESSION['admin']) or isset($_SESSION['prof'])){ echo'<li><a href="#">Grade</a>
				<ul class="niveau2">';
					//if(isset($_SESSION['admin'])){ echo '<li><a href="ajout_bulettin.php">Ajouter une note final</a></li>'; }
				 echo '<li><a href="afficher_bulettin.php">final grade of a student</a></li>'; 
			echo'</ul>
			</li>';}
			echo '<li><a href="#">Diplomas</a>
				<ul class="niveau2">
					<li><a href="type_diplome.php">Types of degrees</a></li>';
					 if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
					echo '<li><a href="diplome_obt.php">Degrees obtained</a></li>	';
					if(isset($_SESSION['admin']))
					echo '<li><a href="ajout_diplome.php?ajout_type">Add a new type</a></li>
					<li><a href="ajout_diplome.php?ajout_diplome">Add an achievement </a>	</li>'; ?>
				</ul>
			</li>
		<?php if(isset($_SESSION['admin']) or isset($_SESSION['prof']))
			echo '<li><a href="#">Evalutation</a>
						<ul class="niveau2">
							<li><a href="ajout_eval.php">Add a rating</a></li>
							<li><a href="afficher_evaluation.php">See reviews</a></li>
						</ul>
					</li>	
			<li><a href="ajout_devoir.php">Devoirs</a>
				<ul class="niveau2">
				<li><a href="ajout_devoir.php">Add an assignment</a></li>
				<li><a href="afficher_devoir.php">See homework</a></li>
				</ul>
			</li>';
		?>	
			<li><a href="#">Major </a>
				<ul class="niveau2" >
					<li><a href="afficher_enseign.php">See Major</a></li>
					<?php if(isset($_SESSION['admin'])){/*!(isset($_SESSION['prof'])) and !(isset($_SESSION['public'])) and !(isset($_SESSION['etudiant']))*/
					echo '<li><a href="ajout_enseignement.php">Add Major</a></li>';
					} ?>
				</ul>
			</li>		
		</ul>
	</div>
		<?php  ?>
		</div>
<div class="connexion2">
&nbsp;&nbsp;&nbsp;<font color="white">Login</font><br/>
<br/>
<?php if(!(isset($_SESSION['admin'])) and !isset($_SESSION['prof']) and !isset($_SESSION['etudiant'])){
?>
<form action="index.php" method="post">
<FIELDSET>
<LEGEND align=top>Authentication<LEGEND>  <pre>
Login :<br/><input type="text" name="pseudo" size="15">
Password :<br/><input type="password" name="mdp" size="15"><br/><br/><input type="submit" value="login"><br/>
</pre></fieldset>
</form>
<?php
}
else
echo '<br/><br/><br/><li><a href="index.php?sortir=1">Logout</a></li>';
?>
</div>
<div class="pied"><br/><center>&reg; 2023 Pytagor By Fabrice Ngahadjo</center></div>