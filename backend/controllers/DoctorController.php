<?php
	namespace App\controllers;
	
	use App\Models\Doctor;
	use App\Core\Response;
	
	class DoctorController {
		private $model;
		
		public function __construct() {
			$this->model = new Doctor();
		}
		
		public function index() {
			response::json(200, $this->model->getAll();
		}
		
		public function show($id) {
			$doctor = $this->model->find($id);
			$doctor ? Response::json(200, $doctor) : Response::json(404, ['message' => 'Doctor not found']);
		}
		
		public function store($data) {
			$success = $this->model->create($data);
			$success ? Response::json_(201, ['message' => 'Doctor created']) : Response::json(500, ['error' => 'insert failed']);
		}
		
		public function update($data) {
			$success = $this->model->update($data);
			$success ? Response::json(200, ['message' =>  'Doctor updated']) : Response::json(500, ['error' => 'Update failed']);
		}
		
		public function delete($id) {
			$success = $this->model->delete($id);
			$success ? Response::json(200, ['message' => 'Doctor deleted']); : Response::json(500, ['error' => 'Delete failed']);
		}
	}
?>