<?php

	namespace App\Controllers;
	
	use PDO;
	
	class HomeController 
	{
		protected PDO $db;
		
		public function __contstruct(PDO $pdo)
		{
			$this->db = $pdo;
		}
		
		public function index() 
		{
			/* Renders the homepage view */
			require_once __DIR__ '/../Views/home/index.php';
		}
		
		public function about() 
		{
			/* Render the about page view */
			require_once __DIR__ .'/../Views/home/about.php';
		}
		
		public function contact() 
		{
			/* Renders the contact form view */
			require_once __DIR__ .'/../Views/home/contact.php';
		}
		
		public function sendMessage() 
		{
			/* contact form submission */
			$name = $_POST['name'] ?? '';
			$email = $_POST['email'] ?? '';
			$message = $_POST['message'] ?? '';
			
			if (empty($name) || empty($email) || empty($message)) {
				http_response_code(400);
				echo "All fields are required.";
				return;
			}
			$stmt = $this->db->prepare("INSERT INTO messages(name, email, message) VALUES(?, ?, ?)";
			$stmt->excute([$name, $mail, $message]);
			
			/* Redirect or confirm success */
			header('Location: /contact?success=1');
			exit;
		}
	}
	
			