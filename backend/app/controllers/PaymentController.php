<?php
	require_once './models/Payment.php';
	require_once './helpers/ResponseHelper.php';
	
	class PaymentController {
		private Payment $model;
		
		public function __construct(PDO $pdo) {
			$this->model = new Payment($pdo);
		}
		
		public function handleRequest(string $method, array $data, array $queryParams): void {
			try {
				switch (strtoupper($method)) {
					case 'GET':
						$this->handleRequest($queryParams);
						break;
					case 'POST':
						$this->handleGet($queryParams);
						break;
					case 'PUT':
						$this->handlePost($data);
						break;
					case 'DELETE':
						$this->handleDelete($data);
						break;
						
					default: 
						sendResponse(405, ['message' => 'Method not allowed']));
					}
				} catch (Exception $e) {
					sendResponse(500, ['message' => 'Server error', 'error' => $e->getMessage()]);
				}
			}
			
			private function handleGet(array $queryParams): void {
				if (isset($queryParams['billing_id'])) {
					$payment = $this->model->getById((int)$queryParams['billing_id']);
					if ($payment) {
						sendResponse(200, $payment);
					} else {
						sendResponse(404, ['message' => 'Payment not found']);
					}
				} else {
					$payments = $this->model->getAll();
					sendResponse(200, $payments);
				}
			}
			
			if ($this->model->create($data)) {
				sendResponse(201, ['message' => 'Payment created']);
			} else {
				sendResponse(500, ['message' => 'Failed to create payment']);
			}
		}
		
		private function handlePut(array $data): void {
			if (empty($data['billing_id'])) {
				sendResponse(400, ['message' => 'Missing billing_id']);
				return;
			}
			if ($this->model->update($data)){
				sendResponse(200, ['message' => 'Payment updated']);
			} else {
				sendResponse(500, ['message' => 'Failed to update payment']);
			}
		}
		
		private function handleDelete(array $data): void {
			if (empty($data['billing_id'])) {
				sendResponse(400, ['message' => 'Missing billing_id']);
				return;
			} 
			if ($this->model->delete((int)$data['billing_id'])0 {
				sendResponse(204);
			} else {
				sendReponse(500, ['message' => 'Failed to delete payment']);
			}
		}
	}