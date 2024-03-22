<?php
class Appointment {	   
	private $appointmentTable = 'hms_appointments';
	private $slotsTable = 'hms_slots';
	private $doctorTable = 'hms_doctor';
	private $specializationTable = 'hms_specialization';
	private $patientsTable = 'hms_patients';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listAppointment(){
		
		$sqlWhere = '';
		if($_SESSION["role"] == 'patient') { 
			$sqlWhere = "WHERE a.patient_id = '".$_SESSION["userid"]."'";
		}	
		
		$sqlQuery = "SELECT a.id, d.name as doctor_name, s.specialization, a.consultancy_fee, appointment_date, a.appointment_time, a.created, a.status, p.name as patient_name, p.id as patient_id, slot.slots
			FROM ".$this->appointmentTable." a 
			LEFT JOIN ".$this->doctorTable." d ON a.doctor_id = d.id
			LEFT JOIN ".$this->patientsTable." p ON a.patient_id = p.id
			LEFT JOIN ".$this->slotsTable." slot ON slot.id = a.appointment_time
			LEFT JOIN ".$this->specializationTable." s ON a.specialization_id = s.id $sqlWhere ";
			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' AND (a.id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR d.name LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR s.specialization LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR a.consultancy_fee LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR a.appointment_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR a.appointment_time LIKE "%'.$_POST["search"]["value"].'%") ';					
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY a.id DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->appointmentTable." as a $sqlWhere");
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($appointment = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $appointment['id'];
			$rows[] = ucfirst($appointment['patient_name']);
			$rows[] = ucfirst($appointment['doctor_name']);
			$rows[] = $appointment['specialization'];
			$rows[] = $appointment['consultancy_fee'];
			$rows[] = $appointment['slots'];
			$rows[] = $appointment['appointment_date'];	
			$rows[] = $appointment['status'];					
			$rows[] = '<button type="button" name="view" id="'.$appointment["id"].'" class="btn btn-info btn-xs view"><span class="glyphicon glyphicon-file" title="View">View</span></button>';
			if($_SESSION["role"] == 'admin' || $_SESSION["role"] == 'patient') { 
				$rows[] = '<button type="button" name="update" id="'.$appointment["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
				$rows[] = '<button type="button" name="delete" id="'.$appointment["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
			} else {
				$rows[] = '';
				$rows[] = '';
				$rows[] = '';
			}
			$records[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}
	
	public function getAppointment(){
		if($this->id) {
			$sqlQuery = "SELECT a.id, d.id as d_id, d.name as doctor_name, s.id as s_id, s.specialization, a.consultancy_fee, appointment_date, a.appointment_time, a.created, a.status, p.name as patient_name, p.id as patient_id, slot.slots
			FROM ".$this->appointmentTable." a 
			LEFT JOIN ".$this->doctorTable." d ON a.doctor_id = d.id
			LEFT JOIN ".$this->patientsTable." p ON a.patient_id = p.id
			LEFT JOIN ".$this->slotsTable." slot ON slot.id = a.appointment_time
			LEFT JOIN ".$this->specializationTable." s ON a.specialization_id = s.id 
			WHERE a.id = ?";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}
	
	function doctorList(){		
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->doctorTable);				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function specializationList(){		
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->specializationTable);				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	public function update(){
		
		if($this->id) {		
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->appointmentTable." 
			SET patient_id = ?, specialization_id= ?, doctor_id = ?, consultancy_fee = ?, appointment_date = ?, appointment_time = ?, status = ?
			WHERE id = ?");
	 
			$this->patient_name = htmlspecialchars(strip_tags($this->patient_name));			
			$this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));
			$this->specialization_id = htmlspecialchars(strip_tags($this->specialization_id));
			$this->fee = htmlspecialchars(strip_tags($this->fee));
			$this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));
			$this->appointment_time = htmlspecialchars(strip_tags($this->appointment_time));
			$this->status = htmlspecialchars(strip_tags($this->status));			
			
			$stmt->bind_param("iiiisssi", $this->patient_name, $this->specialization_id, $this->doctor_id, $this->fee, $this->appointment_date, $this->appointment_time, $this->status, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	public function insert(){
		
		if($this->doctor_id && $this->specialization_id) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->appointmentTable."(`patient_id`, `specialization_id`, `doctor_id`, `consultancy_fee`, `appointment_date`, `appointment_time`,`status`)
			VALUES(?,?,?,?,?,?,?)");			
			
			$this->doctor_id = htmlspecialchars(strip_tags($this->doctor_id));
			$this->specialization_id = htmlspecialchars(strip_tags($this->specialization_id));
			$this->fee = htmlspecialchars(strip_tags($this->fee));
			$this->appointment_date = htmlspecialchars(strip_tags($this->appointment_date));
			$this->appointment_time = htmlspecialchars(strip_tags($this->appointment_time));
			$this->status = htmlspecialchars(strip_tags($this->status));			
			
			$stmt->bind_param("iiiisss", $_SESSION["userid"], $this->specialization_id, $this->doctor_id, $this->fee, $this->appointment_date, $this->appointment_time, $this->status);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}		
	
	public function delete(){
		if($this->id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->appointmentTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){
				return true;
			}
		}
	}
	
	public function getTotalApointment(){		
		$stmt = $this->conn->prepare("
		SELECT *
		FROM ".$this->appointmentTable);				
		$stmt->execute();			
		$result = $stmt->get_result();
		return $result->num_rows;	
	}	
	
	
	public function getSlots(){	
		if($this->doctorId && $this->appointmentDate) {


			$sqlQuery = "
				SELECT appointment_time
				FROM ".$this->appointmentTable."			
				WHERE appointment_date = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("s", $this->appointmentDate);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($bookedSlot = $result->fetch_assoc()) { 					
				$records[$bookedSlot['appointment_time']] = $bookedSlot['appointment_time'];					
			}
			
			
			
			$stmt = $this->conn->prepare("
			SELECT *
			FROM ".$this->slotsTable);				
			$stmt->execute();			
			$result = $stmt->get_result();			
			$slotsList = '';
			while ($slots = $result->fetch_assoc()) {
				$disabled = '';
				if(isset($records[$slots['id']])) {
					$disabled = 'disabled="disabled"';
				}
				$slotsList .= '<option value="'.$slots['id'].'" '.$disabled.'>'.$slots['slots'].'</option>';
			}
			echo $slotsList;
		}
	}	
	
}
?>