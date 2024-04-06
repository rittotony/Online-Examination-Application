<?php
session_start();
$_SESSION['applicant_email'] = $_GET['email'];
include('../models/connection/connection.php');
$connection = new dbConnection();
$conn = $connection->myDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <?php include('../admin/templates/head.php'); ?>
   <style>
    .login-card {
	  height: 600px;	
      max-width: 1200px;
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
  <h2 class="text-center mb-4">Questions</h2>
   <ul>
   <?php 
    $sino=1;
    $sql="SELECT * FROM tbl_questions WHERE status='Active'";
    $questions = mysqli_query($conn,$sql);
	$rowcount = mysqli_num_rows($questions);
	if($rowcount==0) { 
	  echo '<h2 class="text-center mt-10 text-danger">No Questions found!</h2>';
	}
	foreach($questions as $question) { ?>
	<div class="mt-3 question-item">
	 <span style="font-weight:bold; float:right;">Score : <?php echo number_format($question['score'], 0); ?></span>
	 <span style="font-weight:bold;"><?php echo $sino; ?></span>. <span><?php echo $question['question']; ?><br>
	 <label style="font-weight:bold;">options : </label>  <span><?php echo $question['options']; ?></span>
	 <input placeholder="Type your answer" type="text" class="form-control" data-code="<?php echo $question['question_code']; ?>" />
	</div>	
	<?php $sino++; }  ?>
   </ul>
   <?php if($rowcount!=0){ ?>
   <button class="btn btn-success" id="btn-submit" style="float:right;">Submit Answers</button>
   <?php } ?>
</div>


</body>
</html>
<script>
$(document).ready(function(){
	
	$('#btn-submit').click(function(){
		
		Swal.fire({
		  title: "Are you sure?",
		  text: "Do you want to submit your Exam ?",
		  icon: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#3085d6",
		  cancelButtonColor: "#d33",
		  confirmButtonText: "Yes, Confirm!"
		}).then((result) => {
		  if (result.isConfirmed) {
			    var answers = [];
				$('.question-item').each(function() { 
					var questionCode = $(this).find('input').data('code');
					var answer = $(this).find('input').val().trim();  
					answers.push({ answer: answer, code: questionCode });
				});
				
				console.log(answers);
				$.post('../controller/scoreController.php',
				{ action:"calculate_score", formdata:answers },
				function(result, status){
					Swal.fire({
						title: "Score : "+ result,
						text: scoreStatus(result),
						icon: "success"
					});
					
					$('#btn-submit').prop('disabled', true);
					
				});
		  }
		});
		
		function scoreStatus(score) {
			var scoreIs = score.split("/");
			var percentage = parseFloat(scoreIs[0]) / parseFloat(scoreIs[1]) * 100; 

			switch (true) { 
				case percentage === 100:
					return "Excellent";
					break;
				case percentage > 50:
					return "Good Job";
					break;
				default:
					return "Better luck next time";
					break;
			}
		}

	
		
    });
	
});
</script>