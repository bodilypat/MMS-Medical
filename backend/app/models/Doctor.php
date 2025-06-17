<?php
	namespace App\Models;
	
	use App\Core\Database;
	use PDO;
	use PDOException;
	
	class Doctor {
		private PDO $db;
		
		public function __construct() {
			$this->db = Database::connect();
		}
		
		/* Fetch all doctors */
		public function getAll(): array {
			try {
				$stmt = $this->db->query("SELECT * FROM doctors");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Doctor::getAll - ". $e->getMessage());
				return [];
			}
		}
		
		/* Find doctor by ID */
		public function find(int $id): ?array {
			try {				
				$stmt = $this->db->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
				$stmt->execute([$id]);
				$stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Doctor::find - " .$e->getMessage());
				return null;
			}
		}
		
		/* Create new doctor */
		public function create(array $data): bool {
			try {
				$stmt = $this->db->prepare("
					INSERT INTO doctors (first_name, last_name, specialization, email, phone_number, department, birthdate, address, status, notes)
					VALUES (:first_name, :last_name, :specialization, :email, :phone_number, :department, birthdate, :address, :status, :notes) 
				");
				return $stmt->execute($data);
			} catch (PDOException $e) {
				error_log("Doctor::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update doctor record */
		public function update(array $data): bool {
			try {
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
			} catch (PDOException $e) {
				error_log("Doctor::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete doctor by ID */
	public function delete(int $id): bool {
		try {
			$stmt = $this->db->prepare('SELECT 1 FROM doctors WHERE doctor_id = ?');
			return $stmt->execute([$id]);
		} catch (PDOException $e) {
			error_log("Doctor::delete - " . $e->getMessage());
			return false;
		}
	}
}	


	
				
	