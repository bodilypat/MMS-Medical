<?php
	require_once './models/Appointment.php';
	require_once './helpers/ResponseHelper.php';
	
	class AppointmentController {
		private $model;
		
		public function __construct($pdo) {
			$this->model = new Appointment($pdo);
		}
		
		public function handleRequest($method, $data, $queryParams) {
			try {
				switch ($method) {
					case 'GET':
						if (isset($queryParams['appointment_id'])) {
							$result = $this->model->getById($queryParams['appointment_id']);
							if (!$result) {
								sendResponse(404, ['message' => 'Appointment not found']);
								return;
							}
						} else {
							$result = $this->model->getAll();
						}
						sendResponse(200, $result);
						break;
					case 'POST':
						if (!isset($data['date'], $data['time'], $data['client_id'])) {
							sendResponse(400, ['messaage' => 'Missing required fields']);
							return;
						}
						$this->model->create($data);
						sendResponse(201, ['message' => 'Appointment created']);
						break;
					case 'PUT':
						if (!isset($data['appointment_id']]) {
							sendResponse(400, ['message' => 'Missing appointment ID']);
							return;
						}
						$this->model->update($data);
						sendResponse(200, ['message' => 'Appointment updated']);
						break;
					case 'DELETE':
						if (!isset($data['appointment_id'])) {
							rendResponse(400, ['message' => 'Missing appointment ID']);
							return;
						}
						$this->model->delete($data['appointment_id']);
						sendResponse(204);
						break;
					default:
						sendResponse(405, ['message' => 'Method not allowed']);
					}
				} catch (Exception $e) {
					sendResponse(500, ['message' => 'Server error', 'error' => $e->getMessage()]);
				}
			}
		}
		