<?php
session_start();
if(!isset($_SESSION['loginStatus']))
{
	header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <?php include('../templates/head.php'); ?>
    <style>
    .login-card {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
	.modal-dialog {
    max-width: 900px; 
    width: 100%;
   }
  </style>
</head>
<body>

<div class="login-card">
  <h2 class="text-center mb-4">Add Questions</h2>
  <form id="frmQuestions">
    <div class="form-group">
      <label for="">Question</label>
      <input type="text" class="form-control" name="question" id="question">
    </div>
    <div class="form-group">
      <label for="">Answer</label>
      <input type="text" class="form-control" name="answer" id="answer">
    </div>
	<div class="form-group">
      <label for="">Options</label>
	  <textarea class="form-control" id="options" name="options"></textarea>
      <small class="text-muted">Add Options like: 1)op-1  2)op-2  3)op-3  4)op-4</small>
	</div>
	<div class="form-group">
      <label for="">Score</label>
      <input type="number" class="form-control" name="score" id="score">
    </div>
    <button type="submit" class="btn btn-primary btn-block" id="btn-add">Add Question</button>
  </form>
  <div class="mt-3 mb-2">
  <h2 class="text-center mt-4">List of Questions<button style="float:right;" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
    Exam Attendees 
  </button></h2>
  
  </div>
  <div class="container">
  <div class="row">
    <table class="table table-bordered table-dark table-hover" id="tbl_questions">
		  <thead>
			<tr>
			  <th scope="col">SI NO</th>
			  <th scope="col">Question</th>
			  <th scope="col">Options</th>
			  <th scope="col">Answer</th>
			  <th scope="col">Score</th>
			  <th scope="col">Status</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead>
		  <tbody>
			 
		  </tbody>
	</table>
  </div>
</div>
</div>
	
  

  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">List of Exam Attendees</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-hover" style="width:100%;" id="tbl_list_attendees">
			  <thead>
				<tr>
				  <th scope="col">SI NO</th>
				  <th scope="col">Name</th>
				  <th scope="col">Email</th>
				  <th scope="col">Mark Scored</th>
				  <th scope="col">Total Score</th>
				  <th scope="col">Date and Time</th>
				</tr>
			  </thead>
			  <tbody>
				 
	        </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>



</body>
</html>
<script>
$(document).ready(function(){
	
	var tbl_questions = $('#tbl_questions').DataTable({}); 
	
	var tbl_list_attendees = $('#tbl_list_attendees').DataTable({});
	
	load_tbl_questions();
	
	load_tbl_list_attendees();
	
	function load_tbl_list_attendees(){
		
		tbl_list_attendees.destroy();
		
		tbl_list_attendees = $('#tbl_list_attendees').DataTable({
			
			"ajax": {
                    'type': 'POST',
                    'url': '../../controller/MainController.php',
                    'data': {
                        action: 'listAllAttendies'
                    }
                },
			    "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                },
				
				order: [[0, 'desc']],
				
			    "columns": [
				{ "data": null },
				{  "data":"name" },
				{  "data":"email" },
				{  "data":"scored" },
				{  "data":"total_score" },
				{  "data":"date_time" }
			 ],
			 "fnRowCallback" : function(nRow, aData, iDisplayIndex){
				$('td:eq(0)', nRow).html(iDisplayIndex +1);
			   return nRow;
			},
		});
		
	}
	
	function load_tbl_questions(){
		
		tbl_questions.destroy();
		
		tbl_questions = $('#tbl_questions').DataTable({
			
			"ajax": {
                    'type': 'POST',
                    'url': '../../controller/MainController.php',
                    'data': {
                        action: 'listAllQuestions'
                    }
                },
			    "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                },
				
				order: [[0, 'desc']],
				
			    "columns": [
				{ "data": null },
				{  "data":"question" },
				{  "data":"options" },
				{  "data":"answer" },
				{  "data":"score" },
				{  "data":"status",
				   "render":function ( data, type, rows, meta )
					{
					  if(data=="Active")
					  {
						  return '<span class="badge badge-success">Avctive</span>';
					  }
					  else
					  {
						  return '<span class="badge badge-danger">Deactive</span>';
					  }
					}
				},
				{  "data":"status",
                   "render":function ( data, type, rows, meta )
					{
						if(data=="Active")
						{
							return '<button class="btn-sm btn-danger" name="Deactive">Deactivate</button>';
						}
						else
						{
							return '<button class="btn-sm btn-success" name="Active">Activate</button';
						}
					}
				}
			 ],
			 "fnRowCallback" : function(nRow, aData, iDisplayIndex){
				$('td:eq(0)', nRow).html(iDisplayIndex +1);
			   return nRow;
			},
		});
		
	}
	
	 $('#tbl_questions tbody').on('click', 'button', function () {
		var $row = $(this).closest('tr');
		var rowData = tbl_questions.row($row).data();
		if($(this).attr("name")=='Deactive')
		{
			$.post("../../controller/MainController.php",
			{ action:"change_status_active", ids:rowData.ids },
			function(result){
				if(result>=0)
				{
					load_tbl_questions();
				}
				else
				{
					Swal.fire({
					  title: "Error",
					  text: "Some thing went to wrong !",
					  icon: "error"
					});
				}
			});
		}
		if($(this).attr("name")=='Active')
		{
			$.post("../../controller/MainController.php",
			{ action:"change_status_deactive", ids:rowData.ids },
			function(result){
				if(result>=0)
				{
					load_tbl_questions();
				}
				else
				{
					Swal.fire({
					  title: "Error",
					  text: "Some thing went to wrong !",
					  icon: "error"
					});
				}
			});
		}
	 });	
	
	$('#btn-add').click(function(e){
		e.preventDefault();
		 
		 var formData = $('#frmQuestions').serializeArray().reduce(function(obj, item){
                            obj[item.name] = item.value;
                            return obj;
                        }, {});
						
		var isEmpty = false;	

         for (var key in formData) {
            if (formData[key] === "") {
                isEmpty = true;
                break;
            }
         }	

        if(isEmpty)	
		{
			Swal.fire({
			  title: "Field Empty",
			  text: key+" is required...",
			  icon: "warning"
			});
			return false;
		}
		else
		{
			$.post("../../controller/MainController.php",
			{ action:"add_questions", formdata:formData },
			function(result){
				if(result>=0)
				{
					load_tbl_questions();
					Swal.fire({
					  title: "Successfully",
					  text: "Question Added Successfully",
					  icon: "success"
					});
					$('#frmQuestions').trigger("reset");
				}
				else
				{
					Swal.fire({
					  title: "Error",
					  text: "Some thing went to wrong !",
					  icon: "error"
					});
				}
			});
		}		
	})
	
});
</script>




