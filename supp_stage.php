<?php
session_start();
include('cadre.php');

?>
<html>
<div class="corp">
<center><h1>Delete the intership</h1></center>
<div class="formulaire">
<?php
if(isset($_GET['supp_stage'])){
$id=$_GET['supp_stage'];
mysqli_query($con, "delete from stage where numstage='$id'");
echo '<h1>Successfully deleted ! </h1>';
echo '<br/><br/><a href="index.php">Come back to the home page !</a>';
}
?>
</div>
</div>
</html>

