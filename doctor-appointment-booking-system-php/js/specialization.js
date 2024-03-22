$(document).ready(function(){	
	
	var specializationRecords = $('#specializationListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,		
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"specialization_action.php",
			type:"POST",
			data:{action:'listSpecialization'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 2, 3],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#createSpecialization').click(function(){
		$('#specializationModal').modal({
			backdrop: 'static',
			keyboard: false
		});		
		$("#specializationModal").on("shown.bs.modal", function () {
			$('#specializationForm')[0].reset();				
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Specialization");					
			$('#action').val('createSpecialization');
			$('#save').val('Save');
		});
	});		
	
	$("#specializationListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getSpecializationDetails';
		$.ajax({
			url:'specialization_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#specializationModal").on("shown.bs.modal", function () { 
					$('#specializationForm')[0].reset();
					respData.data.forEach(function(item){						
						$('#id').val(item['id']);						
						$('#specialization').val(item['specialization']);												
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Specialization");
					$('#action').val('updateSpecialization');
					$('#save').val('Save');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#specializationModal").on('submit','#specializationForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"specialization_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#specializationForm')[0].reset();
				$('#specializationModal').modal('hide');				
				$('#save').attr('disabled', false);
				specializationRecords.ajax.reload();
			}
		})
	});		

	$("#specializationListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteSpecialization";
		if(confirm("Are you sure you want to delete this record?")) {
			$.ajax({
				url:"specialization_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					specializationRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});