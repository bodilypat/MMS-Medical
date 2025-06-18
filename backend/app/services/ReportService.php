<?php 
	
	require_once __DIR__ . '/../../config/database.php';
	
	class ReportService
	{
		private $db;
		
		public function __construct()
		{
			$this->db = Database::getConnection();
		}
		
		/* Generate a summary report of total counts */
		public function getSummary() 
		{
			$summary = [];
			
			$summary['total_patients'] = $this->countTable('patients');
			$summary['total_doctors'] = $this->countTable('doctors');
			$summary['total_appointment'] = $this->countTable('appointments');
			$summary['total_lab_tests'] = $this->countTable('lab_tests');
			$summary['total_prescription'] = $this->countTable('prescriptions');
			
			return $summary;
		}
		
		/* Get number of appointments per doctor */
		public function getAppointmentsPerDoctor() 
		{
			$stmt = $this->db->prepare("
				SELECT 
					d.doctor_id,
					CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
					COUNT(a.appointment_id) AS total_appointments 
				FROM doctors d 
				LEFT JOIN appointments a ON d.doctor_id = a.doctor_id
				GROUP BY d.doctor_id 
				ORDER BY total_appointments DESC
			");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Get monthy appointments count (for charting)  */
		public function getMonthlyAppointments($year = null)
		{
			$year = $year ?? date('Y');
			
			$stmt = $this->db->prepare("
				SELECT 
					MONTH(appointment_date) AS month,
					COUNT(*) AS count
				FROM appointments
				WHERE YEAR(appointment_date) = :year
				GROUP BY MONTH(appointment_date0
				GROUP BY month ASC
			");
			$stmt->execute(['year' => $year]);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Get payment summary by status */
		public function getPaymentSummery() 
		{
			$stmt = $this->db->prepare("
				SELECT 
					payment_status,
					COUNT(*) AS count,
					SUM(total_amount) AS total_amount,
					SUM(amount_paid) AS total_paid
				FROM payments
				GROUP BY payment_status
			");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Count rows in any table */
		private function countTable($table)
		{
			$stmt = $this->query("SELECT COUNT(*) as total FROM {$table}");
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result['total'] ?? 0;
		}
	}
	