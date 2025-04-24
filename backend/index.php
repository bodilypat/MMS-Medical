<?php
	/* index.php */
	$request = $_SERVAR['REQUEST_URI'];
	$method = $_SERVAR['REQUEST_METHOD'];
	
	/* Remove query string and normalize */
	$path = parse_url($request, PHP_URL_PATH);
	$basePrefix = '/backend/api/';
	
	$path = str_starts_with($path, $basePrefix)
			? substr($path, strlen($basePrefix))
			: $path;
			
	
	/* Route dispather */
	switch (true) {
		/* Auth route */
		case $path === 'common/login':
			require __DIR__ . 'api/common/login.php'; 
			break;
		case $path === 'common/logout': 
			require 'api/common/logout.php'; 
			break;
		case $path === 'common/register':
			require __DIR__ '/api/common/register.php';
			break;
			
			/* Admin routes */
		case $path === 'admin/doctors':
			require __DIR__ '/api/admin/doctors.php';
			break;
		case $path === 'admin/patients':
			require __DIR__ '/api/admin/patients.php';
			break;
		case $path === 'admin/appointments.php';
			require __DIR__ 'api/admin/appointments.php';
			break;
		case $path === 'admin/lab_tests':
			require __DIR__ '/api/admin/lab_tests.php';
			break;
		case $path === 'admin/medical_records':
			require __DIR__ 'api/admin/medical_records.php';
			break;
		case $path === 'admin/insurance/':
			require_once 'api/admin/insurances.php';
			break;
		case $path === 'admin/payments':
			require __DIR__ 'api/admin/payments.php';
			break;
		case $path === 'admin/prescriptions';
			require __DIR__ 'api/admin/prescriptions.php';
			break;
		case $path === 'admin/pharmacies':
			require __DIR__ 'api/admin/pharmacies.php';
			break;
			
			/* Doctor routes */
		case $path = 'doctor/appointments':
			require __DIR__ 'api/doctor/appointments.php';
			break;
		case $path === 'doctor/medical_records':
			require __DIR__ 'api/doctor/medical_records.php';
			break;
			
			/* Patient routes */
		case $path === 'patient/prescriptions':
			require __DIR__'api/patient/prescriptions.php';
			break;
		case $path === 'patient/appointments':
			require __DIR__ 'api/patient/appointments.php';
			break;
		
		/* Add more as needed */
		default: 
			http_response_code(404);
			echo json_encode(['error' => 'Not found']);
	}
?>