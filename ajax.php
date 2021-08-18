
<?php
session_start();
include "DB.php";

if($_POST['action'] == 'sub_product'){
    $prod_id = $_POST["prod_id"];
    $result2 = mysqli_query($connection,"SELECT * FROM products where p_id = $prod_id");
	echo "<option value=''>Select Product Type</option>";

    while($row = mysqli_fetch_array($result2)) {
		echo "<option value=". $row['sub_products'].">". $row['sub_products']."</option>";
    }
}


if($_POST['action'] == 'price'){
    $price = $_POST["price"];
    $result = mysqli_query($connection,"SELECT price FROM products where p_id = $price");
    if($row = mysqli_fetch_array($result)) {
    	
		echo "<option value=". $row['price'].">₹".$row['price']." per Kg</option>";
    }
}

if($_POST['action'] =='insert_order'){

    $prod_id =  $_POST['prod_id'];
    $user_id = $_SESSION['user_id'];
    $tamt =  $_POST['tamt'];
    $prod_qty= $_POST['prod_qty'];
    $file =  $_POST['file'];
    $date =  $_POST['date'];
    $query2 = "insert into orders(user_id,prod_id,weight,total_price,file,scheduled_date,status,date) values('$user_id','$prod_id','$prod_qty','$tamt','$file','$date',1,now())";
    $st=mysqli_query($connection, $query2);
    die();
}

if($_POST['action'] == 'update_status'){
    $id = $_POST["id"];
    mysqli_query($connection,"update orders set status='0' where id = '$id'");
}

if($_POST['action'] == 'delete_cart'){
    $product_id = $_POST["prod_id"];
    mysqli_query($connection,"DELETE FROM `cart` WHERE prod_id = '$product_id'");
    echo("DELETE FROM `cart` WHERE id = '$product_id'");
}

?>
