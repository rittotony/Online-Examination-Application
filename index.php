<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <?php include('admin/templates/head.php'); ?>
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
  <h2 class="text-center mb-4">Exam Login</h2>
  <form id="frmExmLogin">
    <div class="form-group">
      <label for="username">Name</label>
      <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
    </div>
    <div class="form-group">
      <label for="password">Email</label>
      <input type="password" class="form-control" name="email" id="email" placeholder="Enter email">
    </div>
    <button type="submit" class="btn btn-primary btn-block" id="btn-login-exam">Login</button>
  </form>
</div>



</body>
</html>
<script>
$(document).ready(function(){
	
	function validateEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
	
  $('#btn-login-exam').click(function(e){
	  e.preventDefault();
	 var name = $('#name').val();
	 var email = $('#email').val();
	 if(name=="")
	 {
		Swal.fire({
			  title: "Name !",
			  text: "Please Enter your Name...",
			  icon: "warning"
			});
			return false; 
	 }
	 if(email=="")
	 {
		 Swal.fire({
			  title: "Email !",
			  text: "Please Enter your Email...",
			  icon: "warning"
			});
			return false; 
	 }
	 if(!validateEmail(email))
	 {
		Swal.fire({
			  title: "Email !",
			  text: "Shows Invalid Email...",
			  icon: "warning"
			});
			return false;  
	 }
	 var formData = $('#frmExmLogin').serializeArray().reduce(function(obj, item){
                            obj[item.name] = item.value;
                            return obj;
                        }, {});
	 
	 $.post('controller/MainController.php',
		{ action:"examiner_login", formdata:formData },
		function(result, status){
			if(result>=1)
			{
				location.href="views/Exam.php?email="+email;
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