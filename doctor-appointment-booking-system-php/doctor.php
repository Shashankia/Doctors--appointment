<?php

include_once 'config/Database.php';
include_once 'class/User.php';


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(!$user->loggedIn() || ($user->loggedIn() && $_SESSION["role"] == 'patient')) { 
	header("Location: index.php");
}
include_once 'class/Appointment.php';
$appointment = new Appointment($db);
include('inc/header4.php');
?>
<script src="js/doctor.js"></script>	
</head>
<body>
	
	<div class="container-fluid">
	<?php include('top_menus.php'); ?>
		<div class="row row-offcanvas row-offcanvas-left">
			<?php include('left_menus.php'); ?>
			<div class="col-md-9 col-lg-10 main"> 
			<h2>Manage Doctor</h2> 
			<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addDoctor" class="btn btn-success" title="Add Doctor"><span class="glyphicon glyphicon-plus">Add</span></button>
				</div>
			</div>
		</div>
		<table id="doctorListing" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>					
					<th>Address</th>					
					<th>Mobile</th>
					<th>Fee</th>
					<th>Specialization</th>	
					<th></th>
					<th></th>	
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	</div>		
	<div id="doctorModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="doctorForm">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal"></button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Record</h4>
    				</div>
    				<div class="modal-body">
						<div class="form-group"
							<label for="name" class="control-label">Name</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Name" required>			
						</div>						
						<div class="form-group">
							<label for="fee" class="control-label">Fee</label>							
							<input type="text" class="form-control" id="fee" name="fee" placeholder="Fee">			
						</div>	
						<div class="form-group">
							<label for="specialization" class="control-label">Specialization</label>
							<select class="form-control" id="specialization" name="specialization"/>
							<?php 
							$result = $appointment->specializationList();
							while ($specialization = $result->fetch_assoc()) { 	
							?>
								<option value="<?php echo $specialization['id']; ?>"><?php echo ucfirst($specialization['specialization']); ?></option>							
							<?php } ?>
							</select>	
						</div>	
						<div class="form-group">
							<label for="phone" class="control-label">Mobile</label>							
							<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile">			
						</div>	
						<div class="form-group">
							<label for="address" class="control-label">Address</label>							
							<textarea class="form-control" rows="2" id="address" name="address"></textarea>							
						</div>
						<div class="form-group">
							<label for="phone" class="control-label">Email</label>							
							<input type="text" class="form-control" id="email" name="email" placeholder="Email">			
						</div>
						
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="id" id="id" />
    					<input type="hidden" name="action" id="action" value="" />
    					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
	
	<div id="doctorDetails" class="modal fade">
    	<div class="modal-dialog">    		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Doctor Details</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name" class="control-label">Name:</label>
						<span id="d_name"></span>	
					</div>
					<div class="form-group">
						<label for="Specialization" class="control-label">Specialization:</label>				
						<span id="d_specialization"></span>							
					</div>	   	
					<div class="form-group">
						<label for="Fee" class="control-label">Fee:</label>							
						<span id="d_fee"></span>								
					</div>	
					<div class="form-group">
						<label for="email" class="control-label">Email:</label>							
						<span id="d_email"></span>								
					</div>	
					<div class="form-group">
						<label for="Mobile" class="control-label">Mobile:</label>							
						<span id="d_mobile"></span>					
					</div>			
					<div class="form-group">
						<label for="address" class="control-label">Address:</label>							
						<span id="d_address"></span>							
					</div>					
				</div>    				
			</div>    		
    	</div>
    </div>
	
</div>
</body>
</html>
