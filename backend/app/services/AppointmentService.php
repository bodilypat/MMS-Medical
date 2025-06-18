<?php

	require_once __DIR__ . '/../config/database.php';
	
	class AppointmentService 
	{
		private $db;
		
		public function __contruct()
		{
			$this->db = Database::getConnection();
		}
		
		public function listAll() 
		{
			$stmt = $this->db->prepare("
				SELECT 
					a.*, 
					CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
					CANCAT(d.first_name, ' ', d.last_name) AS doctor_name
				FROM appointments a 
				JOIN patients p ON a.patient_id = p.patient_id
				JOIN doctors d ON a.doctor_id  =  d.doctor_id
				ORDER BY a.appointment_date DESC
			");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		public function getById() 
		{
			$stmt = $this->db->prepare("SELECT * FROM appointments WHERE appointment_id = :id");
			$stmt->execute(['id' => $id]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		public function create($data)
		{
			$stmt = $this->db->prepare("
			    INSERT INTO appointments 
					(patient_id, doctor_id, appointment_date, reason_for_visit, appointment_type, status, created_by)
				VALUES
					(:patient_id, :doctor_id, :appointment_date, :reason_for_visit, :appointment_type, :status, :created_by)
				");
			return $stmt->execute([
				'patient_id' => $data['patient_id'],
				'doctor_id' => $data['doctor_id'],
				'appointment_date' => $data['appointment_date'],
				'reason_for_vist' => $data['reason_for_visit'],
				'appointment_type' => $data['appointment_type'] ?? 'Consultation', 
				'status' => $data['status'] ?? 'Scheduled',
				'created_by' => $data['created_by'] ?? 1
			]);
		}
		
		public function update($data) {
		{
			$stmt = $this->db->prepare("
				UPDATE appointments SET 
					appointment_date = :appointment_date,
					reason_for_visit' = :reason_for_visit,
					appointment_type = :appointment_type,
					doctor_id = :doctor_id,
					updated_by = :updated_by
				WHERE appointment_id = :appointment_id 
			");
			return $stmt->execute([ 
				'appointment_date' => $data['appointment_date'],
				'reason_for_visit' => $data['reason_for_visit'],
				'appointment_type' => $data['appointment_type'],
				'doctor_id' => $data['doctor_id'],
				'updated_by' => $data['updated_by'] ?? 1,
				'appointment_id' => $data['appointment_id']
			]);
		}
		
		public function delete($id) 
		{
			$stmt = $this->db->prepare("DELETE FROM appointments WHERE appointment_id = :id");
			return $stmt ->execute(['id' => $id]);
		}
		
		public function updateStatus($id, $status, $updated_by = 1) 
		{
			$stmt = $this->db->prepare("
				UPDATE appointments
				SET status = :status, updated_by = :updated_by
				WHERE appointment_id = :id
			");
			
			return $stmt->execute([
				'status' => $status,
				'updated_by' => $updated_by,
				'id' => $id
			]);
		}
	}
