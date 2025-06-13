<?php
	
	use Core\Router;
	use App\Controllers\{
		UserController,
		PatientController,
		DoctorController,
		AppointmentController,
		MedicalRecordController,
		LabTestController,
		InsuranceController,
		PaymentController,
		PrescriptController,
		PharmarcyController
	};
	
	require_once '../config/database.php';
	require_once '../auth/Login.php';
	require_once '../auth/Register.php';
	require_once '../auth/ResetPassword.php';
	
	$router = new Router();
	
	/* Instantiate Controller with PDO */
	$userController = new UserController($pdo);
	$patientController = new PatientController($pdo);
	$doctorController = new DoctorController($pdo);
	$appointmentController = new AppointmentController($pdo);
	$medicalController = new MedicalRecordController($pdo);
	$labTestController = new LabTestController($pdo);
	$insuranceController = new InsuranceController($pdo);
	$paymentController = new PaymentController($pdo);
	$prescriptionController = new PrecriptionController($pdo);
	$pharmarcyController = new PharmarcyController($pdo);
	
	/* User Routes */
	$router->get('/api/users', [$userController,'index']);
	$router->get('/api/users/{id}', [$userController, 'show']);
	$router->post('/api/users', [$userController,'store']);
	$router->put('/api/users/{id}', [$userController,'update']);
	$router->delete('api/users/{id}', [$userController,'destroy']);
	
	/* Patient Routes */
	$router->get('/api/patients', [$patientController,'index']);
	$router->get('/api/patients/{id}', [$patientController,'show']);
	$router->post('api/patients', [$patientController,'store']);
	$router->put('api/users/{id}', [$patientController,'update']);
	$router->delete('api/users/{id}', [$userController,'destroy']);
	
	/* Doctor Routes */
	$router->get('api/doctors', [$doctorController,'index']);
	$router->get('/api/doctors/{id}', [$doctorController, 'show']);
	$router->post('/api/doctors', [$doctorController,'store']);
	$router->put('/api/doctors/{id}', [$doctorController,'update']);
	$router->delete('/api/appointments/{id}', [$doctorController,'destroy']);
	
	/* Appointment Routes */
	$router->get('/api/appointments', [$appointmentController,'index']);
	$router->get('/api/appointments/{id}', [$appointmentController,'show']);
	$router->post('/api/appointments', [$appointmentController,'store']);
	$router->put('/api/appointment/{id}', [$appointmentController,'update']);
	$router->delete('api/appointments/{id}', [$appointmentController,'destroy']);
	
	/* Medical Records Routes */
	$router->get('/api/medical_records', [$medicalRecordController,' index']);
	$router->get('/api/medical_record/{id}', [$medicalRecordController,'show']);
	$router->post('/api/medical_records', [$medicalRecordController,'store']);
	$router->put('/api/medical_records/{id}', [$medicalRecordController,'update']);
	$router->delete('/api/medical_records/{id}', [$medicalRecordController,'destroy']);
	
	/* Lab Tests Routes */
	$router->get('/api/lab_tests', [$labTestController, 'index']);
	$router->get('/api/lab_tests/{id}', [$labTestController,'show']);
	$router->post('/api/lab_tests', [$labTestController,'store']);
	$router->put('/api/lab_tests/{id}', [$labTestController, 'update']);
	$router->delete('/api/lab_tests/{id}', [$labTestController, 'destroy']);
	
	/* Insurance Routes */
	$router->get('/api/insurance', [$insuranceController, 'index']);
	$router->get('/api/insurance/{id}', [$insuranceController, 'show']);
	$router->post('/api/insurance', [$insuranceController, 'store']);
	$router->put('/api/insurance/{id}', [$insuranceController, 'update']);
	$router->delete('/api/insurance/{id}', [$insuranceController, 'destroy']);
	
	/* Payment Routes */
	$router->get('/api/payments', [$paymentController, 'index']);
	$router->get('/api/payments/{id}', [$paymentController, 'show']);
	$router->post('/api/payments', [$paymentController, 'store']);
	$router->put('/api/payments/{id}', [$paymentController, 'update']);
	$router->delete('/api/payments/{id}', [$paymentController, 'destroy']);
	
	/* Prescriptions Routes */
	$router->get('/api/prescriptions', [$prescriptionController, 'index']);
	$router->get('/api/prescriptions/{id}', [$prescriptionController, 'show']);
	$router->post('/api/prescriptions', [$prescriptionController, 'store']);
	$router->put('/api/prescriptions/{id}', [$prescriptionController, 'update']);
	$router->delete('/api/prescriptions/{id}', [$prescriptionController, 'destroy']);
	
	/* Pharmacies Routes */
	$router->get('/api/pharmacies', [$pharmacyController, 'index']);
	$router->get('/api/pharmacies/{id}', [$pharmacyController, 'show']);
	$router->post('/api/pharmacies', [$pharmacyController, 'store']);
	$router->put('/api/pharmacies/{id}', [$pharmacyController, 'update']);
	$router->delete('/api/pharmacies/{id}', [$pharmacyController, 'destroy']);
	
	/* Auth Routes */
	$router->post('/api/login', function () use ($pdo) {
		$login = new \App\Auth\Login($pdo);
		$login->handle();
	});
	
	$router->post('/api/register', function() use($pdo) {
		$register = new \App\Auth\Register($pdo);
		$register->handle();
	});
	
	$router->post('/api/reset-password', function() use($pdo) {
		$reset = new \App\Auth\ResetPassword($pdo);
		$reset->handle();
	});
	
	return $router;
	
	