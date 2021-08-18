<?php
session_start();
include('DB.php');
// print_r($_SESSION);
$id=$_SESSION['user_id'];
$select="select * from products";
$result=mysqli_query($connection,$select);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

    <style>
        b{
            color: red;
        }
        .btn{
           background: blue; 
        
        }
    </style>
</head>
<body>
   
    <a href="logout.php"><button class="btn btn-primary">LOGOUT</button></a>
    <a href="cart.php?id=<?= $id; ?>"><button class="btn btn-primary">View Cart</button></a>
    <a href="my_order.php?id=<?= $id; ?>"><button class="btn btn-primary">My Orders</button></a>
    <h1>Hi..! Welcome to <b>E-CommeX</b><br><b>E-CommeX</b> Website developed by the team of: <b>InfoDeltaSys Software Solutions Pvt. Ltd.</b>
    <br>Thanks for connecting with Us...!</h1>
    <br/><br/>
    <div class="row">
        <h2 class="text-center">All Products..</h2>
        <?php
    while($row=mysqli_fetch_assoc($result)){
        //print_r($row);
    ?>
        <div class="col-sm-3" style="height: 328px; border:1px solid skyblue;">
                <div  style=" float: left;">
                    <br/><br/>
                    <img src="upload/<?php echo $row['picture']; ?>" class="responsive" style=" max-width:100%;">
                </div>
                <div id="myDIV" style="max-width:100%">                    
                    <div class="col-sm-6"><br/><br/>
                        <p><?php echo $row['p_name'];?></p>
                        <strong>₹<?php echo $row['price'];?></strong>
                    </div>
                    <div class="col-sm-6 text-right"><br/><br/>
                       <a href="buy.php"><button class="btn btn-warning">Buy Now</button></a>
                    </div>
                </div>
        </div> 
        <?php
    }
    ?> 
    </div>
    
</body>
</html>