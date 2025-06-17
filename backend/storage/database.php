<?php

	require_once __DIR__ . '/../config/env.php';
	
	class Database {
		private static $instance = null;
		private $connection;
		
		private function __construct() {
			$host = DB_HOST;
			$db = DB_NAME;
			$user = DB_USER;
			$pass = DB_PASS;
			$charset = 'utf8mb4';
			
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			
			$options = [
				PDO::ATTR_ERRMODE  				 => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE 	 => PDO::FETCH_ASSOC;
				PDO::ATTR_EMULATE_PREPARES       => false;
			];
			
			try {
				$this->connection  = new PDO($dsn, $user, $pass, $options);
			} catch (PDOException $e) {
				error_log("Database Connection Failed: " . $e->getMessage());
				die("Database connection error. ");
			}
		}
		
		public static function getConnection() {
			if (self::$instance === null) {
				self::$instance = new Database();
			}
			return self::$instance->connection;
		}
	}
	
