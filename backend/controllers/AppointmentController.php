<?php
	require_once './models/Appointment.php';
	require_once './helpers/ResponseHelper.php';
	
	class AppointmentController {
		private $model;
		
		public function __construct($pdo) {
			$this->model = new Appointment($pdo);
		}
		
		public function handleRequest($method, $data, $queryParams) {
			switch ($method) {
				case 'GET': 
					if (isset($queryParams['appointment_id'])) {
						$result = $this->model->getById($queryParams['appointment_id']);
					} else {
						$result = $this->model->getAll();
					}
					sendResponse(200, $result);
				case 'POST': 
					$this->model->create($data);
					sendResponse(201, ['message' => 'Appointment created']);
					break;
				case 'PUT':
					$this->model->update($data);
					sendResponse(200, ['message' => 'Appointment updated']);
					break;
				case 'DELETE':
					$this->model->delete($data['appointment_id']);
					sendResponse(200, ['message' => 'Appointment deleted']);
					break;
				default:
					sendResponse(405, ['message' => 'Method not allowed']);
			}
		}
	}
		