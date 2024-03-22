<div class="col-md-3 col-lg-2 sidebar-offcanvas" id="sidebar" role="navigation">
<ul class="nav flex-column pl-1 left-menus">			
<?php if($user->isAdmin()) { ?>		
	<li class="nav-item"><a class="nav-link" href="dashboard.php"><strong>Dashboard</strong></a></li>
	<li class="nav-item"><a class="nav-link" href="doctor.php"><strong>Doctors</strong></a></li>
	<li class="nav-item"><a class="nav-link" href="patient.php"><strong>Patients</strong></a></li>
	<li class="nav-item"><a class="nav-link" href="appointment.php"><strong>Appointments</strong></a></li>	
	<li class="nav-item"><a class="nav-link" href="specialization.php"><strong>Specialization</strong></a></li>	
	<li class="nav-item"><a class="nav-link" href="user.php"><strong>Users</strong></a></li>	
	<li class="nav-item"><a class="nav-link" href="logout.php"><strong>Logout</strong></a></li>
<?php } ?>
</ul>
</div>




