<?php
	class Payment {
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all payments */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM payments");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return [];
			}
		}
		
		/* Get a payment by billing ID */
		public function getById(int $billingId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM payments WHERE billing_id = ?");
				$stmt->execute([billingId]]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return null;
			}
		}
		
		/* Create a new payment */
		public function create(array $data): bool {
			if (!$this->isValidCreateData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO payments ( 
						patient_id, appointment_id, total_amount, amount_paid, balance_due,
						payment_status, payment_date, insurance_claimed_amount, insurance_status
						)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?)
				");
				return $stmt->pdo->prepare([
						$data['patient_id'],
						$data['appointment_id'],
						$data['total_amount'],
						$data['amount_paid'] ?? 0.00,
						$data['balance_due'] ?? 0.00,
						$data['payment_status'] ?? 'Pending',
						$data['payment_date'] ?? date('Y-m-d H:i:s'),
						$data['insurance_claimed_amount'] ?? null,
						$data['insurance_status'] ?? null
					]);
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return false;
			}
		}
		
		/* Update on existing payment */
		public function update(array $data):bool {
			if (empty($data['billing'])) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
						UPDATE payments 
						SET  patient_id = ?, appointment_id = ?, total_amount = ?, amount_paid = ?, balance_due = ?,
						     payment_status = ?, payment_date = ?, insurance_claimed_amount = ?, insurance_status = ?
						WHERE billing_id = ?
					");
					return $stmt->execute([
						$data['patient_id'],
						$data['appointment_id'],
						$data['total_amount'],
						$data['amount_paid'],
						$data['balance_due'],
						$data['payment_status'],
						$data['payment_date'],
						$data['insurance_claimed_amount'],
						$data['insurance_status'],
						$data['billing_id']
					]);
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return false;
			}
		}
		
		/* Delete a payment */
		public function delete(int $billingId): bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM payments WHERE billing_id = ?");
				return $stmt->execute([$billingId]);
			} catch (PDOException $e) {
				error_log($e->getMessage());
				return false;
			}
		}
		
		/* Validate creation input */
		private function isValidCreateData(array $data): bool {
			return isset(
				$data['patient_id'],
				$data['appointment_id'],
				$data['total_amount']
		);
	}
}
						