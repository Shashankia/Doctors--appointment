<?php

include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Appointment.php';
include_once 'class/Patient.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
if(!$user->loggedIn()) {
	header("Location: index.php");
}
$appointment = new Appointment($db);
$patient = new Patient($db);
include('inc/header4.php');
?>
<script src="js/specialization.js"></script>	
</head>
<body>
	
	<div class="container-fluid">
	<?php include('top_menus.php'); ?>
		<div class="row row-offcanvas row-offcanvas-left">
			<?php include('left_menus.php'); ?>
			<div class="col-md-9 col-lg-10 main"> 
			<h2>Manage Specialization</h2> 
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<?php if($user->isAdmin()) { ?>
				<div class="col-md-2" align="right">
					<button type="button" id="createSpecialization" class="btn btn-success" title="Create Specialization"><span class="glyphicon glyphicon-plus">Add</span></button>
				</div>
				<?php } ?>
			</div>
		</div>
		<table id="specializationListing" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>	
					<th>Specialization</th>						
					<th></th>	
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	</div>
	<div id="specializationModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="specializationForm">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal"></button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Specialization</h4>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<label for="fee" class="control-label">Specialization</label>							
							<input type="text" class="form-control" id="specialization" name="specialization" placeholder="specialization">							
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
</div>
</body>
</html>
