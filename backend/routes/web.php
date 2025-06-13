<?php
	
	use Core\Router;
	use App\Controller\{
		HomeController,
		DashboardController,
		AuthController
	};
	
	require_once '../config/database.php';
	
	$router = new Router();
	
	/* Public Web Routes */
	$router->get('/', [HomeController::class, 'index']); //Homepage
	$router->get('/about', [HomeController::class, 'about']);
	$router->get('/contact', [HomeController::class, 'contact']);
	$router->post('/contact',  [HomeController::class, 'sendMessage']);
	
	/* Authentication Views */
	$router->get('/login', [AuthController::class, 'showLoginForm']);
	$router->post('/login', [AuthController::class, 'login']);
	$router->get('/register', [AuthController::class, 'showRegisterForm']);
	$router->post('/register', [AuthController::class, 'register']);
	$router->get('/logout', [AuthController::class, 'logout']);
	
	/* Dashboard Views */
	$router->get('/dashboard', [DashboardController::class, 'index']);
	
	/* Protected Pages  */
	$router->get('/admin/patients', [DashboardController::class, 'patients']);
	$router->get('/admin/doctors', [DashboardController::class, 'doctors']);
	$router->get('/admin/appointment', [DashboardController::class, 'appointments']);
	
	
	return $router;
	