<?php

	require_once __DIR__ '/../../storage/database.php';
	require_once __DIR__ '/../../helpers/response.php';
	require_once __DIR__ '/../../helpers/auth.php';
	
	$action = $_GET['action'] ?? 'summary';
	$db = Database::getConnection();
	
	switch ($action) {
		case 'summary':
			getSummaryReport($db0;
			break;
		
		case 'appointment_by_doctor':
			getMonthlyRevenue($db);
			break;
		
		case 'monthly_revenue':
			getMonthlyRevenue($db);
			break;
			
		default:
			sendJson(400, ['error' => 'Invalid or missing report action']);
			break;
			
	}
	
	/* REPORT FUNCTION */
	function getSummaryReport($db) 
	{
		try {
			$summary = [
				'total_patients' => $db->query("SELECT COUNT(*) FROM patients")->fetchColumn(),
				'total_doctors' => $db->query("SELECT COUNT(*) FROM doctors")->fetchColumn(),
				'total_appointments' => $db->query("SELECT COUNT(*) FROM appointments")->fetchColumn(),
				'total_payments' => $db->query("SELECT COUNT(*) FROM payments")-> fetchColumn(),
				'unpaid_balance' => $db->query("SELECT SUM(balance_due) FROM payments")->fetchColumn(),
			];
			
			sendJson(200, ['summary' => $summary]);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to fetch summary report', 'details' => $e->getMessage()]);
		}
	}
	
	function getAppointmentsByDoctor($db) 
	{
		try {
			$sql = "
			SELECT 
				d.doctor_id,
				CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
				COUNT(a.appointment_id) AS total_appointments 
			FROM doctors d 
			LEFT JOIN appointments a ON d.doctor_id = a.doctor_id
			GROUP BY d.doctor_id 
			ORDER BY total_appointments DESC
		";
		$stmt = $db->query($sql);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		sendJson(200, ['appointment_by_doctor' => $data]);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to fetch doctor appointment report', 'details' => $e->getMessage()]);
		}
	}
	function getMonthlyRevenue($db) 
	{
		try {
			$year = $_GET['year'] ?? date('Y');
			
			$sql = "
				SELECT 
					DATE_FORMAT(payment_date, '%Y-%m') AS month 
					SUM(total_amount) AS total_collected,
					SUM(amount_paid) AS paid,
					SUM(balance_due) AS unpaid 
				FROM paymentss 
				WHERE year(payment_date) = :year
				GROUP BY month
				ORDER BY month DESC 
				LIMIT 12 
			";
			
			$stmt = $db->prepare($sql);
			$stmt->execute(['year' => $year]);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			sendJson(200, ['monthly_revenue' => $data]);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to fetch revenue report', 'details' => $e->getMessage()]);
		}
	}
	
	
		