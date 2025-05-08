<?php
	class MidicalRecord {
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		// GET all medical records 
		public function getAll():array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM medical_records");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				return [];
			}
		}
		// GET record by ID 
		public function getById(int $recordId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM medical_records WHERE record_id = ? ");
				$stmt->execute([$recordId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				return null;
			}
		}
		/* Create new medical record */
		public function create(array $data): bool {
			if (!$this->isValidCreateData($data) {
				return false;
			}
			try {
					$stmt = $this->pdo->prepare("
						INSERT INTO medical_records (
							patient_id, appointment_id, diagnosis, treatment_plan, note, status,
							created_by, update_by, attactments
						)
						VALUES(? ,?, ?, ?, ?, ?, ?, ?, ?)
					");
					return $stmt->execute([
						$data['patient_id'],
						$data['appointment_id'],
						$data['diagnosis'] ?? null,
						$data['treatment_plan'] ?? null,
						$data['note'] ?? null,
						$data['status'] ?? 'Active',
						$data['created_by'] ?? null,
						$data['updated_by'] ?? null,
						$data['attactments'] ?? null,
					]);
			} catch (PDOException $e) {
				return false;
			}
		}
		/* Update a record */
		public function update(array $data): bool {
			if (empty($data['record_id'])) {
				return false;
			}
			try {
					$stmt = $this->pdo->prepare("
						UPDATE medical_records 
						SET patient_id = ?, appointment_id = ?, diagnosis = ?, treatment_plan = ?, note = ?, status = ?,
						    updated_by = ?, attactments = ?
						WHERE record_id = ?
					");
					return $stmt->execute([
						$data['patient_id'],
						$data['appointment_id'],
						$data['diagnosis'],
						$data['treatment_plan'] ?? null,
						$data['note'] ?? null,
						$data['status'] ?? 'Active',
						$data['updated_by'],
						$data['attactments'],
						$data['record_id'],
					]);
			} catch (PDOException $e) {
				return false;
			}
		}
		/* Delete a record (soft delete alternative is butter in practice */
		public function delete(int $recordId): bool{
			try {
					$stmt = $this->pdo->prepare("DELETE FROM medical_records WHERE record_id = ?");
					return $stmt->execute([$recordId]);
			} catch (PDOException $e) {
				return false;
			}
		}
		/* Validate required data for creation */
		private function isValidCreateData(array $data): bool {
			return isset($data['patient_id'], $data['appointment_id']);
		}
	}
	