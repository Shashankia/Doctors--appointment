$(document).ready(function(){	
	var patientRecords = $('#patientListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"patient_action.php",
			type:"POST",
			data:{action:'listPatient'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 8, 9, 10],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addPatient').click(function(){
		$('#patientModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#patientForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Patient");
		$('#action').val('addPatient');
		$('#save').val('Save');
	});		
	
	$("#patientListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getPatient';
		$.ajax({
			url:'patient_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#patientModal").on("shown.bs.modal", function () { 
					$('#id').val(data.id);
					$('#name').val(data.name);
					$('#gender').val(data.gender);
					$('#age').val(data.age);
					$('#email').val(data.email);									
					$('#mobile').val(data.mobile);
					$('#address').val(data.address);
					$('#history').val(data.medical_history);						
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Patient");
					$('#action').val('updatePatient');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#patientModal").on('submit','#patientForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"patient_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#patientForm')[0].reset();
				$('#patientModal').modal('hide');				
				$('#save').attr('disabled', false);
				patientRecords.ajax.reload();
			}
		})
	});	
	
	$("#patientListing").on('click', '.view', function(){
		var id = $(this).attr("id");
		var action = 'getPatient';
		$.ajax({
			url:'patient_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#patientDetails").on("shown.bs.modal", function () { 					
					$('#p_name').html(data.name);
					$('#p_gender').html(data.gender);
					$('#p_age').html(data.age);
					$('#p_email').html(data.email);				
					$('#p_mobile').html(data.mobile);
					$('#p_address').html(data.address);
					$('#p_history').html(data.medical_history);					
				}).modal();			
			}
		});
	});
	
	$("#patientListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deletePatient";
		if(confirm("Are you sure you want to delete this patient?")) {
			$.ajax({
				url:"patient_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					patientRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
	
});