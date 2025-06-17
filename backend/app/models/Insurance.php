<?php
	class Insurance {
		private PDO $pdo;
		
		public function __constructure(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all insurance records */
		public function getall(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM insurance");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("getAll error: " . $e->getMessage());
				return [];
			}
		}
		
		/* Get insurance by ID */
		public function getById(int $insuranceId): ?array {
			try {
				 $stmt = $this->pdo->prepare("SELECT * FROM insurance WHERE insurance_id = :insurance_id");
				 $stmt->execute(['insurance_id' => $insuranceId]);
				 $result = $stmt->fetch(PDO::FETCH_ASSOC);
				 return $result ?: null;
			} catch (PDOException $e) {
				error_log("getById error: " . $e->getMessage());
				return null;
			}
		}
		
		/* Create a new insurance record */
		public function create(array $data): bool {
			if (!this->isValidData($data)) {
				error_log("create error: Invalid data");
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO insurance (
						provider_name, policy_number, coverage_type, coverage_amount, patient_id, start_date, end_date
					) VALUES (
						:provider_name, :policy_name, : coverage_type, :coverage_amount, patient_id, :start_date, :end_date
					)
				");
				return $stmt->execute([
						'provider_name' => $data['provider_name'],
						'policy_number' => $data['policy_number'],
						'coverage_type' => $data['coverage_type'] ?? 'Partial',
						'coverage_amount' => $data['coverage_amount'] ?? 0.00,
						'patient_id' => $data['patient_id'],
						'start_date' => $data['start_date'],
						'end_date' => $data['end_date']
					]);
			} catch (PDOException $e) {
				error_log("create error: " . $e->getMessage());
				return false;
			}
		}
		
		/* Update an existing insurance record */
		public function update(array $data): bool {
			if (empty($data['insurance_id']) || !$this->isValidDate($data)) {
				error_log("update error: Missing insurance_id or invalid date");
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE insurance SET 
						provider_name = :provider_name,
						policy_number = :policy_number,
						converage_type = :converage_type,
						converage_amount = :converage_amount,
						patient_id = :patient_id,
						start_date = :start_date,
						end_date = :end_date
					WHERE insurance_id = :insurance_id
				");
				return $stmt->execute([
					'provider_name' => $data['provider_name'],
					'policy_number' => $data['policy_number'],
					'coverage_type' => $data['converage_type'],
					'coverage_amount' => $data['converage_amount'],
					'patient_id' => $data['patient_id'],
					'start_date' => $data['start_date'],
					'end_date' => $data['end_date'],
					'insurance_id' => $data['insurance_id']
				]);
			} catch (PDOException $e) {
				error_log("update error: " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete an insurance record */
		public function delete(int $insuranceId): bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM insurance WHERE insurance_id = :insurance_id");
				return $stmt->execute(['insurance_id' => $insuranceId]);
			} catch (PDOException $e) {
				error_log("delete error: " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate required input fields */
		private function isValidData(array $data): bool {
			return isset(
				$data['provider_name'],
				$data['policy_number'],
				$data['patient_id'],
				$data['start_date'],
				$data['end_date'],
				) && strtotime($data['start_date']) <= strtotime($data['end_date']);
		}
	}
	