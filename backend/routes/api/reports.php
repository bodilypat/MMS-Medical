<?php

	require_once __DIR__ . '/../../storage/database.php';
	require_once __DIR__ . '/../../helpers/response.php';
	require_once __DIR__ . '/../../helpers/auth.php';
	
	$action = $_GET['action'] ?? 'summary';
	$db = Database::getConnection();
	
	switch($action) {
		case 'summary':
			getSummaryReport($db);
			break;
		
		case 'appointment_by_doctor':
			getAppointmentByDoctor($db);
			break;
			
		case 'monthy_evenue':
			getMonthyRevenue($db);
			break;
			
		default:
			sendJson(400, ['error' => 'Invalid or missing report acction']);
	}
	/* REPORT FUNCTION */
	function getSummaryReport($db) {
		try {
			$summary = [];
			
			$summary['total_patients'] = $db->query("SELECT COUNT(*) FROM patients")->fetchColumn();
			$summary['total_doctors'] = $db->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
			$summary['total_appointments'] = $db->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
			$summary['total_payments'] = $db->query("SELECT COUNT(*) FROM payments")->fetchColumn();
			$summary['unpaid_balance'] = $db->query("SELECT SUM(balance_due) FROM payments")->fetchColumn();
			
			sendJson(200, ['summary' => $summary]);
		} catch (Exception $e) {
			sendJson(500,['error' => 'Failed to fetch summary report', 'details' => $e->getMessage()];
		}
	}
	
	function getAppointmentByDoctor($db) {
		try {
			$sql = "
				SELECT d.doctor_id, CANCAT(d.first_name, ' ' , d.last_name) AS doctor_name,
                        COUNT(a.appointment_id) AS total_appointments
				FROM doctors d 
				LEFT JION appointments a ON d.doctor_id = a.doctor_id 
				GROUP BY d.doctor_id
				ORDER BY total_appointments DESC
			";
			
			$stmt =  $db->query($sql);
			$data = $stmt->fetchAll();
			
			sendJson(200, ['appointments_by_doctor' => $data]);
		} catch(Exception $e) {
			sendJson(500, ['error' => 'Failed to fetch data', 'details' => getMessage()]);
		}
	}
	
	function getMonthlyRevenue($db) {
		try {
			$sql = "
				SELECT DATE_FROMAT(payment_date, '%Y-%m') AS month,
					SUM(total_amount) AS total_collected,
					SUM(amount_paid) AS paid,
					SUM(balance_due) AS unpaid 
				FROM payments 
				GROUP BY month
				ORDER BY month DESC
				LIMIT 12
			";
			
			$stmt = $db->query($sql);
			$data = $stmt->fetchAll();
			
			sendJson(200,['monthly_revenue' => $data]);
		} catch (Exception $e) {
			sendJson(500, ['error' => 'Failed to fetch revenue report', 'details' => $e->getMessage()]);
		}
	}
	