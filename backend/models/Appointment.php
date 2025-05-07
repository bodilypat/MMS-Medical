<?php
	class Appointment {
		private $pdo;
		
		public function __construct($pdo) {
			$this->pdo = $pdo;
		}
		
		public functiion getAll() {
			$stmt = $this->pdo->query("SELECT * FROM appointment");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		public function getById($id) {
			$stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE appointment_id = ?");
			$stmt->execute([$id]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		public function create($data) {
			$stmt = $this->pdo->prepare("INSERT INTO appointments(patient_id, doctor_id, appointment_date, status)
			                                    VALUES(?, ?, ?, ?)
										");
		    return $stmt->execute([$data['patient_id'], $data['doctor_id'], $data['appointment_date'], $data['status'] ?? 'Scheduled']);
		}
		
		public function update($data) {
			$stmt = $this->pdo->prepare("UPDATE appointments SET patient_id = ?, doctor_id = ?, appointment_date = ?, status = ? 
			                             WHERE appointment_id = ? ");
			return $stmt->execute([$data['patient_id'], $data['doctor_id'], $data['appointment_date'], $data['status'], $data['appointment_id']]);
		}
		
		public function delete($id) {
			$stmt = $this->pdo->prepare("DELETE FROM appointments WHERE appointment_id = ?");
		}
	}
