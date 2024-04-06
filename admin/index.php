<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <?php include('templates/head.php'); ?>
   <style>
    .login-card {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
	
  
<div class="login-card">
  <h2 class="text-center mb-4">Admin Login</h2>
  <form id="myForm">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
    </div>
    <button type="submit" class="btn btn-primary btn-block" id="btn-login">Login</button>
  </form>
</div>



</body>
</html>
<script>
$(document).ready(function(){
	
	$('#btn-login').click(function(e){
		e.preventDefault();
		var username = $('#username').val();
		var password = $('#password').val();
		if(username=="")
		{
			Swal.fire({
			  title: "Username !",
			  text: "Please Enter your Username...",
			  icon: "warning"
			});
			return false;
		}
		if(password=="")
		{
			Swal.fire({
			  title: "Password !",
			  text: "Please Enter your Password...",
			  icon: "warning"
			});
			return false;
		}
		 var formData = $('#myForm').serializeArray().reduce(function(obj, item){
                            obj[item.name] = item.value;
                            return obj;
                        }, {});
		
		
		$.post('../controller/MainController.php',
		{ action:"admin_login", formdata:formData },
		function(result, status){
			if(result=="redirect-success")
			{
				location.href="views/welcome-admin.php";
			}
			else
			{
				Swal.fire({
				  title: "Error",
				  text: result,
				  icon: "warning"
				});
				return false;
			}
		});
		
	});
	
});
</script>