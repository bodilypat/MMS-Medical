<?php
	require_once './models/MedicalRecord.php';
	require_once './models/ResponseHelper.php';
	
	class MedicalRecordController {
		private MedicalRecord $model;
		
		public function __contruct(PDO $pdo) {
			$this->model = new MedicalRecord($pdo);
		}
		
		public function handleRequest(string $method, array $data, array $queryParams): void {
			try {
				switch ($method) {
					case 'GET':
							if (isset($queryParams['record_id'])) {
								$record = $this->model->getById((int)$queryParams['record_id']);
								if ($record) {
										sendResponse(200, $record);
									} else {
										sendResponse(404, ['message' => 'Medical record not found']);
									}
							} else {
								$records = $this->model->getAll();
								sendResponse(200, $records);
							}
							break;
							
					case 'POST':
							if (!isset($data['patient_id'], $data['appointment_id'])) {
								sendResponse(400, ['message' => 'Missing required fields: patient_id and appointment_id']);
								return;
							}
							$created = $this->model->create($data);
							if ($created) {
								sendResponse(201, ['message' => 'Medical record created']);
							} else {
								sendResponse(500, ['message' => 'Failed to create medical record']);
							}
							break;
							
					case 'PUT':
							if (empty($data['record_id'])) {
								sendReponse(400, ['message' => 'Missing record_id']);
								return;
							}
							$updated = $this->model->update($data);
							if ($update) {
								sendResponse(200, ['message' => 'Midical record updated']);
							} else {
								sendResponse(500, ['message' => 'Failed to update medical record']);
							}
							break;
							
					case 'DELETE':
							if (empty($data['record_i'])) {
								sendResponse(400, ['message' => 'Missing record_id']);
								return;
							}
							$deleted = $this->model->delete((int)$data['record_id']);
							if ($deleted) {
								sendResponse(204);
							} else {
								sendResponse(500, ['message' => 'Failed to delete medical record']);
							}
							break;
							
					default:
							sendResponse(500, ['message' => 'Method not allowed']);
					}
			  } catch (Exception $e)  {
				  sendResponse(500, ['message' => 'Server error', 'error' => $e->getMessage()]);
			  }
		}
	}
	