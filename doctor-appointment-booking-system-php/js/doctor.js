$(document).ready(function(){	
	var doctorRecords = $('#doctorListing').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"doctor_action.php",
			type:"POST",
			data:{action:'listDoctors'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 6, 7, 8],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#addDoctor').click(function(){
		$('#doctorModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		$('#doctorForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Doctor");
		$('#action').val('addDoctor');
		$('#save').val('Save');
	});		
	
	$("#doctorListing").on('click', '.update', function(){
		var id = $(this).attr("id");
		var action = 'getDoctor';
		$.ajax({
			url:'doctor_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#doctorModal").on("shown.bs.modal", function () { 
					$('#id').val(data.id);
					$('#name').val(data.name);
					$('#fee').val(data.fee);
					$('#specialization').val(data.specialization_id);
					$('#mobile').val(data.mobile);				
					$('#address').val(data.address);
					$('#email').val(data.email);									
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Doctor");
					$('#action').val('updateDoctor');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#doctorModal").on('submit','#doctorForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"doctor_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#doctorForm')[0].reset();
				$('#doctorModal').modal('hide');				
				$('#save').attr('disabled', false);
				doctorRecords.ajax.reload();
			}
		})
	});	
	
	$("#doctorListing").on('click', '.view', function(){
		var id = $(this).attr("id");
		var action = 'getDoctor';
		$.ajax({
			url:'doctor_action.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data){				
				$("#doctorDetails").on("shown.bs.modal", function () { 					
					$('#d_name').html(data.name);
					$('#d_specialization').html(data.specialization);
					$('#d_fee').html(data.fee);
					$('#d_email').html(data.email);				
					$('#d_mobile').html(data.mobile);
					$('#d_address').html(data.address);					
				}).modal();			
			}
		});
	});
	
	$("#doctorListing").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteDoctor";
		if(confirm("Are you sure you want to delete this doctor?")) {
			$.ajax({
				url:"doctor_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					doctorRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
	
});