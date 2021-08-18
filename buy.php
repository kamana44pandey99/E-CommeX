<?php
session_start();
 //print_r($_SESSION);
include('DB.php');
	$uid=$_SESSION['user_id'];

if(isset($_POST['cart']))
{
$prod_ids = $_POST['prod_ids'];
$product = $_POST['product'];
$prod_type = $_POST['prod_type'];
$radios = $_POST['a'];
$price = $_POST['price'];
$location="upload/";
$file_name = $_FILES['file']['name'];	
$tmp_name = $_FILES['file']['tmp_name'];	
//echo $prod_ids.$price.$tmp_name;
move_uploaded_file($tmp_name, $location.$file_name);
$insert = "insert into cart(user_id,prod_id,price,file,date) values('$uid','$prod_ids','$price','$file_name',now())";
mysqli_query($connection, $insert);
header("location:cart.php?id=$uid");
}
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
		<div class="container">
		        <div class="row mt-5">
		            <div class="col-md-8 offset-2 mt-5">
		                <div class="card mt-5">
		                    <div class="card-header bg-primary text-white">
		                        <h4><b>Category Subcategory Dropdown in PHP</b></h4>
		                    </div>
		                    <div class="card-body">
		                        <form method="post" enctype="multipart/form-data">
		                            <div class="form-group">
		                                <label for="PRODUCT-DROPDOWN">Product</label>
		                                <select class="form-control" name="product" id="product-dropdown">
		                                	<option>Select Product</option>
		                                    <?php
		                             
		                                   		$result = mysqli_query($connection,"SELECT * FROM products");
		                                        while($pro = mysqli_fetch_assoc($result)) {
		                                    ?>
		                                        <option value="<?php echo $pro['p_id'];?>"><?php echo $pro["p_name"];?></option>
		                                    <?php
		                                       }
		                                    ?>
		                                </select>
		                            </div>
		                            <div class="form-group">
		                                <label for="SUBPRODUCTS">Product Type</label>
		                                <select class="form-control" name="prod_type" id="product-type-dropdown">
		                                    <option>Select Product Type</option>
		                                </select>
		                            </div>
		                            <div class="form-group">
		                                <input type="radio" id="radio_1" name="a" value="quantity">&nbsp;Quantity &nbsp;
		                                <input type="radio" id="radio_2" name="a" value="weight" >&nbsp;weight
		                          
		                            </div>
		                            <div class="form-group">
		                            	<label for="price">Price</label>
		                                <select class="form-control" name="price" id="price">
		                                    <option value="">price</option>
		                                </select>
		                            </div>
		                            <div class="form-group">
		                            	<img id="img" height="100px" width="170px" style="display: none;"><br/>
		                            	<label for="price">Image</label>
		                                <input type="file" name="file" id="file">
		                            </div>
		                            <input type="hidden" id="hid_id" name="prod_ids" >
		                            <button type="submit" name="cart" class="btn btn-primary">Add To Cart</button>
		                        </form>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		    <script>
			$(document).ready(function() {
		        $('#product-dropdown').on('change', function() {
		            var prod_id = this.value;
		            $("#hid_id").val(prod_id);
		            $.ajax({
		                url: "ajax.php",
		                type: "POST",
		                data: {
		                    prod_id: prod_id,
		                    action:"sub_product"
		                },
		                cache: false,
		                success: function(result){
		                    $("#product-type-dropdown").html(result);
		                    //alert(result);
		                }
		            });
		        });
		    });

		     $(document).ready(function() {
		        $('#product-type-dropdown').on('change', function() {
		        	$("#radio_2").attr('checked', true);
		        	var price = $('#product-dropdown').val();
		        	//alert(price);
		        	$.ajax({
		                url: "ajax.php",
		                type: "POST",
		                data: {
		                    price: price,
		                    action:"price"
		                },
		                cache: false,
		                success: function(result){
		                    $("#price").html(result);
		                    //alert(result); 
		                }
		            });
		        });
		    });

			 $(document).ready(function(){
				$('#file').on('change', function() {
				var reader = new FileReader();
        		reader.readAsDataURL(document.getElementById("file").files[0]);
        		reader.onload = function (oFREvent) {
            	document.getElementById("img").src = oFREvent.target.result;
        		$('#img').css("display","block");
       			};		 	
			 });
			});

		     /*
 if($("#radio_2").is(':checked')){
    					$("#price").val(60);
    				} 
		     */
		    </script>
</body>
</html>
