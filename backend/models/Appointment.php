<?php
	class Appointment {
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all appointments */
		public function getAll(): array {
			try {
					$stmt = $this->pdo->query("SELECT * FROM appointments");
					return $this->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return [];
			}
		}
		
		public function getById(int $id): ?array {
			try {
					$stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE appointment_id = ?");
					$stmt->execute([$id]);
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					return $result ?: null;
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return null;
			}
		}
		
		/* Create a new appointment */
		public function create(array $data): bool {
			if (!$this->isValidCreateData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO appointments (patient_id, doctor_id, appointment_date, status)
					VALUES(? ,?, ?, ?)
				");
				return $stmt->execute([
					$data['patient_id'],
					$data['doctor_id'],
					$data['appointment_date'],
					$data['status'] ?? 'Scheduled'
				]);
			} catch(PDOException $e) {
				error_log($e->getMessage());
				return false;
			}
		}
		
		/* Update an existing appointment */
		public function update(array $data): bool {
			if (!$this->isValidUpdateData($data)) {
				return false;
			}
			try {
					$stmt = $this->pdo->prepare("
						UPDATE appointments
						SET patient_id = ?, appointment_date = ?, status = ?
						WHERE appointment_id = ?
					");
					return $stmt->execute([
						$data['patient_id'],
						$data['doctor_id'],
						$data['appointment_date'],
						$data['status'],
						$data['appointment_id']
					]);
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return false;
			}
		}
		
		/* Delete an appointment */
		public function delete(int $id):bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM appointments WHERE appointment_id = ?");
				return $stmt->execute([$id]);
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return false;
			}
		}
		
		/* Validate data for appointment creation */
		private function isValidCreateData(array $data): bool {
			return isset($data['patient_id'], $data['doctor_id'], $data['appointment_date']);
		}
		
		/* Validate data for appointment udpate */
		private function isValidUpdateData(array $data):bool {
			return isset($data['appointment_id'], 
			$data['patient_id'], $data['doctor_id'], 
			$data['appointment_date'], 
			$data['status']
			);
		}
	}
	
