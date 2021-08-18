<?php
session_start();

include('DB.php');
$email=$_POST['emailid'];
$password=$_POST['password'];
$select="select * from users where email='$email' && password='$password'";
$result=mysqli_query($connection,$select);
$row=mysqli_fetch_assoc($result);
$num=mysqli_num_rows($result);
if($num==1)
{
    $_SESSION['email'] = $row['email'];
    $_SESSION['user_id'] = $row['id'];
    header('location:dashboard.php');

}
else
{
    header('location:index.php');
}
?>
