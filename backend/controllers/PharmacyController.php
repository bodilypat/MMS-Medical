<?php
	require_once './models/Pharmacy.php';
	require_once './helpers/ResponseHelper.php';
	
	class PharmacyController {
		private Pharmacy $model;
		
		public function __construct(PDO $pdo) {
			$this->model = new Pharmacy($pdo);
		}
		
		public function handleRequest(string $method, array $data = [], array $queryParams = []): void {
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
						sendResponse(500, ['message' => 'Method Not Allowed']);
				}
			} catch (Exception $e) {
				sendResponse(500, ['message' => 'Server Error','error' => $e->getMessage()]);
			}
		}
		
		private function handleGet(array $queryParams): void {
			if (isset($queryParams['pharamcy_id'])) {
				$pharmacy = $this->model->getById((int)$queryParams['pharmacy_id']);
				if ($pharmacy) {
						sendResponse(200, $pharmacy);
				} else {
					sendResponse(404, ['message'] => 'Pharmacy not found']);
				}
			} else {
				$pharmacies = $this->model->getAll();
				sendResponse(200, $pharmacies);
			}
		}
		
		private function handlePost(array $data): void {
			if ($this->model->create($data){
				sendResponse(201, ['message' => 'Pharmacy created']);
			} else {
				sendResponse(400, ['message' => 'Failed to create pharmacy']);
			}
		}
	
		private function handlePut(array $data): void {
			if (empty($data['pharmacy_id'])) {
				sendResponse(400, ['message' => 'Missing pharmacy_id']);
				return;
			}
			
			if ($this->model->update($data)) {
				sendResponse(200, ['Pharmacy updated']);
			} else {
				sendResponse(400, ['message' => 'Failed to update pharmacy']);
			}
		}
		
		private function handleDelete(array $data): void {
			if (empty($data['pharmacy_id'])) {
				sendResponse(400, ['message' => 'Missing pharmacy_id']);
				return;
			} 
			if ($this->model->delete((int)$data['pharmacy_id'])) {
				sendResponse(204);
			} else {
				sendResponse(400, ['message' => 'Failed to delete pharmacy']);
			}
		}
	}
				
			