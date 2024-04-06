$(document).ready(function(){
	
	var myDatatable = $('#myDatatable').DataTable({});
	load_myDatatable();
	function load_myDatatable(){
		
		myDatatable.destroy();
		
		myDatatable = $('#myDatatable').DataTable({
			
			"ajax": {
                    'type': 'POST',
                    'url': 'controller/crud_controller.php',
                    'data': {
                        action: 'listAll'
                    }
                },
			    "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                },
				
				order: [[0, 'desc']],
				
			    "columns": [
				{  "data":"ids" },
				{  "data":"name" },
				{  "data":"email" },
				{  "data":"phone" },
				{  "data":"password" },
				{  "data":"gender" },
				{  "data":"status",
				   "render":function ( data, type, rows, meta )
					{
					  if(data==1)
					  {
						  return '<span class="badge badge-success">Avctive</span>';
					  }
					  else
					  {
						  return '<span class="badge badge-danger">Deactive</span>';
					  }
					}
				},
				{  "data":"ids",
                   "render":function ( data, type, rows, meta )
					{
					  return '<div class="d-inline-flex p-2"><button class="btn-sm btn-warning" name="edit">Edit</button> <button class="btn-sm btn-danger" name="delete">Delete</button> <button class="btn-sm btn-success" name="status">Status</button></div>';
					}
				}
			 ]
		});
		
	}
	
    $('#myDatatable tbody').on('click', 'button', function () {
		var $row = $(this).closest('tr');
		var rowData = myDatatable.row($row).data();
		if($(this).attr("name")=='edit')
		{
			for (var key in rowData)
			{
              $('input[name=' + key + ']').val(rowData[key]);
            }	
			$('#gender').val(rowData.gender).trigger("change");
		}
		if($(this).attr("name")=='delete')
		{
			$.post("controller/crud_controller.php",
			{ action:"delete_data",ids:rowData.ids},
			function(result){
				load_myDatatable();
			});
		}
		if($(this).attr("name")=='status')
		{
			var currentStatus = rowData.status;
			
			var thisStatus;
			currentStatus == 1 ? thisStatus = 0 :  thisStatus = 1;
			$.post("controller/crud_controller.php",
			{ action:"update_status", thisStatus:thisStatus, ids:rowData.ids},
			function(result){
				load_myDatatable();
			});
			
		}
    });
	
	$('#submit-button').click(function(e){
		e.preventDefault();
		 
		 var formData = $('#myForm').serializeArray().reduce(function(obj, item){
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
			alert(key+" is required!");
			return;
		}
		else
		{
			$.post("controller/crud_controller.php",
			{ action:"inserting", formdata:formData },
			function(result){
				load_myDatatable();
				$('#myForm').trigger("reset");
			});
		}		
	
	});
	
	
	
	
	
});