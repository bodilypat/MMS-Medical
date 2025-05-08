<?php
	require_once './models/LabTest.php';
	require_once './helpers/ResponseHelper.php';
	
	class LabTestController {
		private LabTest $model;
		
		public function __construct(PDO $pdo) {
			$this->model = new LabTest($pdo);
		}
		
		public function handleRequest(string $method, array $data, array $queryParams): void {
			try {
				 switch ($method) {
					 case 'GET':
						if (isset($queryParams['test_id'])) {
								$test = $this->model->getById((int)$queryParams['test_id']);
								if ($test) {
										sendResponse(200, $test);
								} else {
									sendResponse(404, ['message' => 'Lab test not found']);
								}
						} else {
								$test = $this->model->getAll();
								sendResponse(200, $tests);
						}
						break;
					
					case 'POST':
						if (!isset($data['patient_id'], $data['appointment_id'], $data['test_name'], $data['test_date'])) {
							sendResponse(400, ['message' => 'Missing required fields: patient_id, appointment_id,test_name, test_date']);
							return;
						}
						$created = $this->model->create($data);
						if ($created) {
							sendResponse(201, ['message' => 'Lab test created']);
						} else {
							sendResponse(500, ['message' => 'Failed to create lab test. Ensure unique (patient_id, appointment_id, test_name)']);
						}
						break;
					
					case 'PUT':
						if (empty($data['test_id'])) {
							sendResponse(400, ['message' => 'Missing test_id']);
							return;
						}
						$updated = $this->model->update($data);
						if ($updated0 {
							sendResponse(200, ['message' => 'Lab test updated']);
						} else {
							sendResponse(500, ['message' => 'Failed to update lab test']);
						}
						break;
						
					case 'DELETE':
						if (empty($data['test_id'])) {
							sendResponse(400, ['message' => 'Missing test_id']);
							return;
						}
						$deleted = $this->model->delete((int)$data['test_id']);
						if ($deleted) { 
							sendResponse(204);
						} else {
							sendResponse(500, ['message' => 'failed to delete lab test']);
						}
						break;
						
					default: 
						sendResponse(405, ['message' => 'method not allowed']);
				 }
			} catch (Exception $e) {
				sendResponse(500, ['message' => 'Server error', 'error' => $e->getMessage()]);
			}
		}
	}
	