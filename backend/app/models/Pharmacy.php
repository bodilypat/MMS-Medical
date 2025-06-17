<?php
	class Pharmacy {
		private PDO $pdo;
		
		public function __costruct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all phamacies */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM pharmacies");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("getAll error: " . $e->getMessage());
				return [];
			}
		}
		
		/* Get pharmacy by ID */
		public function getById(int $pharmacyId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM pharmacies WHERE pharmacy_id = :pharmacy_id");
				$stmt->execute(['pharmacy_id' => $pharmacyId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("getById error: " . $e->getMessage());
				return null;
			}
		}
		
		/* Create a new pharmacy */
		public function create(array $data): bool {
			if (!$this->isValidDate($data)) {
				error_log("create error: Invalid data");
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO pharmacies (name, address, phone_number, email)
					VALUES (:name, :address, :phone, :email)
				");
				return $stmt->execute([
					'name' => $data['name'],
					'address' => $data['address'],
					'phone_number' => $data['phone_number'],
					'email' => $data['email']
				]);
			} catch (PDOException $e) {
				error_log("create error: " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing pharmacy */
		public function update(array $data): bool {
			if (empty($data['pharmacy_id']) || !$this->isValidData($data)) {
				error_log("update error: Missing pharmacy_id or invalid data");
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE pharmacies SET 
						name = :name,
						address = :address,
						phone_number = :phone_number,
						email = :email,
					WHERE pharmacy_id = :pharmacy_id
				");
				return $stmt->execute([
					'name' => $data['name'],
					'address' => $data['address'],
					'phone_number' => $data['phone_number'],
					'email' => $data['email'],
					'pharmacy_id' => $data['pharmacy_id']
					]);
			} catch (PDOException $e) {
				error_log("update error: " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a pharmacy  */
		public function delete(int pharmacyId): bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM pharmacies WHERE pharmacy_id = :pharmacy_id");
				return $stmt->execute(["pharmacy_id" => $pharmacyId]);
			} catch (PDOException $e) {
				error_log("delete error: ", . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a pharmacy */
		public function isValidDate(array $data): bool {
			return isset (
				$data['name'],
				$data['address'],
				$data['phone_number'],
				$data['email'],
				) && preg_match('/^[0-9]+$/', $data['phone_number']);
		}
	}
	