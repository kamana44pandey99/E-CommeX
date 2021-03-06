<?php
session_start();
include("DB.php");
$uid = $_SESSION['user_id'];
$select="select * from orders as o left join products as p on o.prod_id=p.p_id where o.user_id = '$uid' order by o.status desc";
$results=mysqli_query($connection, $select);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

</head>
<body>

	<a href="logout.php"><button class="btn btn-primary">LOGOUT</button></a>
    <a href="cart.php?id=<?= $uid; ?>"><button class="btn btn-primary">View Cart</button></a>
    <h1>My All Orders</h1>
<?php
    while($rows=mysqli_fetch_assoc($results)){
    	//print_r($rows);
		         if($rows['status'] == 2 ){
		         ?>
    	     <div class="card mt-5 row">
		                    <div class="card-header ">
		                    	<div class="card-body ">
		                    		<h2>Current</h2>
			                    		<div class="col-md-6">
			                    			<img src="upload/<?= $rows['file']; ?>" style="width:200px;height: 200px;">
			                    		</div>
			                    		<div class="col-md-6">
			                    			<b>Id : <?= $rows['id']; ?></b><br>
			                    			<b>Product : <?= $rows['p_name']; ?></b><br/>
			                    			<b>Total Price : <?= $rows['price']; ?></b><br/>
			                    			<b>Scheduled Date : <?= $rows['scheduled_date']; ?></b>
			                    		</div>
			                    		<form method="post">
			                    			<input type="hidden" name="hidden" id="hidden" value="<?= $rows['id'];?>">
			                    			<button type="submit" class="btn btn-danger" id="cancel" >Cancel Order</button>
			                    		</form>
		                    	</div>
		                    	
		                    </div>
		         </div>
		         <?php
		       }
		         if($rows['status'] == 1){
		         ?>
		         <div class="card mt-5 row">
		                    <div class="card-header ">
		                    	<div class="card-body ">
		                    		<h2>Completed</h2>
			                    		<div class="col-md-6">
			                    			<img src="upload/<?= $rows['file']; ?>" style="width:200px;height: 200px;">
			                    		</div>
			                    		<div class="col-md-6">
			                    			<b>Id : <?= $rows['id']; ?></b><br>
			                    			<b>Product : <?= $rows['p_name']; ?></b><br/>
			                    			<b>Total Price : <?= $rows['price']; ?></b><br/>
			                    			<b>Scheduled Date : <?= $rows['scheduled_date']; ?></b>
			                    		</div>
			                    		<form method="post">
			                    			<input type="hidden" name="hidden" id="hidden" value="<?= $rows['id'];?>">
																<p class="text-success">Completed</p>			                    		
			                    		</form>
		                    	</div>
		                    	
		                    </div>
		         </div>
		       <?php } 
		       if($rows['status'] == 0)
		       {
		       ?>
		          <div class="card mt-5 row">
		                    <div class="card-header ">
		                    	<div class="card-body ">
		                    		<h2>Cancelled</h2>
			                    		<div class="col-md-6">
			                    			<img src="upload/<?= $rows['file']; ?>" style="width:200px;height: 200px;">
			                    		</div>
			                    		<div class="col-md-6">
			                    			<b>Id : <?= $rows['id']; ?></b><br>
			                    			<b>Product : <?= $rows['p_name']; ?></b><br/>
			                    			<b>Total Price : <?= $rows['price']; ?></b><br/>
			                    			<b>Scheduled Date : <?= $rows['scheduled_date']; ?></b>
			                    		</div>
			                    		<form method="post">
			                    			<input type="hidden" name="hidden" id="hidden" value="<?= $rows['id'];?>">
																<p class="text-danger">Cancelled</p>			                    		
															</form>
		                    	</div>
		                    	
		                    </div>
		         </div>
		       <?php } ?>
		        	</div>
  <?php
    }
?>
</body>
</html>
<script>
			$(document).ready(function(){
				$('#cancel').on('click', function() {
				var id = $('#hidden').val();
     		$.ajax({
		                url: "ajax.php",
		                type: "POST",
		                data: {
		                    id: id,
		                    action:"update_status"
		                },
		                cache: false,
		                success: function(result){
		                    alert('Your Order Has Cancelled Succesfully');
		                }
		            });
		        });
       			});		 	
			
</script>
