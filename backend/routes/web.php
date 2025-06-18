<?php

	require_once __DIR__ . '/../config/constants.php';
	require_once __DIR__ . '/../helpers/auth.php';
	
	/* Simple route resolver */
	$page = $_GET['page'] ?? 'home';
	
	session_start();
	
	/* Redirect if not logged in */
	$publicPages = ['login'];
	
	if (!in_array($page, $publicPages) && !isLoggedIn()) {
		header('Location: /public/index.php?page=login');
		exit;
	}
	
	switch ($page) {
		case 'home':
			include_once __DIR__ . '/../public/pages/dashboard/home.php';
			break;
			
		case 'overview':
			include_once __DIR__ .'/../public/pages/dashboard/overview.php';
			break;
			
		case 'login':
			include_once __DIR__ .'/../public/index.php';
			break;
			
		case 'reports':
			include_once __DIR__ .'/../public/pages/modules/reports/summary.php';
			break;
			
		default: 
			include_once __DIR__ .'/../public/404.php';
	}