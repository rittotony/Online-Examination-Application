<?php
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
	<div class="mt-3">
	 <span style="font-weight:bold;"><?php echo $sino; ?></span>. <span><?php echo $question['question']; ?><br>
	 <label style="font-weight:bold;">options : </label>  <span><?php echo $question['options']; ?></span>
	 <input placeholder="Type your answer" type="text" class="form-control" data-score="<?php echo $question['score']; ?>" data-answer="<?php echo $question['answer'];?>">
	</div>	
	<?php $sino++; }  ?>
   </ul>
   <?php if($rowcount!=0){ ?>
   <button class="btn btn-success" id="btn-submit" style="float:right;">Submit Answers</button>
   <?php } ?>
   <input type="hidden" id="txt_current_email" value="<?php echo $_GET['email']; ?>">
</div>



</body>
</html>
<script>
$(document).ready(function(){
	
	$('#btn-submit').click(function(){
        var totalScore = 0;
        var totalPossibleScore = 0;
		var thisEmail = $('#txt_current_email').val();

        $('input[type="text"]').each(function(){
            var userAnswer = $(this).val().trim().toLowerCase(); 
            var correctAnswer = $(this).data('answer').trim().toLowerCase(); 
            var score = $(this).data('score'); 
            totalPossibleScore += parseInt(score); 

            if(userAnswer === correctAnswer) {
                totalScore += parseInt(score);
            }
        });
		
		if(totalScore>parseFloat(totalPossibleScore/2))
		{
			var statusOfScore = "Good Job !";
		}
		else if(totalScore<parseFloat(totalPossibleScore/2))
		{
			var statusOfScore = "Better luck next time !";
		}
		else if(totalScore==totalPossibleScore)
		{
			var statusOfScore = "Excellent";
		}
		else
		{
			var statusOfScore = "Try Hard !";
		}
		
		var formData = {
			totalPossibleScore : totalPossibleScore,
			totalScore : totalScore,
			email : thisEmail
		};
		
		$.post('../controller/MainController.php',
		{ action:"update_score", formdata:formData },
		function(result, status){
			
			Swal.fire({
				title: "Score : "+ totalScore + '/' + totalPossibleScore,
				text: statusOfScore,
				icon: "success"
			});
			
		});
		
    });
	
});
</script>