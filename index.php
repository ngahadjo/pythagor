<?php
session_start();
$con = mysqli_connect("localhost", "oracle", "abc123");
mysqli_select_db($con, "webserver");
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
