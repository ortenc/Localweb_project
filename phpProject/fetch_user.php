<?php
include('database.php.');

session_start();
$user_id = $_SESSION['id'];

$query = "    
SELECT * FROM users 
WHERE id != '".$_SESSION['id']."' 
";

$rs = mysqli_query($conn, $query);

$check = mysqli_fetch_assoc($rs);

$output = '
<table class="table table-bordered table-striped">
 <tr>
  <td>Username</td>
  <td>Status</td>
  <td>Action</td>
 </tr>
';

foreach($rs as $row)
{
    $output .= '
 <tr>
  <td>'.$row['name'].'</td>
  <td></td>
  <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['name'].'">Start Chat</button></td>
 </tr>
 ';
}

$output .= '</table>';

echo $output;

?>