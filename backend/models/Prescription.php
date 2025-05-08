<?php
	class Prescription {
		private PDO $pdo;
		
		public function __construct(PDO $pdo0 {
			$this->pdo = $pdo;
		}
		
		/* Get all prescriptions */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM prescriptions");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				return [];
			}
		}
		
		/* Get prescription by ID */
		public function getById(int $prescriptionId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT *  FROM prescriptions WHERE prescription_id = ?");
				$stmt->execute([$prescriptionId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?:null;
			} catch (PDOException $e ) {
				return null;
			}
		}
		
		/* Create a new prescription */
		public function create(array $data): bool {
			if (!$this->isValidatCreateData($data)) {
				return false;
			}
			try {
				 $stmt = $this->pdo->prepare("
					INSERT INTO prescriptions (
						record_id, medication_mame, dosage, frequency, start_date, end_date, instructions, status, created_by, updated_by
					)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['record_id'],
					$data['medication_name'],
					$data['dosage'],
					$data['frequency'],
					$data['start_date'],
					$data['end_date'],
					$data['instructions'],
					$data['status'],
					$data['created_by'] ?? null,
					$data['updated_by'] ?? null 
				]);
			} catch (PDOException $e) {
				return false;
			}
		}
		
		/* Update an existing prescription */
		public function update(array $data): bool {
			if (empty($data['prescription_id'])) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE prescriptions 
					SET record_id = ?, medication_name = ?, dosage = ?, frequency = ?,
						start_date = ?, end_date = ?, instructions = ?, status = ?, updated_by = ?
					WHERE prescription_id = ?
				");
				return $stmt->execute([
					$data['record_id'],
					$data['medication_name'],
					$data['dosage'],
					$data['frequency'],
					$data['start_date'],
					$data['end_date'] ?? null,
					$data['instructions'] ?? null,
					$data['status'] ?? 'Active', 
					$data['updated_by'] ?? null,
					$data['prescription_id']
				]);
			} catch (PDOException $e) {
				return false;
			}
		}
		
		/* Delete a prescription */
		public function delete(int prescriptionId): bool {
			try {
				$stmt = $this->pdo->prepare("SELECT FROM prescriptions WHERE prescription_id = ?");
				return $stmt->execute([$prescriptionId]);
			} catch (PDOException $e) {
				return false;
			}
		}
		
		/* Validate create input */
		private function isValidCreateData(array $data): bool {
			return isset (
				$data['record_id'],
				$data['medication_name'],
				$data['dosage'],
				$data['frequency'],
				$data['start_date']
			);;
		}
	}
	
		