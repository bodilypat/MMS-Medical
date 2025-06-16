<?php
	require_once __DIR__ '../models/Patient.php';
	require_once __DIR__ '../helpers/ResposeHelper.php';
	require_once __DIR__ '../config/dbconnect.php'; // Ensure PDO is available
	
	class PatientController {
		private Patient $model;
		
		public function __construct($pdo) {
			$this->model = new Patient($pdo);
		}
		
		public function handleRequest(string , array $input = [], array $requeryParams = [], void {
			switch ($method) {
				case 'GET':
					if (!empty($queryParams['id'])) {
						$this->show(($queryParams['id']);
					} else {
						$this->index();
					}
				break;
			
				case 'POST':
					$this->store($input);
				break;
				
				case 'DELETE':
					$this->update($input);
					break;
				
				default: 
					sendJson(405, ['message' => 'Method Not Allowed']);
			}
		}
		public function index(): void {
			$patients = $this->model->getAll();
			sendJson(200, $patients);
		}
		
		public function show($id): void {
			$patient = $this->model->getById($id);
			if ($patient) {
				sendJson(200, $patient);
			} else {
				sendJson(404, ['message' => 'Patient not found']);
			}
		}
		
		public function store(array $data): void {
			if (empty($data['email']) || empty($data['phone_number'])) {
				sendJson(400, ['message' => 'Email and phone number are required']);
				return;
			}
			
			if ($this->model->exists($data['email'], $data['phone_number'])) {
				sendJson(409, ['message' => 'Patient already exists']);
				return;
			}
			
			try {
				$this->model->create($data);
				sendJson(201, ['message' => 'Patient created']);
			} catch (Exception $e) {
				sendJson(500, ['error' => $e->getMessage()]);
			}
		}
		public function update(array $data): void {
			if (empty($data['patient_id'])) {
				sendJson(400, ['message' => 'Patient ID is required']);
				return;
			}
			try {
				$this->model->update($data);
				sendJson(200, ['message' => 'Patient updated']);
			} catch (Exception $e) {
				sendJson(500, ['error' => $e->getMessage()]);
			}
		}
		public function delete(array $data):void {
			if (empty($data['patient_id'])) {
				sendJson(400, ['message' => 'Patient ID is required']);
				return;
			}
			try {
				$this->model->delete($data['patient_id']);
				sendJson(200, ['message' => 'Patient deleted']);
			} catch (Exception $e) {
				sendJson(500, ['error' => $e->getMessage()]);
			}
		}
	}