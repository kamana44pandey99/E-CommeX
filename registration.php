<?php
session_start();
include('DB.php');
$name=$_POST['user'];
$email=$_POST['emailid'];
$password=$_POST['password'];

$select="select * from users where email='$email'";
$result=mysqli_query($connection,$select);
$num=mysqli_num_rows($result);
if($num==1)
{
    header('location:index.php');

    echo" user already exists";
}
else
{

    $reg="insert into users(name,email,password) values('$name','$email','$password')";
    mysqli_query($connection,$reg);
    header('location:index.php');

}
?>