<?php
include("DB.php");
date_default_timezone_set('Asia/Kolkata');
$u_id=$_REQUEST['id'];
// echo $u_id;
$query="select * from users as u left join cart as c on u.id=c.user_id left join products as prod on prod.p_id=c.prod_id where u.id=$u_id";
$res=mysqli_query($connection, $query);
		              
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
</head>
<body>
	<a href="logout.php"><button class="btn btn-primary">LOGOUT</button></a>
    <a href="cart.php?id=<?= $u_id; ?>"><button class="btn btn-primary">View Cart</button></a>
    <a href="my_order.php?id=<?= $u_id; ?>"><button class="btn btn-primary">My Orders</button></a>
	<div class="container">
		<h2 class="text-center">Your Cart</h2>
		<?php 
		$a=1; 
		$amt =0; 
		while($row=mysqli_fetch_assoc($res)){
			$_SESSION['p_id'] = $row['p_id'];
			$amt=$amt+$row['price'];
		 ?>
		 <div class="row<?php echo $a; ?> mt-5">
		            <div class="col-md-12 offset-2 mt-5">
		                <div class="card mt-5">
		                    <div class="card-header ">
		                    	<div class="card-body ">
		                    		<form method="post">
			                    		<div class="col-md-5">
			                    			<img name="img" id="img_src<?= $a; ?>" src="upload/<?= $row['file']; ?>" style="width:100%;">
			                    		</div>
			                    		<div class="col-sm-7 "><br/>
			                    		<h2>Product : <?= $row['p_name']; ?></h2><br/>
			                    		Schedule Date & Time: <input type="datetime-local" id="datetime"><br/><br/>
			                    		Weight(in kg):
										
										<input type="button" value="-" onclick="sub<?php echo $a; ?>()"/>
										<input type="number" class="weight<?= $a; ?>" name="prod_qty" id="q<?php echo $a; ?>" value="1" style="width:30px;"/>
										<input type="button" value="+" onclick="add<?php echo $a; ?>()"/><br/><br/>
										Total Price:<input  id="t" name="tamt" value="<?php echo $amt; ?>" readonly style="width:80px;"/>
			                    		</div>
			                    		<input type="hidden" id="p_ids<?= $a; ?>" name="hidden" value="<?php echo $row['p_id'];?>">
		                          		<button type="submit" name="place_order<?= $a; ?>" id="place_order<?= $a; ?>" class="btn btn-primary from-control">Place  Order</button>
		                          		<button type="submit" name="delete<?= $a; ?>" id="delete<?= $a; ?>" class="btn btn-primary from-control">delete</button>

		                    		</form>
		                    	</div>
		                    	
		                    </div>
		            	</div>
		        	</div>
				</div>

			<script>
			function add<?php echo $a; ?>()
			{
				var a=$(".row<?= $a; ?> #q<?= $a; ?>").val();			
				a=Number(a);
				var result=a+1;
				$(".row<?php echo $a; ?> #q<?= $a; ?>").val(result);
				//var p=$("#p<?= $a; ?>").html();
				//$("#p<?= $a; ?>").html(parseInt(p)+<?php echo $row['price'] ?>);
				var amount=$('.row<?= $a; ?> #t').val();
				//alert(amount);
				$('.row<?php echo $a; ?> #t').val(parseInt(amount)+<?php echo $row['price'] ?>);
			}
			function sub<?php echo $a; ?>()
			{
				var a=$(".row<?php echo $a; ?> #q<?php echo $a; ?>").val();
				a=Number(a);
				if(a<=1)
				{
				
				}
			else
			{				
				var a=$(".row<?php echo $a; ?> #q<?php echo $a; ?>").val();
				a=Number(a);	
				var result=a-1;			
				$(".row<?php echo $a; ?> #q<?php echo $a; ?>").val(result);
				// var p=$("#p<?php echo $a; ?>").html();				
				// $("#p<?php echo $a; ?>").html(parseInt(p)-<?php echo $row['price']; ?>);
				var amount=$('.row<?php echo $a; ?> #t').val();
				//alert(amount);
				$('.row<?php echo $a; ?> #t').val(parseInt(amount)-<?php echo $row['price'];?>);
			}
		}
		</script>

		<script type="text/javascript">
	$(document).ready(function(){
				$('#place_order<?= $a; ?>').on('click', function() {
				var p_id = $('#p_ids<?= $a; ?>').val();
				//alert(p_id);   
				var total_amt = $('#t').val();
				//alert(total_amt);   //60
        		var weight = $('.weight<?= $a; ?>').val();
               //alert(weight);   //60
        		var img_src = $('#img_src<?= $a; ?>').attr('src');
        		var arr = img_src.split('/');
        		var file = arr[arr.length-1];
        		var date = $("#datetime").val();
        		$.ajax({
		                url: "ajax.php",
		                type: "POST",
		                data: {
		                    prod_id: p_id,
		                    tamt: total_amt,
		                    prod_qty: weight,
		                    file: file,
		                    date: date,
		                    action:"insert_order"
		                },
		                cache: false,
		                success: function(result){
		                    alert('Your Order Has Placed Succesfully');
		                    console.log(result);
		                    // alert(result);
		            }
		        });
		    });
       	});	

		$(document).ready(function(){
				$('#delete<?= $a; ?>').on('click', function() {
				var p_id = $('#p_ids<?= $a; ?>').val();
        		$.ajax({
		                url: "ajax.php",
		                type: "POST",
		                data: {
		                    prod_id: p_id,
		                    action:"delete_cart"
		                },
		                cache: false,
		                success: function(result){
		                    alert('deleted');
		                    console.log(result);
		                     alert(result);
		            }
		        });
		    });
       	});	
</script>


	<?php $a++; } ?>

</div>
<!-- <p class="text-center"><?php echo Date("d-m-Y h:i:s A",time()); ?></p> -->
</body>
</html>
