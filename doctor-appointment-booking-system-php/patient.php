<?php

include_once 'config/Database.php';
include_once 'class/User.php';


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if(!$user->loggedIn()) {
	header("Location: index.php");
}
include('inc/header4.php');
?>
<script src="js/patient.js"></script>	
</head>
<body>
	
	<div class="container-fluid">
	<?php include('top_menus.php'); ?>
		<div class="row row-offcanvas row-offcanvas-left">
			<?php include('left_menus.php'); ?>
			<div class="col-md-9 col-lg-10 main"> 
			<h2>Manage Patient</h2> 
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<?php if($_SESSION["role"] != 'patient') { ?>
				<div class="col-md-2" align="right">
					<button type="button" id="addPatient" class="btn btn-success" title="Add Patient"><span class="glyphicon glyphicon-plus">Add</span></button>
				</div>
				<?php } ?>
			</div>
		</div>
		<table id="patientListing" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>					
					<th>Gender</th>	
					<th>Age</th>	
					<th>Email</th>
					<th>Mobile</th>
					<th>Address</th>
					<th>Medical History</th>
					<th></th>
					<th></th>	
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	</div>
	<div id="patientModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="patientForm">
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
							<label for="website" class="control-label">Gender</label>
							<select class="form-control" id="gender" name="gender">
							<option value="">Select</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							</select>		
						</div>	  
						<div class="form-group">
							<label for="website" class="control-label">Age</label>							
							<input type="number" class="form-control" id="age" name="age">							
						</div>	   	
						<div class="form-group">
							<label for="industry" class="control-label">Email</label>							
							<input type="text" class="form-control"  id="email" name="email" placeholder="Email">				
						</div>	
						
						<div class="form-group">
							<label for="phone" class="control-label">Mobile</label>							
							<input type="text" class="form-control" id="mobile" name="mobile" placeholder="mobile">			
						</div>			
						<div class="form-group">
							<label for="address" class="control-label">Address</label>							
							<textarea class="form-control" rows="2" id="address" name="address"></textarea>							
						</div>						
						<div class="form-group">
							<label for="description" class="control-label">Medical History</label>							
							<textarea class="form-control" rows="5" id="history" name="history"></textarea>							
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
	
	<div id="patientDetails" class="modal fade">
    	<div class="modal-dialog">    		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Patient Details</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name" class="control-label">Name:</label>
						<span id="p_name"></span>	
					</div>
					<div class="form-group">
						<label for="p_gender" class="control-label">Gender:</label>				
						<span id="p_gender"></span>							
					</div>	   	
					<div class="form-group">
						<label for="p_age" class="control-label">Age:</label>							
						<span id="p_age"></span>								
					</div>	
					<div class="form-group">
						<label for="description" class="control-label">Email:</label>							
						<span id="p_email"></span>								
					</div>	
					<div class="form-group">
						<label for="phone" class="control-label">Mobile:</label>							
						<span id="p_mobile"></span>					
					</div>			
					<div class="form-group">
						<label for="p_address" class="control-label">Address:</label>							
						<span id="p_address"></span>							
					</div>
					<div class="form-group">
						<label for="p_history" class="control-label">Medical History:</label>							
						<span id="p_history"></span>							
					</div>	
				</div>    				
			</div>    		
    	</div>
    </div>
	
</div>
</body>
</html>
