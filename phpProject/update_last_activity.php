<?php
include('database.php');

session_start();
$user_id = $_SESSION['id'];

$query = "
UPDATE login_details 
SET last_activity = now() 
WHERE login_details_id = '".$_SESSION["id"]."'
";

$rs = mysqli_query($conn,$query);

?>