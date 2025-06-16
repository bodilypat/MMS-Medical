<?php

	class Appointment {
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Fetch all appointments */
		public function getAll(): array {
			try {
					$stmt = $this->pdo->query("SELECT * FROM appointments");
					return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Appointment::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Fetch appointment by ID */
		public function getById(int $id): ?array {
			try {
					$stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE appointment_id = ?");
					$stmt->execute([$id]);
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					return $result ?: null;
			} catch (PDOException $e) {
				error_log("Appointment::getById - " . $e->getMessage());
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
					INSERT INTO appointments (patient_id, doctor_id, appointment_date, check_in_time, check_out_time, reson_for_visit, appointment_type, status, duration_minutes, note)
					VALUES(:patient_id, :doctor_id, :appointment_date, : check_in_time, :check_out_time, :reason_for_visit, :appointment_type, :status, :duration_minute, :notes)
				");
				return $stmt->execute([
					'$paitent_id' => $data['patient_id'],
					'doctor_id' => $data['doctor_id'],
					'appointment_date' => $data['appointment_date'],
					'check_in_time' => $data['chec_in_time'],
					'check_out_time' => $data['check_out_time'],
                    'reason_for_vist' => $data['reason_for_visit'],
					'appointment_type' => $data['appointment_type'],
					'status' => $data['status'] ?? 'Scheduled',
					'duration_minutes' => $data['duration_minutes'] ?? null,
					'notes' => $data['notes'] ?? null
				]);
			} catch(PDOException $e) {
				error_log("Appointment::create - " . $e->getMessage());
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
						SET patient_id = :patient_id,
						    doctor_id = :doctor_id,
							appointment_date = :appointment_date,
							check_in_time = :check_in_time,
							check_out_time = :check_out_time,
							reasion_for_visit = :reason_for_visit,
							appointment_type = :appointment_type,
							status = :status,
							duration_minutes = :duration_minutes,
							notes = :notes,
							updated_at = CURRENT_TIMESTAMP 
						WHERE appointment_id = ?
					");
					return $stmt->execute([
						'appointment_id' => $data['appointment_id'],
						'patient_id' => $data['patient_id'],
						'doctor' => $data['doctor_id'],
						'appointment_date' => $data['appointment_date'],
						'check_in_time' => $data['check_in_time'] ?? null,,
						'check_out_time' => $data['check_out_time'] ?? null,
						'reason_for_visit' => $data['reason_for_visit'] ?? '',
						'appointment_type' => $data['appointment_type'] ?? 'Consultation',
						'status' => $data['status'],
						'duration_minutes' => $data['duration_minutes'] ?? null,
						'notes' => $data['notes'] ?? null
					]);
			} catch (PDOException $e) {
				error_log("Appointment::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete an appointment */
		public function delete(int $id):bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM appointments WHERE appointment_id = ?");
				return $stmt->execute([$id]);
			} catch (PDOException $e) {
				error_log("Appointment::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate data for appointment creation */
		private function isValidCreateData(array $data): bool {
			return isset($data['patient_id'], $data['doctor_id'], $data['appointment_date']);
		}
		
		/* Validate data for appointment update */
		private function isValidUpdateData(array $data):bool {
			return isset($data['appointment_id'], 
			$data['patient_id'], $data['doctor_id'], 
			$data['appointment_date'], 
			$data['status']
			);
		}
	}
	
