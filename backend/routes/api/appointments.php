<?php

	require_once __DIR__ . '/../../storage/database.php';
	require_once __DIR__ . '/../../helpers/response.php';
	require_once __DIR__ . '/../../helpers/auth.php';
	
	$method = $_SERVER['REQUEST_METHOD'];
	$action = $_GET['action'] ?? 'list';
	
	$db = Database::getConnection();
	
	switch ($method) {
		case 'GET':
			if ($action === 'list') {
				listAppointments($db);
			} else {
				sendJSON(400, ['error' => 'Invalid GET action']);
			}
			break;
		case 'POST':
			switch ($action) {
				case 'create':
					createAppointment($db);
					break;
					
				case 'update':
					updateAppointment($db);
					break;
					
				case 'delete':
					deleteAppointment($db);
					break;
					
				case 'status':
					updateStatus($db);
					break;
					
				default:
					sendJSON(400, ['error' => 'Invalid POST action']);
			}
			break;	
		default:
			sendJson(405, ['error' => 'Method not allowed']);
			break;
	}
	/* FUNCTION */
	function listAppointment($db) {
		$stmt = $db->query("SELECT * FROM appointments ORDER BY appointment_date DESC");
		$appointments = $stmt->fetchAll();
		sendaJson(200, $appointments);
	}
	
			
			