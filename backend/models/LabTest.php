<?php
	class LabTest {
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all Lab tests */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM lab_tests WHERE test_id = ?");
				$stmt->execute([$testId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch(PDOExcepton $e) {
				return null;
			}
		}
		/* Create a new Lab test */
		public function create(array $data): bool {
			if (!this->isValidCreateData($data) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO lab_tests (
						patient_id, appointment_id, test_name, test_date,
						result, test_status
						)
					VALUES (?, ?, ?, ?, ? ,?)
				");
				return $stmt->execute([
					$data['patient_id'],
					$data['appointment_id'],
					$data['test_name'],
					$data['test_date'],
					$data['results'] ?? null,
					$data['test_status'] ?? 'Pending'
				]);
			} catch (PDOException $e) {
				return false;
			}
		}
		/* Update an existing lab test  */
		public function update(array $data): bool {
			if (empty($data['test_id'])) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE lab_tests 
					SET patient_id = ?, appointment_id = ?, test_name = ?, test_date = ?, results = ?, test_status = ?
					WHERE test_id = ?
				");
				return $stmt->execute([
					$data['patient_id'],
					$data['appointment_id'],
					$data['test_name'],
					$data['test_date'],
					$data['results'] ?? null,
					$data['test_status'] ?? 'Pending',
					$data['test_id']
				]);
			} catch (PDOException $e) {
				return false;
			}
		}
		/* Delete a lab test */
		public function delete(int $testId): bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM lab_tests WHERE test_id = ?");
				return $stmt->execute([$testId]);
			} catch(PDOException $e) {
				return false;
			}
		}
		/* validation for create operation */
		private function isValidCreateData(array $data): bool {
			return isset($data['patient_id'], $data['appointment-id'], $data['test_name'], $data['test_date']);
		}
	}
			
					
			