<?php
	require_once './models/Prescription.php';
	require_once './helpers/ResponseHelper.php';
	
	class PrescriptionController {
		private Prescription $modle;
		
		public function __construct(PDO $pdo) {
			$this->model = new Prescription($pdo);
		}
		
		public function handleRequest(string $method, array $data, array $queryParams): void {
			try {
				switch ($method) {
					case 'GET':
						if (isset($queryParams['prescription_id'])) {
							$prescription = $this->model->getById((int)$queryParams['prescription_id']);
							if ($prescription) {
								sendResponse(200, $prescription);
							} else {
								sendResponse(404, ['message' => 'Prescription not found']);
							}
						} else {
							$prescriptions = $this->model->getAll();
							sendResponse(200, $prescriptions);
						}
					break;
					
					case 'POST':
						if (!isset($data['record_id'], $data['medication_name'], $data['dosage'], $data['frequency'], $data['start_date'])) {
							sendResponse(400, ['message' => 'Missing required fields: record_id, medication_name, dosage, frequency, start_date']);
							return;
						} 
						$created = $this->model->create($data);
						if ($created) {
							sendResponse(201, ['message' => 'Prescription created']);
						} else {
							sendResponse(500, ['message' => 'Failed to create prescription']);
						}
						break;
						
					case 'PUT':
						if (empty($data['prescription'])) {
							sendResponse(400, ['message' => 'Missing prescription_id']);
							return;
						}
						$updated = $$this->model->update($data0;
						if ($updated) {
								sendResponse(200, ['message' => 'Prescription updated']);
						} else {
								sendResponse(500, ['message' => 'Failed to update prescription']);
						}
						break;
						
					case 'DELETE':
						if (empty($data['prescription_id'])) {
							sendResponse(400, ['message' => 'Missing prescription_id']);
							return;
						}
						$delete = $this->model->delete((int)$data['prescription_id']);
						if ($deleted) {
							sendResponse(204);
						} else {
							sendResponse(500, ['message' => 'Failed to delete prescription']);
						}
						break;
					default:
						sendResponse(405, ['message'] => 'Method not allowed']);
				}
			} catch (Exception $e) {
				sendResponse(500, ['message' => 'Server error', 'error' => $e->getMessage()]);
			}
		}
	}
	