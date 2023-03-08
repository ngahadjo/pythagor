<?php
session_start();
$con = mysqli_connect("localhost", "root", "");
mysqli_select_db($con, "gestion");
?>
<html>
<body>
<?php
include('cadre.php');
?>
<div class="corp">
</div>
</body>
</html>
