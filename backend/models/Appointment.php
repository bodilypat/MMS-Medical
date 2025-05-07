<?php
	class Appointment {
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		public function getAll(): array {
			$stmt = $this->pdo->query("SELECT * FROM appointments");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		public function getById(int $id): ?array {
			$stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE appointment_id = ?");
			$stmt->execute[$id]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result ?: null;
		}
		
		public function create(array $data): bool {
			if (
			empty($data['patient_id']) ||
			empty($data['doctor_id']) ||
			empty($data['appointment_date'])
			) {
				return false;
			}
			$stmt = $this->pdo->prepare(" INSERT INTO appointments(patient_id, doctor_id, appointment_date, status)
										  VALUES(?, ?, ?, ?)
										 ");
			return $stmt->execute([
					$data['patient_id'],
					$data['doctor_id'],
					$data['appointment_id'],
					$data['status'] ?? 'Scheduled'
				]);
		}
		
		public function update(array $data): bool {
			if (empty($data['appointment_id'])) {
				return false;
			}
			
			$stmt = $this->pdo->prepare("UPDATE appointments 
			                             SET patient_id = ?, doctor_id = ?, appointment_date = ?, status = ? 
			                             WHERE appointment_id = ? 
									");
			return $stmt->execute([
					$data['patient_id'], 
					$data['doctor_id'], 
					$data['appointment_date'], 
					$data['status'], 
					$data['appointment_id']
				]);
		}
		
		public function delete(int $id):bool {
			$stmt = $this->pdo->prepare("DELETE FROM appointments WHERE appointment_id = ?");
			return $stmt->execute([$id]);
		}
	}
