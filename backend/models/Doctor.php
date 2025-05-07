<?php
	namespace App\Models;
	
	use App\Core\Database;
	use PDO;
	class Doctor {
		private $db;
		
		public function __construct() {
			$this->db = Database::connect();
		}
		
		public function getAll() {
			return $this->db->query("SELECT * FROM doctors")->fetchAll(PDO::FETCH_ASSOC);
		}
		
		public function find($id) {
			$stmt = $this->db->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
			$stmt->execute([$id]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		public function create($data) {
			$stmt = $this->db->prepare("
				INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
				VALUES (:first_name, :last_name, :specialization, :email, :phone_number, :department, birthdate, :address, :status, :notes) 
			");
			return $stmt->execute($data);
		}
		public function update($data) {
			$stmt = $this->db->prepare(" 
				UPDATE doctors 
				SET first_name = :first_name, 
				last_name = :last_name, 
				specialization = :specialization, 
				email = :email, 
				phone_number = :phone_number,
				department = :department,
				birthdate = :birthdate,
				address = :address,
				status = :status,
				notes = :notes,
				updated_at = CURRENT_TIMESTAMP
				WHERE doctor_id = :doctor_id
			");
			return $stmt->execute($data);
		}
		
	public function delete($id) {
			$stmt = $pdo->prepare('SELECT 1 FROM doctors WHERE doctor_id = ?');
			return $stmt->execute([$id]);
	}
}	
?>

	
				
	