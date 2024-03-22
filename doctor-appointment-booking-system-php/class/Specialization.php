<?php
class Specialization {
	
   
	private $specializationTable = 'hms_specialization';	
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	public function listSpecialization(){		
		
		$sqlQuery = "SELECT id, specialization
			FROM ".$this->specializationTable." ";			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR specialization LIKE "%'.$_POST["search"]["value"].'%" ';					
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare($sqlQuery);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();	
		$count = 1;
		while ($specialization = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $count;
			$rows[] = ucfirst($specialization['specialization']);									
			$rows[] = '<button type="button" name="update" id="'.$specialization["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$specialization["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
			$records[] = $rows;
			$count++;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}	
	
	public function insert(){
		
		if($this->specialization && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO ".$this->specializationTable."(`specialization`)
				VALUES(?)");
		
			$this->specialization = htmlspecialchars(strip_tags($this->specialization));
					
			$stmt->bind_param("s", $this->specialization);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}
	
	public function update(){
		
		if($this->specialization && $_SESSION["userid"]) {			
	
			$stmt = $this->conn->prepare("
				UPDATE ".$this->specializationTable." 
				SET specialization = ?
				WHERE id = ?");
	 
			$this->specialization = htmlspecialchars(strip_tags($this->specialization));
			$this->id = htmlspecialchars(strip_tags($this->id));
			
			$stmt->bind_param("si", $this->specialization, $this->id);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function delete(){
		if($this->id && $_SESSION["userid"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->specializationTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){				
				return true;
			}
		}
	}
	
	public function getSpecializationDetails(){
		if($this->id && $_SESSION["userid"]) {			
					
			$sqlQuery = "
				SELECT id, specialization
				FROM ".$this->specializationTable."			
				WHERE id = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($specialization = $result->fetch_assoc()) { 				
				$rows = array();	
				$rows['id'] = $specialization['id'];				
				$rows['specialization'] = $specialization['specialization'];								
				$records[] = $rows;
			}		
			$output = array(			
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}	
	
	
}
?>