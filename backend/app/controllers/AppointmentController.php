<?php
	require_once './models/Appointment.php';
	require_once './helpers/ResponseHelper.php';
	
	class AppointmentController {
		private Appointment $model;
		
		public function __construct(PDO $pdo) {
			$this->model = new Appointment($pdo);
		}
		
		public function handleRequest(string $method, array $data = [] , $queryParams = []): void {
			try {
				switch (strtoupper($method)) {
					
					case 'GET':
						$this->handleGet($queryParams);
						break;
						
					case 'POST': 
						$this->handlePost($data);
						break;
						
					case 'PUT':
						$this->handlePut($data);
						break;
						
					case 'DELETE': 
						$this->handleDelete($data);
						break;
					
					default:
						sendResponse(405, ['message' => 'Method not allowed']);
						break;
				}
			} catch (Exception $e) {
				sendResponse(500, ['message' => 'Internal servar error', 'error' => $e->getMessage()]);
			}
		}
		
		private function handleGet(array $queryParams): void {
			if (!empty($queryParams['appointment_id'])) {
				$appointmentId = (int)$queryParams['appointment_id'];
				$appointment = $this->model->getById($appointmentId);
				
				if (!$appointment) {
					sendResponse(404, ['message' => 'Appointment not found']);
					return;
				}
				sendResponse(200, $appointment);
			} else {
				$appointments = $this->model->getAll();
				sendResponse(200, $appointments);
			}
		}
		
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
		