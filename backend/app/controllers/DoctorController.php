<?php
	namespace App\controllers;
	
	use App\Models\Doctor;
	use App\Core\Response;
	
	class DoctorController {
		private Doctor $model;
		
		public function __construct() {
			$this->model = new Doctor();
		}
		
		/* List all doctors */
		public function index(): void {
			$doctors = $this->model->getAll();
			response::json(200, $doctors);
		}
		
		/* Get a single doctor by ID */
		public function show($id): void {
			$doctor = $this->model->find($id);
			if ($doctor) {
				response::json(200, $doctor);
			} else {
				response::json(404, ['message' => 'Doctor not found']);
			}
		}
		
		/* Create a new doctor */
		public function store(array $data): void {
			$success = $this->model->create($data);
			if ($success) {
				Response::json(201, ['message' => 'Doctor created']);
			} else {
				Response::json(500, ['error' => 'Doctor ID is required for update']);
				return;
		}
		
		/* Update an existing doctor */
		public function update($data): void {
			if (Empty($data['id'])) {
				Response::json(400, ['error' => 'Doctor ID is required for update']);
				return ;
			} else {
				Response::json(500, ['error' => 'Update failed']);
			}
		}
		
		/* Delete a doctor by ID */
		public function delete($id): void {
			$success = $this->model->delete($id);
			if ($success) {
				Response::json(200, ['message' => 'Doctor deleted']);
			} else {
				Response::json(500, ['error' => 'Delete failed'])
			}
		}
		
		/* Handle incomming HTTP Request */
		public function handleRequest(string $method, array $input =[], array $queryParams = []): void {
			switch (strtoupper($method)) {
				case 'GET':
					if (!empty($queryParams['id'])) {
						$this->show($queryParams['id']);
					} else {
						$this->index();
					} 
					break;
				case 'POST':
					$this->store($input);
					break;
				case 'PUT':
					$this->update($input);
					break;
				case 'DELETE':
				if (!empty($queryParams['id'])) {
					$this->delete($queryParams['id']);
				} else {
					Response::json(400, ['error' => 'Doctor ID required for deletion']);
				}
				break;
			default:
				Response::json(405, ['error' => 'Method not allowed']);
				break;
			}
		}
	}
