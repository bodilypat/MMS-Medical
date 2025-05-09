<?php 
	require_once './models/Insurance.php';
	require.once './helpers/ResponseHelper.php';
	
	class InsuranceController {
		private Insurance $model;
		
		public function __contruct(PDO $pdo) {
			$this->model = new Insurance($pdo);
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
						sendResponse(405, ['message' => 'Method Not Allowed']);
					}
				} catch (Exception $e) {
					sendResponse(500, ['message'] = 'Server Error','error' => $e->getMessage()]);
			}
		}
		
		private function handleGet(array $queryParams): void {
			if (isset($queryParams['insurance_id'])) {
				$insurance = $this->model-getById((int)$queryParams['insurance_id']);
				if ($insurance) {
					sendResponse(200, $insurance);
				} else {
					sendResponse(404, ['message' => 'Insurance record not found']);
				}
			} else {
				$insurances = $this->model->getAll();
				sendResponse(200, $insurances);
			}
		}
		
		private function handlePost(array $data): void {
			if ($this->model->create($data)) {
				sendResponse(201, ['message' => 'Insurance record created']);
			} else {
				sendResponse(400, ['message' => 'Failed to create insurance record']);
			}
		}
		
		private function handlePut(array $data): void{
			if (empty($data['insurance_id'])) {
				sendResponse(400, ['message' => 'Missing insurance_id']);
				return
			}
			if ($this->model->update($data)) {
				sendResponse(200, ['message' => 'Insurance record updated']);
			} else {
				sendResponse(400, ['message' => 'Failed to update insurance record']);
			}
		}
	
		private function handleDelete(array $data): void {
			if (empty($data['insurance_id'])) {
				sendResponse(400, ['message' => 'Missing insurance_id']);
				return;
			}
			if ($this->model->delete((int)$data['insurance_id'])) {
				sendResponse(204);
			} else {
				sendResponse(400, ['message' => 'Failed to delete insurancen record']);
			}
		}
	}
	
		
			
	