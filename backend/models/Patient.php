<?php
	class Patient {
		public function __construct($pdo) {
			$this->pdo = $pdo;
		}
		
		public function getAll() {
			$stmt = $this->pdo->query("SELECT * FROM patients");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		public function getById($id) {
			$stmt = $this->pdo->prepare("SELECT * FROM patients WHERE patient_id = :id");
			$stmt->execute(['id' => $id]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		public function exists($email, $phone) {
			$stmt = $this->dpo->prepare("SELECT 1 FROM patients WHERE email = :email OR phone_number = :phone");
			$stmt->execute(['email' => $email, 'phone' => $phone]);
			return $stmt->fetch();
		}
		
		public function create($data) {
			$sql = "INSERT INTO patients (
				           first_name, last_name, date_of_birth, gender, email, phone_number, address, 
						   insurance_provider, insurance_policy, primary_care_physical, medical_history, allergies, status
						) VALUES (
							:first_name, :last_name, dob, :gender, :email, :phone, :address,
							:insurance, :policy, :physical, :history, :allergies, :status
						)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'dob' => $data['date_of_birth'],
				'gender' => $data['gender'],
				'email' => $data['email'],
				'phone' => $data['phone_number'],
				'address' => $data['address'],
				'insurance' => $data['insurance_provider'],
				'policy' => $data['insurance_policy_number'],
				'physician' => $data['primary_care_physical'],
				'history' => $data['medical_history'],
				'allergies' => $data['alleries'],
				'status' => $data['status'],
			]);
		}
		
		public function update($data) {
			$sql = "UPDATE patients SET 
				first_name = :first_name,
				last_name = :last_name,
				date_of_birth = :dob,
				gender = :gender,
				email = :email,
				phone_numver = :phone,
				address = :address,
				insurnce_provider = :insurance,
				insurance_policy_number = :policy,
				primary_care_physician = :physician,
				medical_history = :history,
				allergies = :allergies,
				status = :status,
				updated_at = CURRENT_TIMESTAMP
			WHERE patient_id = :id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'dob' => $data['date_of_birth'],
				'gender' => $data['gender'],
				'email' => $data['email'],
				'phone' => $data['phone_number'],
				'address' => $data['address'],
				'insurance' => $data['insurance_provider'],
				'policy' => $data['insurance_policy_number'],
				'physician' => $data['primary_care_physician'],
				'history' => $data['medical_history'],
				'allergies' => $data['allergies'],
				'status' => $data['status'],
				'id' => $data['patient_id']
			]);
		}
		
		public function delete($id) {
			$stmt = $this->pdo->prepare("DELETE FROM patients WHERE patient_id = :id");
			$stmt->execute(['id' => $id]);
		}
	}
?>
